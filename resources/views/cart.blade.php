@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row"><div class="col-12"><div class="bread-inner"><ul class="bread-list">
            <li><a href="{{ route('home') }}">Beranda<i class="ti-arrow-right"></i></a></li>
            <li class="active"><a href="{{ route('cart') }}">Keranjang</a></li>
        </ul></div></div></div>
    </div>
</div>
<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table shopping-summery">
                    <thead>
                        <tr class="main-hading">
                            <th width="150">&nbsp;</th>
                            <th>NAMA BARANG</th>
                            <th width="100" class="text-right">HARGA</th>
                            <th width="100" class="text-center">QTY</th>
                            <th width="100" class="text-right">TOTAL</th>
                            <th width="50" class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($carts as $val)
                            @php $total += intval($val['qty']) * intval($val['price']); @endphp
                            <tr>
                                <td class="image" data-title="No">
                                    <img src="{{ productImage('02_', $val['image']) }}" alt="{{ htmlspecialchars($val['name']) }}">
                                </td>
                                <td class="product-des" data-title="Description">
                                    <p class="product-name"><a href="javascript:void(0);">{{ $val['name'] }}</a></p>
                                    <p class="product-des">{{ $val['description'] }}</p>
                                </td>
                                <td class="text-right" data-title="Harga"><span>{{ price($val['price']) }}</span></td>
                                <td class="qty" data-title="Qty">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{ $val['id'] }}]"><i class="ti-minus"></i></button>
                                        </div>
                                        <input type="text" name="quant[{{ $val['id'] }}]" class="input-number input-qty" data-min="1" data-max="100" value="{{ $val['qty'] }}" data-product="{{ $val['product'] }}">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{ $val['id'] }}]"><i class="ti-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right" data-title="Total"><span>{{ price(intval($val['qty']) * intval($val['price'])) }}</span></td>
                                <td class="action" data-title="Hapus"><a href="javascript:void(0);" class="btn-cart-remove" data-product="{{ $val['id'] }}"><i class="ti-trash remove-icon"></i></a></td>
                            </tr>
                        @endforeach
                        @if(empty($carts))
                            <tr><td colspan="6" class="text-center">Pilih produk untuk dimasukan ke keranjang belanja</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12"></div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul><li>Subtotal<span>{{ price($total) }}</span></li></ul>
                                <div class="button5">
                                    <a href="{{ route('checkout') }}" class="btn">Pembayaran</a>
                                    <a href="{{ route('product') }}" class="btn">Lanjutkan Belanja</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
