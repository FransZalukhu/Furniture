<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-warning navbar-dark shadow">
        <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produk.php">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Tambah Produk</h2>
        <form action="storeproduk.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id_produk">Id Produk</label>
                <input type="number" class="form-control" id="id_produk" name="id_produk" required>
            </div>
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
            </div>
            <div class="form-group">
                <label for="harga_produk">Harga Produk</label>
                <input type="number" class="form-control" id="harga_produk" name="harga_produk" required>
            </div>
            <div class="form-group">
                <label for="jumlah_produk">Jumlah Produk</label>
                <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk" required>
            </div>
            <div class="form-group">
                <label for="tgl_masuk">Tanggal Masuk</label>
                <input type="date" class="form-control" id="tgl_masuk" name="tgl_masuk" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto Produk</label>
                <input type="file" class="form-control-file" id="foto" name="foto" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>