<?php


session_start();

include 'header.php'; ?>

    <div class="container" style="margin-top:150px">

      <form id="contactForm" method="post">
        <div class="form-group row" id="email">
          <label for="email" class="col-sm-3 m-2 col-form-label">Email address</label>
          <div class="col-sm-12 m-2">
            <input type="email" name="email" class="form-control"
            <?php if ($_SESSION['email']) {
              echo 'value="'.$_SESSION['email'].'">';
            } else {
              echo 'placeholder="enter your email adress here">';
            }?>

          </div>
        </div>

        <div class="form-group row" id="message">
          <label for="message" class="col-sm-3 m-2 col-form-label">Your message</label>
          <div class="col-sm-12 m-2">
            <textarea class="form-control" name="message" rows="8" cols="80"></textarea>
          </div>
        </div>

        <div class="form-group row"  id="website">
          <label for="website" class="col-sm-3 m-2 col-form-label">Website</label>
          <div class="col-sm-12 m-2">
            <input class="form-control" name="website"></textarea>
          </div>
        </div>

        <div class="form-group row"  id="captcha">
          <div class="col-sm-12 m-2" id="captcha2">
          </div>
        </div>

        <div class="form-group row m-2">
          <input type="submit" name="submit" class="btn btn-primary my-2 my-sm-0">
        </div>
      </form>
    </div>


		<script type="text/javascript" src="contact.js"></script>

<?php include 'footer.php'; ?>
