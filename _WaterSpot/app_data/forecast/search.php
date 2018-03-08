<?php
  $config = parse_ini_file('../../app_data/config.ini');
  if ($_POST) {
    (array)$_POST;
    //die(print_r($_POST));
    if ($_POST['location']) {
      $locationJSON=file_get_contents("https://maps.googleapis.com/maps/api/place/textsearch/json?query=".urlencode($_POST['location'])."&key=AIzaSyAUgrwzR8GR1Y_fWXNzF3yQ3oB_indL5dM");
      $location=json_decode(substr($locationJSON,0,-1));
      $location=(array)$location;
      $location=(array)$location['results'][0];
      $location=(array)$location['geometry'];
      $point=(array)$location['location'];

    } elseif ($_POST['lat']) {
      $point=$_POST;
    }

    $pointstr="Point(".$point['lat'].",".$point['lng'].")";

    $link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
    if (!mysqli_connect_error()){
      $query="SELECT id, name, ST_Distance(".$pointstr.",location) as distance FROM MetOfficeLocations HAVING distance < 25 ORDER BY distance LIMIT 1";

      if($result = mysqli_query($link, $query)) {
        $row=mysqli_fetch_array($result);
        $forecast=file_get_contents('http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/'.$row['id'].'?res=3hourly&key=cd72da0e-dc6e-4129-80ad-168a06b2a0c6');
        //die($row['name'].": ".round($row['distance'],1)." kilometers away. ");
        die($forecast);
      } else {
        die("SQL query error ". mysqli_error($link));
      }
    }
  }
  die("error");
?>
