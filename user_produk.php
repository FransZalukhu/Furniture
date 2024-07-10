<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>King Mebel & Furniture</title>
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
                <form class="d-flex ml-auto" action="user_produk.php" method="get">
                    <input class="form-control mr-2" type="text" name="cari" placeholder="Cari">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- end navbar -->

    <section id="project" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="text-center mt-2">Produk</h2>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <?php
                $no = 1;
                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                    $query = "SELECT * FROM produk WHERE nama_produk LIKE '%$cari%'";
                } else {
                    $query = "SELECT * FROM produk";
                }
                $result = mysqli_query($koneksi, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <img src="img/<?php echo $row['foto'] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                            <p class="card-text"><?php echo "Harga : " . $row['harga_produk'] ?></p>
                            <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#detailModal"
                                data-id="<?php echo $row['id_produk']; ?>"
                                data-nama="<?php echo $row['nama_produk']; ?>"
                                data-harga="<?php echo $row['harga_produk']; ?>"
                                data-foto="img/<?php echo $row['foto']; ?>">
                                Detail Produk
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Modal Detail Produk -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="detailFoto" src="" class="img-fluid" alt="Detail Produk">
                        </div>
                        <div class="col-md-6">
                            <h5 id="detailNama"></h5>
                            <p id="detailHarga"></p>
                            <a id="pesanSekarangBtn" href="#" class="btn btn-primary">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Section  -->

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id_produk = button.data('id');
            var nama_produk = button.data('nama');
            var harga_produk = button.data('harga');
            var foto_produk = button.data('foto');

            // Update the modal's content.
            var modal = $(this);
            modal.find('#detailFoto').attr('src', foto_produk);
            modal.find('#detailNama').text(nama_produk);
            modal.find('#detailHarga').text('Harga: ' + harga_produk);
            modal.find('#pesanSekarangBtn').attr('href', 'formpemesanan.php?id_produk=' + id_produk);
        });
    });
    </script>

</body>

</html>