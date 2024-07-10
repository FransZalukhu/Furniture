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

    $stmt = $pdo->prepare("INSERT INTO pemesanan (id_pembeli, id_produk, jumlah_pesanan, tgl_pemesanan, status_pesanan) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$id_pembeli, $id_produk, $jumlah_pesanan, $tgl_pemesanan, $status_pesanan]);

    echo "<script>alert('Pemesanan Berhasil');window.location='user_produk.php';</script>";
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
