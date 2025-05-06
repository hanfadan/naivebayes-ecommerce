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
<!-- ===== PRODUK TERLARIS / REKOMENDASI ===== -->
<div class="shop-top">
  <h4 class="mb-3">
    <?php if (get('category')): ?>
      Terlaris di Kategori “<?= htmlspecialchars(ucwords(str_replace('-',' ',get('category')))) ?>”
    <?php else: ?>
      Produk Terlaris di Toko
    <?php endif; ?>
  </h4>

  <?php if (!empty($bestSellers)): ?>
    <div class="row">
      <?php foreach ($bestSellers as $bs): ?>
        <div class="col-md-4 col-lg-3 col-6 mb-3">
          <a href="javascript:void(0);" class="text-decoration-none text-dark btn-view"
             data-id="<?= $bs['id']?>"
             data-name="<?= $bs['name']?>"
             data-info="<?= $bs['description']?>"
             data-stok="<?= price($bs['stok'])?>"
             data-price="<?= price($bs['price'])?>"
             data-image="<?= image('05_'.$bs['image'])?>"
             data-category="<?= $bs['category']?>">

            <div class="card border-0 shadow-sm h-100">
              <img src="<?= image('03_'.$bs['image'])?>" class="card-img-top" alt="<?= $bs['name']?>">
              <div class="card-body p-2">
                <p class="card-title small mb-1"><?= $bs['name']?></p>
                <p class="mb-0 text-primary fw-bold"><?= price($bs['price'])?></p>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Belum ada data penjualan di kategori ini.</div>
  <?php endif; ?>
</div>
<!-- ===== /PRODUK TERLARIS ===== -->

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
                                        <a href="#"
     title="Tambah ke Keranjang"
     class="btn-cart"
     data-url="<?php echo url('home/addCart'); ?>"
     data-product="<?php echo $product['id']; ?>"
     data-qty="1"
     data-price="<?php echo $product['price']; ?>">
    Tambah ke Keranjang
  </a>                                        </div>
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

    <script>
  $(document).on('click', '.btn-cart', function(e){
    e.preventDefault();
    const $btn = $(this);

    $.post($btn.data('url'), {
      product: $btn.data('product'),
      qty:     $btn.data('qty')   || 1,
      price:   $btn.data('price') || 0
    }, function(res){
      if (!res.error) {
        // update badge
        let count = parseInt($('.total-count').text()) || 0;
        $('.total-count').text(count + 1);

        // tampilkan toast singkat
        $('<div class="cart-toast">✔ Produk ditambahkan!</div>')
          .appendTo('body')
          .css({
            position: 'fixed', bottom:'20px', right:'20px',
            background:'#28a745', color:'#fff', padding:'10px 15px',
            'border-radius':'4px', 'z-index':9999
          })
          .fadeIn(200)
          .delay(800)
          .fadeOut(300, function(){ $(this).remove() });
      } else {
        alert('Gagal menambahkan ke keranjang');
      }
    }, 'json')
    .fail(function(){
      alert('Terjadi galat pada server');
    });
  });
</script>
