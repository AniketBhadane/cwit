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

if($subject == "" || !ctype_alnum($subject)) {
	echo "Please enter valid subject name. Only alphabets and numbers allowed.";
	exit;
}

$link;

if($dept!="" and $year!="") {
	$link = "uploads\\" . $dept . "\\" . $year . "\\" . $subject . "\\";
} else {
	echo "Error: Either of dept and year are missing";
	exit;
}

$sql = "SELECT subjects from curr_subjects WHERE dept = '$dept' AND year = '$year'";
$res = mysqli_query($con,$sql);

$row = mysqli_fetch_array($res);

if($row != null) {
	$result = explode(',', $row[0]);
	
	if(in_array($subject, $result)) {
		echo "Subject already exists";
		exit;
	}

	
	if(sizeof($result) == 1 && $result[0] == "" ) {  // first element of array
		$result = array($subject);
	}
	else {
		array_push($result, $subject);
	}
	
	
	$sub = implode(",", $result);
		
	$sql = "UPDATE curr_subjects SET subjects = '$sub' WHERE dept = '$dept' AND year = '$year'";
	$res = mysqli_query($con,$sql);
	
	if($res)
	{
		if (!is_dir($link)) {
			mkdir($link);
			mkdir($link . "\\ch1\\");
			mkdir($link . "\\ch2\\");
			mkdir($link . "\\ch3\\");
			mkdir($link . "\\ch4\\");
			mkdir($link . "\\ch5\\");
			mkdir($link . "\\ch6\\");
			echo "Success";
		} 
	} else {
		echo "Database update failure";
		exit;
	}
	
	//echo $result;
} else {
	echo "Error: dept year not correct";
	exit;
}


?>