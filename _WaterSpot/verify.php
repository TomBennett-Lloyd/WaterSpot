<?php
$config = parse_ini_file('../../app_data/config.ini');



if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
  $link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
  if (!mysqli_connect_error()){
    $email=mysqli_real_escape_string($link,$_GET['email']);
    $query = "SELECT hash, active FROM users WHERE email='".$email."'";

    if($result = mysqli_query($link, $query)) {

      $row=mysqli_fetch_array($result);
      if ($row['hash']==$_GET['hash'] && $row['active']==0) {
        $query = "UPDATE users SET active = 1 WHERE email = '".$email."' LIMIT 1";
        if($result = mysqli_query($link, $query)) {
          $message='<p>Thanks for signing up, your account has now been verified!</p><p>You can now sign in to access your account!</p>';
        }
      }
    }
  }
}

if (!$message) {
  $message='<p>Sorry, you have accessed this page via an invalid approach, if you want to sign up please do so from the main menu</p>';
}

?>


<html lang="en">
  <head>
    <title>WaterSpot Verification</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="Mapping.js"></script>
    <script type="text/javascript" src="GetForecast.js"></script>


  </head>
  <body>
    <!-- Navbar -->

    <?php
      include 'navbar.php';
      echo $message;
    ?>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPVmJxOevBtKb_HcYkqlVtWYUz1EWumyY&libraries=places&callback=initMap" async defer></script>

  </body>
</html>
