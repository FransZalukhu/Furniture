<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id_produk = $id_produk";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    // Handle case when no id is provided, redirect or show error
    header('Location: produk.php');
    exit();
}
?>

<!-- Konten form edit yang dimuat di dalam modal overlay -->
<div class="overlay">
    <div class="container mt-5">
        <h2>Edit Produk</h2>
        <form action="update_produk.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
            <!-- Form fields for editing -->
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                    value="<?php echo $data['nama_produk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="harga_produk">Harga Produk</label>
                <input type="number" class="form-control" id="harga_produk" name="harga_produk"
                    value="<?php echo $data['harga_produk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah_produk">Jumlah Produk</label>
                <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk"
                    value="<?php echo $data['jumlah_produk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="tgl_masuk">Tanggal Masuk</label>
                <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk"
                    value="<?php echo $data['tgl_masuk']; ?>" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto Produk</label>
                <input type="file" class="form-control-file" id="foto" name="foto">
                <img src="img/<?php echo $data['foto']; ?>" width="100">
            </div>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
</div>