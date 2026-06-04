@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pelanggan</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th width="150">Nama Lengkap</th>
                                    <th width="120">Email</th>
                                    <th width="110">Nomor Telepon</th>
                                    <th width="80">Usia</th>
                                    <th width="100">Jenis Kelamin</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($customers as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['email'] }}</td>
                                        <td>{{ $value['phone'] }}</td>
                                        <td>{{ checkAge($value['birth']) }} Tahun</td>
                                        <td>{{ $value['gender'] === 'm' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                        <td>{{ $value['address'] }}</td>
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
