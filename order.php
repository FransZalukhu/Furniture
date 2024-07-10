<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
    exit();
}

// Mengubah status pesanan jika form ubah status di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pemesanan'], $_POST['status'])) {
    $id_pemesanan = $_POST['id_pemesanan'];
    $status = $_POST['status'];

    // Query untuk mengupdate status pesanan
    $query_update = "UPDATE pemesanan SET status_pesanan = '$status' WHERE id_pemesanan = $id_pemesanan";

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Status Pesanan Berhasil Di Ubah');window.location='order.php';</script>";
    } else {
        echo "Error: " . $query_update . "<br>" . mysqli_error($koneksi);
    }
}

// Query untuk mengambil data pemesanan
$query = "SELECT pemesanan.id_pemesanan, produk.nama_produk, pembeli.nama_pembeli, pemesanan.jumlah_pesanan, pemesanan.tgl_pemesanan, pemesanan.status_pesanan
          FROM pemesanan
          JOIN produk ON pemesanan.id_produk = produk.id_produk
          JOIN pembeli ON pemesanan.id_pembeli = pembeli.id_pembeli";
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
    <title>Admin Dashboard - Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background-color: #ffc107;
        padding-top: 20px;
        position: fixed;
        height: 100vh;
        flex: 0 0 250px;
        z-index: 9999;
    }

    .sidebar .nav-link {
        color: black;
    }

    .sidebar .nav-link:hover {
        color: #ffc107;
        background-color: black;
    }

    .content {
        flex: 1;
        padding: 20px;
        padding-left: 270px;
        padding-top: 70px;
    }

    .navbar {
        background-color: #343a40;
        color: #fff;
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="text-center mb-4">
            <img src="img/King Mebel & Furniture.png" alt="Logo" class="img-fluid">
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="order.php">Order</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="produk.php">Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="customers.php">Customers</a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top">
            <a class="navbar-brand" href="dashboard.php"><img src="img/King Mebel & Furniture - Copy.png"
                    width="127"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link text-warning" href="dashboard.php">Home <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="container mt-5">
            <h2 class="text-center">Data Pemesanan</h2>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Pemesanan</th>
                        <th>Nama Produk</th>
                        <th>Nama Pembeli</th>
                        <th>Jumlah Pesanan</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id_pemesanan']; ?></td>
                        <td><?php echo $row['nama_produk']; ?></td>
                        <td><?php echo $row['nama_pembeli']; ?></td>
                        <td><?php echo $row['jumlah_pesanan']; ?></td>
                        <td><?php echo $row['tgl_pemesanan']; ?></td>
                        <td>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <input type="hidden" name="id_pemesanan" value="<?php echo $row['id_pemesanan']; ?>">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="Pending" class="text-primary"
                                        <?php if ($row['status_pesanan'] == 'Pending') echo 'selected'; ?>>Pending
                                    </option>
                                    <option value="Dikonfirmasi" class="text-success"
                                        <?php if ($row['status_pesanan'] == 'Dikonfirmasi') echo 'selected'; ?>>
                                        Dikonfirmasi</option>
                                    <option value="Dibatalkan" class="text-danger"
                                        <?php if ($row['status_pesanan'] == 'Dibatalkan') echo 'selected'; ?>>
                                        Dibatalkan</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>