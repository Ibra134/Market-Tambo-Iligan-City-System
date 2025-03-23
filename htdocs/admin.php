<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php'); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <header>Admin Dashboard</header>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['admin']; ?>!</h2>
        <a href="products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>