<html>
<head>

</head>

<body> 
	<h3>Add New User</h3>
	<?php
	// if form submitted
	//process form input
	if (isset($_POST['submit'])) {
		//attempt connection to MySQL
		$mysqli = new mysqli("localhost", "root","","Tastify");
		if ($mysqli == false) {
			die("Error: Could not connect. " . mysql_connect_error());
		} else {
			echo "Connection Success";
		}

		//open message block
		echo '<div id="message">';

		// retrive and check input values
		$inputError = false;
		if (empty($_POST['email'])) {
			echo "Enter valid email";
			$inputError = true;
		} else {
			$email = $mysqli->escape_string($_POST['email']);
		}
		if ($inputError != true && empty($_POST['password'])) {
			echo "Enter valid password plz";
			$inputError = true;
		} else {
			$password = $mysqli->escape_string($_POST['password']);
		}
		if ($inputError != true && empty($_POST['gender'])) {
			echo "Enter valid gender plz";
			$inputError = true;
		} else {
			$gender = $mysqli->escape_string($_POST['gender']);
		}
		if ($inputError != true && empty($_POST['fname'])) {
			echo "Enter valid first name plz";
			$inputError = true;
		} else {
			$fname = $mysqli->escape_string($_POST['fname']);
		}
		if ($inputError != true && empty($_POST['lname'])) {
			echo "Enter valid last name plz";
			$inputError = true;
		} else {
			$lname = $mysqli->escape_string($_POST['lname']);
		}
		

		$sql = "INSERT INTO user_db (email,password,gender,fname,lname) 
			VALUES ('$emails','$password','$gender','$fname','$lname');";

		if ($mysqli->query($sql) == true) {
			echo "New user added with ID: " . $mysqli->insert_id;
		} else {
			echo "ERROR: $sql. " . $mysqli->error;
		}

		//close message block
		echo "</div>";

		
	}
	?>

	</div>

	<form action="register.php" method="POST">
		Email <br \>
		<input type="text" name="email" size="40" />
		<p />
		Password <br \>
		<input type="text" name="password" size="40" />
		<p />
		Gender<br \>
		<input type="text" name="gender" size="40" />
		<p />
		first name<br \>
		<input type="text" name="fname" size="40" />
		<p />
		Last Name?<br \>
		<input type="text" name="lname" size="40" />
		<p />
		<input type="submit" name="submit" value="Submit" />
	</form>

	<?php
	//Attempy query execution
	$sql = "select * from user_db";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				echo $row[0] . " " . $row[1] . " "  . $row[3] . " "  . $row[4] . "<br>";
			}
			$result->close();
		} else {
			echo "No reords matching your query were found.";
		}
	} else {
		echo "Error: could not execute $sql. " . $mysqli->error;
	}

	//close connection
	$mysqli->close() ;
	?>
</body> 

</html>