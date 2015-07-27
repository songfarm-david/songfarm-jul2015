<?php

if ($_POST){
	// get the value of user_type
	$userType = implode($_POST["user_type"]);

	// get and sanitize user name
	$userName = filter_var($_POST["user_name"],FILTER_SANITIZE_STRING);
	$userName = filter_var($userName,FILTER_SANITIZE_SPECIAL_CHARS);

	// get and sanitize email
	$userEmail = filter_var($_POST["user_email"],FILTER_SANITIZE_EMAIL);

	if($userName && $userEmail){
		$message = 'Thanks for Registering!';
		echo $message;
	}else{
		$message = 'There was a problem with your registration.<Br> Please try again.';
		echo $message;
	}


} // end of if $_SERVER["REQUEST_METHOD"] == "POST"

?>
