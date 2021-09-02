<?php

$server = 'localhost:3306';
$username = 'root';
$password = '';
$database = 'full-calendar';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Fallo de conexion: ' . $e->getMessage());
}

?>
