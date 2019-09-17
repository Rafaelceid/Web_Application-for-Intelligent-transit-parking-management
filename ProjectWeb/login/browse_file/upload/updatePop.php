<?php
include 'conecto_database.php';
$q =  json_decode($_REQUEST['q']);
$id = json_decode($_REQUEST['id']);
$all = json_decode($_REQUEST['all']);
$flag = json_decode($_REQUEST['flag']);


$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'map_data';
$maxRuntime = 8; // less then your max script execution limit



$sql = "DROP TABLE IF EXISTS `availability`";
if ($conn->query($sql)) { } 
else {
   echo "Error  " . mysqli_error($conn);
}


$sql = "CREATE TABLE `availability` (
        `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
        `population` int(3),
        `parking` int(11),
		`region` int(5)
        )ENGINE=INNODB CHARACTER SET ascii COLLATE ascii_general_ci";
if ($conn->query($sql)) { } 
else {
   echo "Error  " . mysqli_error($conn);
}


try {
    $con = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con->beginTransaction();
for ($i=0; $i<count($q); $i++) {
    
    if (($q[$i] != null) && ($all[$i]->region==0))
    {
    $parking = round(146 - $q[$i]*0.2);
    $region=2;
    $all[$i]->region=2;
    }  else if (($q[$i] != null) && ($all[$i]->region == 1))
    {
        $parking = round(146 - $q[$i]*0.2);
        $region=1;
        $all[$i]->region = 1;
    } else if (($q[$i] == null) && ($all[$i]->region == 1))
    {
        $parking = 75;
        $region = 1;
        $all[$i]->region = 1;
    } else
    {
            $parking = 75;
            $region = 3;
            $all[$i]->region = 3;
    }

    $con->exec("INSERT INTO `availability` VALUES ('$id[$i]' , '$q[$i]' , '$parking' , '$region') ;");
    
}

$con->commit();
print_r(json_encode($all));
}
catch(PDOException $e)
    {
    // roll back the transaction if something failed
    $con->rollback();
    echo "Error: " . $e->getMessage();
    }




?>