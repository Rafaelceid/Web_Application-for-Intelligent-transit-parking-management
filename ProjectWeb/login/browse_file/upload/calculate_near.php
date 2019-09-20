<?php
error_reporting(E_ERROR | E_PARSE);
include 'conecto_database.php';
include 'random.php';
$name =  json_decode($_REQUEST['id']);
$dist =  json_decode($_REQUEST['dist']);
$hour =  json_decode($_REQUEST['hour']);
$result = array();
$all_centroids=array();
$query = "SELECT `name`,`centroid` FROM `coordinates`";

$centroid;
$match=array();
$test = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) {
array_push($all_centroids,$row);
}
foreach ($all_centroids as $temp){
    if ($temp['name']==$name){
        $centroid = explode(",", $temp['centroid']);
    }
}
foreach ($all_centroids as $temp) {
    $temp1 = explode(",", $temp['centroid']);
    $apostasi=(distance($centroid[0],$centroid[1],$temp1[0],$temp1[1]))*1000;
    if ($apostasi<=$dist){
        array_push($match,$temp['name']);
    }
    
}
$temparray['location'] = array();
foreach ($match as $temp){
    
$query = "SELECT parking,centroid,nt.name FROM new_table AS nt
JOIN coordinates AS co
ON co.name = nt.name
WHERE nt.name='$temp'";

$test = mysqli_query($conn, $query);
$row = mysqli_fetch_array($test, MYSQLI_ASSOC);
$temp1 = explode(",", $row['centroid']);



for ($i=0;$i<=$row['parking'];$i++){
    $res= generateRandomPoint(array($temp1[0], $temp1[1]), 0.0310686);
    $sistarisma=5;

    $temparray['location']= array("accuracy" => $sistarisma, "latitude" => $res['latitude'], "longitude" => $res['longitude']);
    array_push($result,$temparray);
}

}

print_r(json_encode($result));

function distance($lat1, $lon1, $lat2, $lon2) {

$theta = $lon1 - $lon2;
$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;


$km=$miles * 1.609344;
return $km;
}
?>