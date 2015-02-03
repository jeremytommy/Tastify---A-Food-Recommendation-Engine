<?php session_start();  ?>
<?php
session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Registeration Page</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
	<div data-role="page">
		<div data-role="header">			
			<h1>INFO</h1>
		</div>
		<div data-role="content">
		<?
		unset($_SESSION['username']);
		unset($_SESSION['cart']);
		echo 'Logging Out......';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
		?>
		</div>
	</div>
</body>
</html>
