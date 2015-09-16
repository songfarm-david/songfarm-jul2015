<?php
// 1. Connect to the database
	$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	if(mysqli_connect_errno()) {
		// mysqli_connect_errno() returns 0 if there was no error - zero equates to false
		die("Database connection failed: " . mysqli_connect_error() . " (Error #" . mysqli_connect_errno() . ")");
	}

?>
