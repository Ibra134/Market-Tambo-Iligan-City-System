<?php
$servername = "localhost";
$username = "mariadb";  
$password = "mariadb";  
$dbname = "mariadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn instanceof mysqli && $conn->ping()) {
    mysqli_select_db($conn, "mariadb");
} else {
    die("Database connection is closed.");
}
?>