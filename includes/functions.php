<?php

function redirect_to($location) {
	header("Location: " . $location);
	exit;
}




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
