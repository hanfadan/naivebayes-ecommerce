@extends('layouts.app')

@section('content')
<main class="marketplace-page">
    <div class="container">
        <section class="marketplace-section marketplace-hero">
            <span class="marketplace-badge">Keranjang Belanja</span>
            <h1>Review produk sebelum checkout.</h1>
            <p>Pastikan jumlah dan total belanja sudah sesuai sebelum membuat pesanan.</p>
        </section>

        @php
            $total = 0;
            foreach ($carts as $cart) {
                $total += intval($cart['qty']) * intval($cart['price']);
            }
        @endphp

        @if(empty($carts))
            @include('components.empty-state', [
                'icon' => 'ti-shopping-cart',
                'title' => 'Keranjang masih kosong',
                'message' => 'Yuk, temukan produk yang kamu butuhkan.',
                'actionUrl' => route('product'),
                'actionLabel' => 'Cari Produk'
            ])
        @else
            <div class="cart-layout">
                <section>
                    @foreach($carts as $item)
                        <article class="cart-item-card">
                            <img src="{{ productImage('02_', $item['image']) }}" alt="{{ e($item['name']) }}">
                            <div>
                                <h3>{{ $item['name'] }}</h3>
                                <p>{{ $item['category'] }}</p>
                                <p class="mt-2">{{ \Illuminate\Support\Str::limit($item['description'], 110) }}</p>
                                <div class="marketplace-price mt-2">Rp{{ price($item['price']) }}</div>
                            </div>
                            <div class="cart-item-actions text-right">
                                <div class="qty mb-3">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{ $item['id'] }}]" aria-label="Kurangi jumlah"><i class="ti-minus"></i></button>
                                        </div>
                                        <input type="text" name="quant[{{ $item['id'] }}]" class="input-number input-qty" data-min="1" data-max="100" value="{{ $item['qty'] }}" data-product="{{ $item['product'] }}" aria-label="Jumlah {{ $item['name'] }}">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{ $item['id'] }}]" aria-label="Tambah jumlah"><i class="ti-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <p class="summary-row mb-2"><span>Total</span><strong>Rp{{ price(intval($item['qty']) * intval($item['price'])) }}</strong></p>
                                <a href="javascript:void(0);" class="btn marketplace-icon-btn btn-cart-remove" data-product="{{ $item['id'] }}">
                                    <i class="ti-trash"></i> Hapus
                                </a>
                            </div>
                        </article>
                    @endforeach
                </section>

                <aside class="cart-summary">
                    <h3 class="mb-3">Ringkasan Belanja</h3>
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>Rp{{ price($total) }}</strong>
                    </div>
                    <div class="summary-row">
                        <span>Voucher</span>
                        <strong>Belum digunakan</strong>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <strong>Rp{{ price($total) }}</strong>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-block mt-3">Lanjut Checkout</a>
                    <a href="{{ route('product') }}" class="btn marketplace-icon-btn btn-block mt-2">Lanjut Belanja</a>
                </aside>
            </div>
        @endif
    </div>
</main>
@endsection
