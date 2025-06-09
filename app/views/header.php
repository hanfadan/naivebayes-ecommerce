<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo APP_NAME;?></title>
    <link rel="icon" type="image/png" href="<?php echo img('favicon.png');?>">
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo css('bootstrap');?>">
    <link rel="stylesheet" href="<?php echo css('magnific-popup.min');?>">
    <link rel="stylesheet" href="<?php echo css('font-awesome');?>">
	<link rel="stylesheet" href="<?php echo css('jquery.fancybox.min');?>">
    <link rel="stylesheet" href="<?php echo css('themify-icons');?>">
    <link rel="stylesheet" href="<?php echo css('niceselect');?>">
    <link rel="stylesheet" href="<?php echo css('animate');?>">
    <link rel="stylesheet" href="<?php echo css('flex-slider.min');?>">
    <link rel="stylesheet" href="<?php echo css('datepicker.min');?>">
    <link rel="stylesheet" href="<?php echo css('owl-carousel');?>">
    <link rel="stylesheet" href="<?php echo css('slicknav.min');?>">
	<link rel="stylesheet" href="<?php echo css('reset');?>">
	<link rel="stylesheet" href="<?php echo css('style');?>">
    <link rel="stylesheet" href="<?php echo css('responsive');?>">
</head>
<body class="js">
    <div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
    <header class="header shop">
        <div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-12 col-12">
						<div class="top-left">
							<ul class="list-main">
                                <li><i class="ti-headphone-alt"></i> <?php echo APP_PHONE;?></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-8 col-md-12 col-12">
						<div class="right-content">
							<ul class="list-main">
                                <?php if(!empty(session('isUser'))):?>
								<li><i class="ti-user"></i> <a href="<?php echo url('profile');?>">Akun Saya</a></li>
								<li><i class="ti-power-off"></i><a href="<?php echo url('logout');?>">Keluar</a></li>
                                <?php else:?>
								<li><i class="ti-user"></i> <a href="<?php echo url('register');?>">Daftar</a></li>
								<li><i class="ti-power-off"></i><a href="<?php echo url('login');?>">Masuk</a></li>
                                <?php endif;?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="middle-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-12">
						<div class="logo">
							<a href="<?php echo url();?>"><img src="<?php echo img('logo.png');?>" alt="logo"></a>
						</div>
						<div class="search-top">
							<div class="top-search"><a href="javascript:void(0);"><i class="ti-search"></i></a></div>
							<div class="search-top">
								<form class="search-form">
									<input type="text" placeholder="Cari di sini..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
						<div class="mobile-nav"></div>
					</div>
                    <div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<select id="cat">
                                    <option selected="selected">Semua Kategori</option>
                                    <?php echo $categories;?>
								</select>
                                <form action="<?php echo url('product');?>">
									<input name="search" placeholder="Cari Produk Disini....." type="search">
                                    <input name="category" type="hidden" id="category">
									<button class="btnn"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
					</div>
                    <div class="col-lg-2 col-md-3 col-12">
                        <div class="right-bar">
                            <div class="sinlge-bar">
								<a href="<?php echo url('wishlist');?>" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
							</div>
                            <div class="sinlge-bar shopping">
                                <a href="javascript:void(0);" class="single-icon"><i class="ti-bag"></i> <span class="total-count"><?php echo $count;?></span></a>
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
										<span><?php echo $count;?> Barang</span>
										<a href="<?php echo url('cart');?>">Lihat Keranjang</a>
									</div>
                                    <ul class="shopping-list">
                                    <?php $price = 0; $total = 0; if(!empty($carts)):?>
                                    <?php foreach($carts as $cart):?>
                                    <?php $price = intval($cart['qty'])*intval($cart['price']);?>
										<li>
											<a href="javascript:void(0);" class="remove btn-cart-remove" data-product="<?php echo $cart['id'];?>" title="Hapus barang ini"><i class="fa fa-remove"></i></a>
<a class="cart-img" href="javascript:void(0);">
  <img
    src="<?php
      echo filter_var($cart['image'], FILTER_VALIDATE_URL)
        ? $cart['image']
        : image('01_' . $cart['image']);
    ?>"
    alt="<?php echo htmlspecialchars($cart['name'], ENT_QUOTES); ?>"
  >
</a>
											<h4><a href="javascript:void(0);"><?php echo $cart['name'];?></a></h4>
                                            <p class="quantity"><?php echo $cart['qty'];?>x - <span class="amount"><?php echo price($cart['price']);?></span></p>
										</li>
                                    <?php $total += $price;?>
                                    <?php endforeach;endif;?>
									</ul>
									<div class="bottom">
										<div class="total">
											<span>Total</span>
											<span class="total-amount"><?php echo price($total);?></span>
										</div>
										<a href="<?php echo url('checkout');?>" class="btn animate">Periksa</a>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-inner">
            <div class="container">
                <div class="cat-nav-head">
                    <div class="row">
                        <div class="col-12">
                            <div class="menu-area">
                                <nav class="navbar navbar-expand-lg">
                                    <div class="navbar-collapse">
                                        <div class="nav-inner">
                                            <ul class="nav main-menu menu navbar-nav">
                                                <li<?php if($page==='home'){ echo ' class="active"';}?>><a href="<?php echo url();?>">Beranda</a></li>
                                                <li<?php if($page==='product'){ echo ' class="active"';}?>><a href="<?php echo url('product');?>">Produk</a></li>
                                                <li>
                                                    <a href="javascript:void(0);">Kategori <i class="ti-angle-down"></i></a>
                                                    <?php echo $dropdowns;?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>