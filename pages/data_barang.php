<?php 
if (!isset($conn)) require("../config.php");

$data = mysqli_query($conn, "SELECT * FROM tb_barang ORDER BY id DESC");
$no = 1;
?>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b>Data Barang</b></h4>
			<hr>
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<th>No</th>
					<th>KD Barang</th>
					<th>Nama Barang</th>
					<th>Kategori</th>
					<th>Stok</th>
					<th>Terjual</th>
					<th>Harga Jual</th>
					<th style="min-width: 120px;">Action</th>
				</thead>

				<tbody>
					<?php foreach ($data as $dta) { 
						$id = $dta['id'];
						$result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE id = '$id'");
						$get = mysqli_fetch_assoc($result);
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $dta['kd_barang'] ?></td>
							<td><?= $dta['nama_barang'] ?></td>
							<td><?= $dta['kategori'] ?></td>
							<td><?= $dta['stok'] ?> pcs</td>
							<td><?= $dta['terjual'] ?> pcs</td>
							<td>Rp. <?= $dta['harga_jual'] ?></td>
							<td class="text-center">
								<button type="button" class="btn btn-primary waves-effect waves-light" id="detail-barang"  dta-id="<?= $dta['id'] ?>" data-toggle1="tooltip" title="Detail Barang" data-toggle="modal" data-target=".detail-barang">
									<i class="fa fa-eye"></i>
								</button>
								<button type="button" class="btn btn-success waves-effect waves-light" id="edit-barang" dta-id="<?= $dta['id'] ?>" data-toggle1="tooltip" title="Edit Barang" data-toggle="modal" data-target=".edit-barang">
									<i class="fa fa-edit"></i>
								</button>
							</td>
						</tr>
						<?php $no = $no + 1; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Detail -->
	<div class="modal detail-barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Detail Barang</h4>
				</div>
				<div class="modal-body" style="padding: 20px 40px 20px 40px">
					<dl class="row mb-0">
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Kode Barang:</dt>
							<dd class="col-sm-7" id="kd_barang"></dd>	
						</div>
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Harga Jual:</dt>
							<dd class="col-sm-7">Rp. <span id="harga_jual"></span></dd>
						</div>
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Nama Barang:</dt>
							<dd class="col-sm-7" id="nama_barang"></dd>
						</div>
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Stok:</dt>
							<dd class="col-sm-7"><span id="stok"></span> pcs</dd>
						</div>
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Kategori:</dt>
							<dd class="col-sm-7" id="kategori"></dd>
						</div>
						<div class="col-sm-6 row">
							<dt class="col-sm-5">Terjual:</dt>
							<dd class="col-sm-7"><span id="terjual"></span> pcs</dd>
						</div>
					</dl>
					<hr>
					<div class="panel-group" id="accordion-test-2"> 
						<div class="panel panel-default"> 
							<div class="panel-heading"> 
								<h4 class="panel-title"> 
									<a data-toggle="collapse" data-parent="#accordion-test-2" href="#collapseOne-2" aria-expanded="false" class="collapsed">
										Riwayat Pembelian Barang
									</a> 
								</h4> 
							</div> 
							<div id="collapseOne-2" class="panel-collapse collapse"> 
								<div class="panel-body">
									<table class="table table-bordered" style="margin-top: -15px; font-size: 13px;">
										<thead>
											<tr>
												<th>No</th>
												<th>KD Pembelian</th>
												<th>Tggl Pembelian</th>
												<th>Jumlah Beli</th>
												<th>Harga/pcs</th>
												<th>Total Harga</th>
												<th>Supplier</th>
											</tr>
										</thead>
										<tbody id="riwayat-beli">

										</tbody>
									</table>
								</div> 
							</div> 
						</div>
					</div> 
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Tutup</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<!-- Modal Edit -->
	<div class="modal edit-barang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myLargeModalLabel">Edit Barang</h4>
				</div>
				<div class="modal-body" style="padding: 20px 50px 0 50px">
					<form id="fr_edtBrg" action="#" method="POST" enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">KD Barang</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" required="" placeholder="KD Barang" name="kd_barang" id="kd_barang"readonly="">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-3 col-form-label">Nama Barang</label>
							<div class="col-sm-9">
								<input type="text" class="nb-edt form-control" required="" autocomplete="off" placeholder="Nama Barang" name="nama_barang" id="nama_barang">
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
						<div class="form-group row harga_jual">
							<label class="col-sm-3 col-form-label">Harga Jual</label>
							<div class="input-group col-sm-9">
								<span class="input-group-addon">Rp.</i></span>
								<input type="number" class="form-control" required="" placeholder="Harga Jual" name="harga_jual" id="harga_jual">
								<span class="input-group-addon">.00</span>
							</div>
						</div>
						<div class="form-group">
							<div>
								<input type="hidden" name="id" id="id_brg">
								<input type="hidden" name="from_dta_brg" value="true">
								<button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
								<button type="" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Tutup</button>
							</div>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<script type="text/javascript">
		$(document).ready(function () {
			$('[data-toggle1="tooltip"]').tooltip();

		// This Page


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