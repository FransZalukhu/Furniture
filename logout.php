<?php
// Mulai session
session_start();

// Hapus semua data session
session_destroy();

// Redirect ke halaman login atau halaman lain yang sesuai
header("Location: index.php");
exit();