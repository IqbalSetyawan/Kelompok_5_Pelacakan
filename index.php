<?php
// db_connection.php: Menghubungkan aplikasi ke database
include 'db_connection.php';

// Cek jika formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil ID Pembayaran (transaction_id) dari input form
    $transaction_id = $_POST['transaction_id'];

    // Query untuk mengambil data transaksi dan status berdasarkan transaction_id
    $sql = "
        SELECT 
            p.transaction_id, 
            p.total_price, 
            p.created_at, 
            s.status, 
            s.last_updated, 
            s.location, 
            s.remarks
        FROM 
            pembayaran p
        JOIN 
            status_paket s ON p.transaction_id = s.transaction_id
        WHERE 
            p.transaction_id = :transaction_id;
    ";

    // Menyiapkan dan mengeksekusi query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':transaction_id', $transaction_id);
    $stmt->execute();

    // Mengambil hasil query
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Mengecek jika data ditemukan
    if ($result) {
        // Menampilkan hasil pencarian
        echo "<h3>Hasil Pencarian:</h3>";
        echo "<p><strong>ID Transaksi:</strong> " . $result['transaction_id'] . "</p>";
        echo "<p><strong>Total Harga:</strong> " . $result['total_price'] . "</p>";
        echo "<p><strong>Waktu Transaksi:</strong> " . $result['created_at'] . "</p>";
        echo "<p><strong>Status:</strong> " . $result['status'] . "</p>";
        echo "<p><strong>Terakhir Diperbarui:</strong> " . $result['last_updated'] . "</p>";
        echo "<p><strong>Lokasi:</strong> " . $result['location'] . "</p>";
        echo "<p><strong>Keterangan:</strong> " . $result['remarks'] . "</p>";
    } else {
        // Jika tidak ditemukan
        echo "<p>ID Pembayaran tidak ditemukan.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengiriman</title>
</head>
<body>
    <h2>Cek Status Pengiriman Berdasarkan ID Pembayaran</h2>
    <form action="index.php" method="post">
        <label for="transaction_id">Masukkan ID Pembayaran:</label>
        <input type="number" id="transaction_id" name="transaction_id" required>
        <button type="submit">Cek Status</button>
    </form>
</body>
</html>
