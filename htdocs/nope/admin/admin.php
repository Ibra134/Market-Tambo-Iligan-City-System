<?php
session_start();
require_once '../includes/database.php';

if (!isset($_SESSION['admin_id'])) { 
    header('Location: ../admin_login.php'); 
    exit();
}

session_regenerate_id(true); // Improve session security

$admin_id = $_SESSION['admin_id'];

// Ensure the database connection is available
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT Name FROM Market_administrators WHERE Admin_ID = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        $admin_name = $row['Name'];
    } else {
        $admin_name = "Admin";
    }

    $stmt->close();
} else {
    $admin_name = "Admin";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/style.css"> <!-- Updated path -->
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            color: #4CAF50;
        }

        a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            color: white;
            background: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($admin_name, ENT_QUOTES | ENT_HTML5) ?>!</h2>
    <a href="products.php">Manage Products</a>
    <a href="../logout.php">Logout</a>
</div>

</body>
</html>
