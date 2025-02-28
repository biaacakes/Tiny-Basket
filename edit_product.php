<?php
include 'db_connect.php';
include 'product.php';
 
 
 
$product = new Product($conn);
 
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $stock = $_POST['stock'];
        $price = floatval($_POST['price']); // Get price from form
        $expiryDate = $_POST['expiry_date']; // Get expiry date from form
 
        // Update product in the database (including price and expiry_date)
        if ($product->updateProduct($productId, $name, $stock, $price, $expiryDate)) {
            header("Location: product_dashboard.php");
            exit();
        } else {
            echo "Error updating product!";
        }
    }
 
    $productData = $product->getProductById($productId);
    if (!$productData) {
        echo "Product not found!";
        exit();
    }
} else {
    header("Location: product_dashboard.php");
    exit();
}?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="edit.css">
</head>
<body>
 
<div class="container">
    <h2>Edit Product</h2>
    <form method="POST">
        Product Name: <input type="text" name="name" value="<?php echo $productData['name'];?>" required><br>
        Stock: <input type="number" name="stock" value="<?php echo $productData['stock'];?>" required><br>
        Price: <input type="number" name="price" value="<?php echo $productData['price'];?>" min="0" step="0.01" required><br>
        Expiry Date: <input type="date" name="expiry_date" value="<?php echo $productData['expiry_date'];?>" required><br>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
 
</body>
</html>