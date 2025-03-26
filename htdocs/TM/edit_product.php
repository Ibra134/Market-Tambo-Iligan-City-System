<?php
session_start();  

include 'admin_header.php';

if (!isset($_SESSION['products'])) {
    include 'static_data.php';
    $_SESSION['products'] = $products;
}

$products = &$_SESSION['products'];

$id = $_GET['id'] ?? null;
$product = null;

foreach ($products as &$item) {
    if ($item['id'] == $id) {
        $product = &$item;
        break;
    }
}

if (!$product) {
    echo "<p>Product not found!</p>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $product['name'] = $_POST['name'];
    $product['category'] = $_POST['category'];
    $product['price'] = $_POST['price'];

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "assets/products/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $product['image'] = $target_file;
        }
    }

    $_SESSION['products'] = $products;

    header('Location: admin_dashboard.php');  
    exit();
}
?>

<div class="container">
    <h2>Edit Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

        <label>Current Image:</label><br>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="150"><br><br>

        <label>New Image (optional):</label>
        <input type="file" name="image">

        <button type="submit">Update Product</button>
    </form>
</div>

<?php include 'footer.php'; ?>
