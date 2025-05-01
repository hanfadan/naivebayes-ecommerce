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
                            <a href="<?php echo url();?>"><img src="<?php echo img('logo2.png');?>" alt="#"></a>
                        </div>
                        <p class="text"><?php echo APP_INFO;?></p>
                        <p class="call">Punya pertanyaan? Hubungi kami 24/7<span><a href="tel:<?php echo APP_PHONE;?>"><?php echo APP_PHONE;?></a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="left">
                            <p>Copyright © 2024 <a href="<?php echo url();?>"><?php echo APP_NAME;?></a>  -  All Rights Reserved.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="right">
                            <img src="images/payments.png" alt="#">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo js('jquery.min');?>"></script>
<script src="<?php echo js('jquery-migrate-3.0.0');?>"></script>
<script src="<?php echo js('jquery-ui.min');?>"></script>
<script src="<?php echo js('popper.min');?>"></script>
<script src="<?php echo js('bootstrap.min');?>"></script>
<script src="<?php echo js('colors');?>"></script>
<script src="<?php echo js('datepicker.min');?>"></script>
<script src="<?php echo js('slicknav.min');?>"></script>
<script src="<?php echo js('owl-carousel');?>"></script>
<script src="<?php echo js('magnific-popup');?>"></script>
<script src="<?php echo js('waypoints.min');?>"></script>
<script src="<?php echo js('finalcountdown.min');?>"></script>
<script src="<?php echo js('nicesellect');?>"></script>
<script src="<?php echo js('flex-slider');?>"></script>
<script src="<?php echo js('scrollup');?>"></script>
<script src="<?php echo js('onepage-nav.min');?>"></script>
<script src="<?php echo js('easing');?>"></script>
<script src="<?php echo js('active');?>"></script>
<script>
    $(function(){
        $(document).on('click','.btn-cart',function(){
            let btn=$(this);
            $.ajax({
                url:'<?php echo url('home/addCart');?>',
                data:{'price':btn.data('price'),'product':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $('.add-cart-modal').on('click',function(){
            let btn=$(this),qty=$('.modal-qty').val();
            $.ajax({
                url:'<?php echo url('home/addCart');?>',
                data:{'qty':qty,'price':btn.data('price'),'product':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $('.add-wishlist-modal').on('click',function(){
            let btn=$(this),qty=$('.modal-qty').val();
            $.ajax({
                url:'<?php echo url('home/addWishlist');?>',
                data:{'qty':qty,'product':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $(document).on('click','.btn-cart-remove',function(){
            let btn=$(this);
            $.ajax({
                url:'<?php echo url('home/delCart');?>',
                data:{'id':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $(document).on('click','.btn-wishlist',function(){
            let btn=$(this);
            $.ajax({
                url:'<?php echo url('home/addWishlist');?>',
                data:{'product':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $(document).on('click','.btn-wishlist-remove',function(){
            let btn=$(this);
            $.ajax({
                url:'<?php echo url('home/delWishlist');?>',
                data:{'id':btn.data('product')},
                type:'POST',
                dataType:'json',
                success:function(data){
                    if(!data.error){
                        window.location.reload(true);
                    }
                }
            });
        });
        $('.input-qty').each(function(){
            let input=$(this);
            input.on('change',function(){
                $.ajax({
                    url:'<?php echo url('home/addCart');?>',
                    data:{'qty':input.val(),'product':input.data('product')},
                    type:'POST',
                    dataType:'json',
                    success:function(data){
                        if(!data.error){
                            window.location.reload(true);
                        }
                    }
                });
            });
        });
        $('#cat').change(function(){
            $('#category').val(this.value);
        });
        $(document).on('click','.btn-view',function(){
            let btn=$(this),img=$('.img-product');
            $('#modal-view').modal();
            $.each(img,function(){
                img.prop('alt',btn.data('name'));
                img.attr('src',btn.data('image'));
            });
            $('#name').html(btn.data('name'));
            $('#price').html(btn.data('price'));
            $('#info').html(btn.data('info'));
            $('.add-cart-modal').attr('data-price',btn.data('price'));
            $('.add-cart-modal').attr('data-product',btn.data('id'));
            $('.add-wishlist-modal').attr('data-product',btn.data('id'));
        });
    });
</script>
</body>
</html>