<?php
session_start();
if(session_destroy())
{
header("Location: /Songfarm-Jul2015/index.php");
}
?>
