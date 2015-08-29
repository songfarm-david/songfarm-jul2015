<?php
session_start();
require_once('initialize.php');
if(session_destroy()) {
	redirect_to('../public/index.php');
}
?>
