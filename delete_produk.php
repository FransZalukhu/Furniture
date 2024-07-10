<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Ambil nama file foto sebelum menghapus data dari database
    $query_select = "SELECT foto FROM produk WHERE id_produk = $id_produk";
    $result_select = mysqli_query($koneksi, $query_select);
    if ($result_select) {
        $row = mysqli_fetch_assoc($result_select);
        $foto_produk = $row['foto'];

        // Hapus file foto dari folder img
        $file_path = 'img/' . $foto_produk;
        if (file_exists($file_path)) {
            unlink($file_path); // Menghapus file dari folder
        }
    }

    // Hapus data produk dari database
    $query_delete = "DELETE FROM produk WHERE id_produk = $id_produk";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if ($result_delete) {
        // Redirect kembali ke halaman produk.php setelah penghapusan
        header('Location: produk.php');
        exit();
    } else {
        // Handle error jika operasi penghapusan gagal
        die("Delete gagal: " . mysqli_error($koneksi));
    }
} else {
    // Handle kasus saat tidak ada id yang diberikan, redirect atau tampilkan error
    header('Location: produk.php');
    exit();
}
