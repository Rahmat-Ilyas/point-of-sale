<?php 
require('config.php');

$token = get_login();

if (isset($_SESSION['pos_token_session'.$token])) {
	header("location: index.php");
	exit();
}

$error = false;
if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$cek = mysqli_query($conn, "SELECT * FROM tb_kasir WHERE username = '$username'");
	$get = mysqli_fetch_assoc($cek);

	if (password_verify($password, $get['password'])) {
		if (isset($_POST['remember'])) {
			set_cookie($get['password'], $get['id']);
		}
		set_session($get['password'], $get['id']);
		header("location: index.php");
		exit();
	}
	$error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
	<meta name="author" content="Coderthemes">

	<link rel="shortcut icon" href="assets/images/favicon_1.png">

	<title>Halaman Login Kasir</title>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
	<script src="assets/js/modernizr.min.js"></script>

</head>
<body>

	<div class="account-pages"></div>
	<div class="clearfix"></div>
	<div class="wrapper-page">
		<div class=" card-box">
			<div class="panel-heading"> 
				<h3 class="text-center"> Sign In to <strong class="text-custom">POS</strong> </h3>
			</div> 


			<div class="panel-body">
				<form class="form-horizontal m-t-20" method="POST">

					<div class="form-group ">
						<div class="col-xs-12">
							<input class="form-control" type="text" name="username" required="" placeholder="Username">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<input class="form-control" type="password" name="password" required="" placeholder="Password">
						</div>
					</div>

					<div class="form-group">
						<div class="col-xs-12">
							<?php if ($error == true): ?>
								<label class="text-danger">Uername atau password salah</label>
							<?php endif ?>
						</div>
					</div>

					<div class="form-group ">
						<div class="col-xs-12">
							<div class="checkbox checkbox-primary">
								<input id="checkbox-signup" type="checkbox" name="remember">
								<label for="checkbox-signup">
									Remember me
								</label>
							</div>

						</div>
					</div>

					<div class="form-group text-center m-t-40">
						<div class="col-xs-12">
							<button type="submit" name="login" class="btn btn-default btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
						</div>
					</div>
				</form> 

			</div>   
		</div>  
	</div>

	<script>
		var resizefunc = [];
	</script>

	<!-- jQuery  -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/detect.js"></script>
	<script src="assets/js/fastclick.js"></script>
	<script src="assets/js/jquery.slimscroll.js"></script>
	<script src="assets/js/jquery.blockUI.js"></script>
	<script src="assets/js/waves.js"></script>
	<script src="assets/js/wow.min.js"></script>
	<script src="assets/js/jquery.nicescroll.js"></script>
	<script src="assets/js/jquery.scrollTo.min.js"></script>


	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>
	
</body>
</html>