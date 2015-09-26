<?php require_once('initialize.php');

class userProfile{

	public $username;

	public function retrieveUserData($profile_id){
		global $db;
		$sql = "SELECT user_id, user_type, user_name, user_email, reg_date ";
		$sql.= "FROM user_register ";
		$sql.= "WHERE user_id = $profile_id";
		$result = $db->query($sql);
		$user_array = $db->fetch_array($result);
		$this->username = $user_array['user_name'];
	}

}



 ?>
