    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="<?php echo url();?>">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="<?php echo url('wishlist');?>">Daftar Keinginan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table class="table shopping-summery">
                        <thead>
							<tr class="main-hading">
                                <th width="150">&nbsp;</th>
								<th>NAMA BARANG</th>
								<th width="100" class="text-right">HARGA</th>
								<th width="100" class="text-center">QTY</th>
								<th width="100" class="text-right">TOTAL</th>
								<th width="50" class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
                        <tbody>
                        <?php $total=0;foreach($carts as $val):?>
                            <tr>
                                <td class="image" data-title="No"><img src="<?php echo image('02_'.$val['image']);?>" alt="<?php echo $val['name'];?>"></td>
                                <td class="product-des" data-title="Description">
                                    <p class="product-name"><a href="javascript:void(0);"><?php echo $val['name'];?></a></p>
                                    <p class="product-des"><?php echo $val['description'];?></p>
                                </td>
                                <td class="text-right" class="price" data-title="Harga"><span><?php echo price($val['price']);?></span></td>
                                <td class="qty" data-title="Qty">
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[<?php echo $val['id'];?>]">
												<i class="ti-minus"></i>
											</button>
                                        </div>
                                        <input type="text" name="quant[<?php echo $val['id'];?>]" class="input-number input-qty" data-min="1" data-max="100" value="<?php echo $val['qty'];?>" data-product="<?php echo $val['product'];?>">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[<?php echo $val['id'];?>]">
												<i class="ti-plus"></i>
											</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right" class="price" data-title="Harga"><span><?php echo price(intval($val['qty'])*intval($val['price']));?></span></td>
                                <td class="action" data-title="Hapus"><a href="javascript:void(0);" class="btn-cart-remove" data-product="<?php echo $val['id'];?>"><i class="ti-trash remove-icon"></i></a></td>
                            </tr>
                        <?php $total += intval($val['qty'])*intval($val['price']);endforeach;?>
                        <?php if (empty($carts)):?>
                            <tr>
                                <td colspan="6" class="text-center">Pilih produk untuk dimasukan ke keranjang belanja</td>
                            </tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12"></div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
                                        <li>Subtotal<span><?php echo price($total);?></span></li>
									</ul>
									<div class="button5">
										<a href="<?php echo url('checkout');?>" class="btn">Pembayaran</a>
                                        <a href="<?php echo url('product');?>" class="btn">Lanjutkan Belanja</a>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>