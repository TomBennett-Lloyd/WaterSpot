<?php
  $config = parse_ini_file('../../app_data/config.ini');
  session_start();
  $validAccess=0;

  if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    $link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
    if (!mysqli_connect_error()){
      $email=mysqli_real_escape_string($link,$_GET['email']);
      $query = "SELECT hash, active FROM users WHERE email='".$email."'";

      if($result = mysqli_query($link, $query)) {

        $row=mysqli_fetch_array($result);
        if ($row['hash']==$_GET['hash'] && $row['active']==0) {
          $validAccess=1;
          $hash=$_GET['hash'];
          $message='<p>Please use the form below to reset your password!</p>';
        }
      }
    }
  } elseif ($_SESSION['email']) {
    $email=$_SESSION['email'];
    $validAccess=1;
    $hash=1;
    $message='<p>Please use the form below to reset your password!</p>';
  }

  if (!$message) {
    $validAccess=0;
    $message='<p>Sorry, you have accessed this page via an invalid approach, if you want to sign up please do so from the main menu</p>';
  }


  include 'header.php';

  if ($validAccess==1) {
    echo '
    <div class="container align-middle contBack">
      '.$message.'
      <form id="passwordReset" method="POST" onsubmit="submitNewPassword( $(this), event)" class="form-inline m-2 my-lg-0">
          <input type="password" class="form-control m-2" id="newPassword" placeholder="Password" name="password">

          <input type="password" class="form-control m-2" id="newPassword2" placeholder="Re-type Password" name="password2">

          <input type="submit" name="submit" value= "Reset Password" class="btn btn-info m-2">

          <input name="honeypot" value= "'.$hash.'" type="hidden" class="btn btn-info m-2">

          <input name="username" value= "'.$email.'" type="hidden" class="btn btn-info m-2">

          <div class="form-group row"  id="captcha">
            <div class="col-sm-12 m-2" id="captcha2">
            </div>
          </div>

      </form>
      <div id="PasswordMissmatch" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Please make sure both passwords are the same!
      </div>
      <div id="invalidPassword2" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Please enter a new Password!
      </div>
      <div id="passwordResetSuccess" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Your password has now been reset, you can now log in using your new password.
      </div>
      <div id="PasswordAlreadyReset" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Your password has already been reset, you can now log in using your new password.
      </div>
    </div>
    <script type="text/javascript" src="passwordReset.js"></script>
    ';
  }

include 'footer.php';


?>
