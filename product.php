<?php
 
class Product {
    private $conn;
   
    public function __construct($db) {
        $this->conn = $db;
    }
 
    // Add product to the database
    public function addProduct($name, $stock, $productCode, $price, $expiryDate) {
        $sql = "INSERT INTO products (name, stock, qr_code, price, expiry_date)
                VALUES ('$name', '$stock', '$productCode', '$price', '$expiryDate')";
        return $this->conn->query($sql);
    }
 
    // Get product by QR Code
    public function getProductByQRCode($qrCode) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE qr_code =?");
        $stmt->bind_param("s", $qrCode);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
 
    // Update stock when QR is scanned
    public function updateStock($qrCode) {
        $product = $this->getProductByQRCode($qrCode);
        if ($product) {
            $newStock = $product['stock'] + 1;
            $stmt = $this->conn->prepare("UPDATE products SET stock =? WHERE qr_code =?");
            $stmt->bind_param("is", $newStock, $qrCode);
            return $stmt->execute();
        }
        return false;
    }
 
    // Get product by ID
    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id =?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
 
    // Update product
    public function updateProduct($id, $name, $stock, $price, $expiryDate) {
        $stmt = $this->conn->prepare("UPDATE products SET name =?, stock =?, price =?, expiry_date =? WHERE id =?");
        $stmt->bind_param("siisi", $name, $stock, $price, $expiryDate, $id);
        return $stmt->execute();
    }
 
    // Delete product
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id =?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}?>