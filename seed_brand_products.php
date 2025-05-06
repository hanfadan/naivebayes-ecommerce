<?php
/*─────────────────────────────────────────────
  seed_brand_products.php  —  jalankan di CLI
─────────────────────────────────────────────*/
ini_set('display_errors',1);
error_reporting(E_ALL);

/* ---- koneksi manual ------------------------------------------------ */
$mysqli = new mysqli('localhost','root','','pro_naive_bayes');
if ($mysqli->connect_errno) {
    die("❌  Gagal konek MySQL: ".$mysqli->connect_error."\n");
}

/* brand → [kategori, min, max] */
$brandCatalog = [
  'Uniqlo' => ['Kaos',   79000, 249000],
  'H&M'    => ['Kaos',   99000, 299000],
  'Zara'   => ['Kemeja', 249000, 699000],
  'Adidas' => ['Jaket',  399000,1299000],
  'Nike'   => ['Jaket',  399000,1499000],
  'Levis'  => ['Jaket',  499000,1399000],
];

/* --- pastikan kategori ada --- */
foreach (array_unique(array_column($brandCatalog,0)) as $cat){
    $slug = strtolower(str_replace(' ','-',$cat));
    $mysqli->query("INSERT IGNORE INTO categories(name,slug,parent_id)
                    VALUES('$cat','$slug',0)");
}

/* --- sisipkan 5 produk per brand --- */
$stmt = $mysqli->prepare(
  "INSERT INTO products
   (category_id,name,slug,description,image,stok,price,status,created)
   VALUES (?,?,?,?,?,?,?,1,NOW())"
);

foreach ($brandCatalog as $brand=>$meta){
  [$cat,$min,$max] = $meta;
  $catIdRes = $mysqli->query(
      "SELECT id FROM categories WHERE name='".$mysqli->real_escape_string($cat)."' LIMIT 1");
  $catId = $catIdRes->fetch_row()[0];

  for ($i=1;$i<=5;$i++){
      $price = rand($min,$max);
      $name  = "$brand $cat $i";
      $slug  = strtolower(str_replace([' ','&'],'-',$name));

      /* hindari duplikat jika skrip dijalankan ulang */
      $dup = $mysqli->query(
        "SELECT 1 FROM products WHERE slug='".$mysqli->real_escape_string($slug)."' LIMIT 1");
      if ($dup->num_rows) continue;

      $desc = "Produk $cat resmi $brand";
      $stok = rand(20,120);
      $img  = 'dummy.jpg';

      $stmt->bind_param('issssii',
          $catId,$name,$slug,$desc,$img,$stok,$price);
      $stmt->execute();
  }
}

$stmt->close();
$mysqli->close();
echo "✔ 30 produk brand nyata dibuat\n";
