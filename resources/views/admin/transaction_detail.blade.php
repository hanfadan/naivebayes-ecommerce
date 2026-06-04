@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi: {{ $invoice }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th>Nama Barang</th>
                                    <th width="100" style="text-align:right;">QTY</th>
                                    <th width="150" style="text-align:right;">Harga</th>
                                    <th width="150" style="text-align:right;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($transactions as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td>{{ $value['product'] }}</td>
                                        <td style="text-align:right;">{{ price($value['qty']) }}</td>
                                        <td style="text-align:right;">{{ price($value['price']) }}</td>
                                        <td style="text-align:right;">{{ price(intval($value['qty']) * intval($value['price'])) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
