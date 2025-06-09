<?php
/* helper kecil supaya <select> tetap menampilkan nilai terpilih */
if (!function_exists('h_selected')) {
    function h_selected($src, $key, $val) {
        return !empty($src[$key]) && $src[$key]===$val ? 'selected' : '';
    }
}
?>

<?php
if (! function_exists('slugify')) {
  function slugify(string $text): string
  {
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, '-');
      $text = preg_replace('~-+~', '-', $text);
      return strtolower($text);
  }
}

function product_src(string $prefix, string $img): string {
    return filter_var($img, FILTER_VALIDATE_URL)
      ? $img
      : image($prefix . $img);
}
?>

<section class="hero-slider">
		<div class="single-slider">
			<div class="container">
			</div>
		</div>
	</section>
        <div class="container">
            <!-- ==== FORM KUESIONER (PINDAHAN) ==== -->
<div class="bg-white shadow-sm rounded p-4 mb-4">
<div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Dapatkan Rekomendasi Produk</h2>
                    </div>
                </div>
            </div>

            <form method="post" class="mb-5">
  <div class="row">
    <!-- Kelompok Umur -->
    <div class="col-md-4">
      <fieldset class="border rounded-3 p-3 mb-4">
        <legend class="small text-muted px-2">Kelompok Umur</legend>
        <select name="umur" class="form-select" required>
          <option value="" disabled<?= !isset($formInput['umur']) ? ' selected' : '' ?>>Pilih Kelompok Umur</option>
          <?php foreach (['18-24','25-34','35+'] as $age): ?>
            <option value="<?= $age ?>" <?= h_selected($formInput ?? [], 'umur', $age) ?>>
              <?= $age ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>
    </div>

    <!-- Gender -->
    <div class="col-md-4">
      <fieldset class="border rounded-3 p-3 mb-4">
        <legend class="small text-muted px-2">Gender</legend>
        <select name="gender" class="form-select" required>
          <option value="" disabled<?= !isset($formInput['gender']) ? ' selected' : '' ?>>Pilih Gender</option>
          <?php foreach (['m' => 'Laki-laki','f' => 'Perempuan'] as $val => $label): ?>
            <option value="<?= $val ?>" <?= h_selected($formInput ?? [], 'gender', $val) ?>>
              <?= $label ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>
    </div>

    <!-- Gaya / Kategori Favorit -->
    <div class="col-md-4">
      <fieldset class="border rounded p-3 mb-4">
        <legend class="w-auto small text-muted">Gaya / Kategori Favorit</legend>
        <select name="kategori" class="form-select" required>
          <option value="" disabled<?= empty($formInput['kategori']) ? ' selected' : '' ?>>Pilih Kategori</option>
          <?php foreach ($kategoriList as $slug => $label): ?>
            <option value="<?= $slug ?>" <?= isset($formInput['kategori']) && $formInput['kategori'] === $slug ? 'selected' : '' ?>>
              <?= htmlspecialchars($label) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>
    </div>
  </div>

  <div class="row">
    <!-- Frekuensi Belanja -->
    <div class="col-md-4">
      <fieldset class="border rounded-3 p-3 mb-4">
        <legend class="small text-muted px-2">Frekuensi Belanja</legend>
        <select name="buy_freq" class="form-select" required>
          <option value="" disabled<?= !isset($formInput['buy_freq']) ? ' selected' : '' ?>>Pilih Frekuensi Belanja</option>
          <?php foreach (['Setiap minggu','Setiap bulan','Beberapa bulan','Jarang'] as $f): ?>
            <option value="<?= $f ?>" <?= h_selected($formInput ?? [], 'buy_freq', $f) ?>>
              <?= $f ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>
    </div>

    <!-- Budget per Transaksi -->
    <div class="col-md-4">
      <fieldset class="border rounded-3 p-3 mb-4">
        <legend class="small text-muted px-2">Budget per Transaksi</legend>
        <select name="budget_band" class="form-select" required>
          <option value="" disabled<?= !isset($formInput['budget_band']) ? ' selected' : '' ?>>Pilih Budget per Transaksi</option>
          <?php foreach (['<100k','100-300k','300-600k','>600k'] as $b): ?>
            <option value="<?= $b ?>" <?= h_selected($formInput ?? [], 'budget_band', $b) ?>>
              <?= $b ?>
            </option>
          <?php endforeach; ?>
        </select>
      </fieldset>
    </div>
  </div>
  
  <div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary">Tampilkan</button>
  </div>
