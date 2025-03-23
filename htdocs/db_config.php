<?php
// Database configuration
$host = '127.0.0.1';         // IP address instead of localhost
$user = 'root';               // XAMPP default user
$password = '';               // No password by default in XAMPP
$database = 'Tambo_Market_DB'; // Your database name
$port = 3307;                  // Explicit port for MySQL

// Establish connection
$conn = new mysqli($host, $user, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment this to confirm successful connection during testing
// echo "Connected successfully";
?>
