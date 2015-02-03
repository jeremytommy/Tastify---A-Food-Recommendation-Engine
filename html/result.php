<html>
<head>

</head>

<body> 
	<?php
	// if form submitted		//attempt connection to MySQL
		$mysqli = new mysqli("localhost", "root","","Tastify");
		if ($mysqli == false) {
			die("Error: Could not connect. " . mysql_connect_error());
		} else {
			echo "Connection Success" . "<br>";
		}

		
		
	?>

	
	<?php
	//Attempy query execution
	$sql = "select * from categories_db";
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