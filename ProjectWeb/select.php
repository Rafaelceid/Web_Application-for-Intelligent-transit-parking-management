<?php
		include 'conecto_database.php';
		$extra = $_REQUEST['extra'];
		$number_park = $_REQUEST['number_p'];

		$query = "UPDATE coordinates SET number_parking = $number_park WHERE name = '" . mysqli_real_escape_string($conn, $extra) . "'";
		$result = mysqli_query($conn,$query);


if ($conn->query($query) === TRUE) {
	echo "Record updated successfully";
} else {
	echo "Error updating record: " . $conn->error;
}



?>