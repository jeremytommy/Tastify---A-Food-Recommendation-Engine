<?php session_start(); ?>
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
	<! -- User Registeration -- >
	<div data-role="page">
		<div data-role="header">
			<a href="index.php" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
			<h1>Register Page</h1>
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

			if (isset($_POST['submit'])) {
				// retrive and check input values
				$inputError = false;
				if ($inputError != true && empty($_POST['email'])) {
					echo "Enter valid email <br>";
					$inputError = true;
				} else {
					$email = $mysqli->escape_string($_POST['email']);
				}
				if ($inputError != true && empty($_POST['password'])) {
					echo "Enter valid password plz <br>";
					$inputError = true;
				} else {
					$password = $mysqli->escape_string($_POST['password']);
				}
				if ($inputError != true && empty($_POST['password2'])) {
					echo "Confirm Your password plz <br>";
					$inputError = true;
				} else {
					$password2 = $mysqli->escape_string($_POST['password2']);
					if ($password != $password2) {
						echo "Your confirmation password dose not match with the 1st one, Please check <br>";
						$inputError = true;
					} else {
						$sha = sha1(strip_tags(stripslashes(mysql_real_escape_string($password))));
					}
				}
				if ($inputError != true && empty($_POST['gender'])) {
					echo "Enter valid gender plz <br>";
					$inputError = true;
				} else {
					$gender = $mysqli->escape_string($_POST['gender']);
				}
				if ($inputError != true && empty($_POST['fname'])) {
					echo "Enter valid first name plz <br>";
					$inputError = true;
				} else {
					$fname = $mysqli->escape_string($_POST['fname']);
				}
				if ($inputError != true && empty($_POST['lname'])) {
					echo "Enter valid last name plz <br>";
					$inputError = true;
				} else {
					$lname = $mysqli->escape_string($_POST['lname']);
				}

				$option_vegi = $mysqli->escape_string($_POST['vegi']);
				if ($option_vegi != 1) {
					$option_vegi = 0;
				}
				$option_light = $mysqli->escape_string($_POST['diet']);
				if ($option_light != 1) {
					$option_light = 0;
				}
				$option_hot = $mysqli->escape_string($_POST['spice']);
				if ($option_hot != 1) {
					$option_hot = 0;
				}


				if ($inputError == false) {
					$sql = "INSERT INTO user_db (email,password,gender,fname,lname,option_vegi,option_light,option_hot) 
						VALUES ('$email','$sha','$gender','$fname','$lname','$option_vegi','$option_light','$option_hot');";

					$checkUsername = "select * from user_db where email = '$email'";
					$checkResult = mysqli_query($dbc, $checkUsername);


					if (mysqli_num_rows($checkResult) == 0) {
						if ($mysqli->query($sql) == true) {
								echo "Registeration successful <br>";

								$sql = "select * from user_db where email = '$email'";
						        if ($result = $mysqli->query($sql)) {
						          if ($result->num_rows > 0) {
						            while($row = $result->fetch_array()) {
						              echo $row[0] . " " . $row[1] . " "  . $row[3] . " "  . $row[4] . "<br>";
						              
						              $_SESSION['$userid']= $row[0];
						              $tmp = $row[0];

						              //Insert the rating of the new regesterd user
									  if (isset($_SESSION['fav'])) {
										foreach ($_SESSION['fav'] as $id) {
											$insertQuery = "INSERT INTO rating_db(user_id,item_id,rating)
															VALUES ('$tmp','$id',2)";
											
											if ($insertResult = $mysqli->query($insertQuery)) {
												echo "";
											}
									    }
									    
									    unset($_SESSION['fav']);
									  }
									  if (isset($_SESSION['hate'])) {
										foreach ($_SESSION['hate'] as $id) {
											$insertQuery = "INSERT INTO rating_db(user_id,item_id,rating)
															VALUES ('$tmp','$id','-2')";
											
											if ($insertResult = $mysqli->query($insertQuery)) {
												echo "";
											}
									    }
									    
									    unset($_SESSION['hate']);
									    
									  }
									  echo '<meta http-equiv=REFRESH CONTENT=1;url=login.php>';
						            }
						            $result->close();
						          	} else {
						            echo "No reords matching your query were found.";
						          	}	
								} else {
								echo  $mysqli->error;
								}	
						} else {
						echo "Username has already been taken, try another one";
						$email = "";
						}
					}
				}
			}
		?>

		<form method="POST" action="register.php" id="registerForm">
			<div data-role="fieldcontain">
				<label for="email">Email:</label>
			    <input type="email" name="email" id="email"   value="<?php if (!empty($email)) echo $email; ?>">
			</div>
			<div data-role="fieldcontain">
			    <label for="password">Password:</label>
			    <input type="password" name="password" id="password"   placeholder="At least 5 letters long"  value="<?php if (!empty($password)) echo $password; ?>">
			</div>
			<div data-role="fieldcontain">
			    <label for="password2">Confirm Password:</label>
			    <input type="password" name="password2" id="password2"   placeholder="Confirm Your Password"  value="<?php if (!empty($password2)) echo $password2; ?>">
			</div>
			<div data-role="fieldcontain">
			    <label for="fname">First Name: </label>
			    <input type="text" name="fname" id="fname"   value="<?php if (!empty($fname)) echo $fname; ?>">
			</div>
			<div data-role="fieldcontain">
			    <label for="lname">Last name:</label>
			    <input type="text" name="lname" id="lname"   value="<?php if (!empty($lname)) echo $lname; ?>">
			</div>
			<div data-role="fieldcontain">
			    <label for="gender">Your Gender:</label>
			    <select name="gender" id="gender" data-role="slider" >
			    	<option value="Male">Male</option>
			    	<option value="Female">Female</option>
			    </select>
			</div>
			<div data-role="fieldcontain">
		        <fieldset data-role="controlgroup">
		        	<legend>Please Tick If You Are </legend>
		            	<label for="vegi">A vegi</label>
		            	<input type="checkbox" name="vegi" id="vegi" value="1">
		            	<label for="diet">On Diet</label>
		            	<input type="checkbox" name="diet" id="diet" value="1">
		            	<label for="spice">Spicy Food Lover</label>
		            	<input type="checkbox" name="spice" id="spice" value="1">	
		        </fieldset>
		    </div>
		    <input type="submit" name="submit" value="Register">
		</form>		
		</div>
	</div>
</body>
</html>