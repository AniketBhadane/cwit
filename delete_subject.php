<?php

function test_input($data, $con)
{
	$data = trim($data);
	$data = htmlspecialchars($data);
	$data = ltrim($data, '\\');
	$data = ltrim($data, '/');
	$data = mysqli_real_escape_string($con, $data);
	return $data;
}

include 'db_config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

$dept = test_input($_POST["dept"], $con);
$year = test_input($_POST["year"], $con);
$subject = test_input($_POST["subject"], $con);

$link;

if($dept!="" and $year!="" and $subject!="") {
	$link = "uploads\\" . $dept . "\\" . $year . "\\" . $subject . "\\";
} else {
	echo "Error: Either of parameters are missing";
	exit;
}


if( !is_dir($link) ) {
	echo "Error: Directory does not exist";
	exit;
}


$sql = "SELECT subjects from curr_subjects WHERE dept = '$dept' AND year = '$year'";
$res = mysqli_query($con,$sql);

$row = mysqli_fetch_array($res);

if($row != null) {
	$result = explode(',', $row[0]);

	$index = array_search($subject, $result);
	
	unset($result[$index]);
	
	$result = implode(",", $result);
		
	$sql = "UPDATE curr_subjects SET subjects = '$result' WHERE dept = '$dept' AND year = '$year'";
	$res = mysqli_query($con,$sql);
	
	if($res)
	{
		if(delTree($link)) {
			echo "Success";
		} else {
			echo "Error: Directory could not be deleted";
		}
	} else {
		echo "Database update failure";
	}
	
	//echo $result;
} else {
	echo "Error: dept year not correct";
}


function delTree($dir) { 
	$files = array_diff(scandir($dir), array('.','..')); 
	foreach ($files as $file) { 
	  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	} 
	return rmdir($dir); 
} 

?>