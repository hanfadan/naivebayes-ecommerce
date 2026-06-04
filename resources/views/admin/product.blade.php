@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produk</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus-circle"></i> Tambah Baru</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-data table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="40" style="text-align:center;">No</th>
                                    <th width="40" style="text-align:center;">&nbsp;</th>
                                    <th>Nama Produk</th>
                                    <th width="150">Kategori</th>
                                    <th width="80" style="text-align:right;">Stok</th>
                                    <th width="80" style="text-align:right;">Harga</th>
                                    <th width="100" style="text-align:center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($products as $value)
                                    <tr>
                                        <td style="text-align:center;">{{ $no++ }}</td>
                                        <td style="text-align:center;"><img src="{{ productImage('01_', $value['image']) }}" alt="{{ htmlspecialchars($value['name']) }}"></td>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['category'] }}</td>
                                        <td style="text-align:right;">{{ price($value['stok']) }}</td>
                                        <td style="text-align:right;">{{ price($value['price']) }}</td>
                                        <td style="text-align:center;">
                                            <button type="button" class="btn btn-sm btn-primary btn-edit"
                                                data-id="{{ $value['id'] }}" data-old="{{ $value['image'] }}"
                                                data-name="{{ $value['name'] }}" data-stok="{{ $value['stok'] }}"
                                                data-price="{{ $value['price'] }}" data-category="{{ $value['category_id'] }}"
                                                data-description="{{ $value['description'] }}"><i class="fas fa-edit"></i></button>&nbsp;
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $value['id'] }}" data-url="{{ route('admin.product.delete') }}"><i class="fas fa-trash"></i></button>
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
            <form action="{{ route('admin.product.save') }}" class="form-file">
                <div class="modal-body">
                    <div class="form-group"><input type="file" name="image" class="form-control"></div>
                    <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Nama produk" required></div>
                    <div class="form-group">
                        <select name="category" class="form-control" required>
                            @foreach ($categories as $val)
                                <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><input type="text" name="stok" class="form-control autonumeric" placeholder="Jumlah produk" required></div>
                    <div class="form-group"><input type="text" name="price" class="form-control autonumeric" placeholder="Harga produk" required></div>
                    <div class="form-group"><textarea name="description" class="form-control" placeholder="Keterangan produk"></textarea></div>
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
                <h4 class="modal-title">Edit Produk</h4>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('admin.product.save') }}" class="form-file">
                <div class="modal-body">
                    <div class="form-group"><input type="file" name="image" class="form-control"></div>
                    <div class="form-group"><input type="text" id="name" name="name" class="form-control" placeholder="Nama produk" required></div>
                    <div class="form-group">
                        <select id="category" name="category" class="form-control" required>
                            @foreach ($categories as $val)
                                <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><input type="text" id="stok" name="stok" class="form-control autonumeric" placeholder="Jumlah produk" required></div>
                    <div class="form-group"><input type="text" id="price" name="price" class="form-control autonumeric" placeholder="Harga produk" required></div>
                    <div class="form-group"><textarea id="description" name="description" class="form-control" placeholder="Keterangan produk"></textarea></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="old" name="old">
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
        $('#old').val(btn.data('old'));
        $('#name').val(btn.data('name'));
        $('#category').val(btn.data('category'));
        $('#description').val(btn.data('description'));
        AutoNumeric.set('#stok', btn.data('stok'));
        AutoNumeric.set('#price', btn.data('price'));
    });
});
</script>
@endsection
