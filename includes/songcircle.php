<?php require_once('initialize.php');

class Songcircle extends MySQLDatabase{

	public $user_id;
	public $songcircle_name="Songfarm Open Songcircle";
	public $date_of_songcircle;
	public $participants=3;
	public $message;

	protected $songcircle_id;
	protected $songcircle_permission=0;

	public function open_songcircle_exists(){
		//if no open songcircles exist, then call create_open_songcircle function
		// query database for a record of user_id 0. if no rows come back, then run the create method.
		global $db;
		$sql = "SELECT songcircle_id, participants, date_of_songcircle FROM songcircle_create WHERE user_id = 0";
		$result = $db->query($sql);
		if($result){
			$result_array = $db->fetch_array($result);
			$row = $db->has_rows($result);
			if($row == 1){
				// find out when max participants hits..
				$this->open_songcircle_reached_max_parts($result_array['participants'], $result_array['songcircle_id'], $result_array['date_of_songcircle']);
			} elseif(!$row) {
				// if no rows, create a new one
				$this->create_open_songcircle($result_array['date_of_songcircle']);
			}
		}
	}

	private function create_open_songcircle($last_scheduled_time){
		global $db;

		$last_scheduled_time; // returns 2015-10-04 13:00:00
		/* must find a way to take that time and add a week to it */

		$dt = new DateTime();
		$dt->setDate(2015, 9, 27);
		$dt->modify('+1 week');
		$dt->setTime(13,0);
		$date = $dt->format('Y-m-d\TH:i:00');

		$this->user_id=0;
		$this->songcircle_id = uniqid('');
		$this->date_of_songcircle = $date;

		$sql = "INSERT INTO songcircle_create (";
		$sql.= "user_id, songcircle_id, songcircle_name, date_of_songcircle, songcircle_permission, participants";
		$sql.= ") VALUES (";
		$sql.= "'$this->user_id', '$this->songcircle_id', '$this->songcircle_name', '$this->date_of_songcircle', '$this->songcircle_permission', $this->participants)";
		if($db->query($sql)) {
			// success
			$this->message = "Success! New Songcircle scheduled.";
		}
	}

	function open_songcircle_reached_max_parts($max_participants, $songcircle_id, $date_of_songcircle){
		global $db;
		// if open songcircle reaches max participants then create a new one
		$reg_participants = $this->num_of_parts($songcircle_id);
		if($reg_participants == $max_participants){
			return $this->create_open_songcircle($date_of_songcircle);
		}
	}

	function remove_expired_songcircles(){
		// 3 hours past active songcircle OR when songcircle ends, remove it from database and list
		// log record of past songcircles
	}

	public function display_songcircles(){
		global $db;
		$sql = "SELECT ";
		$sql.= "songcircle_id, date_of_songcircle, songcircle_name, ";
		$sql.= "songcircle_permission, participants, user_register.user_id, user_name ";
		$sql.= "FROM songcircle_create, user_register ";
		$sql.= "WHERE songcircle_create.user_id = user_register.user_id";
		if(!$result = $db->query($sql)){
			echo "Error retrieving songcircles";
		} elseif($db->has_rows($result) == 0) {
			echo $this->message = "No songcircles currently scheduled. Why don't you be the first and create one now?";
		} else {
			// display the songcircles
			$output = "<table>";
			while ($row = $db->fetch_array($result)) {
					$output.= "<tr>";
					$output.= "<input type=\"hidden\" data-conference-id=\"" .$row['songcircle_id']. "\">";
					$output.= "<td class=\"date\">" .date("l, F jS, Y -<\b\\r> g:i A", strtotime($row['date_of_songcircle'])).' GMT'."</td>";
					// $output.= "<td class=\"type\"><span class=\"permission\">".$row['songcircle_permission']."</span>&nbsp;";
					$output.= "<td class=\"type\">".$row['songcircle_name']."<br><span class=\"registered\"> (".$this->num_of_parts($row['songcircle_id'])." of " .$row['participants']. " participants registered)</span></td>";
					$output.= "<td class=\"created\">Created by: <br><a href=\"profile.php?id=".$row['user_id']."\">".$row['user_name']."</a></td>";
					// check to see if registered users equals max users
					if($this->is_full_songcircle($row['participants'], $this->num_of_parts($row['songcircle_id'])) && $this->is_not_registered($row['songcircle_id'])){
						$output.= "<td class=\"cannot_register\"><input type=\"submit\" value=\"Register\"></td>";
					} else {
						$output.= "<td><form method=\"post\" action=".$_SERVER['PHP_SELF'].">";
						$output.= "<input type=\"hidden\" name=\"songcircle_id\" value=\"".$row['songcircle_id']."\">";
						$output.= "<input type=\"hidden\" name=\"songcircle_name\" value=\"".$row['songcircle_name']."\">";
						$output.= "<input type=\"submit\"".$this->is_registered($row['songcircle_id']);
						$output.= "</form>";
					}
					// delete button if created user is logged in user
					if($_SESSION['user_id'] == $row['user_id']){
						$output.= "<br><span class=\"delete\"><a href=\"../includes/delete_songcircle.php?songcircle_id=".$row['songcircle_id']."\">Delete</a></span>";
					}
					$output.= "</td>";
					$output.= "</tr>";
			}
			$output.= "</table>";
			echo $output;
		}
	}

