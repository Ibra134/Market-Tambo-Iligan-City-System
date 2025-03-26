<?php
session_start();
require_once '../includes/database.php'; 

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer_login.php");
    exit();
}

$query = "SELECT * FROM Products";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer - View Products</title>
    <link rel="stylesheet" href="../styles/style.css"> <!-- Updated CSS path -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 80%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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

        a {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="container">
    <h2>Customer - View Products</h2>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['Product_ID']) ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Category']) ?></td>
            <td><?= htmlspecialchars($row['Quantity_Available']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="../customer_dashboard.php">Back to Dashboard</a>
</div>

<?php
$stmt->close();
$conn->close();
?>

</body>
</html>
