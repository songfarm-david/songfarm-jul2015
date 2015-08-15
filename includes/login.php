<?php
session_start();
include 'db_connect.php';

$name 	= "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

	$username 	= mysqli_real_escape_string($db, $_POST['username']);
	$useremail 	= filter_var($_POST["username"],FILTER_SANITIZE_EMAIL);
	$password 	= mysqli_real_escape_string($db, $_POST['password']);

	if(!empty($username) || !empty($useremail) && !empty($password)){
		// check that the user name exists
		$query 	= "SELECT id FROM registree_info WHERE user_name = '$username' OR user_email = '$useremail'";
		$result = mysqli_query($db, $query);

		if(!mysqli_num_rows($result))
		{
			echo 'Sorry. We don\'t have any users by that name';
		}
		else
		{
			// retrieve existing password based on username
			$query 	= "SELECT user_password, user_name FROM registree_info WHERE user_name = '$username' OR user_email = '$useremail'";
			$result = mysqli_query($db, $query);

			$fetched_array = mysqli_fetch_array($result);
			$retrieved_password = $fetched_array['user_password'];
			$session_name = $fetched_array['user_name'];

			// verify password
			if( password_verify($password, $retrieved_password) ) {
				$message[] = $_SESSION['username'] = $session_name;
				$message[] = true;
				echo json_encode($message);
			}
			else {
				$message = 'Your password is incorrect';
				echo json_encode($message);
				$name = $username;
			}
		}
	} else {
		$errMsgPass = 'There was an error logging you in. Please refresh the page and confirm your details before trying again';
	}

}


?>
