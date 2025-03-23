<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include 'db_config.php';

// Fetch existing orders
$sql = "SELECT * FROM Transactions";  // Adjust to fit your logic
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Order List</title>
</head>
<body>
    <header>Order Management</header>
    <div class="container">
        <h2>Existing Orders</h2>
        <table>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Transaction_ID'] ?></td>
                <td><?= $row['Date'] ?></td>
                <td><?= $row['Total_Amount'] ?></td>
                <td><!-- Actions like View/Cancel here --></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>