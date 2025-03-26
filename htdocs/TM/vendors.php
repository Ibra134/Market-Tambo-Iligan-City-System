<?php
session_start();
include 'static_data.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Vendors - Admin Dashboard</title>
</head>
<body>
<header>
    <h1>Vendors</h1>
    <a href="admin_dashboard.php" style="color: white">Back to Dashboard</a>
    <a href="?logout=true" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
</header>

<div class="container">
    <h2>Vendor List</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Contact Info</th>
            <th>Location</th>
        </tr>
        <?php foreach ($vendors as $vendor): ?>
            <tr>
                <td><?= htmlspecialchars($vendor['name']) ?></td>
                <td><?= htmlspecialchars($vendor['contact']) ?></td>
                <td><?= htmlspecialchars($vendor['location']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
