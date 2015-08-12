<?php
session_start();
if(session_destroy())
{
header("Location: signUp_Login.php");
}
?>
