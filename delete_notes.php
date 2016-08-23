<?php

function test_input($data)
{
     $data = trim($data);
     $data = htmlspecialchars($data);
	 //$data = mysqli_real_escape_string($data);
     return $data;
}

$link = test_input($_POST["link"]);

if(unlink($link)) {
	echo "Success";
} else {
	echo "Error";
}

?>