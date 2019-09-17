<?php
include 'conecto_database.php';
$query = "DROP TABLE IF EXISTS new_table";
$result = $conn->query($query);
$x =  json_decode($_REQUEST['x']);



$query = "CREATE TABLE new_table(
              SELECT `region`,`name`,`parking`,`Time`,`1` FROM `availability`,`tbl_info` WHERE  (`region`=1 and `Time` = '$x')
			  )";
if($conn->query($query)){
} else {
    echo "Error  " . mysqli_error($conn);
}
;

$query = "INSERT INTO new_table(
            SELECT `region`,`name`,`parking`,`Time`,`2` FROM `availability`,`tbl_info` WHERE  (`region`=2 and `Time` = '$x')
            )";

if ($conn->query($query)) {
} else {
    echo "Error  " . mysqli_error($conn);
}
$query = "INSERT INTO new_table(
            SELECT `region`,`name`,`parking`,`Time`,`3` FROM `availability`,`tbl_info` WHERE  (`region`=3 and `Time` = '$x')
            )";
if ($conn->query($query)) {
} else {
    echo "Error  " . mysqli_error($conn);
}

$resarray=array();

$query = "ALTER TABLE new_table
ADD `percentage` float(6)";
$test = mysqli_query($conn, $query);

$query = "SELECT `name`,`1`,`parking` FROM `new_table`";
$test = mysqli_query($conn, $query);
try {
    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    // $sql=null;
    $con->beginTransaction();
while ($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) {
    $temp=round($row['parking']-$row['1']*$row['parking']);
    if ($row['parking']!=0){
    $percentage = 1 - ($temp / $row['parking']);
            $con->exec("UPDATE `new_table` SET `percentage`='$percentage' WHERE `name`='$row[name]' ;");
    }
    $temp_array=array('name'=>$row['name'],'parking'=>$temp,'percentage'=>$percentage);
    array_push($resarray,$temp_array);
    
}
$con->commit();
print_r(json_encode($resarray));
} catch (PDOException $e) {
    // roll back the transaction if something failed
    $con->rollback();
    echo "Error: " . $e->getMessage();
}

?>