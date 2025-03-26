<?php
session_start();
include 'admin_header.php';

if (!isset($_SESSION['products'])) {
    include 'static_data.php';
    $_SESSION['products'] = $products;
}

$products = $_SESSION['products'];

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$_SESSION['products'] = $products;
?>

<div class="container">
    <h2>Admin Dashboard</h2>
    <a href="add_product.php" style="color: green;">Add Product</a>
    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><img src="<?= htmlspecialchars($product['image']) ?>" width="80" alt="Product Image"></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['category']) ?></td>
                <td>₱<?= number_format($product['price'], 2) ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $product['id'] ?>">Edit</a>
                    <a href="delete_product.php?id=<?= $product['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include 'footer.php'; ?>
