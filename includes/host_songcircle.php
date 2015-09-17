<?php
// session_start();
// require_once('initialize.php');
// echo $referer_url = $_SERVER['HTTP_REFERER'];
if(isset($_POST['submit'])) {
	// echo var_dump($_SERVER['HTTP_REFERER']);
	// global $referer_url;
	$user_id = $_SESSION['user_id'];
	$songcircle_id = uniqid("$user_id-");
	$songcircle_name = mysqli_real_escape_string($db, $_POST['songcircle_name']);
	$date_of_songcircle = $_POST['date_of_songcircle'].":00";
	$songcircle_permission = $_POST['songcircle_permission'];
	$participants = $_POST['max_participants'];
	$duration = $_POST['duration'];

	$sql = "INSERT INTO songcircle (";
	$sql.= "user_id, songcircle_id, songcircle_name, date_of_songcircle, songcircle_permission, participants, duration";
	$sql.= ") VALUES (";
	$sql.= "$user_id, '$songcircle_id', '$songcircle_name', '$date_of_songcircle', $songcircle_permission, $participants, '$duration')";
	if($result = mysqli_query($db, $sql)) {
		// success
		$message = "success";
	} else {
		$message = "Query error: " . mysqli_error($db);
	}
} else {
	$message = "";
}
?>
<!-- <!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Host A Songcircle</title>
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<style>
		main{ width:40%; margin:2.5em auto; padding:0 2em 1em;border: 2px dotted #99EE20;}
		p{margin-bottom:0.5em;}
	</style>
</head>
<body>
	// basic form for scheduling songcircles
	<main>

		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
			<h1>Host a Songcircle</h1>
			<p>
				Name your Songcircle:
			</p>
			<input type="text" name="songcircle_name" maxlength="50" required><br>
			<p>
				Select a time and date: (all times are GMT)<!-- some sort of calculation to take into account where the user is located globally and reflecting and accurate transposition //
			</p>
			<input type="datetime-local" name="date_of_songcircle" required>
			<p>
				Is your Songcircle Public (open to everyone) or Private (invite other Songwriters from your Songwriter's Circle)?
			</p>
			Public<input type="radio" name="songcircle_permission" value="1" checked required></label>
			Private<input type="radio" name="songcircle_permission" value="2" disabled required><!-- Private currently inactive//
			<p>
				What is the maximum number of participants you'll allow?
			</p>
			<select name="max_participants" required>
				<?php for ($i=2; $i <= 12 ; $i++) {
					echo "<option value=\"{$i}\">{$i}</option>";
				} ?>
			</select>
			<p>
				Select a duration for your Songcircle:
			</p>
			<select name="duration" required>
				<option value="30_minutes">30 minutes</option>
				<option value="1_hour">1 hour</option>
				<option value="1.5_hours">1.5 hours</option>
				<option value="2_hours">2 hours</option>
				<option value="3_hours">3 hours</option>
			</select>
			<br>
			<br>
			<input type="submit" name="submit">
		</form>
	</main>

</body>
</html> -->
