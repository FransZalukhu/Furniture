<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Customers</title>
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
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Table for displaying customers -->
        <div class="mt-5">
            <h2>Data Pembeli</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pembeli</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch data from database
                    $query = "SELECT id_pembeli, nama_pembeli, username_pembeli, email_pembeli FROM pembeli";
                    $result = $koneksi->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id_pembeli']}</td>
                                    <td>{$row['nama_pembeli']}</td>
                                    <td>{$row['username_pembeli']}</td>
                                    <td>{$row['email_pembeli']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No data found</td></tr>";
                    }

                    $koneksi->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>