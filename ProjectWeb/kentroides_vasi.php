<?php include 'conecto_database.php';
include 'kentroides.php';
include 'one_two_dim.php';
$query = "SELECT coords FROM coordinates";
			$result = $conn->query($query);
			$counter = 0;
			
			   

			if ($result->num_rows > 0) 
			{
			    // output data of each row
			    while($row = $result->fetch_assoc()) 
			    {
			        $coor[$counter] = $row['coords']; 
	   				$coor_xy[] = preg_split("/[\s,-]+/", $coor[$counter]);
	   			    $counter ++;
	   			    
					$column = 2;
					$rings = $coor_xy;
					$rings = arrayToMat($coor_xy, 2);
					print_r($rings);
					getCentroidOfPolygon($rings);

			    }
			} else 
			{
			    echo "0 results";
			}

			$conn->close();

?>