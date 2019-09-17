<?php

function region_sort(){
include 'conecto_database.php';
$temp_array = array();
$query = "SELECT `id` , `population` FROM `coordinates` WHERE `region`=0";
$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

    array_push($temp_array, $row);
}
var_dump($temp_array);
mysqli_free_result($result);
foreach ($temp_array as $value) {
    var_dump($value["population"]);
if ($value["population"] == 0){
    return 3;
    
} else {
    return 2;
    
}
}
}