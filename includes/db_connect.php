<?php

define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", "Parlophone3");
define("DB_NAME", "register_user");

// make database connection
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

  // check database connection
  if(mysqli_connect_errno() ) {
      die("Database connection failed: " . mysqli_connect_error() . "(error #: " . mysqli_connect_errno() . ")");
  }

?>
