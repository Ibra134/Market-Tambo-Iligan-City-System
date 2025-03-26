<?php
// Check if session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title> <!-- Added title for better SEO and accessibility -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Externalized CSS -->
</head>
<body>

<header>
    <div class="nav-links">
        <?php if (isset($_SESSION['admin_id'])): ?>
            <!-- Admin Navigation -->
            <a href="../admin/admin_dashboard.php">Dashboard</a>
            <a href="../admin/manage_products.php">Products</a>
            <a href="../admin/order_list.php">Orders</a>
        <?php elseif (isset($_SESSION['customer_id'])): ?>
            <!-- Customer Navigation -->
            <a href="../customer/customer_dashboard.php">Home</a>
            <a href="../customer/products.php">Products</a>
            <a href="../customer/orders.php">My Orders</a>
        <?php else: ?>
            <!-- Guest Navigation -->
            <a href="../index.php">Home</a>
            <a href="../customer/customer_login.php">Customer Login</a>
            <a href="../admin/admin_login.php">Admin Login</a>
        <?php endif; ?>
    </div>

    <div class="user-info">
        <?php if (isset($_SESSION['admin_id'])): ?>
            <span>Admin: <?= htmlspecialchars($_SESSION['admin_name']) ?></span>
        <?php elseif (isset($_SESSION['customer_id'])): ?>
            <span>Customer: <?= htmlspecialchars($_SESSION['customer_name']) ?></span>
        <?php else: ?>
            <span>Guest</span>
        <?php endif; ?>

        <?php if (isset($_SESSION['admin_id']) || isset($_SESSION['customer_id'])): ?>
            <a href="../logout.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    </div>
</header>

</body>
</html>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background:rgba(244, 244, 244, 0.51);
    }

    header {
        background:rgb(43, 255, 0);
        color: white;
        padding: 15px 20px;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-links {
        display: flex;
        gap: 15px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        transition: 0.3s;
    }

    .nav-links a:hover {
        background:rgb(6, 233, 17);
        border-radius: 5px;
    }

    .user-info {
        font-size: 14px;
    }

    .logout-btn {
        background: #e74c3c;
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #c0392b;
    }
</style>