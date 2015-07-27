<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Register Form | Test</title>
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
	<style>
		form{ margin:2em 3em; }
		p{ margin-bottom: 0.25em; font-style: italic;}
		input[type="submit"]{ margin-top: 2em; margin-left: 3em;}
		.hide{ display: none; }
	</style>
</head>
<body>

	<div id="trigger">
		<a href="#">Click me</a>
	</div>
	<!-- a button that will display the first part of the form -->

	<script>
	$(document).ready(function(){

		// remove 'hide' when user clicks a 'Register Today' button
		$("#trigger").on('click',function(){
			$('#register').removeClass('hide');
		});
		// on user_type selection, hide user type and display second div
		$('input[type=radio]').change(function(){
	    $('form#register > div').addClass('hide');
			$('#second').removeClass('hide');
		});

		// Method to check for letters only and not numbers
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[a-z\s]+$/i.test(value);
		}, "Only letters and whitespace allowed");

		// on submit (if all fields are valid)
		$("#register").validate({
			rules : {
				user_name : {	// checking to see the name is only letters
					lettersonly:true
				}
			},
			// call a custom handler
			submitHandler: function(form){
				// grab from and serialize the data
				var form = $("#register");
				var formData = form.serialize();
				// send data to php validation file
				$.ajax({
					url:'../includes/register.php',
					type:'POST',
      		data: formData,
    			success: function(data){
						console.log('data sent to register.php');
      		$("#message p").html(data);
					}
				});
				// $.post( 'register_form_test.php', data );
				// console.log('the form should have been sent');
				$("#register div + div").addClass('hide');
				$("#message").removeClass('hide');
			}
		});
	})//end of document ready
	</script>

	<!-- Test form for User Registration -->
	<form id="register" action="../includes/register.php" method="post" class="hide">
		<div>
			<p class="p">
				Which type of user are you?
			</p>
			<label>
				<input type="radio" name="user_type[]" value="artist">Artist
				<input type="radio" name="user_type[]" value="industry">Industry
				<input type="radio" name="user_type[]" value="fan">Fan
			</label>
		</div>

		<div id="second" class="hide">
			<label for="username">Name:
				<input type="text" id="username" name="user_name" minlength="2" value="Pie" required>
			</label>
			<!-- only letters and whitespace .. no numbers -->
			<p>
				What is your email address?
			</p>
			<label for="useremail">Email:
				<input type="email" id="useremail" name="user_email" value="y@z.com" required>
			</label>
			<br>
			<label for="submitForm">
				<input type="submit" id="submitForm">
			</label>
		</div>

		<!-- form result message -->
		<div id="message" class="hide">
			<p>

			</p>
		</div>
	</form>


</body>
</html>
