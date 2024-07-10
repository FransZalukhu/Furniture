<?php
include 'koneksi.php';
include 'midtrans_config.php';

$notif = new \Midtrans\Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

if ($transaction == 'capture') {
    if ($type == 'credit_card') {
        if ($fraud == 'challenge') {
            // Update status pesanan menjadi challenge
            $status = 'Challenge';
        } else {
            // Update status pesanan menjadi success
            $status = 'Success';
        }
    }
} elseif ($transaction == 'settlement') {
    // Update status pesanan menjadi success
    $status = 'Success';
} elseif ($transaction == 'pending') {
    // Update status pesanan menjadi pending
    $status = 'Pending';
} elseif ($transaction == 'deny') {
    // Update status pesanan menjadi deny
    $status = 'Deny';
} elseif ($transaction == 'expire') {
    // Update status pesanan menjadi expire
    $status = 'Expire';
} elseif ($transaction == 'cancel') {
    // Update status pesanan menjadi cancel
    $status = 'Cancel';
}

// Update status pesanan di database
$query_update = "UPDATE pemesanan SET status_pesanan = '$status' WHERE id_pemesanan = $order_id";
mysqli_query($koneksi, $query_update);