<?php session_start(); ?>
<?php
$cats = $_POST['cats'];
$userid = $_SESSION['userid'];
?>
<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<link rel="shortcut icon" href="css/images/favicon.ico">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Tastify</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
	<div data-role='page' id='index' data-position="fixed">
      	<div data-role='header'>
          <a href='member.php#surprise' data-role='button' data-icon='arrow-l' data-iconpos='notext'>Back</a>
            <h1>Surprise</h1>
            <a href='member.php#menu-hot' data-role='button' data-icon='info' >Check the Menu</a>
        </div>

        <div data-role='content'>
        	<ul data-role="listview">
          	<?php 
            	$mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
      			if ($mysqli == false) {
        			die("Error: Could not connect. " . mysql_connect_error());
      			}
      			$dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify");    

      			require './OpenSlopeOne.php';
      			$slopeone = new OpenSlopeOne();
    			$slopeone->initSlopeOneTable('MySQL');

    			$sql = "select s.item_id2 from slope_one s,rating_db u 
          where u.user_id = '$userid' 
          and s.item_id1 = u.item_id and s.item_id2 != u.item_id group by s.item_id2 order by sum(u.rating * s.times - s.rating)/sum(s.times) desc limit 30";
    if ($result = $mysqli->query($sql)) {
      if ($result->num_rows > 0){
          echo "<a> Recommended based on your taste </a>";
          while ($row = $result->fetch_array()) {
            $sql2 = "select * from cuisine_db where id = '$row[0]' and category = '$cats' ";
            if ($tmp = $mysqli->query($sql2)) {
              if ($tmp2 = $tmp->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" . $tmp2[2] . "</h2>
                    <p>£" . $tmp2[3] . "</p>
                    <p>" . $tmp2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmp2[0]}&name={$tmp2[2]}'>Add to Order</a>
                  </li>";
                echo "<li><p><a href='hateFood.php?id={$tmp2[0]}&name={$tmp2[2]}'> Dislike Above Dish</a></p></li>";
              }
            }
          }
        }
    }
          	?>
          </ul>
        </div>

        <div data-role='footer' data-position='fixed'>
        	<div data-role="navbar">
      			<ul>
        			<li> <a href="order.php" data-rel="dialog" data-transition="pop">Your Order <?php echo "({$cartItemCount})"; ?></a> </li>
      			</ul>
    		</div> 
        </div>
    </div> 
</body>
</html>

