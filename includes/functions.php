<?php

function redirect_to($location) {
	header("Location: " . $location);
	exit;
}

// database functions
function user_name_exists($username) {
	$sql = "SELECT * FROM registree_info ";
	$sql.= "WHERE user_name = '{$username}'";
	$sql.= " OR user_email = '{$username}'";
	return query_db($sql);
}

function unique_email($email) {
	$sql = "SELECT * FROM registree_info ";
	$sql.= "WHERE user_email='{$email}' ";
	$sql.= "LIMIT 1";
	return query_db($sql);
}

function insert_user($array=[]) {
	escape_values($array);
	$sql = "INSERT INTO registree_info (";
	$sql.= join(", ", array_keys($array)).", reg_date";
	$sql.= ") VALUES ('";
	$sql.= join("', '",array_values($array))."', NOW())";
	return query_db($sql);
}

function query_db($sql) {
	global $db;
	$result = mysqli_query($db, $sql) or die("Query failed.");
	confirm_query($result);
	return $result;
}

function confirm_query($result) {
	global $db;
	if(!$result) {
	 die("Database query failed " . mysqli_error($db));
 	}
}

function escape_value($value) {
	global $db;
	return $value = mysqli_real_escape_string($db, $value);
}

function escape_values($array=[]) {
	global $db;
	foreach ($array as $key => $value) {
		return $array[$key] = mysqli_real_escape_string($db, $value);
	}
}

function has_rows($result) {
	return mysqli_num_rows($result);
}

function fetch_array($result) {
	return mysqli_fetch_assoc($result);
}

function last_inserted_id($db){
	return mysqli_insert_id($db);
}

// validation functions
function has_presence($value) {
	return isset($value) && !empty(trim($value));
	// returns TRUE if value ISSET && value is NOT EMPTY after TRIM
}

function has_min_length($value, $min=2) {
	return strlen($value) >= $min;
}

function is_valid_email($email) {
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function is_exact($value1, $value2) {
	return $value1 === $value2;
}
?>
