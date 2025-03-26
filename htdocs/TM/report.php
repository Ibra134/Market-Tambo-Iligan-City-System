<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Initialize purchases if not set
if (!isset($_SESSION['purchases'])) {
    $_SESSION['purchases'] = [];
}

$purchases = &$_SESSION['purchases'];

// ✅ Handle report deletion
if (isset($_GET['delete'])) {
    $index = (int)$_GET['delete'];
    
    if (isset($purchases[$index])) {
        array_splice($purchases, $index, 1);  // Remove the selected report
        $_SESSION['purchases'] = $purchases;   // Update the session
        header('Location: report.php');        // Redirect to refresh the report
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Purchase Report</title>
</head>
<body>
<header>
    <h1>Purchase Report</h1>
    <a href="admin_dashboard.php" style="color: white" >Back to Dashboard</a>
</header>

<div class="container">
    <h2>All Purchases</h2>
    <?php if (empty($purchases)): ?>
        <p>No purchases made yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Products</th>
                    <th>Total Amount</th>
                    <th>Date & Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $index => $purchase): ?>
                    <tr>
                        <td><?= htmlspecialchars($purchase['customer']) ?></td>
                        <td>
                            <?php foreach ($purchase['items'] as $item): ?>
                                <?= htmlspecialchars($item['name']) ?> (x<?= $item['quantity'] ?>) - ₱<?= number_format($item['price'], 2) ?><br>
                            <?php endforeach; ?>
                        </td>
                        <td>₱<?= number_format($purchase['total'], 2) ?></td>
                        <td><?= $purchase['date'] ?></td>
                        <td>
                            <a href="report.php?delete=<?= $index ?>" 
                               onclick="return confirm('Are you sure you want to delete this report?')">
                               🗑️ Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
