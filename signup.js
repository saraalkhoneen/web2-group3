document.addEventListener('DOMContentLoaded', function () {
    var userTypeForm = document.getElementById('userTypeForm');
    var designerForm = document.getElementById('designerForm');
    var clientForm = document.getElementById('clientForm');

    userTypeForm.addEventListener('change', function(event) {
        var value = event.target.value;
        if (value === 'designer') {
            designerForm.style.display = 'block';
            clientForm.style.display = 'none';
            
           $(function() {
'use strict';

// Form
var designer_Form = function() {

    if ($('#designer_Form').length > 0 ) {
        $( "#designer_Form" ).validate( {
            rules: {
                firstName: "required",
                lastName: "required",
                email: {
                    required: true,
                    email: true
                },
              password: "required",
              brandName: "required"
            },
            messages: {
                firstName: "This field is required.",
                lastName: "This field is required.",
                email: "This field is required.",
                password: "This field is required.",
                brandName: "This field is required."
            },
            
            
            /* submit via ajax */
            submitHandler: function(form) {		
                var $submit = $('.submitting'),
                    waitText = 'please wait';
                    
                 var data = new FormData(form);

                $.ajax({   	
                      type: 'POST', 
                     enctype: 'multipart/form-data',
                  url: "php/insertdesigner.php",
                  data: data,
                 processData: false,
                contentType: false,
                cache: false,
                   beforeSend: function() { 
                      $submit.css('display', 'block').text(waitText);
                  },
                  success: function(msg) {
                   if (msg == 'OK') {
                       $('#form-message-warning').hide();
                       setTimeout(function(){
                            $submit.css('display', 'none');
                           document.getElementById("designer_Form").reset();
                         $('#form-message-success').fadeIn();  
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
designer_Form();

});
            
          
        } else if (value === 'client') {
            clientForm.style.display = 'block';
            designerForm.style.display = 'none';
           
            $(function() {
'use strict';

// Form
var client_Form = function() {

    if ($('#client_Form').length > 0 ) {
        $( "#client_Form" ).validate( {
            rules: {
                firstName: "required",
                lastName: "required",
                email: {
                    required: true,
                    email: true
                },
              password: "required",
            },
            messages: {
                firstName: "This field is required.",
                lastName: "This field is required.",
                email: "This field is required.",
                password: "This field is required."
            },
            
            
            /* submit via ajax */
            submitHandler: function(form) {		
                var $submit = $('.submitting'),
                    waitText = 'please wait';
                    
                 var data = new FormData(form);

                $.ajax({   	
                      type: 'POST', 
                  url: "php/insertclient.php",
                  data: data,
                 processData: false,
                contentType: false,
                cache: false,
                   beforeSend: function() { 
                      $submit.css('display', 'block').text(waitText);
                  },
                  success: function(msg) {
                   if (msg == 'OK') {
                       $('#form-message-warning').hide();
                       setTimeout(function(){
                            $submit.css('display', 'none');
                           document.getElementById("client_Form").reset();
                         $('#form-message-success').fadeIn();  
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
client_Form();

});
           
        }
    });
});
