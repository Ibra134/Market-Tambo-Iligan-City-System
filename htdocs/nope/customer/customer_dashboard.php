<?php
// filepath: products.php
include 'database.php'; // Include your database connection file

$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color:hsl(72, 23.80%, 95.90%);
    margin: 0;
    padding: 40px;
    text-align: center;
}

h1 {
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 20px;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    overflow: hidden;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

th {
    background-color: #ff5733;
    color: white;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: #ffe0b2;
}

tr:nth-child(odd) {
    background-color: #fff3e0;
}

tr:hover {
    background-color: #ffcc80;
    transition: 0.3s;
}

/* Color coding for different product categories */
tr.electronics {
    background-color: #81c784;
    color: #fff;
}

tr.furniture {
    background-color: #64b5f6;
    color: #fff;
}

tr.grocery {
    background-color: #ffb74d;
    color: #fff;
}body {
    font-family: Arial, sans-serif;
    background-color: #e3f2fd;
    margin: 0;
    padding: 20px;
    text-align: center;
}

h1 {
    color: #2c3e50;
    font-size: 28px;
    margin-bottom: 20px;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 36px;
    overflow: hidden;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
    font-size: 16px;
}

th {
    background-color:rgb(0, 0, 3);
    color: white;
    text-transform: uppercase;
}

tr:nth-child(even) {
    background-color: #ffe0b2;
}

tr:nth-child(odd) {
    background-color: #fff3e0;
}

tr:hover {
    background-color: #ffcc80;
    transition: 0.3s;
}

/* Color coding for different product categories */
tr.electronics {
    background-color: #81c784;
    color: #fff;
}

tr.furniture {
    background-color: #64b5f6;
    color: #fff;
}

tr.grocery {
    background-color: #ffb74d;
    color: #fff;
}
    </style>
</head>
<body>
    <h1>Products</h1>
    <table border="1">
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Quantity</th>
            <th>Supplier ID</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['ProductID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Description']; ?></td>
            <td><?php echo $row['Price']; ?></td>
            <td><?php echo $row['StockQuantity']; ?></td>
            <td><?php echo $row['SupplierID']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>

