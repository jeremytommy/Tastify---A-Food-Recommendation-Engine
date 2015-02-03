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
			<?php

			$mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
			      if ($mysqli == false) {
			        die("Error: Could not connect. " . mysql_connect_error());
			      }
			// get the product id
			$id = isset($_GET['id']) ? $_GET['id'] : "";
			$tmp = $_SESSION['userid'];
			$name = isset($_GET['name']) ? $_GET['name'] : "";

			$insertQuery = "INSERT INTO rating_db(user_id,item_id,rating)
							VALUES ('$tmp','$id','-2')";
			if ($result = $mysqli->query($insertQuery)) {
			echo "We won't recommend anything like". $name. "that anymore";
			echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
			}
			?>
		</div>
	</div>
</body>
</html>