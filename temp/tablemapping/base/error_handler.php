<?php

function error_handler($level, $error, $file, $line)
{
	if (error_reporting() == 0) return;
	if (strpos($file, "parser.php") != false) return;
	$des = strip_tags($error) . " in file $file on line $line";
	echo json_encode(array('error' =>  $des));
	exit;
};

set_error_handler('error_handler');

?>