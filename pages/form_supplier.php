<?php 
if (isset($_POST['type'])) {
	if ($_POST['type'] == "tambah_supplier") {
		$titel = "Tambah Data Supplier";
		$id_supplier = 0;
	}
	else {
		$titel = "Edit Data Supplier";
		$id_supplier = $_POST['id_supplier'];
	}
}
else {
	if (isset($_GET['id'])) {
		$titel = "Edit Data Supplier";
		$id_supplier = $_GET['id'];
	} else {
		$titel = "Tambah Data Supplier";
		$id_supplier = 0;
	}
}

if (!isset($conn)) require("../config.php");

$data = mysqli_query($conn, "SELECT * FROM tb_supplier WHERE id='$id_supplier'");
$i=0;
foreach ($data as $dta) {
	$kd_supplier = $dta['kd_supplier'];
	$nama_supplier = $dta['nama_supplier'];
	$alamat = $dta['alamat'];
	$telepon = $dta['telepon'];
	$email = $dta['email'];
	$i = $i+1;
}

if ($i==0) {
	$data_id = mysqli_query($conn, "SELECT * FROM tb_supplier ORDER BY id DESC");
	$get_data = mysqli_fetch_assoc($data_id);
	$id = $get_data['id'];
	$kd_supplier = "SUP-".sprintf('%04s', $id);
	$nama_supplier = null;
	$alamat = null;
	$telepon = null;
	$email = null;
}

?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title text-center" style="margin-bottom: 20px;"><b><?= $titel ?></b></h4>

			<form class="form-horizontal" role="form"  data-parsley-validate novalidate action="javascript:void(0);">
				<div class="form-group">
					<label for="kd_supplier" class="col-sm-3 control-label">Kode Supllier</label>
					<div class="col-sm-7">
						<input type="text" id="kd_supplier" required class="form-control" id="kd_supplier" value="<?= $kd_supplier ?>" placeholder="Kode Supplier" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="nama_supplier" class="col-sm-3 control-label">Nama Supllier</label>
					<div class="col-sm-7">
						<input type="text" id="nama_supplier" required class="form-control" id="nama_supplier" value="<?= $nama_supplier ?>" placeholder="Nama Supplier">
					</div>
				</div>
				<div class="form-group">
					<label for="alamat" class="col-sm-3 control-label">Alamat</label>
					<div class="col-sm-7">
						<textarea required id="alamat" class="form-control alamat" placeholder="Alamat"><?= $alamat ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="telepon" class="col-sm-3 control-label">Telepon</label>
					<div class="col-sm-7">
						<input type="text" id="telepon" required class="form-control" id="telepon" value="<?= $telepon ?>" placeholder="Telepon">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-7">
						<input type="email" id="email" required class="form-control" id="email" value="<?= $email ?>" placeholder="Email">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-7">
						<button type="submit" class="btn btn-default waves-effect waves-light simpan">
							<i class="fa fa-save"></i>&nbsp;Simpan
						</button>
						<a href="javascript:void(0);" role="button" class="btn btn-danger waves-effect waves-light m-l-5 supplier">
							<i class="fa fa-times-circle"></i>&nbsp;Batal
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.supplier').click(function() {
			$('#content').load('pages/view_supplier.php', function(response, status, xhr) {
				if (xhr.status != 200) {
					alert(xhr.statusText);
				} else {
					window.history.pushState("","","web.php?page=supplier&view=<?= crypt('pages', 'supplier') ?>");
				}
			});
		});

		$('.simpan').click(function() {
			var kd_supplier = $('#kd_supplier').val();
			var nama_supplier = $('#nama_supplier').val();
			var alamat = $('#alamat').val();
			var telepon = $('#telepon').val();
			var email = $('#email').val();

			if (kd_supplier == '' || nama_supplier == '' || alamat == '' || telepon == '' || email == '') {
				alert("Isi semua form terlebih dahulu");
			}
			else {
				$.ajax({
					url		: "controller.php",
					method	: "POST",
					data 	: { 
						id_supplier		: "<?= $id_supplier ?>", 
						kd_supplier		: kd_supplier,
						nama_supplier	: nama_supplier,
						alamat			: alamat,
						telepon			: telepon,
						email			: email,
					},
					success	: function(data) {
						if (data == 0) {
							alert("Data berhasil ditambah");
							$('#content').load('pages/view_supplier.php');
						}else if (data == 1) {
							alert("Data berhasil diedit");
							$('#content').load('pages/view_supplier.php');
						}else {
							alert("Terjadi kesalahan");
						}
					}
				});
			}
		});
	});
</script>