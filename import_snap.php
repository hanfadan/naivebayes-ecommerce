<?php
// import_snap.php
// Skrip CLI untuk mengimpor data produk dari file SNAP JSON (meta_valid.jsonl) ke tabel `products`

ini_set('memory_limit','1G');
set_time_limit(0);

// 1) Koneksi database
$pdo = new PDO(
    'mysql:host=localhost;dbname=pro_naive_bayes;charset=utf8mb4',
    'root',
    '',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 2) Kosongkan tabel products agar import bersih
$pdo->exec("TRUNCATE TABLE products");
echo "✔ Tabel products dikosongkan.\n";

// 3) Target jumlah per kategori (restore distribusi dummy sebelumnya)
$jumlahPerKategori = [
    1  => 2,   // Pakaian Pria
    4  => 32,  // Jaket
    5  => 24,  // Kaos
    6  => 8,   // Sweater
    7  => 5,   // Batik
    8  => 10,  // Kemeja
    11 => 12,  // Dress
    12 => 13,  // Kaos Polo
];

// 4) Mapping keyword → category_id (substring match)
$keywordToCategory = [
    'jacket'  => 4,
    'shirt'   => 5,
    'sweater' => 6,
    'batik'   => 7,
    'dress'   => 11,
    'polo'    => 12,
];

// 5) Prepared statement insert
$stmt = $pdo->prepare(
    "INSERT INTO products
        (category_id, name, slug, image, stok, price, description, status, created, modified)
     VALUES
        (:cat, :name, :slug, :img, :stok, :price, :desc, 1, :today, :today)"
);

// 6) Fungsi slugify untuk membuat URL-friendly strings
function slugify(string $text): string {
    $t = mb_strtolower($text, 'UTF-8');
    $t = preg_replace('/[^a-z0-9]+/u', '-', $t);
    return trim($t, '-');
}

date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

// 7) Buka file JSONL valid meta_valid.jsonl
$file = __DIR__ . '/meta_valid.jsonl';
if (!file_exists($file)) {
    die("✖ File JSONL valid tidak ditemukan: {$file}\n");
}
$handle = fopen($file, 'r');
if (!$handle) {
    die("✖ Gagal membuka file JSONL: {$file}\n");
}

// 8) Inisialisasi counter per kategori
$counter = array_fill_keys(array_keys($jumlahPerKategori), 0);
$inserted = 0;

// 9) Loop setiap baris JSONL
while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    if ($line === '') continue;

    $obj = json_decode($line, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        continue;  // skip jika JSON invalid
    }
    // Validasi field penting
    if (empty($obj['title']) || empty($obj['imUrl']) || empty($obj['categories']) || !is_array($obj['categories'])) {
        continue;
    }

    // 10) Tentukan category_id via substring mapping
    $catId = null;
    foreach ($obj['categories'] as $path) {
        if (!is_array($path)) continue;
        foreach ($path as $levelName) {
            $lvl = mb_strtolower($levelName, 'UTF-8');
            foreach ($keywordToCategory as $keyword => $cid) {
                if (strpos($lvl, $keyword) !== false) {
                    $catId = $cid;
                    break 3;
                }
            }
        }
    }
        if (!$catId) {
        continue; // skip jika tidak ter-mapping
    }
    // skip jika kategori tidak memiliki target per kategori
    if (!isset($jumlahPerKategori[$catId])) {
        continue;
    }

    // 11) Cek apakah kategori ini sudah terpenuhi
    if ($counter[$catId] >= $jumlahPerKategori[$catId]) {
        // Periksa apakah seluruh kategori sudah selesai
        $done = true;
        foreach ($jumlahPerKategori as $cid => $target) {
            if ($counter[$cid] < $target) { $done = false; break; }
        }
        if ($done) break;
        continue;
    }

    // 12) Siapkan data
    $name = $obj['title'];
    $slug = slugify($name);
    $img  = $obj['imUrl'];
    // Cek keberadaan 'price' dan numeric
    if (isset($obj['price']) && is_numeric($obj['price'])) {
        // jika harga dalam USD, konversi ke IDR
        $price = floatval($obj['price']) * 1000;
    } else {
        // fallback harga random
        $price = rand(100000, 500000);
    }
    $desc = 'Brand: ' . ($obj['brand'] ?? 'Unknown');
    $stok = rand(10, 100);

    // 13) Insert ke database
    try {
        $stmt->execute([
            ':cat'   => $catId,
            ':name'  => $name,
            ':slug'  => $slug,
            ':img'   => $img,
            ':stok'  => $stok,
            ':price' => $price,
            ':desc'  => $desc,
            ':today' => $today,
        ]);
        $counter[$catId]++;
        $inserted++;
    } catch (PDOException $e) {
        // skip error duplikat slug atau lainnya
        continue;
    }
}

fclose($handle);

echo "✔ Selesai insert {$inserted} produk berdasarkan mapping dan target per kategori.\n";
