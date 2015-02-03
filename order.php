<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Your Order</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
  <! -- Orders Tab -- >
  <div data-role="page" id="order">
    <div data-role="header">
      <h1>Order Details</h1>
    </div>

    <div data-role="content">
      <?php
        $mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
        if ($mysqli == false) {
          die("Error: Could not connect. " . mysql_connect_error());
        } 

        if(isset($_SESSION['cart'])){
          $ids = "";
          foreach($_SESSION['cart'] as $id){
            $ids = $ids . $id . ",";
          }
            
          // remove the last comma
          $ids = rtrim($ids, ',');
            
          $sql = "SELECT * FROM cuisine_db WHERE id IN ({$ids})";

          echo "<ul data-role='listview' data-inset='true'>";

          if ($result = $mysqli->query($sql)) {
            if ($result->num_rows > 0) {
              $price_sum=0;
              while($row = $result->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" .$row[2] . "</h2>
                    <p>£" . $row[3] . "</p>
                    </a>
                    <a href='removeFromCart.php?id={$row[0]}&name={$row[2]}'>Remove From Order</a>
                  </li>";

                $price_sum = $price_sum + $row[3];
                }
              echo "<li><p>In Total: £" . $price_sum . "</p></li>";
              echo "</ul>";
              echo "<h5>Once make your mind, show this page to the waitress to order.</h5>";
              echo "<h5>After finish your dish, click Next :)";
              echo "</div><div data-role='footer' data-position='fixed'> <div data-role='navbar' data-iconpos='left'> <ul><li>";
              echo "<a href='review.php' data-role='button' data-icon='arrow-r' data-transition='pop'>Next</a>" ;
              echo "</li></ul></div>";
              $result->close();
            } else {
              echo "You haven't order anything yet";
            }
          } else {
            echo "Layer 2 error";
          }
        } else {
          echo "Order is empty";
        }
      ?>   
      
    </div>

    <div data-role="footer" data-position="fixed">
      <div data-role="navbar">
      </div> 
    </div>
  </div>
</body>
</html>