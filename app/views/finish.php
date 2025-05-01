    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="<?php echo url();?>">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="<?php echo url('checkout');?>">Transaksi Selesai</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="shop checkout section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> Pesanan Anda berhasil diterima, silahkan selesaikan pembayaran Anda melalui Whatsapp Kami untuk Proses pembayaran, sehingga kami bisa segera melakukan proses pengemasan dan segera dikirimkan.<br><br>
                        <a class="btn" href="http://api.whatsapp.com/send?phone=<?php echo APP_WHATSAPP;?>&text=Hai, <?php echo APP_NAME;?> pesanan saya sudah di buat dengan nomor pesanan <?php echo $trans['invoice'];?>, dengan total pemesanan sebesar Rp.<?php echo price($trans['total']);?>.-" target="_blank">Klik disini Untuk Konfirmasi via Whatsapp</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
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