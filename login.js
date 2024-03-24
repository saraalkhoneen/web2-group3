
 
               $(function() {
	'use strict';

	// Form
	var loginForm = function() {

		if ($('#loginForm').length > 0 ) {
			$( "#loginForm" ).validate( {
				rules: {
					email: {
						required: true,
						email: true
					},
				  password: "required",
				  userType: "required"
				},
				messages: {
					email: "This field is required.",
					password: "This field is required.",
					userType: "This field is required."
				},
				
				
				/* submit via ajax */
				submitHandler: function(form) {		
					var $submit = $('.submitting'),
						waitText = 'please wait';
						
                     var data = new FormData(form);

					$.ajax({   	
					      type: 'POST', 
				      url: "php/logincheck.php",
				      data: data,
                     processData: false,
                    contentType: false,
                    cache: false,
				       beforeSend: function() { 
				      	$submit.css('display', 'block').text(waitText);
				      },
				      success: function(msg) {
		               if (msg == 'designer') {
		               	$('#form-message-warning').hide();
		               	setTimeout(function(){
				                $submit.css('display', 'none');
				             $('#form-message-success').fadeIn();  
				             window.location.href = 'designerHome.php';
		               	}, 1400);
			            }
			            else if (msg == 'Client') {
		               	$('#form-message-warning').hide();
		               	setTimeout(function(){
				                $submit.css('display', 'none');
				             $('#form-message-success').fadeIn();  
				             window.location.href = 'ClientHomepage.php';
		               	}, 1400);
			            } else {
			               $('#form-message-warning').html(msg);
			            }
			            
				      },
				      
				      error: function() {
				      	$('#form-message-warning').html("Something went wrong. Please try again.");
				         $('#form-message-warning').fadeIn();
				         $submit.css('display', 'none');
				      }
			      });    		
		  		}
				
			} );
		}
	};
	loginForm();

});
                
              
          








