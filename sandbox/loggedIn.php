<?php session_start();

//include 'verify.php'; ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h1>Welcome <?php echo $_SESSION['username']; ?></h1>

	<br><Br>
		<a href="logOut.php">Log Out</a>

</body>
</html>
