<?php 
require("config.php");

$token = get_login();
if (!isset($_SESSION['pos_token_session'.$token])) {
	header("location: login.php");
	exit();
}

if (isset($_GET['lock'])) {
	$_SESSION['lock'] = get_login();
} else {
	header("location: index.php");
	exit();
}

$error = false;
if (isset($_POST['unlock'])) {
	$password = $_POST['password'];
	if (password_verify($password, $token)) {
		unset($_SESSION['lock']);
		header("location: ".url($_GET['from']));
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

	<link rel="shortcut icon" href="assets/images/favicon_1.ico">

	<title>Point of Sale</title>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/core.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/components.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="assets/js/modernizr.min.js"></script>

</head>
<body>

	<div class="account-pages"></div>
	<div class="clearfix"></div>
	<div class="wrapper-page">
		<div class=" card-box">

			<div class="panel-body">
				<form method="post" role="form" class="text-center">
					<div class="user-thumb">
						<img src="assets/images/users/avatar-1.jpg" class="img-responsive img-circle img-thumbnail" alt="thumbnail">
					</div>
					<div class="form-group">
						<h3>Chadengle</h3>
						<p class="text-muted">
							Enter your password to access the admin.
						</p>
						<div class="input-group m-t-30">
							<input type="password" class="form-control" name="password" placeholder="Password" required="">
							<span class="input-group-btn">
								<button type="submit" name="unlock" class="btn btn-pink w-sm waves-effect waves-light">
									Log In
								</button> 
							</span>
						</div>
					</div>
					<div class="form-group">
						<div class="col-xs-12 text-left">
							<?php if ($error == true): ?>
								<label class="text-danger">Uername atau password salah</label>
							<?php endif ?>
						</div>
					</div>

				</form>


			</div>
		</div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<p>
					Not Chadengle?<a href="config.php?logout=true" class="text-primary m-l-5"><b>Sign In</b></a>
				</p>
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