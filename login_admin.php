<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Siapkan dan jalankan query untuk mengambil data admin berdasarkan email
    $stmt = $koneksi->prepare("SELECT id_admin, password_admin FROM tbl_admin WHERE email_admin = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $koneksi->error);
    }

    // Bind parameter
    $stmt->bind_param("s", $email);

    // Execute statement
    if ($stmt->execute()) {
        // Simpan hasil query
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind hasil ke variabel
            $stmt->bind_result($id_admin, $hashed_password);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['id_admin'] = $id_admin;
                echo "<script>alert('Login berhasil.');window.location='dashboard.php';</script>";
            } else {
                echo "<script>alert('Email atau Password SALAH')</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan')</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan')</script> . $stmt->error";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

$koneksi->close();
