<?php

global $app;

$app->registerPlugin( 'logout' );

function logout() {
    unset($_SESSION['auth']);
    session_destroy();

    imv_redirect( 'login' );
    exit;
}
