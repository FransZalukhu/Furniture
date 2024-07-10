<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Anda Harus Login Terlebih Dahulu');window.location='index.php';</script>";
    exit();
}

// Query untuk mengambil jumlah total pesanan
$query = "SELECT COUNT(*) AS total_pesanan FROM pemesanan";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_pesanan = $row['total_pesanan'];
} else {
    echo "Error: " . mysqli_error($koneksi);
    $total_pesanan = 0; // default value if query fails
}

// Query untuk mengambil data pesanan
$query = "SELECT tgl_pemesanan, COUNT(*) AS jumlah_pesanan FROM pemesanan GROUP BY tgl_pemesanan";
$result = mysqli_query($koneksi, $query);

// Mengambil data dan menyimpannya dalam array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

mysqli_close($koneksi);
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
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
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

    <div class="content">
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
            <div class="row">
                <div class="col-md-8">
                    <h1>Welcome to the Admin Dashboard</h1>
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Masuk</h5>
                    <p class="card-text">Total orders: <?php echo $total_pesanan; ?></p>
                    <a href="order.php" class="btn btn-success">Lihat Detail</a>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <h2>Grafik Jumlah Pesanan</h2>
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const data = <?php echo json_encode($data); ?>;
    const labels = data.map(item => item.tgl_pemesanan);
    const values = data.map(item => item.jumlah_pesanan);

    const ctx = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctx, {
        type: 'line', // You can change this to 'bar', 'pie', etc.
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: values,
                backgroundColor: 'rgba(255, 193, 7, 0.2)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>

</html>