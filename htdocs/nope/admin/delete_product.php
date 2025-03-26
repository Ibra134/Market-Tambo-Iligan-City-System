<?php
session_start();
require_once '../includes/database.php'; 

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];  // Sanitize input

    $stmt = $conn->prepare("DELETE FROM Products WHERE Product_ID = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Product deleted successfully.";
        } else {
            $_SESSION['error'] = "Product not found or already deleted.";
        }
        
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare the statement.";
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
}

$conn->close();
header("Location: ../admin/admin_dashboard.php");
exit();
