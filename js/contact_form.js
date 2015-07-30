$(document).ready(function(){

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
					url:'includes/contact_form.php',
					type:'POST',
					data: formData,
					success: function(data){
					$("#contact-form").css('display','none');
					$("div#thank-you_message p").html(data);
					$('div#thank-you_message').removeClass('hide');
					console.log(data);
					}
				});
			}
		});
	});

}); // end of document.ready
