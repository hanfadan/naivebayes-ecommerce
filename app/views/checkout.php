    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="<?php echo url();?>">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="<?php echo url('checkout');?>">Periksa</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="shop checkout section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <div class="form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nama Penerima<span>*</span></label>
                                        <input type="text" value="<?php echo $user['name'];?>" readonly="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nomor Telepon Penerima<span>*</span></label>
                                        <input type="text" value="<?php echo $user['phone'];?>" readonly="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat Pengiriman<span>*</span></label>
                                        <textarea readonly=""><?php echo $user['address'];?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <div class="single-widget">
                            <h2>TOTAL KERANJANG</h2>
                            <div class="content">
                            <?php $price = 0; $total = 0; if(!empty($carts)):?>
                            <?php foreach($carts as $cart):?>
                                <?php $price = intval($cart['qty'])*intval($cart['price']);?>
                                <?php $total += $price;?>
                            <?php endforeach;endif;?>
                                <ul>
                                    <li>Sub Total<span><?php echo price($total);?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <a href="<?php echo url('checkout/process');?>" class="btn">Proses Transaksi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>