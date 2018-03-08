<?php
  $config = parse_ini_file('../../app_data/config.ini');
  session_start();

  if ($_SESSION['email']) {
    $link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
    if (!mysqli_connect_error()){
      foreach($_POST as $key => $value) {
        if (ini_get('magic_quotes_gpc')) {
          $_POST[$key] = stripslashes($_POST[$key]);
        }
        $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
        $_POST[$key] = mysqli_real_escape_string($link,$_POST[$key]);
      }

      $query= "SELECT favourites FROM users WHERE email='".$_SESSION['email']."' LIMIT 1";

      if($result = mysqli_query($link, $query)) {
        $row=mysqli_fetch_array($result);
        if (strlen($row['favourites'])>5) {
          die($row['favourites']);
        }
      }
    }
  }



?>
