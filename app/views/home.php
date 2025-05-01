    <section class="hero-slider">
		<div class="single-slider">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-lg-9 offset-lg-3 col-12">
						<div class="text-inner">
							<div class="row">
								<div class="col-lg-7 col-12">
									<div class="hero-text">
										<h1></h1>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <?php if(!empty($naivebayes)):?>
    <div class="product-area section">
        <div class="container">
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
    <?php endif;?>

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