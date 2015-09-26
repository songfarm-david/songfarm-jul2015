<?php require_once('database.php');

class validateLogin extends MySQLDatabase{

	public $username;
	protected $password;
	public $errors = [];

	public function validateUser($username, $password){
		global $db;
		if($this->validateUsername($username) && $this->validatePassword($password)){
			// success
			if($db->has_rows($result = $db->user_name_exists($this->username))){
				$result = $db->fetch_array($result);
				if(password_verify($this->password, $result['user_password'])){
					$_SESSION['user_id'] = $result['user_id'];
					$_SESSION['username'] = $result['user_name'];
					$_SESSION['permission'] = $result['permission'];
					// the following checks to see if the response is an Ajax response.
					if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
						// ajax message
						echo false;
					} else {
						redirect_to('../public/workshop.php');
					}
				} else {
					echo $this->errors[] = "Incorrect password";
				}
			} else {
				echo $this->errors[] = "Username doesn't exist";
			}
		}
	}

	private function validateUsername($username) {
		global $db;
		if($this->has_presence($db->is_valid_email($username))){
			return $this->username = $db->escape_value($_POST['username']);
		} elseif ($this->has_presence($username)) {
			return $this->username = $db->escape_value($_POST['username']);
		} else {
			echo $this->errors[] = "Please enter your username or email to log in";
			return $this->username = "";
		}
	}

	private function validatePassword($password) {
		global $db;
		if($this->has_presence($password)){
			return $this->password = $db->escape_value($_POST['password']);
		} else {
			echo $this->errors[] = "Please enter your password";
		}
	}

	protected function has_presence($value) {
		$value = trim($value);
		if(isset($value) && !empty($value)){
			return $value;
		}
	}

	// protected function is_valid_email($email) {
	// 	return filter_var($email, FILTER_VALIDATE_EMAIL);
	// }



}

?>
