<?php
session_start();
require_once '../includes/database.php';

// Prevent session fixation attacks
session_regenerate_id(true);

// Redirect if admin is not logged in
if (!isset($_SESSION['admin_id'])) { 
    header('Location: ../admin_login.php'); 
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin_name = "Admin"; // Default name in case of query failure

if (isset($conn)) { // Ensure database connection is available
    $query = "SELECT Name FROM Market_administrators WHERE Admin_ID = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $admin_name = htmlspecialchars($row['Name']); // Escape output for security
        }

        $stmt->close();
    } else {
        die("Query failed: " . $conn->error); // Debugging fallback
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>

<div class="container">
    <h2>Welcome, <?= $admin_name ?>!</h2>
    <a href="products.php">Manage Products</a>
    <a href="../logout.php">Logout</a>
</div>

</body>
</html>