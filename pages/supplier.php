<?php 
if (!isset($conn)) require("../config.php");

$data = mysqli_query($conn, "SELECT * FROM tb_supplier");
?>
<div class="row">
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b>Data Supplier</b></h4>
			<div style="margin-bottom: 10px;">
				<button type="submit" class="btn btn-primary waves-effect waves-light tambah">
					<i class="fa fa-plus-square"></i>&nbsp;Tambah Supplier
				</button>
			</div>
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>KD Supplier</th>
						<th>Nama Supplier</th>
						<th>Alamat</th>
						<th>Telepon</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($data as $dta) : ?>
						<tr>
							<td><?= $dta['kd_supplier'] ?></td>
							<td><?= $dta['nama_supplier'] ?></td>
							<td><?= $dta['alamat'] ?></td>
							<td><?= $dta['telepon'] ?></td>
							<td><?= $dta['email'] ?></td>
							<td class="text-center">
								<button type="button" class="btn btn-default waves-effect waves-light edit" value="<?= $dta['id'] ?>" data-toggle1="tooltip" title="Edit">
									<i class="fa fa-edit"></i>
								</button>
								<button class="btn btn-danger waves-effect waves-light" type="button" data-toggle="modal" data-target="#staticModal<?= $dta['id'] ?>" data-toggle1="tooltip" title="Hapus">
									<i class="fa fa-trash"></i>
								</button>
							</td>
						</tr>
						<!-- Konfirmasi Hapus -->
						<div class="modal fade" id="staticModal<?= $dta['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
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
										<button type="button" data-dismiss="modal" value="<?= $dta["id"]?>" class="btn btn-danger hapus">Hapus</button>
									</div>
								</div>
							</div>
						</div>
						<!-- End Konfirmasi Hapus -->
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function () {
		$('[data-toggle1="tooltip"]').tooltip();
		// This Page
		$('.hapus').click(function() {
			var get_id = $(this).val();
			$.ajax({
				url		: "controller.php",
				method	: "POST",
				data 	: { hapus_supplier: get_id },
				success	: function(data) {
					if (data == 0) {
						alert("Data berhasil dihapus");
						$('#content').load('pages/view_supplier.php');
					}else {
						alert("Terjadi kesalahan");
					}
				}
			});
		});

		$('.tambah').click(function() {
			$.ajax({
				url		: "pages/view_form_supplier.php",
				method	: "POST",
				data 	: {type: "tambah_supplier"},
				success	: function(data) {
					$('#content').html(data);
					window.history.pushState("","","web.php?page=form_supplier&view=<?= crypt('pages', 'form_supplier') ?>");
				}
			});
		});

		$('.edit').click(function() {
			var get_id = $(this).val();
			$.ajax({
				url		: "pages/view_form_supplier.php",
				method	: "POST",
				data 	: { type: "edit_supplier", id_supplier: get_id },
				success	: function(data) {
					$('#content').html(data);
					window.history.pushState("","","web.php?page=form_supplier&view=<?= crypt('pages', 'form_supplier') ?>&id="+get_id);
				}
			});
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