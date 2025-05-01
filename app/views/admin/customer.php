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
                                    <?php $no = 1; foreach($customers as $value):?>
                                        <tr>
                                            <td style="text-align:center;"><?php echo $no;?></td>
                                            <td><?php echo $value['name'];?></td>
                                            <td><?php echo $value['email'];?></td>
                                            <td><?php echo $value['phone'];?></td>
                                            <td><?php echo checkAge($value['birth']);?> Tahun</td>
                                            <td><?php
                                            if($value['gender'] === 'm'){
                                                echo 'Laki-Laki';
                                            }else{
                                                echo 'Perempuan';
                                            }?></td>
                                            <td><?php echo $value['address'];?></td>
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