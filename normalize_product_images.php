<?php
// normalize_product_images.php

// 1) koneksi mysqli
$host     = 'localhost';
$user     = 'root';
$pass     = '';
$dbName   = 'pro_naive_bayes';

$mysqli = new mysqli($host, $user, $pass, $dbName);
if ($mysqli->connect_errno) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

// 2) ambil semua produk
$sql = "SELECT id, image FROM products";
if (! $res = $mysqli->query($sql)) {
    die("Query gagal: " . $mysqli->error);
}

// 3) siapkan prepared statement untuk update
$upd = $mysqli->prepare("UPDATE products SET image = ? WHERE id = ?");
if (! $upd) {
    die("Prepare UPDATE gagal: " . $mysqli->error);
}

// 4) loop tiap baris, strip prefix 03_/04_/05_ kalau ada
$count = 0;
while ($row = $res->fetch_assoc()) {
    $id    = $row['id'];
    $image = $row['image'];

    // hapus prefix 03_, 04_, 05_ di awal nama file
    $clean = preg_replace('#^(0[3-5]_)#', '', $image);

    if ($clean !== $image) {
        // jalankan update
        $upd->bind_param('si', $clean, $id);
        if ($upd->execute()) {
            echo "[$id] “{$image}” → “{$clean}”\n";
            $count++;
        } else {
            echo "ERROR pada id={$id}: " . $upd->error . "\n";
        }
    }
}

echo "\nSelesai! Total di‐update: {$count} baris.\n";

// 5) tutup koneksi
$upd->close();
$mysqli->close();
