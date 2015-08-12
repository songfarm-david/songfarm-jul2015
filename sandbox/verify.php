<?php
include('database.php');
session_start();

$user_check = $_SESSION['username'];

$query 	= mysqli_query($db,"SELECT artist_name FROM sign_up WHERE artist_name = '$user_check'");
$row 		= mysqli_fetch_array($query,MYSQLI_ASSOC);

$login_session = $row['artist_name'];

if(!isset($login_session))
{
 echo 'no session set';
}
?>
