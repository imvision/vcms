<?php

class CMS {

    private $plugins =array();

    private $auth = false;

    public $message = array();

    /**
     * verify and call the requested action then send response
     */
    public function dispatch( $action ) {
        //
        // retrieve response object
        //
        $response = responseObject();
        //
        // Load all plugins
        //
        $this->loadPlugins();

        // user must be logged in
        if( $this->authUser() === false ) {
            $action = "login";
        }

        if( in_array( $action, $this->plugins ) ) {
            call_user_func($action);
        } else {
            $response->isTemplate( false );
            $response->Send( '404.html' );
            return;
        }
    }

    /**
     * Load all plugins
     */
    public function loadPlugins() {
        foreach (glob("plugins/*.php") as $filename) {
            include $filename;
        }
    }

    /**
     * To make a function callable by the public, first it should be registered
     */
    public function registerPlugin( $callback ) {
        if( trim($callback) != "" && function_exists( $callback ) && !in_array( $callback,  $this->plugins) ) {
            array_push( $this->plugins, $callback );
        }
    }

    public function authUser() {
        if( isset( $_SESSION['auth'] ) && $_SESSION['auth'] == 1 ) {
            $this->auth = true;
            return true;
        }
        else {
            $this->auth = false;
            return false;
        }
    }

    public function flash() {

        if( isset($_SESSION['message']) && count($_SESSION['message']) > 0 ) {
            echo $this->notif( $_SESSION['message']['type'], $_SESSION['message']['message'] );
            $_SESSION['message'] = array();
        }

    }

    public function notif( $type, $message ) {
        ob_start();
        ?>

        <div class="alert alert-<?php echo $type ?> clearfix">
            <div class="noti-info">
                <?php echo $message ?>
            </div>
        </div>
        <br>

        <?php
        return ob_get_clean();
    }
}
