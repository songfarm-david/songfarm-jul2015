<?php require_once('initialize.php');

class MySQLDatabase{

	protected $connection;

	function __construct() {
		$this->open_connection();
	}

	function __destruct() {
		$this->close_connection();
	}

	private function open_connection(){
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		if(mysqli_connect_errno()) {
			die("Database connect failed: " .
					mysqli_connect_error() .
					" (" . mysqli_connect_errno() . ")"
			);
		}
	}

	private function close_connection(){
		if(isset($this->connection)){
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}

	private function confirm_query($result) {
		if(!$result) {
			die("Database query failed." . mysqli_error($this->connection));
		}
	}

	public function escape_value($value) {
		return $value = mysqli_real_escape_string($this->connection, $value);
	}

	function escape_values($array=[]) {
		foreach ($array as $key => $value) {
			return $array[$key] = mysqli_real_escape_string($this->connection, $value);
		}
	}

	function user_name_exists($username) {
		$sql = "SELECT * FROM user_register ";
		$sql.= "WHERE user_name = '{$username}'";
		$sql.= " OR user_email = '{$username}'";
		return $this->query($sql);
	}

	function has_rows($result) {
		return mysqli_num_rows($result);
	}

	function fetch_array($result) {
		return mysqli_fetch_assoc($result);
	}

	function insert_user($array=[]) {
		$this->escape_values($array);
		$sql = "INSERT INTO user_register (";
		$sql.= join(", ", array_keys($array)).", reg_date";
		$sql.= ") VALUES ('";
		$sql.= join("', '",array_values($array))."', NOW())";
		return $this->query($sql);
	}

	function last_inserted_id(){
		return mysqli_insert_id($this->connection);
	}

	function is_valid_email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	function unique_email($email) {
		$sql = "SELECT * FROM user_register ";
		$sql.= "WHERE user_email='{$email}' ";
		$sql.= "LIMIT 1";
		return $this->query($sql);
	}

}

$db = new MySQLDatabase;

?>
