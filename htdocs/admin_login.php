<?php
session_start();
include 'db_config.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Query to check admin credentials
    $stmt = $conn->prepare("SELECT * FROM Market_administrators WHERE Name = ? AND password = MD5(?)");
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Store admin data in session
        $_SESSION['admin_id'] = $admin['Admin_ID'];
        $_SESSION['admin_name'] = $admin['Name'];

        // Redirect to dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>

        <!-- Display error message -->
        <?php if (isset($error)) : ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="admin_login.php">
            <label>Username:</label>
            <input type="text" name="name" placeholder="Enter admin name" required><br><br>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter password" required><br><br>

            <button type="submit">Login</button>
        </form>

        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
