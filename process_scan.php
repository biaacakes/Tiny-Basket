<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qrCode = trim($_POST['qr_code']); // Remove spaces

    // Debugging: Print scanned QR code
    // echo "Scanned QR Code: <b>$qrCode</b><br>";

    // Check if QR code exists in the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE qr_code = ?");
    $stmt->bind_param("s", $qrCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    echo "<div class='scan-result-container'>";
if ($product) {
    $newStock = $product['stock'] + 1;
    $update_stmt = $conn->prepare("UPDATE products SET stock = ? WHERE qr_code = ?");
    $update_stmt->bind_param("is", $newStock, $qrCode);
    $update_stmt->execute();

    echo "<div class='success-message'>";
    echo "<h3>✅ Product Found!</h3>";
    echo "<p><strong>Product Name:</strong> " . $product['name'] . "</p>";
    echo "<p><strong>Updated Stock:</strong> " . $newStock . "</p>";
    echo "</div>";
} else {
    echo "<div class='error-message'>";
    echo "<h3>❌ QR Code Not Found!</h3>";
    echo "<p>Please check the code and try again.</p>";
    echo "</div>";
}
echo "</div>"; // Closing the scan-result-container div

    
}
?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
 <link rel="stylesheet" href="process_scan.css">
 <link rel="stylesheet" href="dashboard.css">
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="sidebar.js"></script>
</body>
        
 </html>