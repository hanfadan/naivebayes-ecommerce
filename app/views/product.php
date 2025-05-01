    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="<?php echo url();?>">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="<?php echo url('product');?>">Produk</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="product-area shop-sidebar shop section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="shop-sidebar">
                        <div class="single-widget category">
                            <h3 class="title">Kategori</h3>
                            <?php echo $sidebars;?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-top"></div>
                        </div>
                    </div>
                    <div class="row">
                    <?php foreach ($products as $product):?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="javascript:void(0);">
                                        <img class="default-img" src="<?php echo image('04_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
                                        <img class="hover-img" src="<?php echo image('04_'.$product['image']);?>" alt="<?php echo $product['name'];?>">
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
                                                data-category="<?php echo $product['category'];?>"><i class=" ti-eye"></i><span>Detail Produk</span></a>
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
        </div>
    </section>