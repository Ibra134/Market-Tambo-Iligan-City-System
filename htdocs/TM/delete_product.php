<?php
include 'header.php';
include 'static_data.php';

$id = $_GET['id'] ?? null;

if ($id) {
    foreach ($products as $index => $product) {
        if ($product['id'] == $id) {
            unset($products[$index]);
            echo "<p>Product deleted successfully!</p>";
            break;
        }
    }
}
?>

<div class="container">
    <h2>Delete Product</h2>
    <p>Product with ID <?= htmlspecialchars($id) ?> has been deleted.</p>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</div>

<?php include 'footer.php'; ?>
