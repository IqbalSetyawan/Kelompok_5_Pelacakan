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
        $result_display = "<h3>Hasil Pencarian:</h3>";
        $result_display .= "<p><strong>ID Transaksi:</strong> " . $result['transaction_id'] . "</p>";
        $result_display .= "<p><strong>Total Harga:</strong> " . $result['total_price'] . "</p>";
        $result_display .= "<p><strong>Waktu Transaksi:</strong> " . $result['created_at'] . "</p>";
        $result_display .= "<p><strong>Status:</strong> " . $result['status'] . "</p>";
        $result_display .= "<p><strong>Terakhir Diperbarui:</strong> " . $result['last_updated'] . "</p>";
        $result_display .= "<p><strong>Lokasi:</strong> " . $result['location'] . "</p>";
        $result_display .= "<p><strong>Keterangan:</strong> " . $result['remarks'] . "</p>";
    } else {
        // Jika tidak ditemukan
        $result_display = "<p>ID Pembayaran tidak ditemukan.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pengiriman</title>
    <style>
        /* Reset beberapa elemen dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* Warna abu-abu terang */
            color: #333; /* Warna teks abu gelap */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        /* Container utama */
        .container {
            background-color: #fff; /* Warna putih */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px; /* Lebar maksimal 600px */
            text-align: center;
        }

        /* Heading */
        h3 {
            font-size: 24px;
            color: #1a73e8; /* Biru terang */
            margin-bottom: 20px;
        }

        /* Teks untuk hasil pencarian */
        p {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.5;
        }

        /* Label form dan input */
        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border: 2px solid #ddd; /* Border abu-abu terang */
            border-radius: 4px;
            width: 100%;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        /* Tombol */
        button {
            background-color: #1a73e8; /* Biru terang */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #165d8e; /* Biru lebih gelap saat hover */
        }

        /* Styling untuk tampilan hasil pencarian */
        h3, p {
            color: #333;
        }

        h3 {
            margin-top: 30px;
        }

        p strong {
            color: #1a73e8; /* Warna biru untuk label */
        }

        p {
            font-size: 16px;
            color: #555; /* Warna teks abu-abu */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cek Status Pengiriman Berdasarkan ID Pembayaran</h2>
        <form action="index.php" method="post">
            <label for="transaction_id">Masukkan ID Pembayaran:</label>
            <input type="number" id="transaction_id" name="transaction_id" required>
            <button type="submit">Cek Status</button>
        </form>

        <?php
        // Menampilkan hasil pencarian jika ada
        if (isset($result_display)) {
            echo $result_display;
        }
        ?>
    </div>
</body>
</html>
