<?php
include 'koneksi.php';

$id_produk = $_POST['id_produk'];
$nama_produk = $_POST['nama_produk'];
$harga_produk = $_POST['harga_produk'];
$jumlah_produk = $_POST['jumlah_produk'];
$tgl_masuk = $_POST['tgl_masuk'];
$foto = $_FILES['foto']['name'];

if ($foto != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg');
    $x = explode('.', $foto);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['foto']['tmp_name'];
    $angka_acak = rand(1, 999);

    $nama_gambar_baru = $angka_acak . '-' . $foto;
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        move_uploaded_file($file_tmp, 'img/' . $nama_gambar_baru);

        $query = "UPDATE produk SET nama_produk='$nama_produk', harga_produk='$harga_produk', jumlah_produk='$jumlah_produk', tgl_masuk='$tgl_masuk', foto='$nama_gambar_baru' WHERE id_produk='$id_produk'";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
        } else {
            echo "<script>alert('Data berhasil diupdate.');window.location='produk.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='produk.php';</script>";
    }
} else {
    $query = "UPDATE produk SET nama_produk='$nama_produk', harga_produk='$harga_produk', jumlah_produk='$jumlah_produk', tgl_masuk='$tgl_masuk' WHERE id_produk='$id_produk'";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($koneksi) . " - " . mysqli_error($koneksi));
    } else {
        echo "<script>alert('Data berhasil diupdate.');window.location='produk.php';</script>";
    }
}