<?php
include 'phpqrcode/qrlib.php';
include 'db_connect.php';
include 'product.php';

$product = new Product($conn);

$qrCodeGenerated = false;
$qrPath = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $stock = intval($_POST['stock']);
    $price = floatval($_POST['price']);
    $expiryDate = $_POST['expiry_date'];

    if (!empty($name) && $stock > 0 && $price > 0 && !empty($expiryDate)) {
        // Generate unique product code
        $productCode = uniqid();
        
        // Ensure QR codes directory exists
        if (!file_exists('qrcodes')) {
            mkdir('qrcodes', 0777, true);
        }

        // Insert product into the database
        if ($product->addProduct($name, $stock, $productCode, $price, $expiryDate)) {
            // Generate QR Code
            $qrPath = "qrcodes/" . $productCode . ".png";
            QRcode::png($productCode, $qrPath, QR_ECLEVEL_L, 10);
            $qrCodeGenerated = true;
        } else {
            $error = "Error adding product!";
        }
    } else {
        $error = "Please enter valid product details!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="generateqr.css">
</head>
<body>

<div class="sidebar closed" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <a class="navbar-brand text-white" href="#"><span class="sidebar-text">RFID Inventory</span></a>
    <a href="dashboard.php"><span class="sidebar-text">Home</span></a>
    <a href="generateqr.php"><span class="sidebar-text">Generate QR</span></a>
    <a href="scan_qr.php"><span class="sidebar-text">Scan QR</span></a>
    <a href="product_dashboard.php"><span class="sidebar-text">Product Dashboard</span></a>
</div>

<div class="container">
    <div class="content">
        <h2>Generate Product QR Code</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" class="form-control mb-3" placeholder="Enter product name" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock Quantity</label>
                <input type="number" id="stock" name="stock" class="form-control mb-3" placeholder="Enter stock quantity" min="1" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" class="form-control mb-3" placeholder="Enter price" min="0" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" class="form-control mb-3" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Generate QR</button>
        </form>
    </div>
</div>


<?php if ($qrCodeGenerated): ?>
    <div class="qr-container mt-4">
        <h3 class="text-dark">QR Code Generated</h3>
        <img src="<?= htmlspecialchars($qrPath) ?>" alt="QR Code" class="img-fluid mt-2">
    </div>
<?php elseif (!empty($error)): ?>
    <p class="error-message text-danger mt-3"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="sidebar.js"></script>
</body>
</html>
