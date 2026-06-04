@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pengguna</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th width="80">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($users as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['email'] }}</td>
                                        <td>{{ $value['phone'] }}</td>
                                        <td style="text-align:center;">
                                            <button type="button" class="btn btn-sm btn-primary btn-edit"
                                                data-id="{{ $value['id'] }}" data-name="{{ $value['name'] }}"
                                                data-email="{{ $value['email'] }}" data-phone="{{ $value['phone'] }}"><i class="fas fa-edit"></i></button>&nbsp;
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $value['id'] }}" data-url="{{ route('admin.user.delete') }}"><i class="fas fa-trash"></i></button>
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

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Baru</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.user.save') }}" class="form-ajax">
                <div class="modal-body">
                    <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Nama lengkap" required></div>
                    <div class="form-group"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                    <div class="form-group"><input type="text" name="phone" class="form-control" placeholder="Nomor telepon" required></div>
                    <div class="form-group"><input type="password" name="password" class="form-control" placeholder="Kata sandi" required></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Pengguna</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.user.save') }}" class="form-ajax">
                <div class="modal-body">
                    <div class="form-group"><input type="text" id="name" name="name" class="form-control" placeholder="Nama lengkap" required></div>
                    <div class="form-group"><input type="email" id="email" name="email" class="form-control" placeholder="Email" required></div>
                    <div class="form-group"><input type="text" id="phone" name="phone" class="form-control" placeholder="Nomor telepon" required></div>
                    <div class="form-group"><input type="password" name="password" class="form-control" placeholder="Kata sandi"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="id" name="id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(function(){
    $(document).on('click','.btn-edit',function(){
        let btn=$(this);
        $('#modal-edit').modal();
        $('#id').val(btn.data('id'));
        $('#name').val(btn.data('name'));
        $('#email').val(btn.data('email'));
        $('#phone').val(btn.data('phone'));
    });
});
</script>
@endsection
