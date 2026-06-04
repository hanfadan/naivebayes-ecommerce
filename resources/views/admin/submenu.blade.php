@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sub Kategori</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.category') }}" class="btn btn-tool"><i class="fas fa-chevron-left"></i> Kategori Utama</a>
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th>Nama</th>
                                    <th>Url</th>
                                    <th width="80">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($categories as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['slug'] }}</td>
                                        <td style="text-align:center;">
                                            <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="{{ $value['id'] }}" data-name="{{ $value['name'] }}"><i class="fas fa-edit"></i></button>&nbsp;
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $value['id'] }}" data-url="{{ route('admin.category.delete') }}"><i class="fas fa-trash"></i></button>
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
                <h4 class="modal-title">Tambah Sub Kategori</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.category.save') }}" class="form-ajax">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Nama kategori">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="parent" name="parent" value="{{ $submenu }}">
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
                <h4 class="modal-title">Edit Kategori</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.category.save') }}" class="form-ajax">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nama kategori">
                    </div>
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
    });
});
</script>
@endsection
