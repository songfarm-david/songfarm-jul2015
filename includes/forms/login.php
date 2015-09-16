<?php
if(isset($_POST['submit'])) {
	// check if value is present as is email
	if(has_presence(is_valid_email($_POST['username']))) {
		// sanitize username
		$username = escape_value($_POST['username']);
	}	elseif(has_presence($_POST['username'])) {
		// sanitize username
		$username = escape_value($_POST['username']);
	} else {
		$username = "";
		$errors[] = "Please enter your username or email to log in";
	}
	// check for presence of password
	if(has_presence($_POST['password'])) {
		//sanitize password
		$password = escape_value($_POST['password']);
	} else {
		$errors[] = "Please enter your password";
	}
	// if $errors array is empty
	if(empty($errors)){
		// check that username exists
		if(has_rows($result = user_name_exists($username))) {
			// fetch result information
			$result = fetch_array($result);
			// compare passwords
			if(password_verify($password, $result['user_password'])) {
				$_SESSION['id'] = $result['id'];
				$_SESSION['username'] = $result['user_name'];
				$messages[] = true;
				echo json_encode($messages);
			} else {
				$messages[] = "Incorrect password";
				// echo json_encode($messages);
			}
		} else {
			// no result found
			$messages[] = "The username you entered is not registered";
			// echo json_encode($messages);
		}
	} // end of: if(empty($errors))
} else { // end of: isset($_POST['submit'])
	$username = "";
}
?>
<?php if(!empty($errors)) { ?>
	<ul>
<?php	foreach ($errors as $error) {
				echo "<li>{$error}</li>";
			} ?>
	</ul>
<?php } ?>
<!-- Login form -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"id="login-form" class="hide">
	<input type="text" name="username" placeholder="Artist Name or Email" value="<?php echo $username ?>" required>
	<input type="password" name="password" placeholder="Enter your Password" required>
	<input type="submit" value="Log In" name="submit" id="submitLogIn">
	<span id="login-error">
	<?php if(!empty($messages)) {
					foreach ($messages as $message) {
						echo $message;
					}
				} ?>
	</span>
</form>
