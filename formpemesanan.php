<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_pembeli'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
    exit();
}

if (!isset($_GET['id_produk'])) {
    echo "Produk tidak ditemukan.";
    exit;
}

$id_produk = $_GET['id_produk'];
$query = "SELECT * FROM produk WHERE id_produk = $id_produk";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Produk tidak ditemukan.";
    exit;
}

$row = mysqli_fetch_assoc($result);
$id_pembeli = $_SESSION['id_pembeli'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan - King Mebel & Furniture</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bg-warning navbar-dark shadow">
        <div class="container">
            <a class="navbar-brand" href="home.php"><img src="img/King Mebel & Furniture - Copy.png" width="127"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="user_produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" aria-current="page" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="img/<?php echo $row['foto']; ?>" class="img-fluid" alt="Detail Produk">
            </div>
            <div class="col-md-6">
                <h5><?php echo $row['nama_produk']; ?></h5>
                <p>Harga: <?php echo $row['harga_produk']; ?></p>
                <form action="proses_pemesanan.php" method="post">
                    <input type="hidden" name="id_produk" value="<?php echo $row['id_produk']; ?>">
                    <input type="hidden" name="id_pembeli" value="<?php echo $id_pembeli; ?>">
                    <div class="form-group">
                        <label for="jumlah_pesanan">Jumlah Pesanan</label>
                        <input type="number" class="form-control" id="jumlah_pesanan" name="jumlah_pesanan" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>