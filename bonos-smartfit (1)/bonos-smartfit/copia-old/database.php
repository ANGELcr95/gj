<?php
$server = 'localhost'; 
$username="coomevar_consultaAsociadoUSR";
$password="SeSY[;282;D{gMQ3i2";
$database="coomevar_asociadosDB";

try {
  
    $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password); 
} catch (PDOException $e_) { 
  
  die('Connected failed: '.$e->getMessage());
}
?>
