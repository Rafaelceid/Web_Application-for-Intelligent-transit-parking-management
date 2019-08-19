<?php
$q =  json_decode($_REQUEST['q']);
$id = json_decode($_REQUEST['id']);

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
	$con->exec("UPDATE `coordinates` SET `population`='$q[$i]' WHERE `name`='$id[$i]';");
}

$con->commit();
}
catch(PDOException $e)
    {
    // roll back the transaction if something failed
    $con->rollback();
    echo "Error: " . $e->getMessage();
    }





?>