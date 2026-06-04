@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th width="150" style="text-align:center;">No Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th width="150" style="text-align:right;">Total Belanja</th>
                                    <th width="50">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($transactions as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td style="text-align:center;">{{ $value['invoice'] }}</td>
                                        <td>{{ $value['user'] }}</td>
                                        <td style="text-align:right;">{{ price($value['total']) }}</td>
                                        <td style="text-align:center;">
                                            <a href="{{ route('admin.transaction.detail', ['invoice' => $value['invoice']]) }}" class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></a>
                                        </td>
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
