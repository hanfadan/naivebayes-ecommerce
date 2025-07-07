<div class="modal fade" id="modal-view" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span class="ti-close"></span></button>
            </div>

            <div class="modal-body">
                <div class="row no-gutters">
                    <!-- gambar -->
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                <div class="single-slider">
                                    <img class="img-product" alt="">
                                </div>
                                <div class="single-slider">
                                    <img class="img-product" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- detail -->
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="quickview-content">
                            <h2 id="name"></h2>

                            <div class="quickview-ratting-review">
                                <div class="quickview-ratting-wrap">
                                    <div class="quickview-ratting">
                                        <span id="category"></span>
                                    </div>
                                </div>
                            </div>

                            <h3 id="price"></h3>

                            <div class="quickview-peragraph">
                                <p id="info"></p>
                            </div>

                            <div class="quantity mb-3">
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number"
                                                data-type="minus" data-field="quant[1]" disabled>
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>

                                    <input type="text" name="quant[1]"
                                           class="input-number modal-qty" value="1"
                                           data-min="1" data-max="1000">

                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number"
                                                data-type="plus" data-field="quant[1]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="add-to-cart">
                                <!-- data-* dikosongkan; nanti diset via JS -->
                                <a href="javascript:void(0);"
                                   class="btn add-cart-modal"
                                   data-product="" data-price="">
                                   Masukkan ke Keranjang
                                </a>

                                <a href="javascript:void(0);"
                                   class="btn min add-wishlist-modal"
                                   data-product="">
                                   <i class="ti-heart"></i>
                                </a>
                            </div>
                        </div><!-- /.quickview-content -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.modal-body -->
        </div>
    </div>
</div>
<!-- ========== /MODAL QUICKVIEW ========== -->


<footer class="footer">
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="single-footer about">
                        <div class="logo">
                            <a href="<?= url(); ?>">
                                <img src="<?= img('logo2.png'); ?>"
                                     alt="Logo <?= APP_NAME; ?>">
                            </a>
                        </div>
                        <p class="text"><?= APP_INFO; ?></p>
                        <p class="call">
                            Punya pertanyaan? Hubungi kami 24/7
                            <span><a href="tel:<?= APP_PHONE; ?>">
                                   <?= APP_PHONE; ?></a></span>
                        </p>
                    </div>
                </div>
                <!-- kolom footer lain … -->
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>© 2024 <a href="<?= url(); ?>"><?= APP_NAME; ?></a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="right">
                            <img src="images/payments.png" alt="Metode pembayaran">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- ========== JS VENDOR ========== -->
<script src="<?= js('jquery.min'); ?>"></script>
<script src="<?= js('jquery-migrate-3.0.0'); ?>"></script>
<script src="<?= js('jquery-ui.min'); ?>"></script>
<script src="<?= js('popper.min'); ?>"></script>
<script src="<?= js('bootstrap.min'); ?>"></script>
<script src="<?= js('colors'); ?>"></script>
<script src="<?= js('datepicker.min'); ?>"></script>
<script src="<?= js('slicknav.min'); ?>"></script>
<script src="<?= js('owl-carousel'); ?>"></script>
<script src="<?= js('magnific-popup'); ?>"></script>
<script src="<?= js('waypoints.min'); ?>"></script>
<script src="<?= js('finalcountdown.min'); ?>"></script>
<script src="<?= js('nicesellect'); ?>"></script>
<script src="<?= js('flex-slider'); ?>"></script>
<script src="<?= js('scrollup'); ?>"></script>
<script src="<?= js('onepage-nav.min'); ?>"></script>
<script src="<?= js('easing'); ?>"></script>
<script src="<?= js('active'); ?>"></script>


<!-- ========== CUSTOM SCRIPT ========== -->
<script>
$(function () {

    /* ------- helper fleksibel pengambil ID ------- */
    function getProductId($el) {
        return $el.data('product')      // prefer this
            || $el.data('id')           // fallback lama
            || $el.data('id_product');  // fallback lain
    }

    /* =================================================
     * 1. Buka modal  (btn-view / btn-cart)
     * ================================================= */
    $(document).on('click', '.btn-view, .btn-cart', function (e) {
        e.preventDefault();

        const $btn   = $(this);
        const prodId = getProductId($btn);
        const price  = $btn.data('price');

        const $modal = $('#modal-view');

        /* gambar & info */
        $modal.find('.img-product')
              .attr('src', $btn.data('image'))
              .prop('alt', $btn.data('name'));

        $('#name').text($btn.data('name'));
        $('#price').text(price);
        $('#info').text($btn.data('info'));

        /* simpan ID & price di tombol modal */
        $modal.find('.add-cart-modal')
              .data({ product: prodId, price: price });

        $modal.find('.add-wishlist-modal')
              .data('product', prodId);

        $modal.modal('show');
    });

    /* =================================================
     * 2. Masukkan ke Keranjang (tombol di modal)
     * ================================================= */
    $(document).on('click', '.add-cart-modal', function () {

        const qty     = parseInt($('.modal-qty').val(), 10) || 1;
        const product = $(this).data('product');
        const price   = $(this).data('price');

        if (!product) {
            alert('Produk tidak dikenali. Coba ulangi.');
            return;
        }

        $.post('<?= url("home/addCart"); ?>',
               { qty, product, price },
               function (res) {
                   if (!res.error) {
                       location.reload(true);
                   } else {
                       alert(res.msg || 'Gagal menambah ke keranjang.');
                   }
               },
               'json'
        );
    });

    /* =================================================
     * 3. Wishlist (tambah & hapus)
     * ================================================= */
    $(document).on('click', '.add-wishlist-modal, .btn-wishlist', function () {
        const product = $(this).data('product');
        if (!product) return;

        $.post('<?= url("home/addWishlist"); ?>',
               { product }, () => location.reload(true), 'json');
    });

    $(document).on('click', '.btn-wishlist-remove', function () {
        $.post('<?= url("home/delWishlist"); ?>',
               { id: $(this).data('product') }, () => location.reload(true), 'json');
    });

    /* =================================================
     * 4. Update qty di keranjang
     * ================================================= */
    $(document).on('change', '.input-qty', function () {
        $.post('<?= url("home/addCart"); ?>',
               { qty: $(this).val(), product: $(this).data('product') },
               () => location.reload(true), 'json');
    });

    /* =================================================
     * 5. Hapus item keranjang
     * ================================================= */
    $(document).on('click', '.btn-cart-remove', function () {
        $.post('<?= url("home/delCart"); ?>',
               { id: $(this).data('product') },
               () => location.reload(true), 'json');
    });

});
</script>
</body>
</html>
