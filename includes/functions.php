<?php

function redirect_to($location) {
	header("Location: " . $location);
	exit;
}

// database functions
/* moved this function to database.php */
// function user_name_exists($username) {
// 	$sql = "SELECT * FROM user_register ";
// 	$sql.= "WHERE user_name = '{$username}'";
// 	$sql.= " OR user_email = '{$username}'";
// 	return query_db($sql);
// }

// function unique_email($email) {
// 	$sql = "SELECT * FROM user_register ";
// 	$sql.= "WHERE user_email='{$email}' ";
// 	$sql.= "LIMIT 1";
// 	return query_db($sql);
// }

// function insert_user($array=[]) {
// 	escape_values($array);
// 	$sql = "INSERT INTO user_register (";
// 	$sql.= join(", ", array_keys($array)).", reg_date";
// 	$sql.= ") VALUES ('";
// 	$sql.= join("', '",array_values($array))."', NOW())";
// 	return query_db($sql);
// }

// function query_db($sql) {
// 	global $db;
// 	$result = mysqli_query($db, $sql) or die("Query failed." .mysqli_error($db));
// 	confirm_query($result);
// 	return $result;
// }
//
// function confirm_query($result) {
// 	global $db;
// 	if(!$result) {
// 	 die("Database query failed " . mysqli_error($db));
//  	}
// }



// validation functions
function has_presence($value) {
	$value = trim($value);
	if(isset($value) && !empty($value)){
		return $value;
	}
}

function has_min_length($value, $min=2) {
	return strlen($value) >= $min;
}



function is_exact($value1, $value2) {
	return $value1 === $value2;
}

// photo upload functions
function valid_photo_filename($filename) {
  return ((preg_match('/^[a-zA-Z0-9_.-]+$/',$filename)) ? true : false);
}

function is_valid_extension($filename) {
	$ext_type = array('gif','jpg','jpe','jpeg','png');
	$file_ext = substr(strrchr($filename,'.'),1);
	return in_array($file_ext, $ext_type);
}

?>
