<?php
include 'koneksi.php';
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff;
    }

    .sidebar {
        background-color: #f1c40f;
        height: 100vh;
        padding: 1rem;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        overflow-y: auto;
    }

    .sidebar .nav-link {
        color: #000;
        font-weight: bold;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .sidebar .nav-link.active {
        background-color: #ffa500;
        color: #fff;
    }

    .main-content {
        margin-left: 18rem;
        padding: 2rem;
    }

    .navbar {
        padding: .5rem 1rem;
        background-color: #F2B632;
    }

    .search-form {
        display: flex;
        align-items: center;
    }

    .search-form input {
        margin-right: 0.5rem;
    }

    .btn-search {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
    }

    .btn-dark-custom {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 5px;
    }

    /* Add custom CSS for the cards in the dashboard */
    .card-custom {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-warning {
        background-color: #f39c12;
        color: #fff;
    }

    .card-secondary {
        background-color: #7f8c8d;
        color: #fff;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['id_admin'])) {
        echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
        exit();
    }
    ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky mt-3">
                    <div class="text-center mb-4">
                        <img src="path/to/logo.png" alt="Logo" class="img-fluid">
                        <h4>King Furniture & Mebel</h4>
                        <p>Admin</p>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="daftar_pengguna.php">Daftar Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">Kelola Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="prosesproduk.php">Kelola Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="profil_admin.php">Profil</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="col-md-10 ml-sm-auto col-lg-10 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-light sticky-top">
                    <span class="navbar-brand mb-0 h1">Dashboard</span>
                    <form class="form-inline search-form" method="get" action="produk.php">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"
                            name="cari">
                        <button class="btn btn-search my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <a href="logout.php" class="btn btn-dark-custom">Logout</a>
                </nav>

                <br>

                <!-- Main Content -->
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-custom card-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pesanan Masuk</h5>
                                    <p class="card-text display-4"><?php echo $total_orders; ?> orang</p>
                                    <p class="card-text">untuk produk</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-custom card-secondary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Cancel</h5>
                                    <p class="card-text display-4"><?php echo $total_cancelled; ?> orang</p>
                                    <p class="card-text">untuk produk</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Penjualan Furniture</h5>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($sales_data, 'date')); ?>,
            datasets: [{
                label: 'Penjualan',
                data: <?php echo json_encode(array_column($sales_data, 'sales')); ?>,
                borderColor: 'black',
                fill: false,
                lineTension: 0.1,
                pointBackgroundColor: 'black',
                pointRadius: 5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 500
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true
                }
            },
            elements: {
                point: {
                    hoverRadius: 7,
                    hoverBackgroundColor: 'white'
                }
            }
        }
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>