<?php
$server = 'localhost'; 
$username="root";
$password="";
$database="administraciones_gj";

try {
  
    $conn = new PDO("mysql:host=$server;dbname=$database;",$username,$password); 
} catch (PDOException $e_) { 
  
  die('Connected failed: '.$e->getMessage());
}
?>
