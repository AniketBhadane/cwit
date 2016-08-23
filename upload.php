<?php

define("UPLOAD_DIR", "uploads\\");

if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR);
}

/*
print_r($_POST);
print_r($_FILES);
*/

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$errorMsg = "Missing";

	if(empty($_POST["dept"]))
		$errorMsg = $errorMsg . " Department,";
	if(empty($_POST["year"]))
		$errorMsg = $errorMsg . " Year,";
	if(empty($_POST["subject"]))
		$errorMsg = $errorMsg . " Subject,";
	if(empty($_POST["chapter"]))
		$errorMsg = $errorMsg . " Chapter,";
	if(empty($_FILES["myFile"]["name"]))
		$errorMsg = $errorMsg . " File,";
		
	if($errorMsg == "Missing") {  // i.e. no text after Missing, means nothing is missing

		function test_input($data)
		{
			 $data = trim($data);
			 $data = stripslashes($data);
			 $data = htmlspecialchars($data);
			 //$data = mysqli_real_escape_string($data);
			 return $data;
		}

		$dept = test_input($_POST["dept"]);
		$year = test_input($_POST["year"]);
		$subject = test_input($_POST["subject"]);
		$chapter = test_input($_POST["chapter"]);

		if ($_FILES["myFile"]["error"] !== UPLOAD_ERR_OK) {
			echo "An error occurred: ". $_FILES["myFile"]["error"];
		}

		// ensure a safe filename
		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $_FILES["myFile"]["name"]);

		// don't overwrite an existing file
		/*$i = 0;
		$parts = pathinfo($name);
		while (file_exists(UPLOAD_DIR . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];  // create file with new name zzzz-1.pdf
		}*/

		$dest_path = UPLOAD_DIR . $dept . "\\" . $year . "\\" . $subject . "\\" . $chapter . "\\" . $name;
		
		if(file_exists($dest_path)) {
			echo "A file with same name $name exists in this directory. Please delete it first and then try to upload.";
		}
		else {
			// preserve file from temporary directory
			$success = move_uploaded_file($_FILES["myFile"]["tmp_name"], $dest_path);
			if (!$success) { 
				echo "Unable to save file";
			}
			else {
				echo "Success";
			}
		}
		
		// set proper permissions on the new file
		//chmod(UPLOAD_DIR . $name, 0644);
	}
	else {
		echo rtrim($errorMsg, ",");
	}
		
}

/*
$_FILES["myFile"]["name"] stores the original filename from the client
$_FILES["myFile"]["type"] stores the file’s mime-type
$_FILES["myFile"]["size"] stores the file’s size (in bytes)
$_FILES["myFile"]["tmp_name"] stores the name of the temporary file
$_FILES[“myFile”][“error”] stores any error code resulting from the transfer
*/

?>