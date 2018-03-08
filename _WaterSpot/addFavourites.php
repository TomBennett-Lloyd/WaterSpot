<?php
  $config = parse_ini_file('../../app_data/config.ini');
  session_start();

  if ($_SESSION['email']&& $_POST['name']) {
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
          $favourites=json_decode($row['favourites'], $assoc=true);
          if (isset($favourites[$_POST['name']])) {
            die($_POST['name']." is already in your favourites!");
          }
        } else {
          $favourites= array();
        }
        $favourites[$_POST['name']]=array('lng' => $_POST['lng'] ,'lat' => $_POST['lat']);

        $newFavourites=json_encode($favourites);

        $query = "UPDATE users SET favourites='".$newFavourites."' WHERE email='".$_SESSION['email']."' LIMIT 1";
        if($result = mysqli_query($link, $query)) {
          die ($_POST['name']." added to favourites!");
        }
      }
    }
  }


?>
