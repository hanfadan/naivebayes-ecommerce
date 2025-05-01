<?php
/* helper kecil supaya <select> tetap menampilkan nilai terpilih */
if (!function_exists('h_selected')) {
    function h_selected($src, $key, $val) {
        return !empty($src[$key]) && $src[$key]===$val ? 'selected' : '';
    }
}
?>

<section class="hero-slider">
		<div class="single-slider">
			<div class="container">
			</div>
		</div>
	</section>

    <div class="product-area section">
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
    <form method="post">
        <div class="row">
            <!-- UMUR -->
            <div class="col-md-3 mb-2">
                <label class="small text-muted mx-3 my-2">Kelompok Umur</label>
                <select name="umur" class="form-control" required>
                    <option value="18-24" <?=h_selected($formInput??[],'umur','18-24')?>>18-24</option>
                    <option value="25-34" <?=h_selected($formInput??[],'umur','25-34')?>>25-34</option>
                    <option value="35+"   <?=h_selected($formInput??[],'umur','35+')?>>35+</option>
                </select>
            </div>

            <!-- GENDER -->
            <div class="col-md-3 mb-2">
                <label class="small text-muted mx-3 my-2">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="m" <?=h_selected($formInput??[],'gender','m')?>>Laki-laki</option>
                    <option value="f" <?=h_selected($formInput??[],'gender','f')?>>Perempuan</option>
                </select>
            </div>

            <!-- KATEGORI -->
            <div class="col-md-4 mb-2">
                <label class="small text-muted mx-3 my-2">Gaya / Kategori Favorit</label>
                <select name="kategori" class="form-control" required>
                    <option value="all">– Semua –</option>
                    <?= $kategoriOptions ?? '' ?>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="col-md-2 d-flex align-items-end mb-2">
                <button class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </div>
    </form>
</div>
<!-- ==== /FORM ==== -->
<?php if(!empty($naivebayes)):?>
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
                                <img class="default-img" src="<?php echo image('03_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
                                <img class="hover-img" src="<?php echo image('03_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Detail Produk" href="javascript:void(0);" class="btn-view"
                                       data-id="<?php echo $product['id'];?>"
                                       data-name="<?php echo $product['name'];?>"
                                       data-info="<?php echo $product['description'];?>"
                                       data-stok="<?php echo price($product['stok']);?>"
                                       data-price="<?php echo price($product['price']);?>"
                                       data-image="<?php echo image('05_'.$product['image']);?>"
                                       data-category="<?php echo $product['category'];?>"><i class="ti-eye"></i><span>Detail Produk</span></a>
                                    <a title="Daftar Keinginan" href="javascript:void(0);" class="btn-wishlist" data-product="<?php echo $product['id'];?>"><i class="ti-heart "></i><span>Tambahkan ke Daftar Keinginan</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Tambah ke Keranjang" href="javascript:void(0);" class="btn-cart" data-product="<?php echo $product['id'];?>">Tambah ke Keranjang</a>
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
    <div class="product-area section">
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
                                <img class="default-img" src="<?php echo image('03_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
                                <img class="hover-img" src="<?php echo image('03_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Detail Produk" href="javascript:void(0);" class="btn-view"
                                       data-id="<?php echo $product['id'];?>"
                                       data-name="<?php echo $product['name'];?>"
                                       data-info="<?php echo $product['description'];?>"
                                       data-stok="<?php echo price($product['stok']);?>"
                                       data-price="<?php echo price($product['price']);?>"
                                       data-image="<?php echo image('05_'.$product['image']);?>"
                                       data-category="<?php echo $product['category'];?>"><i class="ti-eye"></i><span>Detail Produk</span></a>
                                    <a title="Daftar Keinginan" href="javascript:void(0);" class="btn-wishlist" data-product="<?php echo $product['id'];?>"><i class="ti-heart "></i><span>Tambahkan ke Daftar Keinginan</span></a>
                                </div>
                                <div class="product-action-2">
                                    <a title="Tambah ke Keranjang" href="javascript:void(0);" class="btn-cart" data-product="<?php echo $product['id'];?>">Tambah ke Keranjang</a>
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