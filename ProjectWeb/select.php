<?php
		include 'conecto_database.php';
		$extra = $_REQUEST['extra'];
		$query = "SELECT * FROM coordinates WHERE name = '" . mysqli_real_escape_string($conn, $extra) . "'";
		$result = mysqli_query($conn,$query);
$temp=array();	
while($row = mysqli_fetch_array($result))
     {
		 
        array_push($temp,$row);
		
     } 
			echo '<pre>';
			print_r($temp);
			echo'</pre>';
?>