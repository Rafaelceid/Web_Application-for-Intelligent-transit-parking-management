<?php
		include 'conecto_database.php';
		$np =  json_decode($_REQUEST['np']);
		$kz = json_decode($_REQUEST['kz']);
		$x = json_decode($_REQUEST['x']);
		$flag = json_decode($_REQUEST['flag']);

if ($flag==0){
		
$percentage=0;
		$query = "SELECT `name`,`parking`,`1` FROM `new_table` WHERE name = '" . mysqli_real_escape_string($conn, $x) . "'";
		$temporary = mysqli_query($conn, $query);
		$temporary = mysqli_fetch_array($temporary, MYSQLI_ASSOC);
		$temp = round($np - $temporary['1'] * $np);
		if ($np != 0) {
			$percentage = 1 - ($temp / $np);
}

$query = "UPDATE `new_table` SET parking = '$temp' , `percentage` = '$percentage'  WHERE name = '" . mysqli_real_escape_string($conn, $x) . "'";

if ($conn->query($query)) { } else {
	echo "Error  " . mysqli_error($conn);
}

$resarray = array();
$query = "SELECT `name`,`parking`,`percentage` FROM `new_table`";

$res = mysqli_query($conn, $query);

		
		
while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
	array_push($resarray, $row);
}

print_r(json_encode($resarray));
}

if ($flag==1){

	$percentage = 0;
	$query = "SELECT `name`,`parking`,`1` FROM `new_table` WHERE name = '" . mysqli_real_escape_string($conn, $x) . "'";
	$temporary = mysqli_query($conn, $query);
	$temporary = mysqli_fetch_array($temporary, MYSQLI_ASSOC);
	$temp = round($temporary['parking'] - $kz * $temporary['parking']);
	if ($temporary['parking'] != 0) {
		$percentage = 1 - ($temp / $temporary['parking']);
	}

	$query = "UPDATE `new_table` SET parking = '$temp', `1` = '$kz' , `percentage` = '$percentage'  WHERE name = '" . mysqli_real_escape_string($conn, $x) . "'";

	if ($conn->query($query)) { } else {
		echo "Error  " . mysqli_error($conn);
	}

	$resarray = array();
	$query = "SELECT `name`,`parking`,`percentage` FROM `new_table`";

	$res = mysqli_query($conn, $query);



	while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
		array_push($resarray, $row);
	}

	print_r(json_encode($resarray));

}

?>