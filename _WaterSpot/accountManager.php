<?php
$config = parse_ini_file('../../app_data/config.ini');
session_start();


include 'header.php';

if ($_SESSION['email']) {
  echo '<div class="container align-middle contBack">
      <div class="row justify-content-md-center my-3">

        <div class="col-sm-3">
          Email:
        </div>

        <div class="col-sm-6">
          <a class="btn btn-success" href="emailReset.php">Reset</a>
        </div>

      </div>

      <div class="row justify-content-md-center my-3">

        <div class="col-sm-3">
          Password:
        </div>

        <div class="col-sm-6">
          <a class="btn btn-success" href="passwordReset.php">Reset</a>
        </div>

      </div>

    </div>';
} else {
  echo '<div class="container align-middle">You must be logged in to view this page</div>';
}

include 'footer.php';

?>
