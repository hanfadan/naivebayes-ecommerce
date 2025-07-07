<div class="modal fade" id="modal-view" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-gallery">
                            <div class="quickview-slider-active">
                                <div class="single-slider"><img class="img-product" alt=""></div>
                                <div class="single-slider"><img class="img-product" alt=""></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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
                            <div class="size"></div>
                            <div class="quantity">
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" name="quant[1]" class="input-number modal-qty" data-min="1" data-max="1000" value="1">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="javascript:void(0);" class="btn add-cart-modal" data-price="" data-product="">Masukkan ke keranjang</a>
                                <a href="javascript:void(0);" class="btn min add-wishlist-modal" data-product=""><i class="ti-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="footer-top section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="single-footer about">
                        <div class="logo">
                            <a href="<?= url(); ?>">
                                <img src="<?= img('logo2.png'); ?>" alt="Logo <?= APP_NAME; ?>">
                            </a>
                        </div>
                        <p class="text"><?= APP_INFO; ?></p>
                        <p class="call">
                            Punya pertanyaan? Hubungi kami 24/7
                            <span><a href="tel:<?= APP_PHONE; ?>"><?= APP_PHONE; ?></a></span>
                        </p>
                    </div>
                </div>
                <!-- … footer column lain jika ada … -->
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>
                                Copyright © 2024
                                <a href="<?= url(); ?>"><?= APP_NAME; ?></a> –
                                All Rights Reserved.
                            </p>
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

<!-- === JS vendor & plugin === -->
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

<!-- === Custom script === -->
<script>
$(function () {

    /* ============================================================
     * 1. Buka modal → set detail produk
     * ============================================================ */
    $(document).on('click', '.btn-cart, .btn-view', function (e) {
        e.preventDefault();

        const btn = $(this);               // tombol kartu produk
        const $modal = $('#modal-view');   // modal
        const $imgs  = $modal.find('.img-product');

        // Set gambar, alt, dan informasi
        $imgs.each(function () {
            $(this).attr('src',  btn.data('image'))
                   .prop('alt',  btn.data('name'));
        });

        $('#name').text(btn.data('name'));
        $('#price').text(btn.data('price'));
        $('#info').text(btn.data('info'));

        /* --------- penting: gunakan .data() (bukan .attr()) --------- */
        $('.add-cart-modal')
            .data('product', btn.data('product'))
            .data('price',   btn.data('price'));

        $('.add-wishlist-modal')
            .data('product', btn.data('id'));

        $modal.modal('show');
    });


    /* ============================================================
     * 2. Tambahkan ke keranjang
     * ============================================================ */
    $(document).on('click', '.add-cart-modal', function () {

        const qty     = parseInt($('.modal-qty').val(), 10) || 1;
        const product = $(this).data('product');   // sudah terisi
        const price   = $(this).data('price');

        if (!product) {
            alert('Produk tidak dikenali. Coba ulangi.');
            return;
        }

        $.ajax({
            url : '<?= url("home/addCart"); ?>',
            type: 'POST',
            dataType: 'json',
            data: { qty, product, price },
            success (res) {
                if (!res.error) {
                    location.reload(true);
                } else {
                    alert(res.msg || 'Gagal menambah ke keranjang.');
                }
            },
            error (xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan server.');
            }
        });
    });


    /* ============================================================
     * 3. Tambah / hapus wishlist
     * ============================================================ */
    $(document).on('click', '.add-wishlist-modal, .btn-wishlist', function () {

        const product = $(this).data('product');
        if (!product) return;

        $.ajax({
            url : '<?= url("home/addWishlist"); ?>',
            type: 'POST',
            dataType: 'json',
            data: { product },
            success (res) {
                if (!res.error) location.reload(true);
            }
        });
    });

    $(document).on('click', '.btn-wishlist-remove', function () {
        $.post('<?= url("home/delWishlist"); ?>',
               { id: $(this).data('product') },
               () => location.reload(true),
               'json');
    });


    /* ============================================================
     * 4. Update qty langsung di keranjang
     * ============================================================ */
    $(document).on('change', '.input-qty', function () {
        $.post('<?= url("home/addCart"); ?>',
               { qty: $(this).val(), product: $(this).data('product') },
               () => location.reload(true),
               'json');
    });


    /* ============================================================
     * 5. Hapus item keranjang
     * ============================================================ */
    $(document).on('click', '.btn-cart-remove', function () {
        $.post('<?= url("home/delCart"); ?>',
               { id: $(this).data('product') },
               () => location.reload(true),
               'json');
    });


    /* ============================================================
     * 6. Dropdown kategori (jika ada)
     * ============================================================ */
    $('#cat').on('change', function () {
        $('#category').val(this.value);
    });

});
</script>
</body>
</html>