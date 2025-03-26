<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include 'database.php';  
include 'header.php';

// Ensure connection is open
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Select the correct database
if (!mysqli_select_db($conn, 'mariadb')) {
    die("Error selecting database: " . mysqli_error($conn));
}

// Check if table exists before querying
$check_table_query = "SHOW TABLES LIKE 'Market_administrators'";
$check_table_result = mysqli_query($conn, $check_table_query);

if (!$check_table_result || mysqli_num_rows($check_table_result) === 0) {
    die("Error: Table 'Market_administrators' does not exist in the database.");
}

$current_page = basename($_SERVER['PHP_SELF']);
if (($current_page != 'index.php') && isset($_SESSION['customer'])) {
    header("Location: customer/customer_dashboard.php");
    exit();
}
if (($current_page != 'index.php') && isset($_SESSION['admin'])) {
    header("Location: admin/admin_dashboard.php");
    exit();
}

$error = ''; // Initialize error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Password should be entered plain for verification
    $form_type = $_POST['form_type'];

    // Prepare SQL query based on the form type
    if ($form_type === 'admin') {
        $sql = "SELECT * FROM Market_administrators WHERE Name = ?"; 
    } elseif ($form_type === 'customer') {
        $sql = "SELECT * FROM Customers WHERE Name = ?";
    } else {
        $error = "Invalid form type.";
        exit();
    }

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Failed to prepare the SQL statement: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password using password_verify
        if (password_verify($password, $user['Password'])) {
            // Set the session variable based on the user type
            if ($form_type === 'admin') {
                $_SESSION['admin'] = $username;
                header("Location: admin/admin_dashboard.php");
            } else {
                $_SESSION['customer'] = $username;
                header("Location: customer/customer_dashboard.php");
            }
            session_regenerate_id(true);
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>