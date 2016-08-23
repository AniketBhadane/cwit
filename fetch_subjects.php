<?php
error_reporting(0);

$dept = $_POST["dept"];
$year = $_POST["year"];

include 'db_config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$sql = "SELECT subjects from curr_subjects WHERE dept = '$dept' AND year = '$year'";
$res = mysqli_query($con,$sql);

$row = mysqli_fetch_array($res);
$result = explode(',', $row[0]);

echo json_encode($result);

?>