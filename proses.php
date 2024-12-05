<?php
// db_connection.php: Menghubungkan aplikasi ke database
include 'db_connection.php';

// Fungsi untuk mengambil data transaksi berdasarkan transaction_id
function get_transaction_status($transaction_id, $conn) {
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
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Cek jika formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction_id = $_POST['transaction_id'];
    $result = get_transaction_status($transaction_id, $conn);

    // Menyimpan hasil pencarian ke dalam variabel untuk digunakan pada HTML
    if ($result) {
        $transaction_details = [
            'transaction_id' => $result['transaction_id'],
            'total_price' => $result['total_price'],
            'created_at' => $result['created_at'],
            'status' => $result['status'],
            'last_updated' => $result['last_updated'],
            'location' => $result['location'],
            'remarks' => $result['remarks']
        ];
    } else {
        $transaction_details = null;
    }
}
?>
