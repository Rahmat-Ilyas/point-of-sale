<?php if (!isset($conn)) require("../config.php"); ?>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box">
			<h4 class="m-t-0 m-b-30 header-title"><b>Transaksi</b></h4>
			<div class="row">
				<form class="form-horizontal group-border-dashed" action="#">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Kasir :</label>
								<span class="col-sm-5 control-label" style="text-align: left;">Rahmat Ilyas</span>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">ID Pegawai :</label>
								<span class="col-sm-5 control-label" style="text-align: left;">POS-0001</span>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label class="col-sm-4 control-label">Kode Transaksi :</label>
								<span class="col-sm-5 control-label" style="text-align: left;">TRS-0001</span>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Tanggal Transaksi :</label>
								<span class="col-sm-5 control-label" style="text-align: left;">14/02/2019</span>
							</div>
						</div>
					</div>
					<hr>
					<div class="col-lg-6">

						<div class="form-group">
							<h4 class="m-b-20 header-title"><b>Input Data Pembelian</b></h4>
							<label class="col-sm-3 control-label">Kode/Nama Barang</label>
							<form method="get">
								<div class="col-sm-7">
									<select class="form-control select2">
										<option>--Pilih Barang--</option>
										<?php 
										$data_barang = mysqli_query($conn, "SELECT * FROM tb_barang");
										foreach ($data_barang as $value) :
											?>
											<option class="get_id" value="<?= $value['id'] ?>"><?= $value['kd_barang']."/".$value['nama_barang'] ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-primary">
										<i class="md md-search"></i>
									</button>
								</div>
							</form>
							<?php
								
							?>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Harga per Pcs</label>
							<div class="col-sm-9">
								<input data-parsley-type="number" type="text" class="form-control" readonly />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label jumlah_beli">Jumlah Beli</label>
							<div class="col-sm-9">
								<input type="number" name="jumlah_beli" id="jumlah_beli" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-9 m-t-15" style="text-align: right;">
								<button type="submit" class="btn btn-primary">
									<i class="fa fa-plus-square"></i>&nbsp;Tambah
								</button>
							</div>
						</div>
					</div>

					<div class="col-lg-6">
						<h4 class="m-b-20 header-title"><b>Data Pembelian</b></h4>
						<div class="p-0">
							<table class="table table-bordered m-0">
								<thead>
									<tr>
										<th>No</th>
										<th>KD Barang</th>
										<th>Nama</th>
										<th>Jumlah</th>
										<th>Total Harga</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row"></th>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/plugins/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-quicksearch/jquery.quicksearch.js"></script>
<script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/pages/jquery.form-advanced.init.js"></script>

<script>
	$(document).ready(function() {
		$('.val_barang').click(function() {
			var id = $('.get_id').val();
			alert(id);
		});
	});
</script>