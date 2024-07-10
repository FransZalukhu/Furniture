<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['sandi'];
    $confirm_password = $_POST['sandiulang'];

    // Periksa kesamaan password dan konfirmasi password
    if ($password == $confirm_password) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Siapkan dan jalankan query untuk menyimpan data
        $stmt = $koneksi->prepare("INSERT INTO tbl_admin (nama_admin, username_admin, email_admin, password_admin) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Error preparing statement: " . $koneksi->error);
        }

        // Bind parameters
        $stmt->bind_param("ssss", $nama, $username, $email, $hashed_password);

        // Execute statement
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil. Silakan login.');window.location='index.php';</script>";
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "<script>alert('Password dan konfirmasi password tidak cocok!')</script>";
    }

    $koneksi->close();
} else {
    echo "Invalid request method.";
}