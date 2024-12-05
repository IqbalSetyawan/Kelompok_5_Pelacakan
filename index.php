<?php
// Mengimpor file PHP yang berisi logika pemrosesan
include 'proses.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengiriman</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Cek Status Pengiriman Berdasarkan ID Pembayaran</h2>
        <form action="index.php" method="post">
            <label for="transaction_id">Masukkan ID Pembayaran:</label>
            <input type="number" id="transaction_id" name="transaction_id" required>
            <button type="submit">Cek Status</button>
        </form>

        <?php if (isset($transaction_details)): ?>
            <?php if ($transaction_details): ?>
                <h3>Hasil Pencarian:</h3>
                <p><strong>ID Transaksi:</strong> <?= $transaction_details['transaction_id'] ?></p>
                <p><strong>Total Harga:</strong> <?= $transaction_details['total_price'] ?></p>
                <p><strong>Waktu Transaksi:</strong> <?= $transaction_details['created_at'] ?></p>
                <p><strong>Status:</strong> <?= $transaction_details['status'] ?></p>
                <p><strong>Terakhir Diperbarui:</strong> <?= $transaction_details['last_updated'] ?></p>
                <p><strong>Lokasi:</strong> <?= $transaction_details['location'] ?></p>
                <p><strong>Keterangan:</strong> <?= $transaction_details['remarks'] ?></p>
            <?php else: ?>
                <p>ID Pembayaran tidak ditemukan.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
