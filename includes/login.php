<?php require('validateLogin.php');

$login = new validateLogin();

if(isset($_POST['submit'])) {
	$username = $login->username;
	$login->validateUser($_POST['username'],$_POST['password']);
} else {
	$username = "";
}
?>
