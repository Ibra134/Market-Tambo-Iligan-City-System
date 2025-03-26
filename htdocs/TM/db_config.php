<?php

$host = 'localhost';
$username = 'mariadb';     
$password = 'mariadb';          
$database = 'mariadb';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
