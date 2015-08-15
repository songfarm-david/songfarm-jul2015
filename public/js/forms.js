
// This page contains scripting for both
// the REGISTRATION, LOG IN, & CONTACT FORM

// on click 'REGISTER TODAY'
$(".register").on('click',function(){
	// show overlay and registration form part 1
	$('div#overlay, form#register-form').fadeIn('fast').removeClass('hide');

	// if user clicks outside of form, HIDE OVERLAY, FORM PART 1, and RESET the form
	$('#overlay, form#register-form img').on('click', function(){
		$('form#register-form').css('display','none');
		$('#register-form > div').removeClass('hide');
		$('#second').addClass('hide');
		$('#overlay').css('display','none');
		$('#message').addClass('hide');
		resetForm($('#register-form'));

	});
});

// Click event for ACTIVE users (currently artists only)
// Retrieve userType value
$('.user:not(.inactive)').on('click',function(){

	// get value of clicked element
	var userType = $(this).attr('value');
	// set value of hidden input to clicked value
	$('#user_type').attr('value',userType);
	// hide first form div
	$('form#register-form > div').addClass('hide');
	// show second form div
	$('#second').removeClass('hide');
	$('input#username').focus();
});

// on SUBMIT (if all fields are valid)
$("#register-form").validate({
	errorElement : 'span',
	rules : {
		user_name : {	// checking to see the name is only letters
			lettersonly:true
		},
		user_password : 'required',
		conf_password: {
			equalTo : '#userpassword'
		}
	},
	messages : {
		user_password : 'You must enter a password',
		conf_password : {
			equalTo : 'Passwords don\'t match'
		}
	},
	// call a custom handler
	submitHandler: function(form){
		// grab from and serialize the data
		var form = $("#register-form");
		var formData = form.serialize();
		// send data to php validation file
		$.ajax({
			url:'../includes/register.php',
			type:'POST',
			data: formData,
			dataType:'json',
			success: function(data){
				$("#register-form #message p").html(data[0]);
				$('#register-form img').addClass('hide');
				$("#register-form div + div").addClass('hide');
				$("#register-form #message").removeClass('hide');
				if($.inArray(true,data) !== -1){
					setTimeout(function(){
						$('#overlay, form#register-form').fadeOut('slow');
						$(".register").off();
						window.location.href = 'workshop.php';
					},2000)
				} else {
					setTimeout(function(){
						$('#overlay, form#register-form').fadeOut('slow')
					},3000)
				}
			} // success: function(data)
		}); // $.ajax
	} // submitHandler
});// end of validate

function resetForm($form) {
	// $form.find('input:hidden, input:text').val('');
	$('input[type=hidden], input[type=text], input[type=email], input[type=password]').val('');
	$('span#useremail-error, span#username-error,span#userpassword-error,span#confpassword-error').html('');

}

// Validator method to check for letters only and not numbers
jQuery.validator.addMethod("lettersonly", function(value, element) {
	return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Only letters and whitespace allowed");


// Log In drop-down
$('#login').on('click', function(){
	$('#login-form').toggle(500, function(){
		$('#login-form input[type=text]').focus();
	});
})

$('#login-form').validate({
	errorElement : 'span',
	rules : {
		username : 'required',
		password : 'required'
	},
	messages : {
		username : 'Please enter your Name or Email',
		password : 'Please enter your Password'
	},
	submitHandler: function(form){
		$('#submitLogIn').submit(function(e){
			e.preventDefault();
		})
		var form 			= $('#login-form');
		var formData 	= form.serialize();
			$.ajax({
				url 	: '../includes/login.php',
				type 	: 'POST',
				data 	: formData,
				dataType : 'JSON',
				success:function(data){
					if($.inArray(true,data) !== -1){
						window.location.href = 'workshop.php';
					} else {
						$('span#login-error').html(data);
					}
				} // success
			}) // ajax
	} // submit handler
}); // validate


// CONTACT FORM
$("form#contact-form div.button").on('click', function(){
	$(this).trigger("submit");
	$("form#contact-form").validate({
		errorElement : 'span',
		// call a custom handler
		submitHandler: function(form){
			// grab from and serialize the data
			var form = $("#contact-form");
			var formData = form.serialize();
			// send data to php validation file
			$.ajax({
				url:'../includes/contact_form.php',
				type:'POST',
				data: formData,
				success: function(data){
				$("#contact-form").css('display','none');
				$("div#thank-you_message p").html(data);
				$('div#thank-you_message').removeClass('hide');
				}
			});
		}
	});
});
