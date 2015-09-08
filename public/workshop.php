<?php session_start();
require_once('../includes/initialize.php');
if(empty($_SESSION)){
	$_SESSION['id'] = $_SESSION['username'] = "";
}


?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION['username'] ?>'s Workshop</title>
	<link href="css/workshop.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
	<nav>
		<h1>Navigation</h1>
		<span class="logo">Songfarm</span>
		<ul>
			<li>
				<a href="#"><?php echo $_SESSION['username']; ?></a>
			</li>
			<li>
				<a href="../includes/sign_out.php">Sign Out</a>
			</li>
		</ul>
	</nav>
	<header>
		<h1><?php echo $_SESSION['username']; ?></h1>
	</header>
	<main>
		<div id="tab-container">
			<ul>
				<li class="tab"><a href="#tab-songbook">Songbook</a></li><li class="tab"><a href="#tab-songcircle">Songcircle</a></li><li class="tab"><a href="#tab-liveConcert">Live Concert</a></li>
			</ul>

			<article id="tab-songbook" class="tab-content">
				<h3>Songbook</h3>
			</article>

			<article id="tab-songcircle" class="tab-content">
				<div><!-- div for styling purposes -->
					<h3>Upcoming Songcircles:</h3>
					<table>
						<?php
							# Populate tables here

						?>
						<!-- Example Table -->
						<tr>
							<td class="date">September 7th, 2015 - 07:00 GMT</td>
							<td class="type">Open Songcircle <span class="registered"><a href="#">(<?php // dynamic count ?> Registered Members)</a></span></td>
							<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								<td class="register"><input type="submit" value="<?php // dynmaic status ?>" name="register"></input></td>
								<input type="hidden" value="<?php // dynamic value ?>" name="songcircle_id">
								<input type="hidden" value="<?php echo $_SESSION['id'] ?>" name="user_id">
								<input type="hidden" value="<?php echo $_SESSION['username'] ?>" name="username">
							</form>
						</tr>
					</table>
				</div>
			</article>

			<article id="tab-liveConcert" class="tab-content">
				<h3>Live Concert</h3>
			</article>

		</div><!-- end of tab container -->

	</main>
	<script>
	// script for tabbed panels
	$('#tab-container ul').each(function(){

		var $active, $content, $links = $(this).find('a');

		$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[1]);
		$active.addClass('active');
		$content = $($active[0].hash);
		$links.not($active).each(function () {
      $(this.hash).hide();
    });
		// Bind the click event handler
    $(this).on('click', 'a', function(e){
      // Make the old tab inactive.
      $active.removeClass('active');
      $content.hide();

      // Update the variables with the new link and content
      $active = $(this);
      $content = $(this.hash);

      // Make the tab active.
      $active.addClass('active');
      $content.show();

      // Prevent the anchor's default click action
      e.preventDefault();
    });
	})
	</script>

</body>
</html>