	private function num_of_parts($songcircle_id){
		global $db;
		$sql = "SELECT username FROM songcircle_register WHERE songcircle_id = '$songcircle_id'";
		$rows = $db->has_rows($db->query($sql));
		return $rows;
	}

	private function is_full_songcircle($participants, $num_reg_participants){
		if($participants == $num_reg_participants){
			return true;
		} else {
			return false;
		}
	}

	function register($songcircle_id, $user_id, $username, $songcircle_name){
		global $db;

		$this->songcircle_id = $songcircle_id;
		$this->user_id = $user_id;
		$this->username = $username;
		$this->songcircle_name = $songcircle_name;

		$sql = "INSERT INTO songcircle_register (songcircle_id, user_id, username) ";
		$sql.= "VALUES ('$this->songcircle_id', $this->user_id, '$this->username')";
		if(!$result = $db->query($sql)){
			echo $message = "Failed to register you for this songcircle.";
		} else {
			$this->message = "You successfully registered for \"{$songcircle_name}\". Check your inbox for more information.";
		}
	}

	public function unregister($songcircle_id, $user_id){
		global $db;
		// delete record
		$sql = "DELETE FROM songcircle_register WHERE songcircle_id = '$songcircle_id' AND user_id = $user_id";
		// echo $sql;
		if(!$result = $db->query($sql)){
			$this->message = "Could not unregister you from this songcircle";
		}
	}

	protected function is_registered($songcircle_id){
		global $db;
		// if something is true, button says register
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT user_id FROM songcircle_register WHERE songcircle_id = '$songcircle_id' AND user_id = $user_id";
		// echo $sql . '<br>';
		if($result = $db->query($sql)){
			$rows = $db->has_rows($result);
			if($rows > 0){
				return "value=\"Unregister\" name=\"unregister\">";
			} else {
				return "value=\"Register\" name=\"register\">";
			}
		}
	}

	protected function is_not_registered($songcircle_id){
		global $db;
		$user_id = $_SESSION['user_id'];
		$sql = "SELECT user_id FROM songcircle_register WHERE songcircle_id = '$songcircle_id' AND user_id = $user_id";
		$result = $db->query($sql);
		if(!$db->has_rows($result)){
			return true;
		}
	}



