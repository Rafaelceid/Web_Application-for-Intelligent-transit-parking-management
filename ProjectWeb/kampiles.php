<?php
include 'conecto_database.php';

$query = "DROP TABLE IF EXISTS new_table";
$result = $conn->query($query);

$query = "CREATE TABLE new_table(
              SELECT `id`,`region`,`name`,`description`,`Time`,`1`,`number_parking` FROM coordinates,tbl_info WHERE  (`region`=1) and `Time` = 2 
			  )";
$result = $conn->query($query);

$query = "INSERT INTO new_table(
            SELECT `id`,`region`,`name`,`description`,`Time`,`2`,`number_parking` FROM coordinates,tbl_info WHERE  (`region`=2) and `Time` = 2
            )";

$result = $conn->query($query);
$query = "INSERT INTO new_table(
            SELECT `id`,`region`,`name`,`description`,`Time`,`3`,`number_parking` FROM coordinates,tbl_info WHERE  (`region`=3) and `Time` = 2
            )";
$result = $conn->query($query);
$resarray=array();
$query = "SELECT `name`,`1`,`number_parking` FROM `new_table`";
$test = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) {
    $temp=round($row['number_parking']-$row['1']*$row['number_parking']);
    if ($row['number_parking']!=0){
    $percentage = $temp / $row['number_parking'];
    }
    $temp_array=array($row['name'],$temp,$percentage);
    array_push($resarray,$temp_array);
}

print_r(json_encode($resarray));

?>