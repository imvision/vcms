<?php

global $app;

$app->registerPlugin( 'login' );

function login() {
    global $app;
    // retrieve response object
    $response = responseObject();

    $data = array();
    // auth user
    if( $_SERVER['REQUEST_METHOD'] == "POST" ) {
        $username = get_var( 'username' );
        $password = get_var( 'password' );

        if( $username == "admin" && $password == "admin@live" ) {
            $_SESSION['auth'] = 1;
            header( 'Location: index.php?action=home' );
            exit;
        } else {
            $_SESSION['message'] = array( "type" => "danger", "message" => "Username or password is incorrect!" );
        }
    }

    $response->isTemplate( false );
    $response->Send( 'views/login.php', $data );
}
