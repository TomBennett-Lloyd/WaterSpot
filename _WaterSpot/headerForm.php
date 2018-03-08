<?php echo '

    <form id="login" method="post" class="form-inline m-2 my-lg-0">
        <input type="email" name="username" class="form-control m-2" id="username" placeholder="Username">

        <input type="password" class="form-control m-2" id="password" placeholder="Password" name="password">

        <input name="submit" value= "Log In" type="button" class="loginButton btn btn-primary m-2">

        <input name="submit" value= "Sign Up" type="button" class="loginButton btn btn-info m-2">

        <input name="submit" value= "Forgotten Password?" type="button" class="loginButton btn btn-info m-2">

        <div class="form-group row"  id="captcha">
          <div class="col-sm-12 m-2" id="captcha1">
          </div>
        </div>

    </form>

    <div id="success" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Log in sucessfull!
    </div>

    <div id="passwordReset" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
      A link to reset your password has been sent to your emaill adress.
    </div>

    <div id="passwordResetFail" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Unfourtunatley your password could not be reset. Please check whether you have verified your account and try again.
    </div>

    <div id="signedUp" class="alert alert-success m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Congratulations you are now signed up! You should recieve your account verification email shortly. <br> You can log into your new account once you have clicked on the link in the email.
    </div>

    <div id="incorrect" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Sorry but the username/password you entered was incorrect, please try again!
    </div>

    <div id="alreadySignedUp" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      The username you entered is already registered, please try logging in with your password!
    </div>

    <div id="nothing" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Please enter a username and password
    </div>

    <div id="invalidEmail" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Please enter a valid email adress
    </div>

    <div id="noCaptcha" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Please complete the captcha!
    </div>

    <div id="invalidPassword" class="alert alert-danger m-sm-3 hidden-xs-up" role="alert" style="display:none">
      Please enter a password that is at least 8 characters long
    </div>

    <script type="text/javascript" src="loginForm.js"></script>

' ?>
