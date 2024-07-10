<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_pembeli'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='login.php';</script>";
    exit();
}

$id_pembeli = $_SESSION['id_pembeli'];

// Query untuk mengambil data pemesanan berdasarkan pembeli
$query = "SELECT pemesanan.id_pemesanan, produk.nama_produk, pemesanan.jumlah_pesanan, pemesanan.tgl_pemesanan, pemesanan.status_pesanan
          FROM pemesanan
          JOIN produk ON pemesanan.id_produk = produk.id_produk
          WHERE pemesanan.id_pembeli = $id_pembeli";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
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
            <!-- <a class="navbar-brand" href="home.php">King Mebel & Furniture</a> -->
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
                <form class="d-flex ml-auto" action="home.php" method="get">
                    <input class="form-control mr-2" type="text" name="cari" placeholder="Cari">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <!-- Data Pemesanan -->
    <div class="container mt-5">
        <h2 class="text-center">Pesanan Saya</h2>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                        <p class="card-text">ID Pemesanan: <?php echo $row['id_pemesanan']; ?></p>
                        <p class="card-text">Jumlah Pesanan: <?php echo $row['jumlah_pesanan']; ?></p>
                        <p class="card-text">Tanggal Pemesanan: <?php echo $row['tgl_pemesanan']; ?></p>
                        <p class="card-text">Status: <?php echo $row['status_pesanan']; ?></p>
                        <?php if ($row['status_pesanan'] == 'Dikonfirmasi') { ?>
                        <a href="pembayaran.php?id_pemesanan=<?php echo $row['id_pemesanan']; ?>"
                            class="btn btn-primary">Bayar Sekarang</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>