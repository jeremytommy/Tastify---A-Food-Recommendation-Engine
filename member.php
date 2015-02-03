<?php session_start(); ?>
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

<! -- Index Tab -- >
<div data-role="page" id="index">
  <?php
    // if session 'cart' was set, count it, else set it to 0
    $cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
  ?>

  <div data-role="header" data-position="fixed">
    <a href="#panel-01" data-role="button" data-icon="arrow-l" data-iconpos="notext">Personal Profile</a>
    <h1>Tastify</h1>
    <a href="order.php" data-rel="dialog" data-transition="pop">Your Order<?php echo "({$cartItemCount})"; ?></a> 
  </div>

  <div class="panel left" data-role="panel" data-position="left" data-display="reveal" id="panel-01">  
    <ul>
      <li><a href="#account" data-rel="dialog" data-icon="plus">Account</a></li>
      <li><a href="logout.php" data-icon="star" >Log Out</a></li>
      <li><a href="http://uk.linkedin.com/in/yihengzhou"  data-icon="star">About Me</a></li>
      <li><a href="mailto:Yiheng.Zhou@warwick.ac.uk?Subject=Tastify%20Problem" data-icon="alert">Report A Problem</a></li>
    </ul> 
  </div> 

  <div data-role="content">
    <?php
    // to prevent undefined index notice
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    $name = isset($_GET['name']) ? $_GET['name'] : "";

    echo "<div data-role='navbar' data-iconpos='left'>";

    if($action=='add'){
      echo "<li><a data-icon='info'>" . $name . " was added to your order.</a></li>";
    }

    if($action=='exists'){
      echo "<li><a data-icon='info'>" . $name . " already exists in your order.</a></li>";
    }

    if($action=='removed'){
      echo "<li><a data-icon='info'>" . $name . " was removed from your order.</a></li>";
    }

    echo "</div>";
    ?>    

    <?php
      $mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
      if ($mysqli == false) {
        die("Error: Could not connect. " . mysql_connect_error());
      }
      $dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify");    

      if($_SESSION['username'] != null) {
        $username = $_SESSION['username'];

        $sql = "select * from user_db where email = '$username'";
        if ($result = $mysqli->query($sql)) {
          if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
              echo "<a>Welcome Back, "  . $row[4] . "</a><br>";
              $userid= $row[0];
              $fname = $row[5];
              $veg = $row[7];
              $lig = $row[8];
              $hot = $row[9];
              $_SESSION['userid'] = $userid;
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
    ?>   

    <h5>To view our recommendation to you, based on your past preference, click Surprise Me</h5>
    <h5>To view the menu to order, click Check the Menu</h5>
    <h5>Click the right arrow next  to the dish to add it into your order list</h5>
    <h5>To view your order list, click Your order</h5>
  </div>

  <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li> <a href="#surprise" data-role="button" data-icon="star"> Surprise Me !</a> </li>
        <li> <a href="#menu-hot" data-role="button" data-icon="info"> Check the Menu</a> </li>
      </ul>
    </div>  
  </div>
</div> 

<! -- Surprise Tab -- >
<div data-role="page" id="surprise">
  <div data-role="header" data-position="fixed">
    <a href="#index" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
    <h1>Tastify</h1>
    <a href="#menu-hot" data-role="button" data-icon="info" >Check the Menu</a>
  </div>

  <div data-role="content">
    <form method="POST" action="surprise.php">
     <fieldset>
     <label for="cats">I want some ......</label>
     <select name="cats" id="cats"  data-native-menu="false" data-ajax="false">
      <option>Pick Categories</option>
      <?php
        $sql = "select * from categories_db";
        if ($result = $mysqli->query($sql)) {
          if ($result->num_rows > 0) {
            while($row = $result->fetch_array()) {
              echo "<option value='".$row[0]."'>".$row[1]."</option> ";
            }
          }
        }
      ?>
     </select>
     </fieldset>
     <input type="submit" data-inline="true" value="Surprise">
  </form> 
  <a href="#lucky" data-role="button">I'm feeling lucky</a>
  </div>

  <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li> <a href="order.php" data-rel="dialog" data-transition="pop">Your Order <?php echo "({$cartItemCount})"; ?></a> </li>
      </ul>
    </div> 
  </div>
</div>


<! -- Feeling lucky Tab -- >
<div data-role="page" id="lucky">
  <div data-role="header" data-position="fixed">
    <a href="#index" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
    <h1>Try this</h1>
    <a href="#menu-hot" data-role="button" data-icon="info" >Check the Menu</a>
  </div>

  <div data-role="content">
    <ul data-role="listview">
    <?php
      require './OpenSlopeOne.php';
      $slopeone = new OpenSlopeOne();
    $slopeone->initSlopeOneTable('MySQL');

    if ($veg == 1) {
      $tmp = "select id 
              from cuisine_db 
              where not exists 
              (select item_id from rating_db where user_id = '$userid' and item_id = id) 
              and option_vegi = 1
              limit 1;";
      if ($tmprst = $mysqli->query($tmp)) {
        if ($tmprst->num_rows>0) {
          echo "<a> Vegeterian  Choice </a>";
          while ($tmprow = $tmprst->fetch_array()) {
            $tmp2 = "select * from cuisine_db where id = ". $tmprow[0];
            if ($tmprst2 = $mysqli->query($tmp2)) {
              if ($tmprow2 = $tmprst2->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" . $tmprow2[2] . "</h2>
                    <p>£" . $tmprow2[3] . "</p>
                    <p>" . $tmprow2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmprow2[0]}&name={$tmprow2[2]}'>Add to Order</a>
                  </li>";
                  echo "<li><p><a href='hateFood.php?id={$tmprow2[0]}&name={$tmprow2[2]}'> Dislike Above Dish</a></p></li>";
              }
            }
          }
        }
      }
    }

    if ($hot == 1) {
      $tmp = "select id 
              from cuisine_db 
              where not exists 
              (select item_id from rating_db where user_id = '$userid' and item_id = id) 
              and option_hot = 1
              limit 1;";
      if ($tmprst = $mysqli->query($tmp)) {
        if ($tmprst->num_rows>0) {
          echo "<a> Spice Lover's Choice </a>";
          while ($tmprow = $tmprst->fetch_array()) {
            $tmp2 = "select * from cuisine_db where id = ". $tmprow[0];
            if ($tmprst2 = $mysqli->query($tmp2)) {
              if ($tmprow2 = $tmprst2->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" . $tmprow2[2] . "</h2>
                    <p>£" . $tmprow2[3] . "</p>
                    <p>" . $tmprow2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmprow2[0]}&name={$tmprow2[2]}'>Add to Order</a>
                  </li>";
                  echo "<li><p><a href='hateFood.php?id={$tmprow2[0]}&name={$tmprow2[2]}'> Dislike Above Dish</a></p></li>";
              }
            }
          }
        }
      }
    }

    if ($lig == 1) {
      $tmp = "select id 
              from cuisine_db 
              where not exists 
              (select item_id from rating_db where user_id = '$userid' and item_id = id) 
              and option_light = 1
              limit 1;";
      if ($tmprst = $mysqli->query($tmp)) {
        if ($tmprst->num_rows>0) {
          echo "<a> Diet Choice </a>";
          while ($tmprow = $tmprst->fetch_array()) {
            $tmp2 = "select * from cuisine_db where id = ". $tmprow[0];
            if ($tmprst2 = $mysqli->query($tmp2)) {
              if ($tmprow2 = $tmprst2->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" . $tmprow2[2] . "</h2>

                    <p>£" . $tmprow2[3] . "</p>
                    <p>" . $tmprow2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmprow2[0]}&name={$tmprow2[2]}'>Add to Order</a>
                  </li>";
                  echo "<li><p><a href='hateFood.php?id={$tmprow2[0]}&name={$tmprow2[2]}'> Dislike Above Dish</a></p></li>";
              }
            }
          }
        }
      }
    }

    $sql = "select s.item_id2 from slope_one s,rating_db u 
          where u.user_id = '$userid' 
          and s.item_id1 = u.item_id and s.item_id2 != u.item_id group by s.item_id2 order by sum(u.rating * s.times - s.rating)/sum(s.times) desc limit 10";
    if ($result = $mysqli->query($sql)) {
      if ($result->num_rows > 0){
          echo "<a> Recommended based on your taste </a>";
          while ($row = $result->fetch_array()) {
            $sql2 = "select * from cuisine_db where id = ". $row[0];
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

  <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li> <a href="order.php" data-rel="dialog" data-transition="pop">Your Order <?php echo "({$cartItemCount})"; ?></a> </li>
      </ul>
    </div> 
  </div>
</div>

<! -- Menu Tab HOT -- >
<div data-role="page" id="menu-hot">
  <div data-role="header" data-position="fixed">
    <a href="#index" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
    <h1></h1>
    <a href="#surprise" data-role="button" data-icon="star" >Surpise Me!</a>
    <div data-role="navbar">
      <ul>
        <li> <a href="" class="ui-btn-active ui-state-persist"> Top 10</a> </li>
        <li> <a href="#menu-full"> Menu</a> </li>
      </ul>
    </div>  
  </div>

  <div data-role="content">
    <h2>Varsity Top 10</h2>
    <ol data-role="listview" >
    <?php
      $sql = "select item_id, count(item_id) as cnt
              from rating_db 
              where rating > 0.5
              group by item_id
              order by cnt desc
              limit 10";
      $sql2;
      $tmp;
      $tmp2;

      if ($result = $mysqli->query($sql)) {
        if ($result->num_rows > 0){
          while ($row = $result->fetch_array()) {
            $sql2 = "select * from cuisine_db where id = ". $row[0];
            if ($tmp = $mysqli->query($sql2)) {
              if ($tmp2 = $tmp->fetch_array()) {
                echo "<li><a href='#'>
                    <h2>" . $tmp2[2] . "</h2>
                    <p>£" . $tmp2[3] . "</p>
                    <p>" . $tmp2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmp2[0]}&name={$tmp2[2]}'>Add to Order</a>
                  </li>";
              }
            }
          }
        }
      }
    ?>   
  </ol>
  </div>

  <div data-role="footer" data-position="fixed">
    <div data-role="navbar">
      <ul>
        <li> <a href="order.php" data-rel="dialog" data-transition="pop">Your Order <?php echo "({$cartItemCount})"; ?></a> </li>
      </ul>
    </div> 
  </div>

</div> 

<! -- Menu Tab FULL -- >
<div data-role="page" id="menu-full">
  <div data-role="header" data-position="fixed">
    <a href="#index" data-role="button" data-icon="home" data-iconpos="notext">Back to Index</a>
    <h1></h1>
    <a href="#surprise" data-role="button" data-icon="star" >Surpise Me!</a>
    <div data-role="navbar">
      <ul>
        <li> <a href="#menu-hot"> Top 10</a> </li>
        <li> <a href="" class="ui-btn-active ui-state-persist"f> Menu</a> </li>
      </ul>
    </div> 
  </div>

  <div data-role="content">
    <?php
  //Attempy query execution
  $sql = "select * from categories_db";
  $sql2;
  $tmp;
  $tmp2;

  if ($result = $mysqli->query($sql)) {
    if ($result->num_rows > 0) {
      while($row = $result->fetch_array()) {
        echo  "<div data-role='collapsible'><h4>" . $row[1] . "</h4>";
        echo "<ul data-role='listview' data-inset='true'>";
        $sql2 = "select * from cuisine_db where category = " . $row[0];
        if ($tmp = $mysqli->query($sql2)) {
          while ($tmp2 = $tmp->fetch_array()) {
            echo "<li><a href='#'>
                    <h2>" .$tmp2[2] . "</h2>
                    <p>£" . $tmp2[3] . "</p>
                    <p>" . $tmp2[11] . "</p>
                    </a>
                    <a href='addToCart.php?id={$tmp2[0]}&name={$tmp2[2]}'>Add to Order</a>
                  </li>";
                  echo "<li><p><a href='hateFood.php?id={$tmp2[0]}&name={$tmp2[2]}'> Dislike Above Dish</a></p></li>";
          }
        }
        echo "</ul></div>";
      }
      $result->close();
    } else {
      echo "No reords matching your query were found.";
    }
  } else {
    echo "Error: could not execute $sql. " . $mysqli->error;
  }
  ?>
  </div>

  <div data-role="footer" data-position="fixed"> 
    <div data-role="navbar">
      <ul>
        <li> <a href="order.php" data-rel="dialog" data-transition="pop">Your Order<?php echo "({$cartItemCount})"; ?></a> </li>
      </ul>
    </div> 
  </div>
</div>
  
  <! -- Account Tab -- >
<div data-role="page" id="account">
  <div data-role="header">
    <h1>Account Setting</h1>
  </div>

  <div data-role="content">
    <a href="update.php" data-rel="dialog" data-role="button">Change Password</a>
  </div>

</div> 

</body>
</html>
