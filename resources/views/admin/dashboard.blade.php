@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Transaksi Hari Ini</span>
                        <span class="info-box-number">{{ $totalNow }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Transaksi Bulan Ini</span>
                        <span class="info-box-number">{{ $totalMonth }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Transaksi</span>
                        <span class="info-box-number">{{ $totalAll }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Pelanggan</span>
                        <span class="info-box-number">{{ $totalUser }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pencarian Terpopuler</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th>Pencarian</th>
                                    <th width="120" style="text-align:right;">Sebanyak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($searchs as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td>{{ $value['name'] }}</td>
                                        <td style="text-align:right;">{{ price($value['view']) }} pencarian</td>
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
