<?php 
require("config.php");

$token = get_login();
if (!isset($_SESSION['pos_token_session'.$token])) {
	header("location: login.php");
	exit();
}

require("template/header.php");

// get file
if (is_dir('pages/')) {
	if ($handle = opendir('pages/')) {
		$i = 0;
		while (($file = readdir($handle)) !== false) {
			$set_file = explode('.', $file);
			$files[$i] = $set_file[0];
			$i = $i + 1;
		}
	}
}

if (isset($_GET['view']) && isset($_GET['page'])) {
	$view = $_GET['view'];
	$page = $_GET['page'];
	$crypt = crypt('pages', $page);

	if (isset($_SESSION['lock'])) {
		header("location: lock.php?lock=true&from=".$page);
		exit();
	}

	?>
	<script>
		$(document).ready(function() {
			$('#<?= $page ?>').addClass('active');
			$('#<?= $page ?>').parentsUntil('.has_sub').addClass('parnt');
			$('#link-lock').attr('href', 'lock.php?lock=true&from=<?= $page ?>');
			$('.parnt').siblings().addClass('active subdrop');
			$('.parnt').css('display', 'block');
		});
	</script>
	<?php

	$error = 0;
	foreach ($files as $file) {
		if ($page == $file) {
			if ($view == $crypt) require("pages/".$page.".php");
			else  echo "<script>location.href='404.php'</script>";
			$error = $error+1;
		}
	}

	if ($error <= 0) echo "<script>location.href='404.php'</script>";
}
else {
	echo "<script>location.href='403.php'</script>";
}
require("template/footer.php");
?>