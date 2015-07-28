$(document).ready(function(){

	// remove 'hide' when user clicks a 'Register Today' button
	$(".register").on('click',function(){
		// alert('working');
		$('#overlay, #register-form').removeClass('hide');
		$('#overlay').on('click', function(){
			$(this).addClass('hide');
			$('#register-form').addClass('hide');
			// reset the form here
		})
	});
	// on user_type selection, hide user type and display second div
	$('input[type=radio]').change(function(){
		$('form#register-form > div').addClass('hide');
		$('#second').removeClass('hide');
	});

	// Method to check for letters only and not numbers
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z\s]+$/i.test(value);
	}, "Only letters and whitespace allowed");

	// on submit (if all fields are valid)
	$("#register-form").validate({
		rules : {
			user_name : {	// checking to see the name is only letters
				lettersonly:true
			}
		},
		// call a custom handler
		submitHandler: function(form){
			// grab from and serialize the data
			var form = $("#register-form");
			var formData = form.serialize();
			// send data to php validation file
			console.log(formData);
			$.ajax({
				url:'includes/register.php',
				type:'POST',
				data: formData,
				success: function(data){
					console.log('data sent to register.php');
				$("#register-form #message p").html(data);
				}
			});
			// $.post( 'register_form_test.php', data );
			// console.log('the form should have been sent');
			$("#register-form div + div").addClass('hide');
			$("#register-form #message").removeClass('hide');
		}
	});
})//end of document ready
