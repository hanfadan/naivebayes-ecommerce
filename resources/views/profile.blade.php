@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <span class="marketplace-badge">Akun Saya</span>
            <h1>Kelola pengalaman belanjamu.</h1>
            <p>Akses keranjang, wishlist, dan lanjutkan belanja dari satu tempat.</p>
        </section>

        <section class="marketplace-panel">
            <div class="marketplace-title-row">
                <div>
                    <h2>{{ $user['name'] ?? 'Akun Belanja' }}</h2>
                    <p>{{ $user['email'] ?? '' }}{{ !empty($user['phone']) ? ' · ' . $user['phone'] : '' }}</p>
                </div>
            </div>
            @if(!empty($user['address']))
                <div class="checkout-section-card">
                    <h3>Alamat Utama</h3>
                    <p class="mb-0">{{ $user['address'] }}</p>
                </div>
            @endif
            <div class="row">
                <div class="col-md-4 mb-3 mb-md-0">
                    <a href="{{ route('cart') }}" class="category-chip w-100 justify-content-center">
                        <span class="category-chip-icon"><i class="ti-shopping-cart"></i></span>
                        Keranjang Saya
                    </a>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <a href="{{ route('wishlist') }}" class="category-chip w-100 justify-content-center">
                        <span class="category-chip-icon"><i class="ti-heart"></i></span>
                        Daftar Keinginan
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('product') }}" class="category-chip w-100 justify-content-center">
                        <span class="category-chip-icon"><i class="ti-search"></i></span>
                        Jelajah Produk
                    </a>
                </div>
            </div>
        </section>
    </div>
</main>

@include('components.trust-strip')
@endsection
