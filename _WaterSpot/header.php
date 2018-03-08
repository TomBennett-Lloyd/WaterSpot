<?php
$config = parse_ini_file('../../app_data/config.ini');
session_start(); ?>

<html lang="en">
  <head>
    <title>WaterSpot</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="Mapping.js"></script>
    <script type="text/javascript" src="GetForecast.js"></script>
    <script type="text/javascript">

    var captcha1="";
    var captcha2="";
      var onloadCallback = function() {
        if ($("#captcha1").length>0) {
          captcha1 = grecaptcha.render('captcha1', {
            'sitekey' : '6LcdyjYUAAAAAE-VaswScrj4QonDomFQSRS0sxY2',
            'theme' : 'light'
          });
        }
        if ($("#captcha2").length>0) {
          captcha2 = grecaptcha.render('captcha2', {
            'sitekey' : '6LcdyjYUAAAAAE-VaswScrj4QonDomFQSRS0sxY2',
            'theme' : 'light'
          });
        }
      };
    </script>


</head>
<body> <!-- style="background: url('background.jpg') no-repeat fixed center; background-size:cover;"-->

<?php
echo '
<nav class="navbar navbar-toggleable-sm navbar-light  mb-5" style="background-color: #e3f2fd;">
  <a class="navbar-brand" href="index.php">WaterSpot</a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto search">
      <li class="nav-item mx-2">
        <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item mx-2">
        <a class="nav-link active" href="contact.php">Contact</a>
      </li>
      ';
if ($_SESSION['email']) {
  echo '<li class="nav-item mx-2">
    <a class="nav-link active" data-toggle="collapse" data-target="#favourites" aria-controls="favourites" aria-expanded="false" aria-label="Toggle favourites">
    My favourites
    </a>
  </li>
  <li class="nav-item mx-2"><div class="collapse navbar-collapse" id="favourites"> Add some favourites </div></li>';
  echo '<li class="nav-item mx-2"><a id="myAccount" class="nav-link active" href="accountManager.php">My Account</a></li>';
} else {
    echo '<li class="nav-item mx-2"><a id="favourites" class="nav-link disabled" href="index.php">My favourites</a></li>';
    echo '<li class="nav-item mx-2"><a id="myAccount" class="nav-link disabled" href="#">My Account</a></li>';
}
echo '
      <li class="nav-item search">
        <form method="post" action="search.php" class="form-inline search">
          <input id="location1" name="location" class="form-control m-2 location" type="text" placeholder="Find your spot">
        </form>
        <div class="getForecastButton">
          <button class="btn btn-outline-success m-2 getForecast" onclick="getForecast(this)">Get Forecast!</button>
        </div>
      </li>
    </ul>';

if (!$_SESSION['email']) {
  include 'headerForm.php';
} else {
  echo '
  <a class="btn btn-info m-2" href="logout.php">Log Out</a>';
}
echo'
  </div>
</nav>

<div id="errorMessages" class="modal align-middle">
  <div class="modal-dialog align-middle" role="document" style="top:30vh">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">WaterSpot</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="modalMessage" ></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="infowindow-content" class="container">
  <img src="" width="16" height="16" id="place-icon">
  <span id="place-name" class="title"></span><br>
  <span id="place-address"></span>
  <button class="btn btn-success m-2 getForecast" onclick="getForecast(this)">Get Forecast!</button>
  <form id="GMapVals" class="GMapVals" method="post">
    <input type="hidden" id="lat" name="lat" />
    <input type="hidden" id="lng" name="lng" />
    <input type="hidden" id="name" name="name" />
  </form>

</div>'
?>
