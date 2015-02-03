<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Review Your Order</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
  <! -- Orders Tab -- >
  <div data-role="page" id="review">
    <div data-role="header">
      <h3>How do you like it?</h3>      
    </div>

    <div data-role="content">
      <h5 data-icon="info">Your rating will help us learn your taste more accurately</h5>
      <?php
        $mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
        $dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify");  
        if ($mysqli == false) {
          die("Error: Could not connect. " . mysql_connect_error());
        } 

        if($_SESSION['username'] != null) {
          $username = $_SESSION['username'];
          $sql = "select * from user_db where email = '$username'";
          if ($result = $mysqli->query($sql)) {
            if ($result->num_rows > 0) {
              while($row = $result->fetch_array()) {              
                $userid= $row[0];
                $fname = $row[5];
              }
              $result->close();
            } else {
              echo "No reords matching your query were found.";
            }
          } else {
            echo "Error: could not execute $sql. " . $mysqli->error;
          }
        } else {
          echo "<h1>Please Log In First</h1>";
          echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
        }

        $id_ary = array();

        if(isset($_SESSION['cart'])){
          $ids = "";
          foreach($_SESSION['cart'] as $id){
            $ids = $ids . $id . ",";
          }
            
          // remove the last comma
          $ids = rtrim($ids, ',');

          $sql = "SELECT * FROM cuisine_db WHERE id IN ({$ids})";

          if ($result = $mysqli->query($sql)) {
            if ($result->num_rows > 0) {
              $i = 0;
              echo "<form method ='post' action = 'review.php'> 
                    <fieldset data-role='fieldcontain'> ";
              while($row = $result->fetch_array()) {
                echo "<div data-role='fieldcontain'> <fieldset data-role='fieldcontain'> ";
                echo "<label for = 'item". $row[0] ."'>".$row[2]."</label>
                    <select name='item". $row[0] ."' id = 'item". $row[0] ."'>
                      <option value=-2>1 - Awful</option>
                      <option value=-1>2 - Nah</option>
                      <option value=0 selected>3 - Alright</option>
                      <option value=1>4 - Nice</option>
                      <option value=2>5 - Amazing</option>
                    </select>
                    </fieldset></div>";
                array_push($id_ary, $row[0]);
                $i ++;
              }     
              echo "</ul>";
              echo "<input type='submit' name='submit' data-inline='true' value='Review'> </form>";    
              $result->close();
            } else {
              echo "You haven't order anything yet";
            }
          } else {
            echo "You haven't order anything yet";
          }
        } else {
          echo "You haven't order anything yet";
        }

        if (isset($_POST['submit'])) {
          foreach ($id_ary as $cuisine_id) {
            $rating = $mysqli->escape_string($_POST['item'.$cuisine_id]);
            $sql = "INSERT INTO rating_db (user_id,item_id,rating)
                      VALUES ('$userid','$cuisine_id','$rating');";

            $checkRating = "select * from rating_db where user_id = '$userid' AND item_id = '$cuisine_id' ";
            $checkResult = mysqli_query($dbc, $checkRating);

            if (mysqli_num_rows($checkResult) == 0) {
              if ($mysqli->query($sql) == true) {
                echo "Rating Added";
                echo '<meta http-equiv=REFRESH CONTENT=1;url=clear.php>';
              } else {
                echo $mysqli->error;
              }
            } else {
              $sql2 = "UPDATE rating_db SET rating = '$rating' WHERE user_id='$userid' and item_id = '$cuisine_id'; ";
              if ($mysqli->query($sql2) == true) {
                echo "Rating Updated";
                echo '<meta http-equiv=REFRESH CONTENT=1;url=clear.php>';
              } else {
                echo $mysqli->error;
              }
            }
            
          }
        }
        
      ?>   
    
    </div>

    <div data-role="footer" data-position="fixed">
    </div>
  </div>
</body>
</html>