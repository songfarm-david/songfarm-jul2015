<?php

define("DB_HOST", '50.62.209.83:3306');
define("DB_USER", 'songfarm');
define("DB_PASS", "Parlophone3");
define("DB_NAME", "registree_info");

// make database connection
$db = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

  // check database connection
  if(mysqli_connect_errno() ) {
      die("Database connection failed: " . mysqli_connect_error() . "(error #: " . mysqli_connect_errno() . ")");
  }

?>
