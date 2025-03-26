<?php
session_start();
require_once '../includes/database.php';  // Use centralized DB connection

// Ensure admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../admin/admin_login.php');
    exit();
}

// Fetch orders with customer info
$sql = "
    SELECT 
        t.Transaction_ID, 
        t.Date, 
        t.Total_Amount, 
        c.Username AS Customer_Name 
    FROM Transactions t
    JOIN Customers c ON t.Customer_ID = c.Customer_ID
    ORDER BY t.Date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Management</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Centralized CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        header {
            background: #4CAF50;
            color: white;
            padding: 15px;
            font-size: 24px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #4CAF50;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .actions a {
            text-decoration: none;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .view-btn {
            background: #3498db;
        }

        .cancel-btn {
            background: #e74c3c;
        }

        .actions a:hover {
            opacity: 0.8;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: #4CAF50;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<header>Order Management</header>

<div class="container">
    <h2>Existing Orders</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Transaction_ID']) ?></td>
                    <td><?= htmlspecialchars($row['Customer_Name']) ?></td>
                    <td><?= htmlspecialchars($row['Date']) ?></td>
                    <td>₱<?= number_format($row['Total_Amount'], 2) ?></td>
                    <td class="actions">
                        <a href="view_order.php?id=<?= $row['Transaction_ID'] ?>" class="view-btn">View</a>
                        <a href="cancel_order.php?id=<?= $row['Transaction_ID'] ?>" class="cancel-btn" onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
