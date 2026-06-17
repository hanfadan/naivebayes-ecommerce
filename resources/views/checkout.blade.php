@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <span class="marketplace-badge">Checkout</span>
            <h1>Satu langkah lagi untuk membuat pesanan.</h1>
            <p>Cek alamat, produk, dan total belanja. Pembayaran tetap dikonfirmasi sesuai alur toko saat ini.</p>
        </section>

        @php
            $total = 0;
            foreach ($carts as $cart) {
                $total += intval($cart['qty']) * intval($cart['price']);
            }
        @endphp

        <div class="checkout-layout">
            <section>
                <div class="checkout-section-card">
                    <h3>Alamat Pengiriman</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="marketplace-muted mb-1">Nama Penerima</p>
                            <strong>{{ $user['name'] ?? '-' }}</strong>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <p class="marketplace-muted mb-1">Nomor Telepon</p>
                            <strong>{{ $user['phone'] ?? '-' }}</strong>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="marketplace-muted mb-1">Alamat</p>
                            <strong>{{ $user['address'] ?? '-' }}</strong>
                        </div>
                    </div>
                </div>

                <div class="checkout-section-card">
                    <h3>Produk yang Dibeli</h3>
                    @foreach($carts as $item)
                        <article class="checkout-item-card">
                            <img src="{{ productImage('02_', $item['image']) }}" alt="{{ e($item['name']) }}">
                            <div>
                                <h3>{{ $item['name'] }}</h3>
                                <p>{{ $item['category'] }} · {{ $item['qty'] }} barang</p>
                                <div class="marketplace-price mt-2">Rp{{ price($item['price']) }}</div>
                            </div>
                            <strong>Rp{{ price(intval($item['qty']) * intval($item['price'])) }}</strong>
                        </article>
                    @endforeach
                </div>

                <div class="checkout-section-card">
                    <h3>Voucher & Pengiriman</h3>
                    <p class="marketplace-muted mb-2">Voucher dan biaya pengiriman belum tersedia di sistem saat ini.</p>
                    <span class="marketplace-badge">Total dihitung dari subtotal produk</span>
                </div>

                <div class="checkout-section-card">
                    <h3>Metode Pembayaran</h3>
                    <p class="marketplace-muted mb-0">Pesanan dibuat terlebih dahulu, lalu pembayaran dikonfirmasi melalui WhatsApp toko.</p>
                </div>
            </section>

            <aside class="checkout-summary">
                <h3 class="mb-3">Ringkasan Pesanan</h3>
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <strong>Rp{{ price($total) }}</strong>
                </div>
                <div class="summary-row">
                    <span>Diskon/Voucher</span>
                    <strong>Rp0</strong>
                </div>
                <div class="summary-row">
                    <span>Pengiriman</span>
                    <strong>Belum dihitung</strong>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <strong>Rp{{ price($total) }}</strong>
                </div>
                <a href="{{ route('checkout.process') }}" class="btn btn-block mt-3">Buat Pesanan</a>
                <a href="{{ route('cart') }}" class="btn marketplace-icon-btn btn-block mt-2">Kembali ke Keranjang</a>
            </aside>
        </div>
    </div>
</main>
@endsection
