<?php
require 'vendor/autoload.php';

\Midtrans\Config::$serverKey = '1Q7YDzKsKm2ifWdvTh9ae6h42sYsrfioAd';
\Midtrans\Config::$isProduction = false; // Set false untuk sandbox, true untuk production
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;