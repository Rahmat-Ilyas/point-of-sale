<?php 
require("config.php");

// Crypt
if (isset($_POST['crypt'])) {
	$element = $_POST['element'];
	echo url($element);
}

// STAR Barang Masuk
// Get Barang
if(isset($_POST["keyword"])){
	$output = '';
	$keyword = $_POST["keyword"];
	$result = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang LIKE '%$keyword%' LIMIT 10");
	$res = mysqli_num_rows($result);

	$output = '<ul class="list-unstyled">';
	if($res > 0){
		foreach ($result as $val) {
			$output .= '<li id="item-ac">'.$val["nama_barang"].'</li>'; 
		}
	} else {
		$output .= '<li>Barang baru! barang belum ada di gudang</li>';  
	}  
	$output .= '</ul>';

	$data = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang = '$keyword'");
	$dta = mysqli_fetch_assoc($data);
	$return = get_data('tb_barang_masuk', 'nama_barang', $keyword);
	$return['output'] = $output;

	header('Content-Type: application/json');
	echo json_encode($return);
}

if(isset($_POST["text"])){
	$text = $_POST["text"];
	$data = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE nama_barang = '$text'");
	$dta = mysqli_fetch_assoc($data);
	$return = $dta;

	header('Content-Type: application/json');
	echo json_encode($return);
}

// getDataEdit
if (isset($_POST['get_dtaBrg'])) {
	$id = $_POST['id'];
	// $result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk INNER JOIN tb_supplier ON tb_supplier.id = tb_barang_masuk.supplier_id WHERE tb_barang_masuk.id = '$id'");
	$data = get_data('tb_barang_masuk', 'id', $id);
	$kd_barang = $data['kd_barang'];
	$result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE kd_barang = '$kd_barang'");
	$res = mysqli_num_rows($result);
	if ($res > 1) $data['many'] = true;

	header('Content-Type: application/json');
	echo json_encode($data);
}

// Add & Edit Barang Masuk
if (isset($_POST['from_brg_msk'])) {
	if ($_POST['action'] == 'create') {
		$success = 'Data baru berhasil ditambahkan ke database!';
		$error = 'Data gagal ditambahkan ke database!';
		$proses = false;

		if (add_data('tb_barang_masuk', $_POST)) {
			$last_id = mysqli_insert_id($conn);
			$result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE kd_barang = '$_POST[kd_barang]'");
			$res = mysqli_num_rows($result);
			if ($res == 1) {
				$more = ['stok' => $_POST['jumlah_beli'], 'terjual' => 0];
				$proses = add_data('tb_barang', $_POST, $more);
			} else {
				$dta = get_data('tb_barang', 'kd_barang', $_POST['kd_barang']);
				$id = $dta['id'];
				$set_stok = $dta['stok'] + $_POST['jumlah_beli'];

				$more = ['stok' => $set_stok];
				$proses = edt_data('tb_barang', $_POST, $id, $more);
			}

			if ($proses == true)
				$status = response('success', $success);
			else {
				del_data('tb_barang_masuk', $last_id);
				$status = response('error', $error);
			}
		} else $status = response('error', $error);

		header('Content-Type: application/json');
		echo json_encode($status);

	} else {
		$success = 'Data "'.$_POST['kd_barang'].'" berhasil diupdate!';
		$error = 'Data "'.$_POST['kd_barang'].'" gagal terupdate!';
		$id = $_POST['id'];

		$dta_br = get_data('tb_barang', 'kd_barang', $_POST['kd_barang']);
		$dta_bm = get_data('tb_barang_masuk', 'id', $id);
		$id_brg = $dta_br['id'];
		$set_stok = $dta_br['stok'] - $dta_bm['jumlah_beli'] + $_POST['jumlah_beli'];
		$more = ['stok' => $set_stok];
		if(edt_data('tb_barang', $_POST, $id_brg, $more))
			$status = response('success', $success);
		else {
			$status = response('error', $error);
			exit();
		}

		if (edt_data('tb_barang_masuk', $_POST, $id))
			$status = response('success', $success);
		else
			$status = response('error', $error);

		header('Content-Type: application/json');
		echo json_encode($status);
	}
}

// Delete Barang Masuk
if (isset($_POST['del_dtaBrg'])) {
	$success = 'Data berhasil dihapus dari database!';
	$error = 'Data gagal dihapus di database!';
	$id = $_POST['id'];

	$data = get_data('tb_barang_masuk', 'id', $id);
	$kd_barang = $data['kd_barang'];
	$dta_br = get_data('tb_barang', 'kd_barang', $kd_barang);
	$id_brg = $dta_br['id'];

	$result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE kd_barang = '$kd_barang'");
	$res = mysqli_num_rows($result);
	if ($res == 1) {
		$del_br = del_data('tb_barang', $kd_barang, 'kd_barang');
		$del_bm = del_data('tb_barang_masuk', $id);
		if ($del_br == true && $del_bm == true) 
			$status = response('success', $success);
		else 
			$status = response('error', $error);
	}
	else {
		$set_stok = $dta_br['stok'] - $data['jumlah_beli'];
		$more = ['stok' => $set_stok];
		if(edt_data('tb_barang', $_POST, $id_brg, $more)) {
			del_data('tb_barang_masuk', $id);
			$status = response('success', $success);
		}
		else 
			$status = response('error', $error);
	}

	header('Content-Type: application/json');
	echo json_encode($status);
}

