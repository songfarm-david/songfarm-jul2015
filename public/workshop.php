<?php session_start();
require_once('../includes/initialize.php');
include_once('../includes/host_songcircle.php');
$photo_errors = [];
$php_upload_errors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);
## For testing -
if(empty($_SESSION)){
	$_SESSION['user_id'] = 1000;
	$_SESSION['username'] = 'Test User';
  $_SESSION['permission'] = 1;
}

// if user is not logged in: isset($_SESSION['logged_in']) !== true
if(!isset($_SESSION)) { // testing condition
	redirect_to('index.php');
} else {
	// if user submits photo
	if(isset($_POST['submit_image'])) {
		// make sure uploaded file is valid and not empty
		if(!$_FILES['file_upload'] || empty($_FILES['file_upload']) || !is_array($_FILES['file_upload'])) {
			$photo_errors[] = "No file was uploaded";
		}	elseif (!valid_photo_filename($_FILES['file_upload']['name'])) {
			$photo_errors[] = "Invalid characters in file name. Only characters, numbers and (_-.) allowed.";
			$image_name = "";
		}	elseif ($_FILES['file_upload']['error'] != 0) {
			foreach($php_upload_errors as $key => $value) {
				if($_FILES['file_upload']['error'] == $key) {
					$photo_errors[] = $value;
					$image_name = "";
				}
			}
		} elseif (!is_valid_extension($_FILES['file_upload']['name'])) {
			$photo_errors[] = "Files must be of either type jpeg, jpg, jpe, gif or png.";
			$image_name = "";
		}
		else // if no errors..
		{
			// target directory of file system
			$target_dir = SITE_ROOT.DS."uploaded_images";
			// specify attribute variables
			$user_id 		= $_SESSION['user_id'];
			$filename 	= uniqid('', true); // creates unique id
			$type 			= str_replace('image/','.',$_FILES['file_upload']['type']);
			$size 			= $_FILES['file_upload']['size'];
			$tmp_name 	= $_FILES['file_upload']['tmp_name'];
			// check if an image already exists
			$sql = "SELECT * FROM user_photo WHERE id = $user_id";
			$result = query_db($sql);
			$res_array = fetch_array($result);
			$old_filename = $res_array['filename'];
			$old_type = $res_array['type'];
			if(has_rows($result) != 0){ // if a row exists
				// try to delete the existing file from the file system, if fails...
        if(file_exists($target_dir.DS.$old_filename.$old_type)) {
          if(!unlink($target_dir.DS.$old_filename.$old_type)){
  					 $photo_errors[] = "Could not delete existing file in file system. Update failed.";
  				} else {
  					$sql = "UPDATE user_photo ";
  					$sql.= "SET filename = '$filename', type = '$type', size = $size ";
  					$sql.= "WHERE user_id = $user_id";
  					if($result = query_db($sql)) {
  						if(!move_uploaded_file($tmp_name, "$target_dir/$filename$type")){
  							$photo_errors[] = "Error moving file to file system";
  						} else {
  							$image_name = $filename.$type;
  						}
  					} else {
  						$photo_errors[] = "There was an error updating your profile picture. Please try again at a later time.";
  						$image_name = "";
  					}
  				}
        } else {
          $image_name = "";
        }// end of: if(file_exists);
			} else {	// if no rows exist perform an insert
				if(file_exists($target_dir.DS.$filename.$type)){
					$photo_errors[] = "This photo has already been uploaded";
				} elseif(!move_uploaded_file($tmp_name, "$target_dir/$filename$type")){
					$photo_errors[] = "There was an error uploading your file. Please try again, or upload a different image";
				} else {
					$sql = "INSERT INTO user_photo (";
					$sql.= "user_id, filename, type, size ";
					$sql.= ") VALUES (";
					$sql.= "$user_id, '$filename', '$type', $size)";
					if($result = query_db($sql)){
						if(mysqli_affected_rows($db) == 0){
							$photo_errors[] = "There was an error inserting your file into our records. Please try again at a later time.";
						} else {
							// success
							$image_name = $filename.$type;
						}
					}
				}
			}
		} // end of: if no file upload errors
	} else {
		## retrieve user photo from file system
		if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
			$sql = "SELECT filename, type FROM user_photo WHERE ";
			$sql.= "user_id = $user_id";
			$result = query_db($sql);
			if(mysqli_num_rows($result) != 0){
				$res_array = fetch_array($result);
				$filename = $res_array['filename'];
				$type = str_replace('image/','',$res_array['type']);
				$image_dir = SITE_ROOT.DS."uploaded_images".DS;
				if(!file_exists($image_dir.$filename.$type)){
					// $photo_errors[] = 'We don\'t have a profile picture in our systems of you. You should upload one.';
          $image_name = "";
				} else {
					$image_name = $filename.$type;
				}
			} else {
				$image_name = "";
				// here you could assign a standard image prompting upload of a profile pic
			}
		} // end of: if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
	}
}
?>
<?php if($photo_errors) { ?>
  <span>Photo error:</span>
  <ul>
    <?php foreach ($photo_errors as $error) {
      echo "<li>{$error}</li>";
    } ?>
  </ul>
<?php } ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $_SESSION['username'] ?>&apos;s Workshop</title>
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
		<div class="user_image" style="background-image:url('../uploaded_images/<?php echo $image_name; ?>')">
			<!-- Is there a better way to access these pictures?? Absolute Path? -->
		</div>
		<h1><?php echo $_SESSION['username']; ?></h1>
		<span class="attr">Singer/Songwriter, Lyricist</span>&nbsp;<span style="font-style:italic;">located in</span>&nbsp;<span style="font-weight:bold;">Canoa, Ecuador</span>
		<!-- Input form for user_image -->
		<form id="upload_user_image" action="workshop.php" method="post" enctype="multipart/form-data" class="hide">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
			<input type="file" name="file_upload">
			<input type="submit" name="submit_image" value="Upload">
		</form>
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
              $sql = "SELECT songcircle_id, date_of_songcircle, songcircle_name, songcircle_permission, participants, duration FROM songcircle";
              if(!$result = mysqli_query($db, $sql)) {
                echo mysqli_error($db);
              } else {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<input type=\"hidden\" data-conference-id=" .$row['songcircle_id']. "\">";
                  echo "<td class=\"date\">" .$row['date_of_songcircle']. "</td>";
                  echo "<td class=\"type\"><span class=\"permission\">".$row['songcircle_permission']."</span>&nbsp;".$row['songcircle_name'].
                       "<span class=\"registered\"> (0 of " .$row['participants']. " participants registered)</span></td>";
                  echo "<input type=\"hidden\" data-duration=" .$row['duration']. "\">";
                  echo "<td class=\"register\"><input type=\"submit\" value=\"Register\" name=\"register\"></input></td>";
                  echo "</tr>";
                }
              }

						?>
						<!-- Example Table -->
						<!-- <tr>
							<td class="date">September 7th, 2015 - 07:00 GMT</td>
							<td class="type">Open Songcircle <span class="registered"><a href="#">(<?php // dynamic count ?> Registered Members)</a></span></td>
							<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
								<td class="register"><input type="submit" value="Register<?php // dynmaic status ?>" name="register"></input></td>
								<input type="hidden" value="<?php // dynamic value ?>" name="songcircle_id">
								<input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="user_id">
								<input type="hidden" value="<?php echo $_SESSION['username'] ?>" name="username">
							</form>
						</tr> -->

					</table>
				</div>
				<aside class="aside-left">
					<button>
						<a href="#">Invite other Songwriters</a>
					</button>
          <?php if($_SESSION['permission'] != 1) {
					  echo "<button class=\"inactive\"><a href=\"#\">Host a Songcircle</a>";
          } else {
            echo "<button id=\"host_songcircle\"><a href=\"#\">Host a Songcircle</a>";
          }?>
					</button>
				</aside>
			</article>

			<article id="tab-liveConcert" class="tab-content">
				<h3>Live Concert</h3>
			</article>

		</div><!-- end of tab container -->

	</main>
  <div id="overlay" class="hide"></div>
  <form id="host_a_songcircle" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="hide">
    <h1>Host a Songcircle</h1>
    <p>
      Name your Songcircle:
    </p>
    <input type="text" name="songcircle_name" maxlength="50" required><br>
    <p>
      Select a time and date: (all times are GMT)<!-- some sort of calculation to take into account where the user is located globally and reflecting and accurate transposition -->
    </p>
    <input type="datetime-local" name="date_of_songcircle" required>
    <p>
      Is your Songcircle Public (open to everyone) or Private (invite other Songwriters from your Songwriter's Circle)?
    </p>
    Public<input type="radio" name="songcircle_permission" value="Public" required></label>
    Private<input type="radio" name="songcircle_permission" value="Private" required><!-- Private currently inactive-->
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
    <?php echo $message; ?>
  </form>
	<script>
  // host songcircle overlay
  $('#host_songcircle').on('click', function(){
    console.log('click');
    $('form#host_a_songcircle, div#overlay').fadeIn().removeClass('hide');
  });
  // hide form and overlay
  $('#overlay').on('click', function(){
    $('#overlay, form#host_a_songcircle').fadeOut().addClass('hide');
  })

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

	// user image
	$('.user_image').on('click', function(){
		$('#upload_user_image').fadeIn('fast').removeClass('hide');
	})
	</script>

</body>
</html>
