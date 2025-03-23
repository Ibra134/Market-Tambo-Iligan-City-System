<?php
session_start();

// Match the session key with login script
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
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

        .dashboard-container {
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

<div class="dashboard-container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>You are successfully logged in as a customer.</p>

    <a href="products.php">View Products</a>
    <a href="orders.php">My Orders</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
