<?php
session_start();
if (!isset($_SESSION['id_pembeli'])) {
    header("Location: login.php");
    exit;
}

$id_pembeli = $_SESSION['id_pembeli'];
$id_produk = $_POST['id_produk'];
$jumlah_pesanan = $_POST['jumlah_pesanan'];
$tgl_pemesanan = date('Y-m-d');
$status_pesanan = 'Pending';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=mebel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil harga produk dari tabel produk
    $stmt = $pdo->prepare("SELECT harga_produk FROM produk WHERE id_produk = ?");
    $stmt->execute([$id_produk]);
    $produk = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produk) {
        echo "<script>alert('Produk tidak ditemukan');window.location='user_produk.php';</script>";
        exit;
    }

    $harga_produk = $produk['harga_produk'];

    // Simpan pemesanan ke database
    $stmt = $pdo->prepare("INSERT INTO pemesanan (id_pembeli, id_produk, jumlah_pesanan, tgl_pemesanan, status_pesanan, harga_produk) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_pembeli, $id_produk, $jumlah_pesanan, $tgl_pemesanan, $status_pesanan, $harga_produk]);

    echo "<script>alert('Pemesanan Berhasil');window.location='user_produk.php';</script>";
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
