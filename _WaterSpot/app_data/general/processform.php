<?php
$config = parse_ini_file('../../app_data/config.ini');
$success=0;
$error="";
//if(isset($_POST['submit']) && !empty($_POST['submit'])){
if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
  $email=$_POST['email'];
  $message=$_POST['message'];

  if(!$email){
    $error.="Please enter a valid email adress!</br>";
  }
  if(!$message){
      $error.="Please enter a message!";
  }

  if($email&&$message){
    if (strlen($message) < 10 || substr_count($message, " ") < 2) {
      $error="Your message is too short.";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      //your site secret key
      $secret = $config['recaptchaKey'];
      //get verify response data
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
      $responseData = json_decode($verifyResponse , $assoc = true);


      if($responseData["success"]==true){

        foreach($_POST as $key => $value) {
          if(ini_get('magic_quotes_gpc'))
            $_POST[$key] = stripslashes($_POST[$key]);

          $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
        }

        if (!empty($_POST['website'])) {
          $error="Thank you for your email! We will be in touch shortly";
          $success=1;
        } else {
              # process as normal
              $error="Thank you for your email! We will be in touch shortly. <br> you will now be redirected to the home page";
              $success=1;

        }
      } else {
        $error="Please try the captcha again!</br>";
      }
    } else {
      $error="Please enter a valid email adress!</br>";
    }
  }

} else {
  $error="Please complete the captcha!</br>";
}

$output = array('output' => $error, 'success' => $success );
echo json_encode($output);
//}
exit;
?>
