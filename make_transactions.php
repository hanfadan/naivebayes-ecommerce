<?php
/*  make_transactions.php
    ----------------------------------------------
    - Membuat transaksi dummy untuk setiap user
    - Qty acak 1-3 / produk, 1-4 produk per user
    - Mengurangi stok di tabel products
    ---------------------------------------------- */
ini_set('display_errors',1); error_reporting(E_ALL);

$mysqli = new mysqli('localhost','root','','pro_naive_bayes');
if ($mysqli->connect_errno) die($mysqli->connect_error);

/* ---------- ambil users dummy & produk ---------- */
$users = $mysqli->query(
    "SELECT id FROM users WHERE email LIKE 'd%'"   // hanya dummy
)->fetch_all(MYSQLI_ASSOC);

$prodQ = $mysqli->query(
    "SELECT id,stok,price FROM products WHERE stok>0"
);
$products = [];
while ($r = $prodQ->fetch_assoc()) {
    $r['sold'] = 0;
    $products[] = $r;
}

/* ---------- prepared statements ---------- */
$stTran = $mysqli->prepare(
   "INSERT INTO transactions(user_id,invoice,total)
    VALUES (?,CONCAT('INV',UUID()),0)"
) or die($mysqli->error);

$stDet  = $mysqli->prepare(
   "INSERT INTO transactions_details(tran_id,product_id,qty,price)
    VALUES (?,?,?,?)"
) or die($mysqli->error);

$stUpd  = $mysqli->prepare(
   "UPDATE products SET stok=? WHERE id=?"
) or die($mysqli->error);

/* ---------- generate transaksi ---------- */
foreach ($users as $u) {
    /* 1-4 produk unik untuk tiap user */
    $randKeys = (array) array_rand($products, rand(1, min(4, count($products))));
    foreach ($randKeys as $idx) {
        $p   = &$products[$idx];
        $qty = rand(1, 3);
        if ($p['stok'] <= 0) continue;         // stok habis

        /* insert transaksi (header) */
        $stTran->bind_param('i', $u['id']); $stTran->execute();
        $tranId = $mysqli->insert_id;

        /* insert detail */
        $stDet->bind_param(
            'iiii',
            $tranId,
            $p['id'],
            $qty,
            $p['price']
        );
        $stDet->execute();

        /* catat penjualan untuk update stok nanti */
        $p['sold'] += $qty;
    }
}

/* ---------- update stok produk ---------- */
foreach ($products as $p) {
    if ($p['sold'] == 0) continue;
    $sisa = max(0, $p['stok'] - $p['sold']);
    $stUpd->bind_param('ii',$sisa,$p['id']);
    $stUpd->execute();
}

echo "✔ transaksi & stok selesai\n";
