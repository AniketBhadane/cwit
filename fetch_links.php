<?php
error_reporting(0);

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
$subj_code = test_input($_POST["subj_code"]);

if( empty($dept) || empty($year) || empty($subj_code) ) {
	exit;
}

$links = array();

/*register_shutdown_function('shutdown');
function shutdown()
{
    // This is our shutdown function for fatal errors (if directory does not exist), in 
    // here we can do any last operations
    // before the script is complete.
    echo json_encode();
}*/

$path = "uploads\\$dept\\$year\\$subj_code";
$di = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
    //echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';	
	array_push($links, $filename);
}

/*
$directory = '/path/to/my/directory';
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
//such directories 1-6 for 6 folders/chapters, and create them in array: $links = array(sd1,sd2,..,sd6);
*/

echo json_encode($links);

?>