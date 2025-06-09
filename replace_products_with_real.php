<?php
// replace_products_with_real.php

// 1. Koneksi database
$pdo = new PDO('mysql:host=localhost;dbname=pro_naive_bayes;charset=utf8mb4','root','',[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
]);

// 2. Hitung target per kategori (setelah restore)
$stmt = $pdo->query("
  SELECT category_id, COUNT(*) AS jumlah
  FROM products
  GROUP BY category_id
");
$jumlahPerKategori = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 3. Mapping kategori → keyword pencarian
$mapping = [
    1  => 'mens clothing',
    4  => 'jacket',
    5  => 'shirt',
    6  => 'sweater',
    7  => 'batik',
    8  => 'shirt',
    11 => 'dress',
    12 => 'polo shirt',
];

// 4. Ambil semua produk sekali saja dari Shopify demo store
$shopifyUrl = 'https://shopicruit.myshopify.com/products.json?limit=250';
$json = file_get_contents($shopifyUrl);
$allProducts = json_decode($json, true)['products'] ?? [];

// 5. Fungsi slugify
function slugify($text) {
    $t = mb_strtolower($text,'UTF-8');
    $t = preg_replace('/[^a-z0-9]+/u','-',$t);
    return trim($t,'-');
}

// 6. Truncate table
$pdo->exec("TRUNCATE TABLE products");
echo "✔ products table dikosongkan.\n";

// 7. Prepare INSERT
$ins = $pdo->prepare("
  INSERT INTO products
    (category_id,name,slug,image,stok,price,description,status,created,modified)
  VALUES
    (:cat,:name,:slug,:img,:stok,:price,:desc,1,:today,:today)
");

date_default_timezone_set('Asia/Jakarta');
$today = date('Y-m-d');

// 8. Loop tiap kategori
foreach($jumlahPerKategori as $catId=>$target) {
    echo "→ Kategori ID={$catId} butuh {$target} produk…\n";
    $keyword = $mapping[$catId] ?? '';
    if(!$keyword) {
        echo "  ✖ Tidak ada mapping keyword.\n"; continue;
    }

    // Filter produk yang judulnya mengandung keyword (case-insensitive)
    $matches = array_filter($allProducts, function($p) use($keyword){
        return stripos($p['title'],$keyword)!==false;
    });

    $countFound = count($matches);
    echo "  • Ditemukan {$countFound} item matching '{$keyword}'.\n";

    // Ambil sebanyak target (atau sebanyak yang ada)
    $toInsert = array_slice($matches, 0, $target);

    $inserted = 0;
    foreach($toInsert as $p) {
        $ins->execute([
          ':cat'   => $catId,
          ':name'  => $p['title'],
          ':slug'  => slugify($p['title']),
          ':img'   => $p['images'][0] ?? '',
          ':stok'  => rand(10,50),
          ':price' => $p['variants'][0]['price'] ?? 0,
          ':desc'  => $p['body_html'] ?? '',
          ':today' => $today,
        ]);
        $inserted++;
    }

    // Laporan
    if($inserted < $target) {
      echo "  ⚠ Hanya insert {$inserted}/{$target}. Butuh sumber lain sisanya.\n";
    } else {
      echo "  ✔ Berhasil insert {$inserted}/{$target}.\n";
    }
}

echo "🎉 Selesai.\n";
