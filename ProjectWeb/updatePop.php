<?php
$q =  json_decode($_REQUEST['q']);
$id = json_decode($_REQUEST['id']);
$all = json_decode($_REQUEST['all']);

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'map_data';
$maxRuntime = 8; // less then your max script execution limit


try {
    $con = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$con->beginTransaction();
for ($i=0; $i<count($q); $i++) {
    
    if (($q[$i] != null) && ($all[$i]->region==0))
    {
    $parking = 146 - $q[$i]*0.2;
    $region=2;
    $all[$i]->region=2;
    }  else if (($q[$i] != null) && ($all[$i]->region == 1))
    {
        $parking = 146 - $q[$i]*0.2;
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

    $con->exec("UPDATE `coordinates` SET `population`='$q[$i]', `number_parking`='$parking' , `region`=$region WHERE `name`='$id[$i]';");
    
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