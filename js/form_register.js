$(document).ready(function(){

	// remove 'hide' when user clicks a 'Register Today' button
	$(".register").on('click',function(){ // on link click
		// show overlay and registration form part 1
		$('div#overlay, form#register-form').fadeIn('fast').removeClass('hide');
		// if user clicks outside of form: hide overlay, form
		// and reset form
		$('#overlay').on('click', function(){
			resetForm($('#register-form'));

		 	$('form#register-form').css('display','none');
			$('#register-form div').removeClass('hide');
			$('#second').addClass('hide');
			$(this).css('display','none');
			// somehow reset all the form elements
			// document.location.reload(false);
			// instead of the above, SIMULATE a reload by
			// resetting elements and going back to initial state
		});
	});
	// detect value of clicked element
	$('.user').on('click',function(){
		// get value of clicked element
		var userValue = $(this).attr('value');
		// set value of hidden input to clicked value
		$('#user_type').attr('value',userValue);
		// var hidden = $('input[type=hidden]').val();
		// console.log(hidden);
		// hide first form div
		$('form#register-form > div').addClass('hide');
		// show second form div
		$('#second').removeClass('hide');
	});

	// on user_type selection, hide user type and display second div
	// $('input[type=radio]').change(function(){
	// 	$('form#register-form > div').addClass('hide');
	// 	$('#second').removeClass('hide');
	// });

	// Method to check for letters only and not numbers
	jQuery.validator.addMethod("lettersonly", function(value, element) {
		return this.optional(element) || /^[a-z\s]+$/i.test(value);
	}, "Only letters and whitespace allowed");

	// on submit (if all fields are valid)
	$("#register-form").validate({
		errorElement : 'span',
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
			// console.log(formData);
			$.ajax({
				url:'includes/register.php',
				type:'POST',
				data: formData,
				success: function(data){
				$("#register-form #message p").html(data);
				// set timer than close the window and disable opening it again
				}
			});
			// $.post( 'register_form_test.php', data );
			// console.log('the form should have been sent');
			$("#register-form div + div").addClass('hide');
			$("#register-form #message").removeClass('hide');
			setTimeout(function(){
				$('#overlay, form#register-form').fadeOut('slow');
			 	$(".register").off();
			},1500);
		}
	});// end of validate

	function resetForm($form) {
    // $form.find('input:hidden, input:text').val('');
		$('input[type=hidden], input[type=text], input[type=email]').val('');
		$('span#useremail-error, span#username-error').html('');

}
})//end of document ready
