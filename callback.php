<?php
require_once 'midtrans.php';

$notif = new \Midtrans\Notification();
$transaction = $notif->transaction_status;

$orderId = $notif->order_id;
$paymentType = $notif->payment_type;
$grossAmount = $notif->gross_amount;

// Ambil ID pemesanan dari order ID
$id_pemesanan = str_replace('ORDER-', '', $orderId);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mebel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    switch ($transaction) {
        case 'capture':
            if ($paymentType == 'credit_card') {
                // Pembayaran berhasil
                $stmt = $pdo->prepare("UPDATE pemesanan SET status_pesanan = 'Dibayar' WHERE id_pemesanan = ?");
                $stmt->execute([$id_pemesanan]);
            }
            break;

        case 'settlement':
            $stmt = $pdo->prepare("UPDATE pemesanan SET status_pesanan = 'Dibayar' WHERE id_pemesanan = ?");
            $stmt->execute([$id_pemesanan]);
            break;

        case 'pending':
            // Pembayaran belum selesai
            break;

        case 'deny':
            // Pembayaran ditolak
            $stmt = $pdo->prepare("UPDATE pemesanan SET status_pesanan = 'Ditolak' WHERE id_pemesanan = ?");
            $stmt->execute([$id_pemesanan]);
            break;

        case 'expire':
            // Pembayaran kadaluarsa
            $stmt = $pdo->prepare("UPDATE pemesanan SET status_pesanan = 'Kadaluarsa' WHERE id_pemesanan = ?");
            $stmt->execute([$id_pemesanan]);
            break;

        case 'cancel':
            // Pembayaran dibatalkan
            $stmt = $pdo->prepare("UPDATE pemesanan SET status_pesanan = 'Dibatalkan' WHERE id_pemesanan = ?");
            $stmt->execute([$id_pemesanan]);
            break;
    }
} catch (PDOException $e) {
    error_log("Error: " . htmlspecialchars($e->getMessage()));
}
?>
