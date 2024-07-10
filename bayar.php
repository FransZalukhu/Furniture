<?php
require_once 'midtrans.php'; // Sertakan file konfigurasi Midtrans

$id_pemesanan = $_GET['id_pemesanan'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mebel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT pemesanan.id_pemesanan, produk.nama_produk, pemesanan.jumlah_pesanan, pemesanan.tgl_pemesanan, pemesanan.status_pesanan, produk.harga_produk
                           FROM pemesanan
                           JOIN produk ON pemesanan.id_produk = produk.id_produk
                           WHERE pemesanan.id_pemesanan = ? AND pemesanan.status_pesanan = 'Dikonfirmasi'");
    $stmt->execute([$id_pemesanan]);
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pemesanan) {
        echo "<script>alert('Pesanan tidak ditemukan atau belum dikonfirmasi');window.location='pesanan.php';</script>";
        exit;
    }

    // Menghitung total pembayaran
    $total = $pemesanan['jumlah_pesanan'] * $pemesanan['harga_produk'];

    // Membuat transaksi di Midtrans
    $orderId = 'ORDER-' . $id_pemesanan;  // ID unik untuk transaksi
    $transaction_details = array(
        'order_id' => $orderId,
        'gross_amount' => $total,
    );

    $item_details = array(
        array(
            'id' => $pemesanan['id_pemesanan'],
            'price' => $pemesanan['harga_produk'],
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

    $params = array(
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    );

    $snapToken = \Midtrans\Snap::getSnapToken($params);

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
