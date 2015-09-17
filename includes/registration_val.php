<?php session_start();
require_once('initialize.php');
$errors = [];
$user_data = [];
if(isset($_POST['submit'])){
	// get the value of user_type
	$user_type = (int)$_POST["user_type"];
	// assign user_type to user_data array..
	$user_data['user_type'] = $user_type;
	// check for the presence of a user_name
	if(has_presence($_POST["user_name"])) {
		$user_name = htmlspecialchars($_POST["user_name"]);
		$user_data['user_name'] = $user_name;
	} else {
		$user_name = "";
		$errors[] = "Please enter your Artist name or real name.";
	}
	// check for the presence of an email
	if(has_presence($_POST['user_email'])) {
    // make sure email is valid
    if(is_valid_email($_POST['user_email'])) {
      // assign clean, valid 'email' variable
      $user_email = htmlspecialchars($_POST['user_email']);
			$user_data['user_email'] = $user_email;
    } else {
      $user_email = htmlspecialchars($_POST['user_email']);
      $errors[] = "Please enter a valid email address";
    }
  } else {
    $user_email = "";
    $errors[] = "Please enter an email address";
  }
	// check for presence of a password
	if(has_presence($_POST['user_password'])) {
		// make sure its at least 7 characters long
		if(has_min_length($_POST['user_password'],7)) {
			// check for presence of a conf_password
			if(has_presence($_POST['conf_password'])) {
				// compare the two password for exactness
				if(is_exact($_POST['user_password'], $_POST['conf_password'])) {
					// passwords match
					$user_password = htmlspecialchars($_POST['conf_password']);
					$conf_password = htmlspecialchars($_POST['conf_password']);
					// hash protect password
					$hash_password = password_hash($user_password, PASSWORD_DEFAULT);
					$user_data['user_password'] = $hash_password;
				} else {
					$user_password = "";
					$conf_password = "";
					$errors[] = "Your passwords didn't match";
				}
			} else {
				$user_password = htmlspecialchars($_POST['user_password']);
				$conf_password = "";
				$errors[] = "Please confirm your password";
			}
		} else {
			$user_password = htmlspecialchars($_POST['user_password']);
			$conf_password = "";
			$errors[] = "Your password has to be at least 7 characters long";
		}
	} else {
		$user_password = "";
		$conf_password = "";
		$errors[] = "Please enter a password";
	}
	// if no errors, proceed to database
	if(empty($errors)){
		// check if email is unique
		if(has_rows(unique_email($user_email))) {
			$messages[] = "That email address has already been registered.";
			echo json_encode($messages);
		} else {
			// insert user into the database
			if(insert_user($user_data)) {
				// success
				// $messages[] = "Thanks for registering";
				$_SESSION['user_id'] = last_inserted_id($db);
				$_SESSION['username'] = $user_data['user_name'];
				$_SESSION['permission'] = 0;
				$_SESSION['logged_in'] = true;
				// $messages[] = true;
				// echo json_encode($messages);

				// NOTE: Send Registration Email
				$to = $user_email;
				$subject = "Thanks for Registering, {$user_name}!";
				$from = "Songfarm"; // not a valid email here..probably needs to be
				$message = // <<<< special html block >>>>

				$headers = "From: {$from}\r\n"; // need an email here
				$headers.= "Reply-to: {$email}\r\n"; // songfarm email
				$headers.= "Bcc: David Gaskin <davidburkegaskin@gmail.com>\r\n";
				$headers.= "MIME-Version: 1.0\r\n";
				$headers.= "Content-Type: text/plain; charset=utf-8";
				$result = mail($to, $subject, $message, $headers, '-fsongfarm'); // 5th arg. possible bug
				if(!$result){
					return false; // error log the message
				}
			} else {
				// failure
				$messages[] = "There was an error inserting into the database.";
				echo json_encode($messages);
			}
		}
	} else { // if there were $errors
		$messages[] = "There were errors in the form.";
		echo json_encode($messages);
	}
} else {
	$user_name = $user_email = $user_password = $conf_password = $messages = "";
}
?>
