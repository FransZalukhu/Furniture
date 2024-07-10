<?php
require_once 'midtrans-php-master/Midtrans.php'; // Pastikan path ini benar

\Midtrans\Config::$serverKey = 'SB-Mid-server-OYAW_ZlssVNo8TcXgSIFJz1_';
\Midtrans\Config::$clientKey = 'SB-Mid-client-lnBggjNWzsNMIaUz'; // Ganti dengan Client Key yang valid
\Midtrans\Config::$isProduction = false;  // Set to true for production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;
?>
