<?php
include 'conecto_database.php';
$username = $_POST['username'];
$password = $_POST['password'];


$username = stripcslashes($username);
$password = stripcslashes($password);


$username = mysqli_real_escape_string($conn,$username);
$password = mysqli_real_escape_string($conn, $password);
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'LIMIT 1";
$result = mysqli_query($conn,$sql) or die("Lathos query".mysql_error());
$row = mysqli_fetch_array($result,MYSQLI_BOTH);

if ($row['username'] == $username && $row['password'] == $password)
	{
		 header('Location: http://localhost/Rousoi/ProjectWeb/login/browse_file/browse_file.html');

	}
else
	{
 		echo "failed";
	}
	
?>