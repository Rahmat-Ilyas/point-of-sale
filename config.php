<?php 
session_start();
$conn = mysqli_connect("localhost", "rahmat_ryu", "", "db_pos");

function url($url) {
	$crypt = crypt('pages', $url);
	$set_url = "web.php?page=".$url."&view=".$crypt;
	return $set_url;
}

function set_cookie($pass, $id) {
	setcookie('pos_token_cookie'.$pass, $pass, time()+172800);
	setcookie('this_pos_id', $id, time()+172800);
}

function set_session($pass, $id) {
	$_SESSION['pos_token_session'.$pass] = $pass;
	$_SESSION['this_pos_id'] = $id;
}

function get_login() {
	if (isset($_SESSION['this_pos_id'])) $id = $_SESSION['this_pos_id'];
	else if (isset($_COOKIE['this_pos_id'])) $id = $_COOKIE['this_pos_id']; 

	if (isset($id)) {
		global $conn;
		$result = mysqli_query($conn, "SELECT * FROM tb_kasir WHERE id = 1");
		$get = mysqli_fetch_assoc($result);
		$token = $get['password'];

		if (isset($_SESSION['pos_token_session'.$token])) {
			return $token;
		} else if (isset($_COOKIE['pos_token_cookie'.$token])) {
			$_SESSION['pos_token_session'.$token] = $token;
			$_SESSION['this_pos_id'] = $id;
			return $token;
		} else {
			return null;
		}
	}
}

if (isset($_GET['logout'])) {
	$token = get_login();
	unset($_SESSION['pos_token_session'.$token]);
	unset($_SESSION['this_pos_id']);
	unset($_SESSION['lock']);
	setcookie('pos_token_cookie'.$token, '', time()-172800);
	setcookie('this_pos_id', '', time()-172800);

	header("location: login.php");
}

function response($status, $message) {
	$set_status = [];
	$set_status['status'] = $status;
	$set_status['message'] = $message;
	if ($status == 'success') $set_status['title'] = 'Berhasil diproses';
	else $set_status['title'] = 'Terjadi kesalahan';

	return $set_status;
}

function get_data($tabel, $col, $val = NULL) {
	global $conn;
	if ($col == 'all' && $val == NULL) {
		$result = mysqli_query($conn, "SELECT * FROM $tabel");
		return $result;
	} else {
		$result = mysqli_query($conn, "SELECT * FROM $tabel WHERE $col = '$val'");
		$res = mysqli_fetch_assoc($result);
		return $res;
	}
}

function add_data($tabel, $data, $more = NULL) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM $tabel");
	$res = mysqli_fetch_assoc($result);

	if (isset($more)) {
		foreach ($more as $key => $val) {
			$data[$key] = $val;
		}
	}
	$data['id'] = 0;
	$key = ''; $val = '';
	$i = 0;
	foreach ($res as $key_res => $val_res) {
		foreach ($data as $key_dta => $val_dta) {
			if ($key_res == $key_dta) {
				$key .= $key_dta;
				$val .= "'$val_dta'";

				if ($i < count($res) - 1) {
					$key .= ", ";
					$val .= ", ";
				}
			}
		}
		$i = $i + 1;
	}

	$query = "INSERT INTO $tabel ($key) VALUES ($val)";
	return mysqli_query($conn, $query);
}

function edt_data($tabel, $data, $params, $more = NULL, $remove = NULL) {
	global $conn;
	$result = mysqli_query($conn, "SELECT * FROM $tabel");
	$res = mysqli_fetch_assoc($result);

	if (isset($more)) {
		foreach ($more as $key => $val) {
			$data[$key] = $val;
		}
	}

	if (isset($remove)) {
		foreach ($remove as $val) {
			unset($data[$data]);
		}
	}

	if (isset($data['id'])) {
		unset($data['id']);
	}

	$key = '';
	$i = 0;
	foreach ($res as $key_edt => $val_edt) {
		foreach ($data as $key_dta => $val_dta) {
			if ($key_edt == $key_dta) {
				$key .= "$key_dta = '$val_dta', ";
			}
		}
		$i = $i + 1;
	}

	$set_key = substr($key, 0, strlen($key) - 2);

	if (is_array($params)) {
		$row = $params[0];
		$val = $params[1];
		$query = "UPDATE $tabel SET $set_key WHERE $row = '$val'";
	} else { 
		$id = $params;
		$query = "UPDATE $tabel SET $set_key WHERE id = '$id'";
	}

	return mysqli_query($conn, $query);
}

function del_data($tabel, $val, $row = NULL) {
	global $conn;
	if (isset($row)) $query = "DELETE FROM $tabel WHERE $row ='$val'";
	else $query = "DELETE FROM $tabel WHERE id = '$val'";
	return mysqli_query($conn, $query);
}
?>
