<?php
session_start();

date_default_timezone_set( 'Asia/Qatar' );

require_once 'registry.php';
require_once 'db.php';
require_once 'response.php';
require_once 'tmpl.php';
require_once 'helper.php';
require_once 'cms.php';

/**
 * Registry will store objects that we need to use all over the application
 */
$registry = Registry::instance();


/**
 * Create Database connection object and store in the registry
 */
$db_connection = DB::connection();
$registry->set( 'connection', $db_connection );


/**
 * Register JScript object to handle js files inclusion
 */
$scripts = array();
$registry->set( 'scripts', $scripts );


/**
 * Create Response object and store in the registry
 */
$Response = new Response();
$registry->set( 'response', $Response );

// action
$action = get_var( 'action', 'home' );

// render login page
$app = new CMS;

$app->dispatch( $action );
