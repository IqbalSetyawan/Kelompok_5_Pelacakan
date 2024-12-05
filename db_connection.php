<?php
// db_connection.php
$host = 'localhost';
$dbname = 'pembayaran'; // Ganti dengan nama database Anda
$username = 'root';     // Ganti dengan username Anda
$password = '';         // Ganti dengan password Anda

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