	//
	// public function create_songcircle(){
	// 	global $db;
	// 	$this->user_id = $_SESSION['user_id'];
	// 	$this->songcircle_id = uniqid('');
	// 	$this->songcircle_name = mysqli_real_escape_string($db->connection, $_POST['songcircle_name']);
	// 	$this->date_of_songcircle = $_POST['date_of_songcircle'].":00";
	// 	$this->songcircle_permission = $_POST['songcircle_permission'];
	// 	$this->max_participants = $_POST['max_participants'];
	//
	// 	$sql = "INSERT INTO songcircle (";
	// 	$sql.= "user_id, songcircle_id, songcircle_name, date_of_songcircle, songcircle_permission, participants";
	// 	$sql.= ") VALUES (";
	// 	$sql.= "$this->user_id, '$this->songcircle_id', '$this->songcircle_name', '$this->date_of_songcircle', '$this->songcircle_permission', $this->max_participants)";
	// 	if($db->query($sql)) {
	// 		// success
	// 		$this->message = "Success! New Songcircle scheduled.";
	// 	}
	// }
	//
	// private function populate_songcircles($db_result){
	// 	global $db;
	// 	$this->register_value = "register";
	// 	$this->registered = "Register";
	// 	$this->participants = 0;
	// 	if($db->has_rows($db_result) == 0) {
	// 		echo $message = "No songcircles currently scheduled";
	// 	} else {
	// 		$output = "<table>";
	// 		while ($row = $db->fetch_array($db_result)) {
	// 			echo $this->get_participants($row['songcircle_id']);
	// 			$output.= "<tr>";
	// 			$output.= "<input type=\"hidden\" data-conference-id=" .$row['songcircle_id']. "\">";
	// 			$output.= "<td class=\"date\">" .date("l, F jS, Y - g:i A", strtotime($row['date_of_songcircle'])).' GMT'. "</td>";
	// 			$output.= "<td class=\"type\"><span class=\"permission\">".$row['songcircle_permission']."</span>&nbsp;";
	// 			$output.= $row['songcircle_name']."<span class=\"registered\"> (".$this->participants." of " .$row['participants']. " participants registered)</span></td>";
	// 			// $output.= "<input type=\"hidden\" data-duration=" .$row['duration']. "\">";
	// 			$output.= "<td class=\"created\">Created by: <a href=\"profile.php?id=".$row['user_id']."\">".$row['user_name']."</a></td>";
	// 			$output.= "<td class=\"register\"><form method=\"post\" action=".$_SERVER['PHP_SELF'].">";
	// 			$output.= "<input type=\"hidden\" name=\"songcircle_id\" value=\"".$row['songcircle_id']."\">";
	// 			$output.= "<input type=\"submit\" value=\"".$this->registered."\" name=\"".$this->register_value."\">";
	// 			$output.= "</input></form>";
	// 			// delete button if created user is logged in user
	// 			if($_SESSION['user_id'] == $row['user_id']){
	// 				$output.= "<br><span class=\"delete\"><a href=\"../includes/delete_songcircle.php?songcircle_id=".$row['songcircle_id']."\">Delete</a></span>";
	// 			}
	// 			$output.= "</td>";
	// 			$output.= "</tr>";
	// 		}
	// 		$output.= "</table>";
	// 		return $output;
	// 	}
	// }
	//
	public function delete_songcircle($songcircle_id){
		global $db;
		$sql = "DELETE FROM songcircle_create WHERE songcircle_id = '$songcircle_id' LIMIT 1";
		if($db->query($sql)){
			redirect_to('../public/workshop.php');
		} else {
			echo $message = "error deleting songcircle";
		}
	}
	//
	// public function register_songcircle($songcircle_id, $user_id, $username){
		// global $db;
		// $this->songcircle_id = $songcircle_id;
		// $this->user_id = $user_id;
		// $this->username = $username;
		// $sql = "INSERT INTO songcircle_register (songcircle_id, user_id, username) ";
		// $sql.= "VALUES ('$this->songcircle_id', $this->user_id, '$this->username')";
		// if(!$result = $db->query($sql)){
		// 	echo $message = "Failed to register you for this songcircle.";
		// }
	// }
	//
	// protected function get_participants($songcircle_id){
	// 	// echo "running get participants";
	// 	global $db;
	// 	$sql = "SELECT username FROM songcircle_register WHERE songcircle_id = '$songcircle_id'";
	// 	if($result = $db->query($sql)){
	// 		while($row = $db->fetch_array($result)){
	// 			if($row['username'] == $this->username){
	// 				$this->registered = 'Unregister';
	// 				$this->register_value = "unregister";
	// 			}
	// 			++$this->participants;
	// 		}
	// 	} else {
	// 		echo "no result";
	// 	}
	// }
	//

			// if(() > 0){
			//
			//
		// }

	//

}

?>
