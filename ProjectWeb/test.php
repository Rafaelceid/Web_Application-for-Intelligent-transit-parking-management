<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "map_data";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		 die("Connection failed: " . $conn->connect_error);
	} 
	$query = "CREATE TABLE new_table(
              SELECT `name`,`Time`,`1` FROM coordinates,tbl_info WHERE region=1 AND Time=2
			  )";
	$result =$conn->query($query);

	
	//while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
//{
//    array_push($data_array,$row);
//}
//mysqli_free_result($result);
//
		$query = "SELECT * FROM new_table";

$data_array=array();
$test=mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($test, MYSQLI_ASSOC)) 
{
    array_push($data_array,$row);
}
print_r(json_encode($data_array));
?>