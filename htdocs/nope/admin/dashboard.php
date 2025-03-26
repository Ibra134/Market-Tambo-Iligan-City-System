<?php
session_start();
include 'database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit();
}

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $quantity = intval($_POST['quantity']);

    $uploadDir = "uploads/";
    $imagePath = "";

    if (!empty($_FILES['image']['name'])) {
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $stmt = $conn->prepare("INSERT INTO Products (Product_name, Category, Image_Path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $category, $imagePath);
    $stmt->execute();
    $product_id = $stmt->insert_id;
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO Inventory (Product_ID, Quantity_Available) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $quantity);
    $stmt->execute();
    $stmt->close();
}

$query = "
    SELECT p.Product_ID, p.Product_name, p.Category, p.Image_Path, i.Quantity_Available 
    FROM Products p 
    LEFT JOIN Inventory i ON p.Product_ID = i.Product_ID
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            text-align: center;
        }
        form, table {
            width: 100%;
            margin-bottom: 20px;
        }
        input, button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        button {
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        tr:hover {
            background: #f1f1f1;
        }
        img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .actions a {
            text-decoration: none;
            color: #4CAF50;
            margin: 0 10px;
        }
        .actions a:hover {
            color: #45a049;
        }
        .logout-btn {
            background: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: #e60000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>

    <!-- Add Product Form -->
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="product_name" required>

        <label>Category:</label>
        <input type="text" name="category" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" required>

        <label>Product Image:</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>

    <!-- Product List Table -->
    <h3>Product List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['Product_ID'] ?></td>
                <td>
                    <img src="<?= $row['Image_Path'] ?>" alt="Product Image">
                </td>
                <td><?= htmlspecialchars($row['Product_name']) ?></td>
                <td><?= htmlspecialchars($row['Category']) ?></td>
                <td><?= htmlspecialchars($row['Quantity_Available']) ?></td>
                <td class="actions">
                    <a href="edit_product.php?id=<?= $row['Product_ID'] ?>">Edit</a> |
                    <a href="delete_product.php?id=<?= $row['Product_ID'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>
