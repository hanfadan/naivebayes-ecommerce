@extends('layouts.app')

@section('content')
@php
function h_selected($src, $key, $val) {
    return !empty($src[$key]) && $src[$key]===$val ? 'selected' : '';
}
@endphp

<section class="hero-slider">
    <div class="single-slider">
        <div class="container"></div>
    </div>
</section>

<div class="container">
    <div class="bg-white shadow-sm rounded p-4 mb-4">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Dapatkan Rekomendasi Produk</h2>
                </div>
            </div>
        </div>

        <form method="post" class="mb-5">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="small text-muted px-2">Kelompok Umur</legend>
                        <select name="umur" class="form-select" required>
                            <option value="" disabled {{ empty($formInput['umur']) ? 'selected' : '' }}>Pilih Kelompok Umur</option>
                            @foreach (['18-24','25-34','35+'] as $age)
                                <option value="{{ $age }}" {{ h_selected($formInput, 'umur', $age) }}>{{ $age }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="small text-muted px-2">Gender</legend>
                        <select name="gender" class="form-select" required>
                            <option value="" disabled {{ empty($formInput['gender']) ? 'selected' : '' }}>Pilih Gender</option>
                            @foreach (['m' => 'Laki-laki','f' => 'Perempuan'] as $val => $label)
                                <option value="{{ $val }}" {{ h_selected($formInput, 'gender', $val) }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="border rounded p-3 mb-4">
                        <legend class="w-auto small text-muted">Gaya / Kategori Favorit</legend>
                        <select name="kategori" class="form-select" required>
                            <option value="" disabled {{ empty($formInput['kategori']) ? 'selected' : '' }}>Pilih Kategori</option>
                            @foreach ($kategoriList as $slug => $label)
                                <option value="{{ $slug }}" {{ isset($formInput['kategori']) && $formInput['kategori']===$slug ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="small text-muted px-2">Frekuensi Belanja</legend>
                        <select name="buy_freq" class="form-select" required>
                            <option value="" disabled {{ empty($formInput['buy_freq']) ? 'selected' : '' }}>Pilih Frekuensi Belanja</option>
                            @foreach ($buyFreqList as $f)
                                <option value="{{ $f }}" {{ h_selected($formInput, 'buy_freq', $f) }}>{{ $f }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
                <div class="col-md-4">
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="small text-muted px-2">Budget per Transaksi</legend>
                        <select name="budget_band" class="form-select" required>
                            <option value="" disabled {{ empty($formInput['budget_band']) ? 'selected' : '' }}>Pilih Budget per Transaksi</option>
                            @foreach ($budgetBandList as $b)
                                <option value="{{ $b }}" {{ h_selected($formInput, 'budget_band', $b) }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
        </form>
    </div>

    @if(request()->isMethod('POST') && !empty($naivebayes))
        <div class="row">
            <div class="col-12">
                <div class="section-title"><h2>Rekomendasi Produk Terbaik Untukmu</h2></div>
            </div>
        </div>
        <div class="row">
            @foreach ($naivebayes as $product)
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="javascript:void(0);">
                                <img class="default-img" src="{{ productImage('03_', $product['image']) }}" alt="{{ htmlspecialchars($product['name']) }}">
                                <img class="hover-img"   src="{{ productImage('03_', $product['image']) }}" alt="{{ htmlspecialchars($product['name']) }}">
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
                                    <a href="#" class="btn-cart" data-url="{{ route('home.addCart') }}" data-product="{{ $product['id'] }}" data-qty="1" data-price="{{ $product['price'] }}">Tambah ke Keranjang</a>
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
    @elseif(request()->isMethod('POST'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info w-100 text-center py-4">
                    Belum ada rekomendasi untuk pilihanmu.<br>Coba ubah kategori atau parameter lain, ya!
                </div>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title"><h2>Produk Terbaru</h2></div>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-xl-3 col-lg-4 col-md-4 col-12">
                    <div class="single-product">
                        <div class="product-img">
                            <a href="javascript:void(0);">
                                <img class="default-img" src="{{ productImage('03_', $product['image']) }}" alt="{{ htmlspecialchars($product['name']) }}">
                                <img class="hover-img"   src="{{ productImage('03_', $product['image']) }}" alt="{{ htmlspecialchars($product['name']) }}">
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
                                    <a href="#" class="btn-cart" data-url="{{ route('home.addCart') }}" data-product="{{ $product['id'] }}" data-qty="1" data-price="{{ $product['price'] }}">Tambah ke Keranjang</a>
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

<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12"><div class="single-service"><i class="ti-rocket"></i><h4>Bebas biaya kirim</h4><p>Pesanan lebih dari 1000K</p></div></div>
            <div class="col-lg-3 col-md-6 col-12"><div class="single-service"><i class="ti-reload"></i><h4>Pengembalian Gratis</h4><p>Dalam waktu 2 hari kembali</p></div></div>
            <div class="col-lg-3 col-md-6 col-12"><div class="single-service"><i class="ti-lock"></i><h4>Pembayaran yang aman</h4><p>Pembayaran aman 100%.</p></div></div>
            <div class="col-lg-3 col-md-6 col-12"><div class="single-service"><i class="ti-tag"></i><h4>Harga Terbaik</h4><p>Harga terjamin</p></div></div>
        </div>
    </div>
</section>
@endsection
