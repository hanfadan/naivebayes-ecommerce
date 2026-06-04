@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row"><div class="col-12"><div class="bread-inner"><ul class="bread-list">
            <li><a href="{{ route('home') }}">Beranda<i class="ti-arrow-right"></i></a></li>
            <li class="active"><a href="{{ route('checkout') }}">Periksa</a></li>
        </ul></div></div></div>
    </div>
</div>
<section class="shop checkout section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="checkout-form">
                    <div class="form">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama Penerima<span>*</span></label>
                                    <input type="text" value="{{ $user['name'] ?? '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nomor Telepon Penerima<span>*</span></label>
                                    <input type="text" value="{{ $user['phone'] ?? '' }}" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat Pengiriman<span>*</span></label>
                                    <textarea readonly>{{ $user['address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="order-details">
                    <div class="single-widget">
                        <h2>TOTAL KERANJANG</h2>
                        <div class="content">
                            @php $total = 0;
                            foreach($carts as $cart) { $total += intval($cart['qty']) * intval($cart['price']); }
                            @endphp
                            <ul><li>Sub Total<span>{{ price($total) }}</span></li></ul>
                        </div>
                    </div>
                    <div class="single-widget get-button">
                        <div class="content">
                            <div class="button">
                                <a href="{{ route('checkout.process') }}" class="btn">Proses Transaksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
