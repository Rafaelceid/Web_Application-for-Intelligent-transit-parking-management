<?php
include 'upload/conecto_database.php';

$sql="DROP TABLE `availability`";
if (mysqli_query($conn, $sql)){
}
else {
    echo ("Error creating database: " . mysqli_error($conn));
};
$sql = "DROP TABLE IF EXISTS coordinates";
mysqli_query($conn, $sql);
$sql = "DROP TABLE IF EXISTS new_table";
mysqli_query($conn, $sql);
$sql = "DROP TABLE IF EXISTS tbl_info";
mysqli_query($conn, $sql);

?>