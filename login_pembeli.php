<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email_pemesan'];
    $password = $_POST['password_pemesan'];

    // Siapkan dan jalankan query untuk mengambil data pembeli berdasarkan email
    $stmt = $koneksi->prepare("SELECT id_pembeli, password_pembeli FROM pembeli WHERE email_pembeli = ?");
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
            $stmt->bind_result($id_pembeli, $hashed_password);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['id_pembeli'] = $id_pembeli;
                echo "<script>alert('Login berhasil.');window.location='home.php';</script>";
            } else {
                echo "<script>alert('Email atau Password SALAH')</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan')</script>";
        }
    } else {
        echo "<script>alert('Terjadi kesalahan')</script> . $stmt->error";
    }
    $stmt->close();
} else {
    header("Location: index.php?pesan=belum_login");
    exit();
}

$koneksi->close();
