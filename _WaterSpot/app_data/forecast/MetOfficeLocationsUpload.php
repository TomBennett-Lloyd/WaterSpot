<?php
$config = parse_ini_file('../../app_data/config.ini');
$success=0;

// $Sitelist=file_get_contents('http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/json/sitelist?key=cd72da0e-dc6e-4129-80ad-168a06b2a0c6');
// $sites=json_decode($Sitelist);
// $sites=(array)$sites;
// $sites=(array)$sites['Locations'];
// $sites=(array)$sites['Location'];



// $strFields= array("name","region","unitaryAuthArea");
// $numFields= array("elevation","id");
// $query1="INSERT into MetOfficeLocations (elevation,id,location,name,region,unitaryAuthArea) VALUES (";
$link = mysqli_connect("shareddb1e.hosting.stackcp.net",$config['username'],$config['password'],$config['dbname']);
if (!mysqli_connect_error()){
  // foreach ($sites as $key => $value) {
  //   $attributes=(array)$value;
  //   $values='';
  //   foreach ($attributes as $key2 => $value2) {
  //     if ($key2=='elevation') {
  //       $values=$value2;
  //     } elseif (in_array($key2,$strFields)) {
  //       $values.=",'".$value2."'";
  //     } elseif (in_array($key2,$numFields)) {
  //       $values.=",".$value2;
  //     } elseif ($key2=="latitude") {
  //       $values.=",ST_GeomFromText('POINT(".$value2;
  //     } elseif ($key2=="longitude") {
  //       $values.=" ".$value2.")')";
  //     }
  //     // $values.=" ".$value2;
  //   }
  //
  //   $query=$query1.$values.")";




    if($result = mysqli_query($link, $query)) {
      $success=1;
    } else {
      echo "SQL query error ". mysqli_error($link);
    }

  }
}

?>
