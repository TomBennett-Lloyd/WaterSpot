<?php
  $config = parse_ini_file('../../app_data/config.ini');
  session_start();
  $validAccess=0;

  if ($_SESSION['email']) {
    $email=$_SESSION['email'];
    $validAccess=1;
    $message='<p>Please use the form below to reset your email!</p>';
  } else {
    $validAccess=0;
    $message='<p>Sorry, you have accessed this page via an invalid approach, if you want to sign up please do so from the main menu</p>';
  }

  include 'header.php';

  if ($validAccess==1) {
    echo '
    <div class="container align-middle contBack">
      '.$message.'
      <form id="passwordReset" method="post" class="form-inline m-2 my-lg-0">
          <input type="password" class="form-control m-2" id="newPassword" placeholder="New Email" name="password">

          <input type="password" class="form-control m-2" id="newPassword2" placeholder="Re-type Email" name="password2">

          <input name="submit" value= "Reset Email" type="submit" class="btn btn-info m-2">

          <input name="honeypot" value= "email" type="hidden" class="btn btn-info m-2" id="honeypot">

          <input name="username" value= "'.$email.'" type="hidden" class="btn btn-info m-2">

          <div class="form-group row"  id="captcha">
            <div class="col-sm-12 m-2" id="captcha2">
            </div>
          </div>

      </form>
      <div id="PasswordMissmatch" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Please make sure both Emails are the same!
      </div>
      <div id="passwordResetSuccess" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Your email has now been reset, you can now log in using your new email.
      </div>
      <div id="PasswordAlreadyReset" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
        Your email has already been reset, you can now log in using your new email.
      </div>
    </div>
    <script type="text/javascript" src="passwordReset.js"></script>
    ';
  }

  include 'footer.php';

?>
