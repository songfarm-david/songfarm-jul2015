<?php

class User extends MySQLDatabase{

	public $timezone;

	public function has_timezone($user_id){
		global $db;

		$sql = "SELECT timezone FROM user_timezone WHERE user_id = {$user_id}";
		$result = $db->query($sql);
		if($db->has_rows($result) > 0){
			$row = $db->fetch_array($result);
			return $this->timezone = $row['timezone']; 
		} else {
			return false;
		}
	}

	public function insert_timezone($user_id, $timezone){
		global $db;

		$sql = "INSERT INTO user_timezone (user_id, timezone) ";
		$sql.= "VALUES ($user_id, '$timezone')";
		if($result = $db->query($sql)){
			echo "Result";
		}
	}

}

$user = new User;

?>
