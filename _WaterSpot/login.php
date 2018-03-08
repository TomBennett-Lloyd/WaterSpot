<?php
  $config = parse_ini_file('../../app_data/config.ini');
  $success=0;

  session_start();

  function random_str(
      $length = 8,
      $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
  ) {
      $str = '';
      $max = mb_strlen($keyspace, '8bit') - 1;
      if ($max < 1) {
          throw new Exception('$keyspace must be at least two characters long');
      }
      for ($i = 0; $i < $length; ++$i) {
          $str .= $keyspace[random_int(0, $max)];
      }
      return $str;
  }

  function sendAccountEmail($message,$email,$subject){
    $message = '
  <html>
  <head>
  <title>Account Verification</title>
  </head>
  <body>
  <p> Hi, </p>
  '.$message.'
    <p>All the best</p>

    <p>WaterSpot</p>
    </body>
    </html>
                        ';

    $to      = $email; // Send email to our user
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: WaterSpot <tom@bennett-lloydtech.com>' . "\r\n"; // Set from headers
    $headers .='Reply-To: WaterSpot <tom@bennett-lloydtech.com>' . "\r\n";
    $result = mail($to, $subject, $message, $headers);
    return $result;
  }



  if ($_POST) {
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
      $username=$_POST['username'];
      $password=$_POST['password'];

      if(!$username){
        die ("Please enter a valid email adress!");
      }
      if(!$password){
          die("Please enter a password!");
      }

      if($username&&$password) {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
          //your site secret key
          $secret = $config['recaptchaKey'];
          //get verify response data
          $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
          $responseData = json_decode($verifyResponse , $assoc = true);


          if($responseData['success']){

            foreach($_POST as $key => $value) {
              if (ini_get('magic_quotes_gpc')) {
                $_POST[$key] = stripslashes($_POST[$key]);
              }
              $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
            }


            # process as normal
            $link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
            if (!mysqli_connect_error()){
              $username=mysqli_real_escape_string($link,$username);
              $query = "SELECT password, active FROM users WHERE email='".$username."'";

              if($result = mysqli_query($link, $query)) {

                $row=mysqli_fetch_array($result);
                if ($_POST['submit']=="Log In"){
                  if (password_verify($password, $row['password']) && $row['active']==1) {
                    $success=1;
                    session_start();
                    $_SESSION['email']=$username;


                  } elseif ($row['active']==1) {
                    $success=6;//incorrect password
                  } elseif ($row['active']==0) {
                    $success=5;//account not verified
                  }
                } elseif ($_POST['submit']=="Sign Up") {
                  if ($row['password']) {
                    $success=2;
                  } else {
                    $Phash = password_hash($password, PASSWORD_DEFAULT);
                    $hash=md5(random_str());
                    $query = "INSERT INTO users (email,password,hash) VALUES ('".$username."','".$Phash."','".$hash."')";
                    if($result = mysqli_query($link, $query)) {
                      $success=3;
                      $subject = 'WaterSpot Signup Verification'; // Give the email a subject
                      $message.= '

  <p>Thanks for signing up!</p>
  <a href="https://www.bennett-lloydtech.com/_WaterSpot/verify.php?email='.$username.'&hash='.$hash.'">Click Here to activate your account!</a>';
                      $sent=sendAccountEmail($message,$username,$subject);
                    }
                  }
                } elseif ($_POST['submit']=="Forgotten Password?") {
                  if ($row['active']==1) {
                    $password= random_str();
                    $Phash = password_hash($password, PASSWORD_DEFAULT);
                    $hash=md5(random_str());
                    $query = "UPDATE users SET active = 0, password='".$Phash."', hash = '".$hash."'  WHERE email = '".$username."' LIMIT 1";

                    if($result = mysqli_query($link, $query)) {


                      $subject = 'Password Reset'; // Give the email a subject
                      $message = '<p>Your Password has been reset!</p>

<a href="https://www.bennett-lloydtech.com/_WaterSpot/passwordReset.php?email='.$username.'&hash='.$hash.'">Click Here to set your new password!</a>';
                      $sent=sendAccountEmail($message,$username,$subject);
                    }
                  } elseif ($row['active']==0) {
                    $success=5;//account not yet verified
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  $output = array('success' => $success );
  die(json_encode($output));
?>