// Return Pembelian
if (isset($_POST['ret_brgBli'])) {
	$kd_pembelian = $_POST['kd_pembelian'];
	$id = null;
	if (strlen($kd_pembelian) == 8) $id = substr($kd_pembelian, 4, 8);

	$data = get_data('tb_barang_masuk', 'id', $id);
	$data['strlen'] = strlen($kd_pembelian);
	header('Content-Type: application/json');
	echo json_encode($data);
}

if (isset($_POST['fr_ret_brgmsk'])) {
	$success = 'Pembelian barang "'.$_POST['kd_pembelian'].'" berhasil direturn!';
	$error = 'Pembelian barang "'.$_POST['kd_pembelian'].'" gagal direturn!';
	$proses = false;
	$set_jum_beli = $_POST['jumlah_beli'] - $_POST['jumlah_return'];
	$set_tot_hrgbli = $_POST['total_hrg_beli'] - $_POST['uang_return'];
	$id = $_POST['id_brgmsk'];

	$more = ['barang_masuk_id' => $id];
	if (add_data('tb_return_pembelian', $_POST, $more)) {
		$last_id = mysqli_insert_id($conn);		
		if ($set_jum_beli > 0) {
			$data = ['jumlah_beli' => $set_jum_beli, 'total_hrg_beli' => $set_tot_hrgbli];
			$proses = edt_data('tb_barang_masuk', $data, $id);
		} else {
			$proses = del_data('tb_barang_masuk', $id);
		}

		if($proses == true) {
			$dta_br = get_data('tb_barang', 'kd_barang', $_POST['kd_barang']);
			$id_brg = $dta_br['id'];
			$set_stok = $dta_br['stok'] - $_POST['jumlah_return'];
			$data_stok = ['stok' => $set_stok];
			if(edt_data('tb_barang', $data_stok, $id_brg)) {
				$status = response('success', $success);
			}
			else {
				$status = response('error', $error);
				del_data('tb_return_pembelian', $last_id);
			}
			$status = response('success', $success);
		}
		else {
			$status = response('error', $error);
			del_data('tb_return_pembelian', $last_id);
		}
	} else $status = response('error', $error);

	header('Content-Type: application/json');
	echo json_encode($status);
}
// END Barang Masuk

// STAR Data Barang
// Get Data Barang
if (isset($_POST['get_dataBrg'])) {
	$data = get_data('tb_barang', 'id', $_POST['id']);
	if (isset($_POST['detail'])) {
		$kd_barang = $data['kd_barang'];
		$result = mysqli_query($conn, "SELECT * FROM tb_barang_masuk WHERE kd_barang = '$kd_barang'");
		$riwayat = '';
		$no = 1;

		foreach ($result as $val) {
			$kd_pembelian = sprintf('%04s', $val['id']);
			$tggl_masuk = date('d M Y', strtotime($val['tggl_masuk']));
			$jumlah_beli = $val['jumlah_beli'];
			$hrg_beli_prpcs = $val['hrg_beli_prpcs'];
			$total_hrg_beli = $val['total_hrg_beli'];
			$supplier = get_data('tb_supplier', 'id', $val['supplier_id']);
			$nama_supplier = $supplier['nama_supplier'];
			$riwayat .= '<tr><th scope="row">'.$no.'</th><td>KSL-'.$kd_pembelian.'</td><td>'.$tggl_masuk.'</td><td>'.$jumlah_beli.' pcs</td><td>Rp.'.$hrg_beli_prpcs.'</td><td>Rp.'.$total_hrg_beli.'</td><td>'.$nama_supplier.'</td></tr>';
			$no = $no + 1;
		}

		$data['riwayat'] = $riwayat;
	}

	header('Content-Type: application/json');
	echo json_encode($data);
}

// Edit Data Barang
if (isset($_POST['from_dta_brg'])) {
	$success = 'Data barang "'.$_POST['kd_barang'].'" berhasil diedit!';
	$error = 'Data barang "'.$_POST['kd_barang'].'" gagal diedit!';

	if (edt_data('tb_barang', $_POST, $_POST['id'])) {
		$params = ['kd_barang', $_POST['kd_barang']];
		if (edt_data('tb_barang_masuk', $_POST, $params)) 
			$status = response('success', $success);
		else 
			$status = response('error', $error);
	} else $status = response('error', $error);

	header('Content-Type: application/json');
	echo json_encode($status);
}
// END Data Barang

?>