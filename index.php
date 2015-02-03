<!DOCTYPE html>
<html>
<head>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="css/images/favicon.ico">
<link rel="apple-touch-icon"  href="css/images/apple-touch-icon.ico">
<meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">
<title>Tastify</title> 
<link rel="stylesheet" href="./css/jquery.mobile-1.3.1.css">
<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
</head>

<body>
  <! -- Index Tab -- >
  <div data-role="page" id="index">
    <div data-role="header" data-position="fixed">
      <a href="#panel-01" data-role="button" data-icon="info" data-iconpos="notext">Personal Profile</a>
      <h1>Tastify</h1>
    </div>

    <div class="panel left" data-role="panel" data-position="left" data-display="reveal" id="panel-01">  
      <ul>
        <li><a href="http://uk.linkedin.com/in/yihengzhou"  data-icon="star">About Me</a></li>
        <li><a href="mailto:Yiheng.Zhou@warwick.ac.uk?Subject=Tastify%20Problem" target="_top"  data-icon="alert">Report A Problem</a></li>
      </ul>
    </div>  

    <div data-role="content">
      <?php
        $mysqli = new mysqli("192.186.227.227", "jacobyhz","thoXibE34","Tastify");
          if ($mysqli == false) {
            die("Error: Could not connect. " . mysql_connect_error());
          } 
      ?>   
      <a>Tastify is an instant dish recommendation app based on your personal taste.</a>
      <h5>This is an alpha version for marking purpose, for my final year project.</h5>
      <a>For now, it can only recommend dish from Varsity restaurant at University of Warwick</a>
      <h5>Please play around freely, and leave feedback </h5>
    </div>

    <div data-role="footer" data-position="fixed">
      <div data-role="navbar">
        <ul>
          <li><a href="initialize.php" data-role="button">Get Started</a></li>
          <li><a href="login.php" data-role="button">Log In</a></li>
        </ul>
      </div>  
    </div>
  </div> 
</body>
</html>
