<html>
<head>

</head>

<body> 
	<h3>Add New Rating</h3>
	<?php
	// if form submitted
	//process form input
	if (isset($_POST['submit'])) {
		//attempt connection to MySQL
		$mysqli = new mysqli("localhost", "root","","Tastify");
		$connection = mysqli_connect("localhost", "root", "","Tastify");
		if ($mysqli == false) {
			die("Error: Could not connect. " . mysql_connect_error());
		} else {
			echo "Connection Success";
		}

		//open message block
		echo '<div id="message">';

		// retrive and check input values
		$inputError = false;
		if (empty($_POST['user_id'])) {
			echo "Enter valid userid";
			$inputError = true;
		} else {
			$user_id = $mysqli->escape_string($_POST['user_id']);
		}
		if ($inputError != true && empty($_POST['cuisine_id'])) {
			echo "Enter valid cuisine id plz";
			$inputError = true;
		} else {
			$cuisine_id = $mysqli->escape_string($_POST['cuisine_id']);
		}
		if ($inputError != true && empty($_POST['rating'])) {
			echo "Enter valid rating plz";
			$inputError = true;
		} else {
			$rating = $mysqli->escape_string($_POST['rating']);
		}
		

		$sql = "INSERT INTO rating (user_id,cuisine_id,rating) 
			VALUES ($user_id, $cuisine_id, $rating);";

		if ($mysqli->query($sql) == true) {
			echo "New rating added with ID: " . $mysqli->insert_id;
		} else {
			echo "ERROR: $sql. " . $mysqli->error;
		}

		//close message block
		echo "</div>";

		
	}
	?>

	</div>

	<form action="rating.php" method="POST">
		user id <br \>
		<input type="text" name="user_id" size="40" />
		<p />
		cuisine id <br \>
		<input type="text" name="cuisine_id" size="40" />
		<p />
		rating<br \>
		<input type="text" name="rating" size="40" />
		<p />
		
		<input type="submit" name="submit" value="Submit" />
	</form>

	<?php
	//Attempy query execution
	$sql = "select * from rating";
	if ($result = $mysqli->query($sql)) {
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array()) {
				echo $row[0] . " " . $row[1] . " "  . $row[2] . " "  
				. $row[3] . "<br>";
			}
			$result->close();
		} else {
			echo "No reords matching your query were found.";
		}
	} else {
		echo "Error: could not execute $sql. " . $mysqli->error;
	}
	?>

	
	<?php
		// This code assumes $itemID is set to that of 
		// the item that was just rated. 
		// Get all of the user's rating pairs
		$sql = "SELECT DISTINCT r.cuisine_id, r2.rating - r.rating 
		            as rating_difference
		            FROM rating r, rating r2
		            WHERE r.user_id=$user_id AND 
		                    r2.cuisine_id=$cuisine_id AND 
		                    r2.user_id=$user_id;";
		$db_result = mysql_query($sql, $connection);
		$num_rows = mysql_num_rows($db_result);
		//For every one of the user's rating pairs, 
		//update the dev table
		while ($row = mysql_fetch_assoc($db_result)) {
		    $other_cuisineID = $row["cuisine_id"];
		    $rating_difference = $row["rating_difference"];
		    //if the pair ($itemID, $other_itemID) is already in the dev table
		    //then we want to update 2 rows.
		    if (mysql_num_rows(mysql_query("SELECT itemID1 
		    FROM dev WHERE itemID1=$cuisine_id AND itemID2=$other_cuisineID",
		    $connection)) > 0)  {
		        $sql = "UPDATE dev SET count=count+1, 
			sum=sum+$rating_difference WHERE itemID1=$cuisine_id 
			AND itemID2=$other_cuisineID";
		        mysql_query($sql, $connection);
			//We only want to update if the items are different                
		        if ($cuisine_id != $other_cuisineID) {
		            $sql = "UPDATE dev SET count=count+1, 
			    sum=sum-$rating_difference 
			    WHERE (itemID1=$other_cuisineID AND itemID2=$cuisine_id)";
		            mysql_query($sql, $connection);
		        }
		    }
		    else { //we want to insert 2 rows into the dev table
		        $sql = "INSERT INTO dev VALUES ($cuisine_id, $other_cuisineID,
		        1, $rating_difference)";
		        mysql_query($sql, $connection); 
			//We only want to insert if the items are different       
		        if ($cuisine_id != $other_cuisineID) {         
		            $sql = "INSERT INTO dev VALUES ($other_cuisineID, 
			    $cuisine_id, 1, -$rating_difference)";
		            mysql_query($sql, $connection);
		        }
		    }    
		}



	//close connection
	$mysqli->close() ;
	?>
</body> 

</html>