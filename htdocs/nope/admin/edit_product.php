<?php
session_start();
require_once '../includes/database.php';  // Use centralized DB connection

// Ensure admin authentication
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

// Validate and sanitize product ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    echo "Invalid product ID.";
    exit();
}

// Fetch product details
$stmt = $conn->prepare("
    SELECT p.Product_ID, p.Product_Name, p.Category, p.Image_Path, i.Quantity_Available
    FROM Products p
    LEFT JOIN Inventory i ON p.Product_ID = i.Product_ID
    WHERE p.Product_ID = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$product) {
    echo "Product not found.";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'] ?? '';
    $category = $_POST['category'] ?? '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;

    $imagePath = $product['Image_Path'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../uploads/";
        
        // Create the uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . basename($_FILES['image']['name']);

        // Secure image upload
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);

        if (in_array($fileType, $allowedTypes)) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            exit();
        }
    }

    // Start transaction for data integrity
    $conn->begin_transaction();

    try {
        // Update product details
        $stmt = $conn->prepare("
            UPDATE Products 
            SET Product_Name = ?, Category = ?, Image_Path = ? 
            WHERE Product_ID = ?
        ");
        $stmt->bind_param("sssi", $product_name, $category, $imagePath, $id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update product: " . $stmt->error);
        }
        $stmt->close();

        // Update inventory quantity
        $stmt = $conn->prepare("
            UPDATE Inventory 
            SET Quantity_Available = ? 
            WHERE Product_ID = ?
        ");
        $stmt->bind_param("ii", $quantity, $id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update inventory: " . $stmt->error);
        }
        $stmt->close();

        $conn->commit();
        
        $_SESSION['success'] = "Product updated successfully.";
        header("Location: ../admin/admin_dashboard.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/style.css">  <!-- Centralized stylesheet -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 0 10px #ccc;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
        }

        input, button, select {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['Product_Name'] ?? '') ?>" required>

        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($product['Category'] ?? '') ?>" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($product['Quantity_Available'] ?? 0) ?>" required>

        <label>Current Image:</label><br>
        <?php if (!empty($product['Image_Path'])): ?>
            <img src="<?= htmlspecialchars($product['Image_Path']) ?>" alt="Product Image">
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>

        <label>New Image (optional):</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Save Changes</button>
    </form>

    <a href="../admin/admin_dashboard.php">Back</a>
</div>

</body>
</html>
