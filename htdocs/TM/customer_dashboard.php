<?php
session_start();
include 'header.php';

// Ensure products are loaded from the session
if (!isset($_SESSION['products'])) {
    include 'static_data.php';  // Fallback to static data if session is empty
    $_SESSION['products'] = $products;  
}

$products = $_SESSION['products'];  // Use the latest session products

// Check if the user is logged in and is a customer
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'customer') {
    header('Location: index.php');
    exit();
}
?>

<div class="container">
    <h2>Customer Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']) ?>!</p>

    <h3>Available Products</h3>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="80"></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td>₱<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <a href="purchase.php?id=<?= $product['id'] ?>">Purchase</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
