<?php
session_start();
include 'database.php';

$name = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	// collect login form submission
	$username 	= mysqli_real_escape_string($db, $_POST['username']);
	$useremail 	= filter_var($_POST["username"],FILTER_SANITIZE_EMAIL);
	$password 	= mysqli_real_escape_string($db, $_POST['password']);


	// check that the user name exists
	$query 	= "SELECT id FROM sign_up WHERE artist_name = '$username' OR artist_email = '$useremail'";
	$result = mysqli_query($db, $query);


	if(!mysqli_num_rows($result))
	{
		echo 'That user doesn\'t exist';
	}
	else
	{
		// retrieve existing password based on username
		$query 	= "SELECT artist_password, artist_name FROM sign_up WHERE artist_name = '$username' OR artist_email = '$useremail'";
		$result = mysqli_query($db, $query);

		$fetched_array = mysqli_fetch_array($result);
		$retrieved_password = $fetched_array['artist_password'];
		$session_name = $fetched_array['artist_name'];

		// verify password
		if( password_verify($password, $retrieved_password) ) {
			$_SESSION['username'] = $session_name;
			header('location: loggedIn.php');
		}
		else {
			echo 'Your password is incorrect';
			$name = $username;
		}
	}
}


?>
