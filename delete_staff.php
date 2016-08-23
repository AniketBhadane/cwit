<?php

function test_input($data, $con)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = mysqli_real_escape_string($con, $data);
	return $data;
}

include 'db_config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

$id = test_input($_POST["id"], $con);

if($id == "" OR $id == null)
	exit;
	
$sql = "DELETE from staff WHERE staff_login_id = '$id'";
$res = mysqli_query($con,$sql);

if($res) {
	
	echo "Success";
		
} else {
	echo "Error: Database record deletion failed";
}

?>