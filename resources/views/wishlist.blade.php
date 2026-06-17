@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <span class="marketplace-badge">Daftar Keinginan</span>
            <h1>Produk yang kamu simpan.</h1>
            <p>Cek kembali produk favoritmu dan tambahkan ke keranjang saat sudah siap.</p>
        </section>

        @if(empty($wishlists))
            @include('components.empty-state', [
                'icon' => 'ti-heart',
                'title' => 'Belum ada produk tersimpan',
                'message' => 'Simpan produk favorit agar mudah ditemukan lagi.',
                'actionUrl' => route('product'),
                'actionLabel' => 'Jelajah Produk'
            ])
        @else
            <section class="marketplace-panel">
                @foreach($wishlists as $item)
                    <article class="wishlist-item-card">
                        <img src="{{ productImage('02_', $item['image']) }}" alt="{{ e($item['name']) }}">
                        <div>
                            <span class="marketplace-badge">{{ $item['category'] }}</span>
                            <h3>{{ $item['name'] }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($item['description'], 120) }}</p>
                            <div class="marketplace-price mt-2">Rp{{ price($item['price']) }}</div>
                        </div>
                        <div class="wishlist-item-actions text-right">
                            <a href="javascript:void(0);"
                               class="btn btn-cart mb-2"
                               data-product="{{ $item['product'] }}"
                               data-name="{{ e($item['name']) }}"
                               data-info="{{ e($item['description']) }}"
                               data-price="{{ $item['price'] }}"
                               data-price-label="{{ price($item['price']) }}"
                               data-image="{{ productImage('05_', $item['image']) }}"
                               data-category="{{ e($item['category']) }}"
                               data-brand="Toko lokal">
                                + Keranjang
                            </a>
                            <a href="javascript:void(0);" class="btn marketplace-icon-btn btn-wishlist-remove" data-product="{{ $item['id'] }}">
                                <i class="ti-trash"></i> Hapus
                            </a>
                        </div>
                    </article>
                @endforeach
            </section>
        @endif
    </div>
</main>
@endsection
