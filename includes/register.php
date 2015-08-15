<?php include ('db_connect.php');

session_start();

if ($_POST){
	// get the value of user_type
	$userType = $_POST["user_type"];

	// get and sanitize user name
	$userName = filter_var($_POST["user_name"], FILTER_SANITIZE_STRING);
	$userName = filter_var($userName, FILTER_SANITIZE_SPECIAL_CHARS);

	// get and sanitize email
	$userEmail = filter_var($_POST["user_email"],FILTER_SANITIZE_EMAIL);

	$userPass = mysqli_real_escape_string($db, $_POST['conf_password']);
	$hashPass = password_hash($userPass, PASSWORD_DEFAULT);

	if($userType && $userName && $userEmail && $hashPass){
		// check to see that the email is unique
		$query = "SELECT id FROM registree_info WHERE user_email = '$userEmail'";
		$result = mysqli_query($db, $query) or trigger_error("Query: $query \n <br /> MySql Error: " . mysqli_errno($db));
		if(!mysqli_num_rows($result)){
			// if no email match
			// insert values into database
			$query 	= "INSERT INTO registree_info (user_type, user_name, user_email, user_password, reg_date) ";
			$query .= "VALUES ($userType, '$userName', '$userEmail', '$hashPass', NOW() )";
			$result = mysqli_query($db, $query) or trigger_error("Query: $query \n <br /> MySql Error: " . mysqli_errno($db));
			if($result){
				$message[] = "Thanks for Registering!";
				$message[] = $_SESSION['username'] = $userName;
				$message[] = true;
				echo json_encode($message);
			} else {
				$message[] = "Something went wrong with your registration. Please try back later.";
				echo json_encode($message);
			}
		} else {
			$message[] = 'It seems that your email has already been registered. Try logging in.';
			echo json_encode($message);
		}

	} // end of if ($userType && $userName && $userEmail)

} // end of if $_SERVER["REQUEST_METHOD"] == "POST"

?>
