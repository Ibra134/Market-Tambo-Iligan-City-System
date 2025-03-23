<?php
session_start();
include "db_config.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'customer') {
    header("Location: index.php");
    exit();
}

// Display products
$sql = "SELECT * FROM Products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer</title>
</head>
<body>
<?php include "header.php"; ?>

<h2>Customer - View Products</h2>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Quantity</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
        <td><?php echo $row['Product_ID']; ?></td>
        <td><?php echo $row['Name']; ?></td>
        <td><?php echo $row['Category']; ?></td>
        <td><?php echo $row['Quantity_Available']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
