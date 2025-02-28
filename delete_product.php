<?php
include 'db_connect.php';
include 'product.php';

$product = new Product($conn);

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Delete product from the database
    if ($product->deleteProduct($productId)) {
        header("Location: product_dashboard.php");
        exit();
    } else {
        echo "Error deleting product!";
    }
} else {
    header("Location: product_dashboard.php");
    exit();
}?>