<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Tastify</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
  <! -- Initialize Tab 1 -- >
  <div data-role="page" id="tab1">
    <div data-role="header">
      <a href="initialize.php" data-role="button" data-icon="arrow-l" >Back</a>
      <h1>Cuisines</h1>
    </div>

    <div data-role="content">
      <?php $favItemCount = isset($_SESSION['hate']) ? count($_SESSION['hate']) : 0; ?>
      <h3>Tap to Select  Dishes You don't like</h3>
      <h4>We will filter foods with similar taste out from the recommendation result.</h4>
      <a><?php echo "{$favItemCount}"; ?> Item selected</a>
      <?php
        $mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
        if ($mysqli == false) {
          die("Error: Could not connect. " . mysql_connect_error());
        }
        $dbc = mysqli_connect("192.186.227.227", "jacobyhz","thoXibE34","Tastify");    

        

        // to prevent undefined index notice
        $action = isset($_GET['action']) ? $_GET['action'] : "";
        $name = isset($_GET['name']) ? $_GET['name'] : "";

        echo "<div data-role='navbar' data-iconpos='left'>";

        if($action=='add'){
          echo "<li><a data-icon='info'>" . $name . " was added.</a></li>";
        }

        if($action=='exists'){
          echo "<li><a data-icon='info'>" . $name . " already exists</a></li>";
        }

        if($action=='removed'){
          echo "<li><a data-icon='info'>" . $name . " was removed.</a></li>";
        }

        echo "</div>";

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
                          <a href='addToHate.php?id={$tmp2[0]}&name={$tmp2[2]}'>Add to Order</a>
                        </li>";
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
          <li><a href="register.php" data-role="button" data-icon="arrow-r">Next</a></li>
        </ul>
      </div>  
    </div>
  </div> 

  
</body>
</html>
