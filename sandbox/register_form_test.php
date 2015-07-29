<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Register Form | Test</title>
	<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../js/form_register.js"></script>

	<link href="../css/registration.css" rel="stylesheet">
</head>
<body>

	<!-- <div id="trigger">
		<a href="#">Click me</a>
	</div> -->
	<!-- a button that will display the first part of the form -->

	<script>
	// $(document).ready(function(){
	//
	// 	// remove 'hide' when user clicks a 'Register Today' button
	// 	$("#trigger").on('click',function(){
	// 		$('#register').removeClass('hide');
	// 	});
	// 	// on user_type selection, hide user type and display second div
	// 	$('input[type=radio]').change(function(){
	//     $('form#register > div').addClass('hide');
	// 		$('#second').removeClass('hide');
	// 	});
	//
	// 	// Method to check for letters only and not numbers
	// 	jQuery.validator.addMethod("lettersonly", function(value, element) {
	// 		return this.optional(element) || /^[a-z\s]+$/i.test(value);
	// 	}, "Only letters and whitespace allowed");
	//
	// 	// on submit (if all fields are valid)
	// 	$("#register").validate({
	// 		rules : {
	// 			user_name : {	// checking to see the name is only letters
	// 				lettersonly:true
	// 			}
	// 		},
	// 		// call a custom handler
	// 		submitHandler: function(form){
	// 			// grab from and serialize the data
	// 			var form = $("#register");
	// 			var formData = form.serialize();
	// 			// send data to php validation file
	// 			$.ajax({
	// 				url:'../includes/register.php',
	// 				type:'POST',
  //     		data: formData,
  //   			success: function(data){
	// 					console.log('data sent to register.php');
  //     		$("#message p").html(data);
	// 				}
	// 			});
	// 			// $.post( 'register_form_test.php', data );
	// 			// console.log('the form should have been sent');
	// 			$("#register div + div").addClass('hide');
	// 			$("#message").removeClass('hide');
	// 		}
	// 	});
	// })//end of document ready
	</script>

	<span class="register"><a href="#">Register Today</a></span>

	<div id="overlay" class="hide"></div>

	<!-- Test form for User Registration -->
	<form id="register-form" action="../includes/register.php" method="post" class="hide">
		<div>
			<p>Please Select Your User Type:</p>
			<div class="user" value="1">Artist</div>
			<div class="user" value="2">Industry</div>
			<div class="user" value="3">Fan</div>
			<input type="hidden" id="user_type" name="user_type" value="">
			<!-- <label>
				<input type="radio" name="user_type[]" value="1">Artist
				<input type="radio" name="user_type[]" value="2">Industry
				<input type="radio" name="user_type[]" value="3">Fan
			</label> -->
		</div>

		<div id="second" class="hide">
			<p>Please Enter Your Name And Email</p>
			<input type="text" id="username" name="user_name" data-msg-required="The name field is required" minlength="2" placeholder="Your Name" required>

			<input type="email" id="useremail" name="user_email" data-msg-required="The email field is required" placeholder="Your Email" required>

			<input type="submit" id="submitForm" value="Register Me!">

		</div>

		<!-- form result message -->
		<div id="message" class="hide">
			<p>
				Thanks for Registering!
			</p>
		</div>
	</form>


</body>
</html>
