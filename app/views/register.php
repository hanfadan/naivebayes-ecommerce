<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="<?php echo url();?>">Beranda<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="<?php echo url('register');?>">Daftar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="contact-head">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="form-main">
                        <div class="title">
                            <h4>Untuk memulai Pemesanan</h4>
                            <h3>Anda harus mempunyai akun</h3>
                        </div>
                        <?php Flasher::output();?>
                        <form class="form" method="post" action="<?php echo url('register');?>">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Nama Lengkap<span>*</span></label>
                                        <input name="name" type="text" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Nomor Telepon<span>*</span></label>
                                        <input name="phone" type="text" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir<span>*</span></label>
                                        <input id="birth" name="birth" type="text" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir<span>*</span></label><br>
                                        <select name="gender" class="form-control" required="">
                                            <option>Pilih Jsnis Kelamin</option>
                                            <option value="m">Laki-laki</option>
                                            <option value="f">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Email<span>*</span></label>
                                        <input name="email" type="text" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label>Kata Sandi<span>*</span></label>
                                        <input name="password" type="password" required="">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Alamat<span>*</span></label>
                                        <textarea name="address" required=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group button">
                                        <input name="submit" value="register" type="hidden">
                                        <button type="submit" class="btn">Daftar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-head">
                        <div class="single-info">
                            <i class="fa fa-phone"></i>
                            <h4 class="title">Hubungi kami Sekarang:</h4>
                            <ul>
                                <li><?php echo APP_PHONE;?></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-envelope-open"></i>
                            <h4 class="title">Email:</h4>
                            <ul>
                                <li><a href="mailto:<?php echo APP_EMAIL;?>"><?php echo APP_EMAIL;?></a></li>
                            </ul>
                        </div>
                        <div class="single-info">
                            <i class="fa fa-location-arrow"></i>
                            <h4 class="title">Alamat Kami:</h4>
                            <ul>
                                <li><?php echo APP_ADDRESS;?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>