<?php
session_start();
include 'admin_header.php';  
include 'static_data.php';

// Load products from session or initialize if not set
if (!isset($_SESSION['products'])) {
    $_SESSION['products'] = $products;
}

$products = &$_SESSION['products'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_id = count($products) + 1;  // Generate unique ID
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    // Handle image upload
    $target_dir = "assets/products/";

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);  // Create the folder if it doesn't exist
    }

    $image = "assets/products/default.png";  // Default image

    if (!empty($_FILES['image']['name'])) {
        $image_path = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $image = $image_path;  // Use uploaded image path
        }
    }

    // Add new product to the session
    $new_product = [
        'id' => $new_id,
        'name' => $name,
        'category' => $category,
        'price' => $price,
        'image' => $image
    ];

    $products[] = $new_product;  // Add to session array

    // ✅ Save back to the session
    $_SESSION['products'] = $products;

    // ✅ Redirect to admin dashboard to reflect changes
    header('Location: admin_dashboard.php');
    exit();
}
?>

<div class="container">
    <h2>Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Category:</label>
        <input type="text" name="category" required>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required>

        <label>Image:</label>
        <input type="file" name="image">

        <button type="submit">Add Product</button>
    </form>
</div>

<?php include 'footer.php'; ?>
