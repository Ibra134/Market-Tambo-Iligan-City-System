<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}
include 'db_config.php';

// Fetch products
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Product List</title>
</head>
<body>
    <header>Product List</header>
    <div class="container">
        <h2>Products</h2>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Product_ID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['Category'] ?></td>
                <td>
                    <a href="#">Edit</a> | <a href="#">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <h3>Add New Product</h3>
        <form action="add_product.php" method="POST">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="text" name="category" placeholder="Category" required>
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>