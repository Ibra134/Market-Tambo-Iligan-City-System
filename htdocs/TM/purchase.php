<?php 
session_start();
include 'static_data.php';

if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'customer') {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (!isset($_SESSION['purchases'])) {
    $_SESSION['purchases'] = [];
}

// Handle adding product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        // Validate and add to cart
        foreach ($products as $product) {
            if ($product['id'] == $product_id) {
                $_SESSION['cart'][] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
                break;
            }
        }
    }

    // Handle purchase action
    if (isset($_POST['purchase'])) {
        $total = 0;
        $purchase_items = [];

        foreach ($_SESSION['cart'] as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
            $purchase_items[] = $item;
        }

        // Store the purchase in the session for reports
        $_SESSION['purchases'][] = [
            'customer' => $_SESSION['user'] ?? 'Guest',
            'items' => $purchase_items,
            'total' => $total,
            'date' => date('Y-m-d H:i:s')
        ];

        echo "<script>alert('Thank you for purchasing!'); window.location.href = 'customer_dashboard.php';</script>";
        $_SESSION['cart'] = [];  // Clear the cart after purchase
        exit();
    }

    // Handle cancel action
    if (isset($_POST['cancel'])) {
        $_SESSION['cart'] = [];
        echo "<script>alert('Purchase cancelled.'); window.location.href = 'purchase.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/style.css">
    <title>Purchase Products</title>
</head>
<body>
<header>
    <h1>Purchase Products</h1>
    <a href="customer_dashboard.php">Back to Dashboard</a>
</header>

<div class="container">
    <h2>Products</h2>
    <form method="POST" action="purchase.php">
        <label>Product:</label>
        <select name="product_id" required>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['id'] ?>"><?= $product['name'] ?> - ₱<?= number_format($product['price'], 2) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Quantity:</label>
        <input type="number" name="quantity" min="1" value="1" required>

        <button type="submit">Add to Cart</button>
    </form>

    <h3>Cart</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        <?php 
        $total = 0;
        foreach ($_SESSION['cart'] as $item): 
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>₱<?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₱<?= number_format($subtotal, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong>₱<?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>

    <!-- Purchase and Cancel buttons -->
    <form method="POST" action="purchase.php">
        <button type="submit" name="purchase">Purchase</button>
        <button type="submit" name="cancel">Cancel</button>
    </form>
</div>

</body>
</html>
