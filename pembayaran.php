<?php
require_once 'midtrans.php'; // Sertakan file konfigurasi Midtrans

$id_pemesanan = $_GET['id_pemesanan'];

// Ambil detail pemesanan
try {
    $pdo = new PDO('mysql:host=localhost;dbname=mebel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT pemesanan.id_pemesanan, produk.nama_produk, pemesanan.jumlah_pesanan, pemesanan.tgl_pemesanan, pemesanan.status_pesanan, produk.harga
                           FROM pemesanan
                           JOIN produk ON pemesanan.id_produk = produk.id_produk
                           WHERE pemesanan.id_pemesanan = ?");
    $stmt->execute([$id_pemesanan]);
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pemesanan) {
        echo "<script>alert('Pesanan tidak ditemukan');window.location='pesanan.php';</script>";
        exit;
    }

    $total = $pemesanan['jumlah_pesanan'] * $pemesanan['harga'];

    $orderId = 'ORDER-' . $id_pemesanan;  // ID unik untuk transaksi
    $transaction_details = array(
        'order_id' => $orderId,
        'gross_amount' => $total,
    );

    $item_details = array(
        array(
            'id' => $pemesanan['id_pemesanan'],
            'price' => $pemesanan['harga'],
            'quantity' => $pemesanan['jumlah_pesanan'],
            'name' => $pemesanan['nama_produk'],
        ),
    );

    $customer_details = array(
        'first_name' => 'Customer',
        'last_name' => 'Name',
        'email' => 'customer@example.com',
        'phone' => '08123456789',
    );

    $transaction = array(
        'payment_type' => 'credit_card',
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    );

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);

    // Arahkan pengguna ke Midtrans
    echo "<script src='https://app.sandbox.midtrans.com/snap/snap.js' data-client-key='" . \Midtrans\Config::$clientKey . "'></script>";
    echo "<script>
        snap.pay('$snapToken', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                window.location = 'pesanan.php';
            },
            onPending: function(result) {
                alert('Pembayaran Anda sedang diproses.');
                window.location = 'pesanan.php';
            },
            onError: function(result) {
                alert('Terjadi kesalahan saat proses pembayaran.');
                window.location = 'pesanan.php';
            }
        });
    </script>";

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
