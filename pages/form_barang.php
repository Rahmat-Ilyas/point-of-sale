<?php 
if (isset($_POST['type'])) {
	if ($_POST['type'] == "tambah_barang") {
		$titel = "Tambah Data Barang";
		$id_barang = 0;
	}
	else {
		$titel = "Edit Data Barang";
		$id_barang = $_POST['id_barang'];
	}
}
else {
	if (isset($_GET['id'])) {
		$titel = "Edit Data Barang";
		$id_barang = $_GET['id'];
	} else {
		$titel = "Tambah Data Barang";
		$id_barang = 0;
	}
}

if (!isset($conn)) require("../config.php");

$data = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id='$id_barang'");
$i=0;
foreach ($data as $dta) {
	$kd_barang = $dta['kd_barang'];
	$nama_barang = $dta['nama_barang'];
	$kategori = $dta['kategori'];
	$harga_jual = $dta['harga_jual'];
	$harga_beli = $dta['harga_beli'];
	$total_beli = $dta['total_beli'];
	$tggl_masuk = $dta['tggl_masuk'];
	$nama_supplier = $dta['nama_supplier'];
	$i = $i+1;
}

if ($i==0) {
	$data_id = mysqli_query($conn, "SELECT * FROM tb_barang ORDER BY id DESC");
	$get_data = mysqli_fetch_assoc($data_id);
	$id = $get_data['id'];
	$kd_barang = "BRG-".sprintf('%04s', $id);
	$nama_barang = null;
	$kategori = null;
	$harga_jual = null;
	$harga_beli = null;
	$total_beli = null;
	$tggl_masuk = null;
	$nama_supplier = null;
}

?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title text-center" style="margin-bottom: 20px;"><b><?= $titel ?></b></h4>

			<form class="form-horizontal" role="form"  data-parsley-validate novalidate method="" action="javascript:void(0);">
				<div class="form-group">
					<label for="kd_barang" class="col-sm-3 control-label">Kode Barang</label>
					<div class="col-sm-7">
						<input type="text" required class="form-control" id="kd_barang" value="<?= $kd_barang ?>" placeholder="Kode Barang" readonly>
					</div>
				</div>
				<div class="form-group">
					<label for="nama_barang" class="col-sm-3 control-label">Nama Barang</label>
					<div class="col-sm-7">
						<input type="text" required class="form-control" id="nama_barang" value="<?= $nama_barang ?>" placeholder="Nama Barang">
					</div>
				</div>
				<div class="form-group">
					<label for="kategori" class="col-sm-3 control-label">Kategori</label>
					<div class="col-sm-7">
						<select name="kategori" id="kategori" class="form-control">
							<option value="">--Pilih Kategori--</option>
							<?php 
							$data_kategori = ['Elektronik', 'Fashion', 'ATK', 'Mainan Anak']; 
							foreach ($data_kategori as $ktgr) :
								?>
								<option 
								<?php if ($kategori == $ktgr) echo "selected" ?>
								value="<?= $ktgr ?>"><?= $ktgr ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="harga_jual" class="col-sm-3 control-label">Harga Jual</label>
					<div class="col-sm-7">
						<input type="number" required class="form-control autonumber" id="harga_jual" value="<?= $harga_jual ?>" placeholder="Harga Jual" data-a-sign="Rp. ">
					</div>
				</div>
				<div class="form-group">
					<label for="harga_beli" class="col-sm-3 control-label">Harga Beli</label>
					<div class="col-sm-7">
						<input type="number" required class="form-control autonumber" id="harga_beli" value="<?= $harga_beli ?>" placeholder="Harga Beli" data-a-sign="Rp. ">
					</div>
				</div>
				<div class="form-group">
					<label for="total_beli" class="col-sm-3 control-label">Total Beli</label>
					<div class="col-sm-7">
						<input type="number" required class="form-control" id="total_beli" value="<?= $total_beli ?>" placeholder="Total Beli">
					</div>
				</div>
				<div class="form-group">
					<label for="tggl_masuk" class="col-sm-3 control-label">Tanggal Masuk</label>
					<div class="col-sm-7">
						<input type="date" required class="form-control" id="tggl_masuk" value="<?= $tggl_masuk ?>" placeholder="Tanggal Masuk">
					</div>
				</div>
				<div class="form-group">
					<label for="nama_barang" class="col-sm-3 control-label">Nama Supplier</label>
					<div class="col-sm-7">
						<select name="nama_supplier" id="nama_supplier" class="form-control">
							<option value="">--Pilih Supplier--</option>
							<?php 
							$data_supplier = mysqli_query($conn, "SELECT * FROM tb_supplier");
							foreach ($data_supplier as $supplier) :
								?>
								<option 
								<?php if ($nama_supplier == $supplier['nama_supplier']) echo "selected" ?>
								value="<?= $supplier['nama_supplier'] ?>"><?= $supplier['nama_supplier'] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-7">
						<button type="submit" class="btn btn-default waves-effect waves-light simpan">
							<i class="fa fa-save"></i>&nbsp;Simpan
						</button>
						<a href="javascript:void(0);" role="button" class="btn btn-danger waves-effect waves-light m-l-5 barang">
							<i class="fa fa-times-circle"></i>&nbsp;Batal
						</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="assets/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script src="assets/plugins/autoNumeric/autoNumeric.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {
		$('.barang').click(function() {
			$('#content').load('pages/view_data_barang.php', function(response, status, xhr) {
				if (xhr.status != 200) {
					alert(xhr.statusText);
				} else {
					window.history.pushState("","","web.php?page=barang&view=<?= crypt('pages', 'barang') ?>");
				}
			});
		});

		$('.simpan').click(function() {
			var kd_barang = $('#kd_barang').val();
			var nama_barang = $('#nama_barang').val();
			var kategori = $('#kategori').val();
			var harga_jual = $('#harga_jual').val();
			var harga_beli = $('#harga_beli').val();
			var total_beli = $('#total_beli').val();
			var tggl_masuk = $('#tggl_masuk').val();
			var nama_supplier = $('#nama_supplier').val();

			if (kd_barang == '' || nama_barang == '' || kategori == '' || harga_jual == '' || harga_beli == '' || total_beli == '' || tggl_masuk == '' || nama_supplier == '') 
			{
				alert("Isi semua form terlebih dahulu");
			}
			else {
				$.ajax({
					url		: "controller.php",
					method	: "POST",
					data 	: { 
						id_barang		: "<?= $id_barang ?>", 
						kd_barang		: kd_barang,
						nama_barang		: nama_barang,
						kategori		: kategori,
						harga_jual		: harga_jual,
						harga_beli		: harga_beli,
						total_beli		: total_beli,
						tggl_masuk		: tggl_masuk,
						nama_supplier	: nama_supplier,
					},
					success	: function(data) {
						if (data == 0) {
							alert("Data berhasil ditambah");
							$('#content').load('pages/view_data_barang.php');
						}else if (data == 1) {
							alert("Data berhasil diedit");
							$('#content').load('pages/view_data_barang.php');
						}else {
							alert("Terjadi kesalahan");
						}
					}
				});
			}
		});

		$('.autonumber').autoNumeric('init');  
	});
</script>