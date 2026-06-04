@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row"><div class="col-12"><div class="bread-inner"><ul class="bread-list">
            <li><a href="{{ route('home') }}">Beranda<i class="ti-arrow-right"></i></a></li>
            <li class="active"><a href="{{ route('wishlist') }}">Daftar Keinginan</a></li>
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
                            <th width="50" class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $val)
                            <tr>
                                <td class="image" data-title="No">
                                    <img src="{{ productImage('02_', $val['image']) }}" alt="{{ htmlspecialchars($val['name']) }}">
                                </td>
                                <td class="product-des" data-title="Description">
                                    <p class="product-name"><a href="javascript:void(0);">{{ $val['name'] }}</a></p>
                                    <p class="product-des">{{ $val['description'] }}</p>
                                </td>
                                <td class="text-right" data-title="Harga"><span>{{ price($val['price']) }}</span></td>
                                <td class="action" data-title="Hapus"><a href="javascript:void(0);" class="btn-wishlist-remove" data-product="{{ $val['id'] }}"><i class="ti-trash remove-icon"></i></a></td>
                            </tr>
                        @endforeach
                        @if(empty($wishlists))
                            <tr><td colspan="4" class="text-center">Pilih produk untuk dimasukan ke daftar keinginan</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