</form>
</div>
<!-- ==== /FORM ==== -->
<?php if ($_SERVER['REQUEST_METHOD']==='POST' && !empty($naivebayes)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Rekomendasi Produk Terbaik Untukmu</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            <?php foreach ($naivebayes as $product):?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="javascript:void(0);">
<img class="default-img"
     src="<?php echo product_src('03_', $product['image']);?>"
     alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES);?>">
<img class="hover-img"
     src="<?php echo product_src('03_', $product['image']);?>"
     alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES);?>">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Detail Produk" href="javascript:void(0);" class="btn-view"
                                       data-id="<?php echo $product['id'];?>"
                                       data-name="<?php echo $product['name'];?>"
                                       data-info="<?php echo $product['description'];?>"
                                       data-stok="<?php echo price($product['stok']);?>"
                                       data-price="<?php echo price($product['price']);?>"
data-image="<?php echo product_src('05_', $product['image']);?>"
                                       data-category="<?php echo $product['category'];?>"><i class="ti-eye"></i><span>Detail Produk</span></a>
                                    <a title="Daftar Keinginan" href="javascript:void(0);" class="btn-wishlist" data-product="<?php echo $product['id'];?>"><i class="ti-heart "></i><span>Tambahkan ke Daftar Keinginan</span></a>
                                </div>
                                <div class="product-action-2">
                                <a href="#"
   class="btn-cart"
   data-url="<?= url('home/addCart') ?>"
   data-product="<?= $product['id'] ?>"
   data-qty="1"
   data-price="<?php echo $product['price'];?>">
  Tambah ke Keranjang
</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="javascript:void(0);"><?php echo $product['name'];?></a></h3>
                            <div class="product-price">
                                <span><?php echo price($product['price']);?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php else: ?>
      <!-- ========= ALERT LEBAR PENUH ========= -->
      <div class="row">
        <div class="col-12">
          <div class="alert alert-info w-100 text-center py-4">
            Belum ada rekomendasi untuk pilihanmu.<br>
            Coba ubah kategori atau parameter lain, ya!
          </div>
        </div>
      </div>
    <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produk Terbaru</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            <?php foreach ($products as $product):?>
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="javascript:void(0);">
<img class="default-img"
     src="<?php echo product_src('03_', $product['image']);?>"
     alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES);?>">
<img class="hover-img"
     src="<?php echo product_src('03_', $product['image']);?>"
     alt="<?php echo htmlspecialchars($product['name'], ENT_QUOTES);?>">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Detail Produk" href="javascript:void(0);" class="btn-view"
                                       data-id="<?php echo $product['id'];?>"
                                       data-name="<?php echo $product['name'];?>"
                                       data-info="<?php echo $product['description'];?>"
                                       data-stok="<?php echo price($product['stok']);?>"
                                       data-price="<?php echo price($product['price']);?>"
data-image="<?php echo product_src('05_', $product['image']);?>"

                                       data-category="<?php echo $product['category'];?>"><i class="ti-eye"></i><span>Detail Produk</span></a>
                                    <a title="Daftar Keinginan" href="javascript:void(0);" class="btn-wishlist" data-product="<?php echo $product['id'];?>"><i class="ti-heart "></i><span>Tambahkan ke Daftar Keinginan</span></a>
                                </div>
                                <div class="product-action-2">
                                <a href="#"
   class="btn-cart"
   data-url="<?= url('home/addCart') ?>"
   data-product="<?= $product['id'] ?>"
   data-qty="1"
   data-price="<?php echo $product['price'];?>">
  Tambah ke Keranjang
</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="javascript:void(0);"><?php echo $product['name'];?></a></h3>
                            <div class="product-price">
                                <span><?php echo price($product['price']);?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>

    <section class="shop-services section home">
    <div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Bebas biaya kirim</h4>
						<p>Pesanan lebih dari 1000K</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Pengembalian Gratis</h4>
						<p>Dalam waktu 2 hari kembali</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Pembayaran yang aman</h4>
						<p>Pembayaran aman 100%.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Harga Terbaik</h4>
						<p>Harga terjamin</p>
					</div>
				</div>
			</div>
		</div>
	</section>