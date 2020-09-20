<?php 
if (!isset($conn)) require("../config.php");

$data = mysqli_query($conn, "SELECT * FROM tb_barang_masuk ORDER BY id DESC");

$data_id = mysqli_query($conn, "SELECT * FROM tb_barang ORDER BY id DESC");
$get_data = mysqli_fetch_assoc($data_id);
$id = $get_data['id'];
$kd_barang = "BRG-".sprintf('%04s', $id);

$supplier = mysqli_query($conn, "SELECT * FROM tb_supplier");
$no = 1;
?>
<div class="row barang-masuk">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="header-title"><b>Data Barang Masuk</b></h4>
			<div style="margin-bottom: 25px; margin-top: 25px;">
				<button type="submit" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target=".modal-form" id="add-btn">
					<i class="ti-package"></i>&nbsp;&nbsp;Barang Masuk
				</button>
				<button type="submit" class="btn btn-danger btn-rounded waves-effect waves-light" data-toggle="modal" data-target=".form-rebeli" id="rtb-btn">
					<i class=" ti-share-alt"></i>&nbsp;&nbsp;Return Barang
				</button>
				<hr>
			</div>
			<table id="datatable" class="table table-striped table-bordered" style="font-size: 13px;">
				<thead>
					<th>No</th>
					<th>KD Pmblian</th>
					<th>KD Barang</th>
					<th style="min-width: 120px;">Nama Barang</th>
					<th>Kategori</th>
					<th>Jmlh Beli</th>
					<th>Harga/pcs</th>
					<th>Total Harga</th>
					<th>Tggl Masuk</th>
					<th>Supplier</th>
					<th style="min-width: 80px;">Action</th>
				</thead>

				<tbody>
					<?php foreach ($data as $dta) { 
						$id = $dta['supplier_id'];
						$result = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id = '$id'");
						$get = mysqli_fetch_assoc($result);
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= "KSL-".sprintf('%04s', $dta['id']) ?></td>
							<td><?= $dta['kd_barang'] ?></td>
							<td><?= $dta['nama_barang'] ?></td>
							<td><?= $dta['kategori'] ?></td>
							<td><?= $dta['jumlah_beli'] ?> pcs</td>
							<td>Rp.<?= $dta['hrg_beli_prpcs'] ?></td>
							<td>Rp.<?= $dta['total_hrg_beli'] ?></td>
							<td><?= date('dMy', strtotime($dta['tggl_masuk'])) ?></td>
							<td><?= $get['nama_supplier'] ?></td>
							<td class="text-center">
								<button type="button" class="btn btn-success waves-effect waves-light edit" id="edt-btn" dta-id="<?= $dta['id'] ?>" data-toggle1="tooltip" title="Edit Barang" data-toggle="modal" data-target=".modal-form">
									<i class="fa fa-edit"></i>
								</button>
								<button class="btn btn-danger waves-effect waves-light" type="button" data-toggle="modal" data-target=".modal-delete" data-toggle1="tooltip" id="del-btn" dta-id="<?= $dta['id'] ?>" title="Hapus Barang">
									<i class="fa fa-trash"></i>
								</button>
							</td>
						</tr>
						<?php $no = $no + 1; }?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Form -->
	<div class="modal modal-form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Produk</h4>
				</div>
				<div class="modal-body" style="padding: 20px 50px 0 50px">
					<form id="fr_brgMasuk" action="#" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">KD Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="KD Barang" name="kd_barang" id="kd_barang" value="<?= $kd_barang ?>" data-kdbrg="<?= $kd_barang ?>" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Barang</label>
							<div class="col-sm-9">
								<input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Barang" name="nama_barang" id="nama_barang">
								<input type="text" class="nb-add form-control" required="" autocomplete="off" placeholder="Nama Barang" name="nama_barang" id="nama_brg">
								<div class="my-autocomplete" id="getBarang"></div>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 control-label">Kategori</label>
							<div class="col-sm-9">
								<select name="kategori" id="kategori" class="form-control">
									<?php 
									$data_kategori = ['Elektronik', 'Fashion', 'ATK', 'Mainan Anak', 'Sport']; 
									foreach ($data_kategori as $ktgr) {
										?>
										<option value="<?= $ktgr ?>"><?= $ktgr ?></option>
									<?php } ?>
								</select>
								<input type="hidden" name="kategori" id="kategori1" disabled="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Jumlah Beli</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" required="" placeholder="Jumlah Beli" name="jumlah_beli" id="jumlah_beli">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Harga/pcs</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</span>
								<input type="number" class="form-control" required="" placeholder="Harga/pcs" name="hrg_beli_prpcs" id="hrg_beli_prpcs">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Total Harga Beli</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</i></span>
								<input type="number" class="form-control" required="" placeholder="Total Harga" name="total_hrg_beli" id="total_hrg_beli">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						<div class="form-group row harga_jual">
							<label class="col-sm-3 col-form-label">Harga Jual Sementara</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</i></span>
								<input type="number" class="form-control" required="" placeholder="Harga Jual Sementara" name="harga_jual" id="harga_jual">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Tanggal Masuk</label>
							<div class="col-sm-9">
								<input type="date" class="form-control" required="" placeholder="Tanggal Masuk" name="tggl_masuk" id="tggl_masuk">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Supplier</label>
							<div class="col-sm-9">
								<select name="supplier_id" id="supplier_id" class="form-control">
									<?php foreach ($supplier as $val) { ?>
										<option value="<?= $val['id'] ?>"><?= $val['nama_supplier'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div>
								<input type="hidden" name="id" class="id">
								<input type="hidden" name="from_brg_msk" value="true">
								<input type="hidden" class="action" name="action" value="">
								<button type="submit" name="addData" class="btn btn-primary waves-effect waves-light">Simpan</button>
								<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<div class="modal form-rebeli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Tambah Produk</h4>
				</div>
				<div class="modal-body" style="padding: 20px 50px 0 50px">
					<form id="fr_returBrg" action="#" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">KD Pembelian</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="KD Pembelian" name="kd_pembelian" id="kd_pembelian" autocomplete="off">
								<span class="text-danger" hidden="" id="find-kd">*Kode Pembelian tidak ditemukan!</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Jumlah Return</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" data-container="body" data-toggle="popover" data-placement="left" data-content="Jumlah Return tidak boleh melebihi Jumlah Beli" required="" autocomplete="off" placeholder="Jumlah Return" name="jumlah_return" id="jumlah_return">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Uang Return</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</span>
								<input type="text" class="form-control" required="" autocomplete="off" placeholder="Uang Return" name="uang_return" id="uang_return">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Keterangan</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" autocomplete="off" placeholder="Keterangan" name="keterangan" id="keterangan">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3"></div>
							<div class="col-sm-9">
								<button type="submit" class="btn btn-primary waves-effect waves-light" id="btn-rtb">Return</button>
								<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Batal</button>
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">KD Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" readonly="" required="" placeholder="KD Barang" name="kd_barang" id="re_kd_barang" readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" readonly="" required="" autocomplete="off" placeholder="Nama Barang" name="nama_barang" id="re_nama_barang">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Jumlah Beli</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" readonly="" required="" placeholder="Jumlah Beli" name="jumlah_beli" id="re_jumlah_beli">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Harga/pcs</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</span>
								<input type="number" class="form-control" required="" placeholder="Harga/pcs" name="hrg_beli_prpcs" id="re_hrg_beli_prpcs" readonly="">
								<span class="input-group-addon">.00</span>
								<input type="hidden" name="id_brgmsk" id="re_id">
								<input type="hidden" name="total_hrg_beli" id="re_total_hrg_beli">
								<input type="hidden" name="fr_ret_brgmsk" value="true">
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<!-- Modal Hapus -->
	<div class="modal modal-delete" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticModalLabel">Hapus Data</h5>
				</div>
				<div class="modal-body">
					<p>Yakin ingin menghapus data ini?</p>
				</div>
				<div class="modal-footer form-inline">
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-danger delete">Hapus</button>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function () {
			$('[data-toggle1="tooltip"]').tooltip();

		// This Page
		$(document).on('keyup focus', '#hrg_beli_prpcs', function () {
			var jumBeli = $('#jumlah_beli').val();
			if (jumBeli == '') $('#jumlah_beli').focus();
			var totHarga = jumBeli * $(this).val();
			$('#total_hrg_beli').val(totHarga);

			var prediksi = parseInt($(this).val()) + ($(this).val() * 10 / 100);
			$('#harga_jual').val(prediksi);
		});

		$(document).on('keyup focus', '#total_hrg_beli', function () {
			var hrgPcs = $('#hrg_beli_prpcs').val();
			var prediksi = parseInt(hrgPcs) + (hrgPcs * 10 / 100);
			$('#harga_jual').val(prediksi);
		});

		$(document).on('keyup focus', '#jumlah_beli', function () {
			var jumBeli = $('#jumlah_beli').val();
			var hrgPcs = $('#hrg_beli_prpcs').val();

			var totHarga = $(this).val() * hrgPcs;
			$('#total_hrg_beli').val(totHarga);

			var prediksi = parseInt(hrgPcs) + (hrgPcs * 10 / 100);
			$('#harga_jual').val(prediksi);
		});

		// Data Table
		$('#datatable').dataTable();
		$('#datatable-keytable').DataTable({keys: true});
		$('#datatable-responsive').DataTable();
		$('#datatable-colvid').DataTable({
			"dom": 'C<"clear">lfrtip',
			"colVis": {
				"buttonText": "Change columns"
			}
		});
		$('#datatable-scroller').DataTable({
			ajax: "assets/plugins/datatables/json/scroller-demo.json",
			deferRender: true,
			scrollY: 380,
			scrollCollapse: true,
			scroller: true
		});
		var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
		var table = $('#datatable-fixed-col').DataTable({
			scrollY: "300px",
			scrollX: true,
			scrollCollapse: true,
			paging: false,
			fixedColumns: {
				leftColumns: 1,
				rightColumns: 1
			}
		});
	});
		TableManageButtons.init();

	</script>