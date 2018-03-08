<?php
$config = parse_ini_file('../app_data/config.ini');
session_start();

include '../app_data/header.php'; ?>

  <!-- MainContent -->

  <!--<div class="jumbotron jumbotron-fluid m-0 p-0 align-middle" style="min-height:100vh; background:url('background.jpg') no-repeat center fixed;background-size: cover;">
--><div class="jumbotron jumbotron-fluid m-0 pt-2 align-middle" style="background-color:transparent;">


    <div class="container text-center search contBack">
      <div class="text-center my-5" id="title" style="background-color:transparent;">
        <h1 class="display-3">WaterSpot</h1>
        <p class="lead">Find your spot!</p>
      </div>
      <div class="row justify-content-md-center search my-3" id="searchForm">
        <div class="col-md-3 mb-3">
          <button class="btn btn-warning" onclick="addFavourites()">Add to Favourites!</button>
        </div>
        <div class="col-md-6">
          <div class="row search justify-content-md-end">
            <form  id="search2" class="form-inline search col-md-8"  method="post">
              <input name="location" class="form-control location" style="width:100%;" type="text" placeholder="Location" id="location2">
            </form>

            <div class="col-md-4">
              <button class="btn btn-success getForecast" onclick="getForecast(this)">Get Forecast!</button>
            </div>
          </div>
        </div>

      </div>

      <div id="forecast" class="my-2">
        <?php include 'forecastWindow.php'; ?>
      </div>

      <div id="nothing2" class="alert alert-danger mx-sm-3 hidden-xs-up" role="alert" style="display:none">
        Please enter a location!
      </div>
      <div id="locationError" class="alert alert-danger mx-sm-3 hidden-xs-up" role="alert" style="display:none">
        Sorry but the location you entered could not be found, please try again!
      </div>
    </div>
  </div>


<!-- googleMaps -->
  <div class="pac-card" id="pac-card">
    <div id="title">
    </div>
    <div id="pac-container">
      <form id="GMapSearch" method="post">
        <input id="pac-input" type="text" class="location" placeholder="Enter a location">
      </form>

    </div>
  </div>
  <div id="map"></div>


<?php include 'footer.php'; ?>
