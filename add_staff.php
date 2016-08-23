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

$name = test_input($_POST["name"], $con);
$id = test_input($_POST["id"], $con);
$pass = test_input($_POST["pass"], $con);
$dept = test_input($_POST["dept"], $con);
$priv = test_input($_POST["priv"], $con);

$error = "";

if($name == "" || !preg_match('/^[0-9a-zA-Z ]+$/', $name)) {
	$error = $error . " Name can have alphabets, numbers and space.";
}
if($id == "" || !ctype_alnum($id)) {
	$error = $error . " Login Id can have only alphabets and numbers.";
}
if($pass == "" || !ctype_alnum($pass)) {
	$error = $error . " Password can have only alphabets and numbers.";
}
if($dept == "" || !ctype_alnum($dept)) {
	$error = $error . " Department can have only alphabets and numbers.";
}
if($priv == "" || !ctype_alnum($priv)) {
	$error = $error . " Privilege can have only alphabets and numbers.";
}

if($error != "") {
	echo $error;
	exit;
}

$sql = "SELECT * from staff WHERE staff_login_id = '$id'";
$res = mysqli_query($con,$sql);

if (mysqli_num_rows($res) > 0) {
	$row = mysqli_fetch_array($res);
	echo "A Staff with same Login Id exists in " . $row["dept"] . ". Please select some different Login Id";
	exit;
}

$sql = "INSERT INTO staff values('$name','$id','$pass','$dept','$priv')";
$res = mysqli_query($con,$sql);

if($res)
	echo "Success";
else
	echo "Error: Could not insert in database";

?>