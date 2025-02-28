<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="scan_qr.css">
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
  



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


<<div class="container">
        <div class="content">
            <h2 class="font-weight-bold text-dark">Scan QR Code</h2>
            <div class="text-center">
                <video id="preview"></video>
            </div>
            
            <form id="qrForm" action="process_scan.php" method="POST" class="mt-3">
                <input type="text" name="qr_code" id="qr_code" class="form-control" readonly>
                <button type="submit" class="btn btn-primary btn-block mt-3">Update Stock</button>
            </form>
        </div>
    </div>
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    
    scanner.addListener('scan', function (content) {
        console.log("Scanned QR Code: " + content);
        document.getElementById('qr_code').value = content;
        document.getElementById('qrForm').submit();
    });

    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            alert('No cameras found.');
        }
    }).catch(function (e) {
        console.error("Camera error:", e);
        alert("Error accessing camera: " + e);
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="sidebar.js"></script>
</body>
</html>
