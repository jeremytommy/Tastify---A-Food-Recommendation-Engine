<html>
<head>

</head>

<body> 
	<h3>Add New Cuisine</h3>
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
		if (empty($_POST['cuisine_name'])) {
			echo "Enter valid name plz";
			$inputError = true;
		} else {
			$name = $mysqli->escape_string($_POST['cuisine_name']);
		}
		if ($inputError != true && empty($_POST['diner_id'])) {
			echo "Enter valid diner plz";
			$inputError = true;
		} else {
			$diner_id = $mysqli->escape_string($_POST['diner_id']);
		}
		if ($inputError != true && empty($_POST['cuisine_type'])) {
			echo "Enter valid type plz";
			$inputError = true;
		} else {
			$type = $mysqli->escape_string($_POST['cuisine_type']);
		}
		if ($inputError != true && empty($_POST['cuisine_price'])) {
			echo "Enter valid price plz";
			$inputError = true;
		} else {
			$price = $mysqli->escape_string($_POST['cuisine_price']);
		}
		
			$vegi = $mysqli->escape_string($_POST['cuisine_option_vegi']);
		
		
			$light = $mysqli->escape_string($_POST['cuisine_option_light']);
		
			$hot = $mysqli->escape_string($_POST['cuisine_option_hot']);

			$addon = $mysqli->escape_string($_POST['addon']);

			$addon_name = $mysqli->escape_string($_POST['addon_name']);

			$addon_price = $mysqli->escape_string($_POST['addon_price']);
		
			
		
		

		$sql = "INSERT INTO cuisine_db (diner_id,name,type,price,option_vegi,option_light,option_hot,option_addon,option_addon_obj,option_addon_prc) 
			VALUES (1,'$name','$type',$price,$vegi,$light,$hot,$addon,'$addon_name',$addon_price);";

		if ($mysqli->query($sql) == true) {
			echo "New cuisine added with ID: " . $mysqli->insert_id;
		} else {
			echo "ERROR: $sql. " . $mysqli->error;
		}

		//close message block
		echo "</div>";

		
	}
	?>

	</div>

	<form action="configure.php" method="POST">
		Diner  :Varsity<br \>
		<p />
		Cuisine Name <br \>
		<input type="text" name="cuisine_name" size="40" />
		<p />
		Cuisine Type <br \>
		<input type="text" name="cuisine_type" size="40" />
		<p />
		Cuisine Price £<br \>
		<input type="text" name="cuisine_price" size="40" />
		<p />
		Vegi?      <br \>
		<input type="text" name="cuisine_option_vegi" size="40" />
		<p />
		Light?<br \>
		<input type="text" name="cuisine_option_light" size="40" />
		<p />
		Hot? <br \>
		<input type="text" name="cuisine_option_hot" size="40" />
		<p />

		Addon? <br \>
		<input type="text" name="addon" size="40" />
		<p />

		Addon Name? <br \>
		<input type="text" name="addon_name" size="40" />
		<p />

		Addon Price? <br \>
		<input type="text" name="addon_price" size="40" />
		<p />
		<input type="submit" name="submit" value="Submit" />
	</form>

	<?php
	//Attempy query execution
	$sql = "select * from cuisine_db";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				echo $row[0] . " " . $row[2] . " "  . $row[3] . " "  . $row[4] . "<br>";
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