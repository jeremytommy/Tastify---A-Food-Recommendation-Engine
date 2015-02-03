<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Tastify</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
	<! -- Log In Pop Up Tab -- >

	<div data-role="page" id="login">
	  <div data-role="header">
	  	<a href="index.php" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
	    <h1>Log In</h1>
	  </div>

	  <div data-role="content">

		<?php
		$mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
		$dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify"); 
		if ($mysqli == false) {
			die("Error: Could not connect. " . mysql_connect_error());
		} 

		if (isset($_POST['submit'])) {
			$email = $mysqli->escape_string($_POST['email']);
			$pw = $mysqli->escape_string($_POST['password']);
			$sha = sha1(strip_tags(stripslashes(mysql_real_escape_string($pw))));

			$sql = "SELECT * FROM user_db where email = '$email' and password = '$sha'";
			$result = mysqli_query($dbc, $sql);

			if ($email != null && $pw != null) {
				if (mysqli_num_rows($result) == 1) {
					$_SESSION['username'] = $email;
					unset($_SESSION['cart']);
			        echo 'Log In Successful!';
			        echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
				} elseif (mysqli_num_rows($result) > 1) {
					echo "Multiple Records Found";
				} elseif (mysqli_num_rows($result) == 0) {
					echo "One of your cridentials is incorrect or you may not have registered.";
				} else {
					echo 'Log In Failure! Unknown Issue';
		        	echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
				}
			} else {
				echo "Please fill in all the  details";
			}
		}
		?>

		<form method="POST" id="loginForm" action="login.php">
	      <div data-role="fieldcontain">
	        <label for="email">Email :</label>
	        <input type="text" name="email" id="email" value="<?php if (!empty($email)) echo $email; ?>">
	      </div>
	      <div data-role="fieldcontain">
	        <label for="password">Password :</label>
	        <input type="password" name="password" id="password">
	      </div>
	      <input type="submit" name="submit" value="Log In">
	    </form>    
	  </div>
	</div> 
	</body>
</html>