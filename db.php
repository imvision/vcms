<?php

class DB {
  static function connection(){
    $conn = null;
    try {
      $conn = new PDO('mysql:host=localhost;dbname=mlive;charset=utf8', 'root', '');
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      throw $e;
    }
    return $conn;
  }
}
