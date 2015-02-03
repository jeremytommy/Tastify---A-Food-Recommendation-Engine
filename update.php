<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Registeration Page</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
	<! -- User Registeration -- >
<div data-role="page" id="changepw">
  <div data-role="header">
    <h1>Change Password</h1>
  </div>

  <div data-role="content">
<?php
			//attempt connection to MySQL
			$mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
			$dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify");    
			//Check if the connection is successful
			if ($mysqli == false) {
				die("Error: Could not connect. " . mysql_connect_error());
			} 
			$username = $_SESSION['username'];

			if (isset($_POST['submit'])) {

				// retrive and check input values
				$inputError = false;
				$oldpassword = $mysqli->escape_string($_POST['oldpassword']);
				$sha0 = sha1(strip_tags(stripslashes(mysql_real_escape_string($oldpassword))));
				if ($inputError != true && empty($_POST['newpassword'])) {
					echo "Enter valid new password plz <br>";
					$inputError = true;
				} else {
					$newpassword = $mysqli->escape_string($_POST['newpassword']);
				}
				if ($inputError != true && empty($_POST['newpassword2'])) {
					echo "Confirm Your New password plz <br>";
					$inputError = true;
				} else {
					$newpassword2 = $mysqli->escape_string($_POST['newpassword2']);
					if ($newpassword != $newpassword2) {
						echo "Your confirmation password dose not match with the 1st one, Please check <br>";
						$inputError = true;
					} else {
						$sha = sha1(strip_tags(stripslashes(mysql_real_escape_string($newpassword))));
					}
				}

				if ($inputError == false) {
					$sql = "update user_db set password='$sha' where email='$username'";

					$checkpw = "select * from user_db where email = '$username' and password = '$sha0'";
					$checkResult = mysqli_query($dbc, $checkpw);


					if (mysqli_num_rows($checkResult) == 1) {
						if ($mysqli->query($sql) == true) {
								echo "Password Updated";
								echo '<meta http-equiv=REFRESH CONTENT=1;url=member.php>';
							} else {
								echo  $mysqli->error;
							}
					} else {
						echo "You put the wrong old password";
					}
				}
			}
		?>

		<form method="POST" action="update.php" id="changepwForm">
      <div data-role="fieldcontain">
        <label for="oldpassword">Old Password</label>
         <input type="password" name="oldpassword" id="oldpassword">
      </div>
      <div data-role="fieldcontain">
        <label for="newpassword">New Password</label>
         <input type="password" name="newpassword" id="newpassword">
      </div>
      <div data-role="fieldcontain">
        <label for="newpassword2">Confirm</label>
         <input type="password" name="newpassword2" id="newpassword2">
      </div>
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>

</div> 
</body>
</html>