<?php include ('db_connect.php'); ?>
<?php

if ($_POST){
	// get the value of user_type
	$userType = $_POST["user_type"];

	// get and sanitize user name
	$userName = filter_var($_POST["user_name"],FILTER_SANITIZE_STRING);
	$userName = filter_var($userName,FILTER_SANITIZE_SPECIAL_CHARS);

	// get and sanitize email
	$userEmail = filter_var($_POST["user_email"],FILTER_SANITIZE_EMAIL);

	if($userType && $userName && $userEmail){
		// check to see that the email is unique
		$query = "SELECT id FROM registree_info WHERE user_email = '$userEmail'";
		$result = mysqli_query($db, $query) or trigger_error("Query: $query \n <br /> MySql Error: " . mysqli_errno($db));
		if(!mysqli_num_rows($result)){
			// if no email match
			// insert values into database
			$query 	= "INSERT INTO registree_info (user_type, user_name, user_email, reg_date) ";
			$query .= "VALUES ($userType, '$userName', '$userEmail', NOW() )";
			$result = mysqli_query($db, $query) or trigger_error("Query: $query \n <br /> MySql Error: " . mysqli_errno($db));
			if($result){
				echo "Thanks for Registering!";
			} else {
				echo "Something went wrong with your registration. Please try back later.";
			}
		} else {
			echo 'You have already registered with that email.';
		}

	} // end of if ($userType && $userName && $userEmail)

} // end of if $_SERVER["REQUEST_METHOD"] == "POST"

?>
