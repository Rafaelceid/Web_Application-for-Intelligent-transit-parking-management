<?php

include 'conecto_database.php';

$name =  json_decode($_REQUEST['id']);
$lon =  json_decode($_REQUEST['lon']);
$lat =  json_decode($_REQUEST['lat']);

$query = "SELECT `centroid` FROM `coordinates` WHERE `name`='$name'";
$test = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) {

$centroid = explode(",", $row['centroid']);
}
$res=distance($lon,$lat,$centroid[0],$centroid[1]);

function distance($lat1, $lon1, $lat2, $lon2) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;


  $km=$miles * 1.609344;
return round($km*1000);

}
print_r(json_encode($res));
?>