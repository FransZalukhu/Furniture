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
    <?php
    session_start();
    if (!isset($_SESSION['id_pembeli'])) {
        echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
        exit();
    }
    ?>

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

    <!-- Jumbotron -->
    <section class="jumbotron text-center bg-light">
        <img src="img/King Mebel & Furniture.png" width="763">
    </section>
    <!-- end Jumbotron -->

    <!-- Section -->

    <!-- About Section -->
    <section id="about" class="py-5 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2 class="text-light">Tentang Kami</h2>
                    <p class="text-light">King Mebel & Furniture menyediakan beragam produk mebel dan furniture
                        berkualitas tinggi. Kami
                        selalu mengutamakan kepuasan pelanggan dengan menawarkan produk terbaik dan layanan yang
                        profesional.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <section class="section-content bg-warning">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-0">
                    <div class="image" style="background-image: url('img/Section1.png');">
                        <img src="img/Section1.png" alt="Produk Berkualitas" class="img-fluid d-none">
                    </div>
                </div>
                <div class="col-md-6 p-5 d-flex align-items-center">
                    <div class="content">
                        <div>
                            <h2>Produk Berkualitas</h2>
                            <p>Setiap produk kami dibuat dengan bahan-bahan berkualitas terbaik dan dirancang oleh para
                                ahli kami yang berpengalaman dalam bidangnya. Kami percaya bahwa furniture bukan hanya
                                tentang fungsi, tetapi juga tentang estetika dan kenyamanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-content bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-5 d-flex align-items-center">
                    <div class="content">
                        <div>
                            <h2 class="text-light">Berbagai Pilihan Design</h2>
                            <p class="text-light">Dengan berbagai pilihan desain modern dan minimalis, kami yakin Anda
                                akan menemukan
                                sesuatu yang sesuai dengan gaya dan selera Anda. Dari sofa yang nyaman hingga meja makan
                                yang elegan, kami memiliki segalanya.</p>
                            <a href="user_produk.php" class="btn btn-warning">Selengkapnya →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="image" style="background-image: url('img/Section2.png'); height: 100%;">
                        <img src="img/Section2.png" alt="Berbagai Pilihan Design" class="img-fluid d-none">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="project" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2 class="text-center mt-2">Produk</h2>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
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
                        <div class="card-body card-dark shadow">
                            <h5 class="card-title"><?php echo $row['nama_produk']; ?></h5>
                            <p class="card-text"><?php echo "Harga : " . $row['harga_produk'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-warning">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h2>Kontak Kami</h2>
                    <p>Hubungi kami untuk informasi lebih lanjut mengenai produk kami.</p>
                    <p>Email: info@kingmebelfurniture.com | Telp: 123-456-7890</p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->

    <!-- End Section  -->

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 King Mebel & Furniture. All rights reserved.</p>
    </footer>
    <!-- End Footer -->

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>