 
 <?php


function updateCentroids(){
	include 'geometry_sort.php';
	include 'conecto_database.php';
	$query = "SELECT coords FROM coordinates";
	$result = mysqli_query($conn,$query);
	
	//DECLARE YOUR ARRAY WHERE YOU WILL KEEP YOUR RECORD SETS
$data_array=array();
$final_array=array();
$temp_array=array();
//STORE ALL THE RECORD SETS IN THAT ARRAY 


while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{
	
    array_push($data_array,$row);
}
mysqli_free_result($result);


foreach ($data_array as $value)
{
$value=implode(" ",$value);
$temp = explode (" ",$value); 

array_push($temp_array,array_chunk($temp,1));
}

foreach ($temp_array as &$value)
{
foreach ($value as &$coords)
{
$coords=explode (",",$coords[0]); 
}
}


$centroids=array();
 foreach ($temp_array as $testi)
 {
 $geometry = new stdClass();
 $geometry->rings = array($testi);
 array_push($centroids,getCentroidOfPolygon($geometry));
 }
 
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'map_data';
$maxRuntime = 8; // less then your max script execution limit

try {
    $con = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
// $sql=null;
$con->beginTransaction();
for ($i = 0; $i < count($centroids); $i++) {
    $c = $centroids[$i][0]. "," . $centroids[$i][1];
    $temp=distance(22.944420, 40.640064, $centroids[$i][0], $centroids[$i][1], 'K');
$con->exec("UPDATE coordinates SET `centroid`='$c' , `region`='$temp'  WHERE id='$i';");
    

}
$con->commit();
}
catch(PDOException $e)
    {
    // roll back the transaction if something failed
    $con->rollback();
    echo "Error: " . $e->getMessage();
    }
}
	
/*
	if ($conn->multi_query($sql) === TRUE) {
	while (mysqli_next_result($conn));
        echo "Centroids updated successfully";
    } else {
        echo "Error updating Centroids: " . $conn->error;
    }
    echo '<pre>';
 
 }
 
 */
 function getAreaOfPolygon($geometry) {
    $area = 0;
    for ($ri=0, $rl=sizeof($geometry->rings); $ri<$rl; $ri++) {
        $ring = $geometry->rings[$ri];

        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++) {
            $thisx = $ring[ $vi ][0];
            $thisy = $ring[ $vi ][1];
            $nextx = $ring[ ($vi+1) % $vl ][0];
            $nexty = $ring[ ($vi+1) % $vl ][1];
            $area += ($thisx * $nexty) - ($thisy *$nextx);
        }
    }

    // done with the rings: "sign" the area and return it
    $area = abs(($area / 2));
    return $area;
}


 
 
 function getCentroidOfPolygon($geometry) {
    $cx = 0;
    $cy = 0;

    for ($ri=0, $rl=sizeof($geometry->rings); $ri<$rl; $ri++) {
        $ring = $geometry->rings[$ri];

        for ($vi=0, $vl=sizeof($ring); $vi<$vl; $vi++) {
            $thisx = $ring[ $vi ][0];
            $thisy = $ring[ $vi ][1];
            $nextx = $ring[ ($vi+1) % $vl ][0];
            $nexty = $ring[ ($vi+1) % $vl ][1];

            $p = ($thisx * $nexty) - ($thisy * $nextx);
            $cx += ($thisx + $nextx) * $p;
            $cy += ($thisy + $nexty) * $p;
        }
    }

    // last step of centroid: divide by 6A
    $area = getAreaOfPolygon($geometry);
    $cx = -$cx / ( 6 * $area);
    $cy = -$cy / ( 6 * $area);

    // done!
    
    return array($cx,$cy);
    

}



?>