<?php

class Notification {
    public static function Push($device, $gcm, $message) {
        if($device=="iOS") {
            $deviceToken = $gcm;

            // Put your private key's passphrase here:
            $passphrase = '';

            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns-dev.pem');
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

            // Open a connection to the APNS server
            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

            // Create the payload body
            $body['aps'] = array(
                'alert' => $message,
                'sound' => 'default'
                );

            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result1 = fwrite($fp, $msg, strlen($msg));

            // Close the connection to the server
            fclose($fp);

        }
        else if($device=="android") {
            $GOOGLE_API_KEY = 'AIzaSyB9xp2Z7iJSwH9on51IQoXgmPwKpksKKBs';
            $url = 'https://android.googleapis.com/gcm/send';
            $registration_ids = $gcm;

            $fields = array(
                'registration_ids'  => array($registration_ids),
                'data'              => array( "message"=>$message ),
            );

            $headers = array(
                'Authorization: key=' . $GOOGLE_API_KEY,
                'Content-Type: application/json'
            );

            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            // Execute post
            $result2 = curl_exec($ch);

            // Close connection
            curl_close($ch);
        }
    }
}
