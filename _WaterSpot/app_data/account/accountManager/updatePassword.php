<?php

  $config = parse_ini_file('../../app_data/config.ini');
  session_start();
  $validAccess=0;

  $success=0;

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
    return $result; // Send our email
  }

  if ($_POST) {
    if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
      $password2=$_POST['password2'];
      $password=$_POST['password'];
      $username=$_POST['username'];

      if($password!=$password2){
        die ("Please enter matching passwords");
      } else {

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
          if (!mysqli_connect_error()) {
            $username=mysqli_real_escape_string($link,$username);
            $query = "SELECT hash, active FROM users WHERE email='".$username."' LIMIT 1";


            if($result = mysqli_query($link, $query)) {
              $query = "";
              $row=mysqli_fetch_array($result);
              if ($row['hash']==$_POST['honeypot'] || $_SESSION['email']==$username) {
                if ($row['active']==1 && $_SESSION['email']!=$username) {
                  $success=2;
                } else {
                  $hash=md5(random_str());
                  if ($_POST['honeypot']=='email' && filter_var($password, FILTER_VALIDATE_EMAIL)) {
                    $newEmail=$password;
                    $query = "UPDATE users SET email='".$newEmail."', hash='".$hash."', active=0 LIMIT 1";
                    $subject = 'WaterSpot New Email Verification'; // Give the email a subject
                    $message = '<p>Thanks for signing up!</p>
<a href="https://www.bennett-lloydtech.com/_WaterSpot/verify.php?email='.$username.'&hash='.$hash.'">Click Here to activate your account!</a>';
                    if (!sendAccountEmail($message,$newEmail,$subject)){
                      $success='email send failiure';
                    }
                  } elseif ($_POST['honeypot']==$row['hash']) {
                    $Phash = password_hash($password, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET password='".$Phash."', hash='".$hash."', active=1 LIMIT 1";
                  } elseif ($_POST['honeypot']=='email' && !filter_var($password, FILTER_VALIDATE_EMAIL)) {
                    $success='invalid email';
                  }
                }
                if($result = mysqli_query($link, $query)) {
                  $success=1;
                  
                } else {
                  $success='sql query error 2';
                }
              } else {
                $success='incorrect hash'." ";
              }
            } else {
              $success='sql query error';
            }
          } else {
            $success='sql connection failiure';
          }
        } else {
          $success='invalid recaptcha';
        }
      }
    }
  }
  $output = array('success' => $success );
  die (json_encode($output));

?>
