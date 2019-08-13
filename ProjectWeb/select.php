<?php
		include 'conecto_database.php';
		$firstname = $_REQUEST['firstname'];
		$query = "SELECT * FROM coordinates WHERE name = '" . mysqli_real_escape_string($conn, $firstname) . "'";
		$result = mysqli_query($conn,$query);
	
while($row = mysqli_fetch_array($result))
     {
		 echo '<pre>';
        print_r($row);
		echo '</pre>';
     } 
			
?>