<?php
include 'db_connect.php';

// Fetch total items (number of products)
$totalItemsQuery = "SELECT COUNT(*) AS totalItems FROM products";
$totalItemsResult = $conn->query($totalItemsQuery);
$totalItemsRow = $totalItemsResult->fetch_assoc();
$totalItems = $totalItemsRow['totalItems'];

// Fetch total stocks (sum of stock values)
$totalStocksQuery = "SELECT SUM(stock) AS totalStocks FROM products";
$totalStocksResult = $conn->query($totalStocksQuery);
$totalStocksRow = $totalStocksResult->fetch_assoc();
$totalStocks = $totalStocksRow['totalStocks'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
 

</head>
<body>
<div class="sidebar closed" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
    <a class="navbar-brand text-white" href="#"><span class="sidebar-text">QR BASED INVENTORY </span></a>
    <a href="dashboard.php"><span class="sidebar-text">Home</span></a>
    <a href="generateqr.php"><span class="sidebar-text">Generate QR</span></a>
    <a href="scan_qr.php"><span class="sidebar-text">Scan QR</span></a>
    <a href="product_dashboard.php"><span class="sidebar-text">Product Dashboard</span></a>
    <a href="logout.php"><span class="sidebar-text">Log Out</span></a>

</div>


    <div class="container mt-5">
        <div class="container-box">
            <h2 class="header-title">TINY BASKET GROCERY MART</h2>
            <h3 class="header-title">QR-based Inventory System</h3>
            <p class="subtext">This system allows you to generate QR codes, scan them to update stock, and view real-time product data.</p>
            
            <!-- Updated Dashboard Container -->
            <div class="dashboard-container">
                <div class="dashboard-box">
                    <h4>Total Products</h4>
                    <p class="highlight-text"><?php echo $totalItems; ?></p>
                    <a href="product_dashboard.php" class="btn btn-custom">View Products</a>
                </div>
                
                <div class="dashboard-box">
                    <h4>Total Stocks</h4>
                    <p class="highlight-text"><?php echo $totalStocks; ?></p>
                    <a href="product_dashboard.php" class="btn btn-custom">Manage Stocks</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="sidebar.js"></script>
</body>
</html>