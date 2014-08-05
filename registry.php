<?php
class Registry {
  private static $instance;
  private $values = array();

  private function __construct() { }

  static function instance() {
  if ( ! isset( self::$instance ) ) { self::$instance = new self(); }
    return self::$instance;
  }

  function get( $key ) {
    if ( isset( $this->values[$key] ) ) {
      return $this->values[$key];
    }
    return null;
  }

  function set( $key, $value ) {
    $this->values[$key] = $value;
  }
}

/* usage */
/*
$registry = Registry::instance();

$registry->set('connection', 'Connection object');
$registry->set('response', 'Response Object');

echo $registry->get('connection');
*/
