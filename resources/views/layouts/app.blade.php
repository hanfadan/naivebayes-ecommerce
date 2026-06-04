<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/niceselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flex-slider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
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
                                <li><i class="ti-headphone-alt"></i> {{ config('app.phone') }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-12">
                        <div class="right-content">
                            <ul class="list-main">
                                @if(session('isUser'))
                                    <li><i class="ti-user"></i> <a href="{{ route('profile') }}">Akun Saya</a></li>
                                    <li><i class="ti-power-off"></i><a href="{{ route('logout') }}">Keluar</a></li>
                                @else
                                    <li><i class="ti-user"></i> <a href="{{ route('register') }}">Daftar</a></li>
                                    <li><i class="ti-power-off"></i><a href="{{ route('login') }}">Masuk</a></li>
                                @endif
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
                            <a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="logo"></a>
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
                                    {!! $categories ?? '' !!}
                                </select>
                                <form action="{{ route('product') }}">
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
                                <a href="{{ route('wishlist') }}" class="single-icon"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="sinlge-bar shopping">
                                <a href="javascript:void(0);" class="single-icon"><i class="ti-bag"></i> <span class="total-count">{{ $count ?? 0 }}</span></a>
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{ $count ?? 0 }} Barang</span>
                                        <a href="{{ route('cart') }}">Lihat Keranjang</a>
                                    </div>
                                    <ul class="shopping-list">
                                        @php $cartTotal = 0; @endphp
                                        @foreach($carts ?? [] as $cart)
                                            @php $cartTotal += intval($cart['qty']) * intval($cart['price']); @endphp
                                            <li>
                                                <a href="javascript:void(0);" class="remove btn-cart-remove" data-product="{{ $cart['id'] }}" title="Hapus barang ini"><i class="fa fa-remove"></i></a>
                                                <a class="cart-img" href="javascript:void(0);">
                                                    <img src="{{ productImage('01_', $cart['image']) }}" alt="{{ htmlspecialchars($cart['name']) }}">
                                                </a>
                                                <h4><a href="javascript:void(0);">{{ $cart['name'] }}</a></h4>
                                                <p class="quantity">{{ $cart['qty'] }}x - <span class="amount">{{ price($cart['price']) }}</span></p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">{{ price($cartTotal ?? 0) }}</span>
                                        </div>
                                        <a href="{{ route('checkout') }}" class="btn animate">Periksa</a>
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
                                                <li @if(($page ?? '') === 'home') class="active" @endif><a href="{{ route('home') }}">Beranda</a></li>
                                                <li @if(($page ?? '') === 'product') class="active" @endif><a href="{{ route('product') }}">Produk</a></li>
                                                <li>
                                                    <a href="javascript:void(0);">Kategori <i class="ti-angle-down"></i></a>
                                                    {!! $dropdowns ?? '' !!}
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

    @yield('content')

    <div class="modal fade" id="modal-view" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider"><img class="img-product" alt=""></div>
                                    <div class="single-slider"><img class="img-product" alt=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="quickview-content">
                                <h2 id="name"></h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting"><span id="category"></span></div>
                                    </div>
                                </div>
                                <h3 id="price"></h3>
                                <div class="quickview-peragraph"><p id="info"></p></div>
                                <div class="quantity mb-3">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[1]" disabled><i class="ti-minus"></i></button>
                                        </div>
                                        <input type="text" name="quant[1]" class="input-number modal-qty" value="1" data-min="1" data-max="1000">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]"><i class="ti-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-to-cart">
                                    <a href="javascript:void(0);" class="btn add-cart-modal" data-product="" data-price="">Masukkan ke Keranjang</a>
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
                                <a href="{{ route('home') }}">
                                    <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo {{ config('app.name') }}">
                                </a>
                            </div>
                            <p class="text">{{ config('app.info') }}</p>
                            <p class="call">Punya pertanyaan? Hubungi kami 24/7
                                <span><a href="tel:{{ config('app.phone') }}">{{ config('app.phone') }}</a></span>
                            </p>
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
                                <p>&copy; 2024 <a href="{{ route('home') }}">{{ config('app.name') }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/colors.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/slicknav.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/finalcountdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/nicesellect.js') }}"></script>
    <script src="{{ asset('assets/js/flex-slider.js') }}"></script>
    <script src="{{ asset('assets/js/scrollup.js') }}"></script>
    <script src="{{ asset('assets/js/onepage-nav.min.js') }}"></script>
    <script src="{{ asset('assets/js/easing.js') }}"></script>
    <script src="{{ asset('assets/js/active.js') }}"></script>

    <script>
    $(function () {
        function getProductId($el) {
            return $el.data('product') || $el.data('id') || $el.data('id_product');
        }

        $(document).on('click', '.btn-view, .btn-cart', function (e) {
            e.preventDefault();
            const $btn = $(this), prodId = getProductId($btn), price = $btn.data('price');
            const $modal = $('#modal-view');
            $modal.find('.img-product').attr('src', $btn.data('image')).prop('alt', $btn.data('name'));
            $('#name').text($btn.data('name'));
            $('#price').text(price);
            $('#info').text($btn.data('info'));
            $modal.find('.add-cart-modal').data({ product: prodId, price: price });
            $modal.find('.add-wishlist-modal').data('product', prodId);
            $modal.modal('show');
        });

        $(document).on('click', '.add-cart-modal', function () {
            const qty = parseInt($('.modal-qty').val(), 10) || 1;
            const product = $(this).data('product'), price = $(this).data('price');
            if (!product) { alert('Produk tidak dikenali.'); return; }
            $.post('{{ route("home.addCart") }}', { qty, product, price, _token: '{{ csrf_token() }}' },
                function (res) { if (!res.error) location.reload(true); }, 'json');
        });

        $(document).on('click', '.add-wishlist-modal, .btn-wishlist', function () {
            const product = $(this).data('product');
            if (!product) return;
            $.post('{{ route("home.addWishlist") }}', { product, _token: '{{ csrf_token() }}' }, () => location.reload(true), 'json');
        });

        $(document).on('click', '.btn-wishlist-remove', function () {
            $.post('{{ route("home.delWishlist") }}', { id: $(this).data('product'), _token: '{{ csrf_token() }}' }, () => location.reload(true), 'json');
        });

        $(document).on('change', '.input-qty', function () {
            $.post('{{ route("home.addCart") }}', { qty: $(this).val(), product: $(this).data('product'), _token: '{{ csrf_token() }}' }, () => location.reload(true), 'json');
        });

        $(document).on('click', '.btn-cart-remove', function () {
            $.post('{{ route("home.delCart") }}', { id: $(this).data('product'), _token: '{{ csrf_token() }}' }, () => location.reload(true), 'json');
        });
    });
    </script>

    @yield('scripts')
</body>
</html>
