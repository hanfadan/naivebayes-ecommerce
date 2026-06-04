@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{ route('home') }}">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="{{ route('product') }}">Produk</a></li>
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
                        {!! $sidebars !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-top">
                            <h4 class="mb-3">
                                @if(request('category'))
                                    Terlaris di Kategori "{{ ucwords(str_replace('-',' ',request('category'))) }}"
                                @else
                                    Produk Terlaris di Toko
                                @endif
                            </h4>
                            @if(!empty($bestSellers))
                                <div class="row">
                                    @foreach ($bestSellers as $bs)
                                        <div class="col-md-4 col-lg-3 col-6 mb-3">
                                            <a href="javascript:void(0);" class="text-decoration-none text-dark btn-view"
                                               data-id="{{ $bs['id'] }}" data-name="{{ $bs['name'] }}"
                                               data-info="{{ $bs['description'] }}" data-stok="{{ price($bs['stok']) }}"
                                               data-price="{{ price($bs['price']) }}" data-image="{{ productImage('05_', $bs['image']) }}"
                                               data-category="{{ $bs['category'] }}">
                                                <div class="card border-0 shadow-sm h-100">
                                                    <img src="{{ productImage('03_', $bs['image']) }}" class="card-img-top" alt="{{ htmlspecialchars($bs['name']) }}">
                                                    <div class="card-body p-2">
                                                        <p class="card-title small mb-1">{{ $bs['name'] }}</p>
                                                        <p class="mb-0 text-primary fw-bold">{{ price($bs['price']) }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">Belum ada data penjualan di kategori ini.</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="javascript:void(0);">
                                        <img class="default-img" src="{{ productImage('04_', $product['image']) }}" alt="{{ htmlspecialchars($product['name']) }}">
                                        <img class="hover-img"   src="{{ productImage('04_', $product['image']) }}" alt="{{ $product['name'] }}">
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a title="Detail Produk" href="javascript:void(0);" class="btn-view"
                                               data-id="{{ $product['id'] }}" data-name="{{ $product['name'] }}"
                                               data-info="{{ $product['description'] }}" data-stok="{{ price($product['stok']) }}"
                                               data-price="{{ price($product['price']) }}" data-image="{{ productImage('05_', $product['image']) }}"
                                               data-category="{{ $product['category'] }}"><i class="ti-eye"></i><span>Detail Produk</span></a>
                                            <a title="Daftar Keinginan" href="javascript:void(0);" class="btn-wishlist" data-product="{{ $product['id'] }}"><i class="ti-heart"></i><span>Tambahkan ke Daftar Keinginan</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a href="#" title="Tambah ke Keranjang" class="btn-cart"
                                               data-url="{{ route('home.addCart') }}" data-product="{{ $product['id'] }}"
                                               data-qty="1" data-price="{{ $product['price'] }}"
                                               data-name="{{ htmlspecialchars($product['name']) }}"
                                               data-image="{{ productImage('05_', $product['image']) }}"
                                               data-info="{{ htmlspecialchars($product['description']) }}">
                                               Tambah ke Keranjang
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="javascript:void(0);">{{ $product['name'] }}</a></h3>
                                    <div class="product-price"><span>{{ price($product['price']) }}</span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).on('click', '.btn-cart', function(e){
    e.preventDefault();
    const $btn = $(this);
    $('.img-product').each(function(){
        $(this).prop('alt', $btn.closest('.single-product').find('h3 a').text());
        $(this).attr('src', $btn.closest('.single-product').find('img.default-img').attr('src'));
    });
    $('#name').html($btn.closest('.single-product').find('h3 a').text());
    $('#price').html($btn.data('price'));
    $('#info').html('');
    $('.add-cart-modal').attr('data-price', $btn.data('price')).attr('data-product', $btn.data('product'));
    $('.add-wishlist-modal').attr('data-product', $btn.data('product'));
    $('#modal-view').modal('show');
});
</script>
@endsection
