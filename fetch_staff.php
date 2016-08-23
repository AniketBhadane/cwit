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

$dept = test_input($_POST["dept"], $con);

if($dept == "" OR $dept == null) {
	exit;
}

$sql = "SELECT * from staff WHERE dept = '$dept'";
$res = mysqli_query($con,$sql);

$result = array();

while($row = mysqli_fetch_array($res)){
	array_push($result,
		array('Name'=>$row[0],
			'Id'=>$row[1],
			'Privilege'=>$row[4]
	));
}
echo json_encode($result);

?>