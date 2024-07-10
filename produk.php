<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
    exit();
}

$query = "SELECT * FROM produk";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
    function showEditModal(id, nama, harga, jumlah, tgl, foto) {
        document.getElementById('edit_id_produk').value = id;
        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_harga_produk').value = harga;
        document.getElementById('edit_jumlah_produk').value = jumlah;
        document.getElementById('edit_tgl_masuk').value = tgl;
        document.getElementById('edit_foto_lama').src = 'img/' + foto;
        $('#editModal').modal('show');
    }
    </script>
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
            <form action="produk.php" method="get">
                <label>Cari :</label>
                <input type="text" name="cari">
                <input type="submit" value="Cari">
            </form>
            <a href="tambah_produk.php" class="btn btn-primary mb-4 mt-4">Tambah Produk</a>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga Produk</th>
                        <th>Jumlah Produk</th>
                        <th>Tanggal Masuk</th>
                        <th>Foto Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                        $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk LIKE '%" . $cari . "%'");
                    } else {
                        $data = mysqli_query($koneksi, "SELECT * FROM produk");
                    }
                    while ($row = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?php echo $row['nama_produk']; ?></td>
                        <td><?php echo $row['harga_produk']; ?></td>
                        <td><?php echo $row['jumlah_produk']; ?></td>
                        <td><?php echo $row['tgl_masuk']; ?></td>
                        <td><img src="img/<?php echo $row['foto'] ?>" width="100"></td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="showEditModal('<?php echo $row['id_produk']; ?>', '<?php echo $row['nama_produk']; ?>', '<?php echo $row['harga_produk']; ?>', '<?php echo $row['jumlah_produk']; ?>', '<?php echo $row['tgl_masuk']; ?>', '<?php echo $row['foto']; ?>')">Edit</button>
                            <a href="delete_produk.php?id=<?php echo $row['id_produk']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus produk ini?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- Modal Edit Produk -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="update_produk.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="edit_id_produk" name="id_produk">
                                <div class="form-group">
                                    <label for="edit_nama_produk">Nama Produk</label>
                                    <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_harga_produk">Harga Produk</label>
                                    <input type="text" class="form-control" id="edit_harga_produk" name="harga_produk"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_jumlah_produk">Jumlah Produk</label>
                                    <input type="text" class="form-control" id="edit_jumlah_produk" name="jumlah_produk"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_tgl_masuk">Tanggal Masuk</label>
                                    <input type="date" class="form-control" id="edit_tgl_masuk" name="tgl_masuk"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_foto">Foto Produk</label>
                                    <img id="edit_foto_lama" src="" width="100"><br>
                                    <input type="file" class="form-control-file" id="edit_foto" name="foto">
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>