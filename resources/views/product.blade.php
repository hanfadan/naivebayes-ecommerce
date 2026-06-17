@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="marketplace-badge">Pusat produk fashion</span>
                    <h1>
                        @if(request('search'))
                            Hasil pencarian "{{ request('search') }}"
                        @elseif(request('category'))
                            Kategori {{ ucwords(str_replace('-', ' ', request('category'))) }}
                        @else
                            Jelajahi Produk
                        @endif
                    </h1>
                    <p>Cari produk yang pas, cek stok, simpan favorit, lalu lanjut checkout saat sudah siap.</p>
                </div>
                <div class="col-lg-5 mt-3 mt-lg-0">
                    <form action="{{ route('product') }}" class="d-flex">
                        <input type="search" name="search" class="form-control mr-2" value="{{ request('search') }}" placeholder="Cari produk, toko, atau kategori..." aria-label="Cari produk">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <button class="btn" type="submit">Cari</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="marketplace-section">
            <div class="marketplace-title-row">
                <div>
                    <h2>Kategori Cepat</h2>
                    <p>Filter produk berdasarkan kategori yang tersedia.</p>
                </div>
                @if(request('category') || request('search'))
                    <a href="{{ route('product') }}">Reset filter</a>
                @endif
            </div>
            @include('components.category-shortcuts', ['categories' => $categoryShortcuts ?? []])
        </section>

        <div class="row">
            <aside class="col-lg-3 col-md-4 col-12 mb-4">
                <div class="marketplace-sidebar shop-sidebar">
                    <div class="single-widget category">
                        <h3 class="title">Kategori</h3>
                        {!! $sidebars !!}
                    </div>
                </div>
            </aside>

            <div class="col-lg-9 col-md-8 col-12">
                <section class="marketplace-section marketplace-panel">
                    <div class="marketplace-title-row">
                        <div>
                            <h2>
                                @if(request('category'))
                                    Terlaris di kategori ini
                                @else
                                    Produk terlaris
                                @endif
                            </h2>
                            <p>Ringkasan produk yang paling sering dibeli.</p>
                        </div>
                    </div>

                    @if(!empty($bestSellers))
                        <div class="row marketplace-grid">
                            @foreach ($bestSellers as $bestSeller)
                                @include('components.product-card', [
                                    'product' => $bestSeller,
                                    'imagePrefix' => '03_',
                                    'columnClass' => 'col-xl-4 col-lg-4 col-md-6 col-6'
                                ])
                            @endforeach
                        </div>
                    @else
                        @include('components.empty-state', [
                            'icon' => 'ti-bar-chart',
                            'title' => 'Belum ada data terlaris',
                            'message' => 'Produk populer akan tampil setelah ada transaksi.'
                        ])
                    @endif
                </section>

                <section class="marketplace-section">
                    <div class="marketplace-title-row">
                        <div>
                            <h2>Semua Produk</h2>
                            <p>{{ count($products) }} produk tersedia untuk filter saat ini.</p>
                        </div>
                    </div>

                    @if(!empty($products))
                        <div class="row marketplace-grid">
                            @foreach ($products as $product)
                                @include('components.product-card', [
                                    'product' => $product,
                                    'imagePrefix' => '04_',
                                    'columnClass' => 'col-xl-4 col-lg-4 col-md-6 col-6'
                                ])
                            @endforeach
                        </div>
                    @else
                        @include('components.empty-state', [
                            'icon' => 'ti-search',
                            'title' => 'Produk tidak ditemukan',
                            'message' => 'Coba gunakan kata kunci lain atau cek kategori populer.',
                            'actionUrl' => route('product'),
                            'actionLabel' => 'Reset Pencarian'
                        ])
                    @endif
                </section>
            </div>
        </div>
    </div>
</main>
@endsection
