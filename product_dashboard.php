<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="product_dashboard.css">
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
<div class="container mt-5">
    <h2 class="font-weight-bold text-dark text-center">Product Dashboard</h2>

    <div class="row mt-3">
        <div class="col-md-8 offset-md-2"> <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search products...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Expiry Date</th>
                    <th>QR Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTableBody"> 
                <?php
                $sql = "SELECT * FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>". htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>". htmlspecialchars($row["stock"]) . "</td>";
                        echo "<td>". htmlspecialchars($row["price"]) . "</td>";
                        echo "<td>". htmlspecialchars($row["expiry_date"]) . "</td>";
                        echo "<td><img src='qrcodes/". htmlspecialchars($row["qr_code"]) . ".png' width='100' class='img-fluid'></td>";
                        echo "<td>";
                        echo "<a href='edit_product.php?id=". $row["id"] . "' class='btn btn-primary btn-sm'>Edit</a> ";
                        echo "<a href='delete_product.php?id=". $row["id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="sidebar.js"></script>

<script>
$(document).ready(function(){
  $("#searchButton").click(function(){
    var searchText = $("#searchInput").val().toLowerCase(); 

    $("#productTableBody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(searchText) > -1)
    });
  });
});
</script>

</body>
</html>