        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kategori</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#modal-add">
                                        <i class="fas fa-plus-circle"></i> Tambah Baru
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-data table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="40" style="text-align:center;">No</th>
                                            <th>Nama</th>
                                            <th>Url</th>
                                            <th width="120">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; foreach($categories as $value):?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $no;?></td>
                                            <td><?php echo $value['name'];?></td>
                                            <td><?php echo $value['slug'];?></td>
                                            <td style="text-align:center;">
                                                <a href="<?php echo url('admin/category?submenu='.$value['id'])?>" class="btn btn-sm btn-success btn-edit" data-id="<?php echo $value['id'];?>" data-name="<?php echo $value['name'];?>"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;
                                                <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="<?php echo $value['id'];?>" data-name="<?php echo $value['name'];?>"><i class="fas fa-edit"></i></button>&nbsp;&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="<?php echo $value['id'];?>" data-url="<?php echo url('admin/category/delete');?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php $no++; endforeach;?>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo url('admin/category/save');?>" class="form-ajax">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Nama kategori">
                            </div>
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
                        <h4 class="modal-title">Edit Kategori</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo url('admin/category/save');?>" class="form-ajax">
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