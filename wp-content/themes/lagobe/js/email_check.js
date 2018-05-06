 jQuery(document).ready(function($) {
	jQuery('.blockUI, .blockOverlay').hide();
	jQuery('.blockUI, .blockOverlay').remove();
/*	jQuery('#billing_email_n').one('click', function () { 
     jQuery('#billing_email_n').append('<section id="nextractor"> </section>');  
	});*/
	
	
    jQuery('#billing_email_n').blur(function(){
		jQuery('#billing_email_n_field span').remove();									  
		var input_value = jQuery(this).val();
        $.post( validateEmail.ajaxurl, { action:'validate_email', email:input_value }, function(data) {
			console.log(data);
			
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
			
			if(jQuery('#billing_email_n').val().length != 0) {
				if(emailReg.test(input_value)) {
					if(data == '1'){
						jQuery('#billing_email_n_field span').remove();	
						jQuery('#billing_email_n_field').addClass('validate_email_error');
						jQuery('#billing_email_n').addClass('error-email');
						jQuery('#billing_email_n').after('<span style="color:red">Already used</span>');
						jQuery('.actions ul li:nth-of-type(2)').addClass('disable-email');
						console.log(data);
					} else if(data == '0'){ 
						jQuery('#billing_email_n_field span').remove();
						jQuery('#billing_email_n_field').removeClass('validate_email_error');
						jQuery('#billing_email_n').removeClass('error-email');
						jQuery('#billing_email_n').after('<span style="color:green">Available</span>');	
						jQuery('.actions ul li:nth-of-type(2)').removeClass('disable-email');
						console.log(data);
					}
				} else {
						jQuery('#billing_email_n_field span').remove();	
						jQuery('#billing_email_n_field').addClass('woocommerce-invalid');
						jQuery('#billing_email_n_field').addClass('woocommerce-invalid-required-field');
						jQuery('#billing_email_n').addClass('error-email');
						jQuery('.actions ul li:nth-of-type(2)').addClass('disable-email');
				}
			} 
			
        });
    });
	
	
	
	jQuery('#usr-dob_field').blur(function(){
		if(jQuery('#usr-dob').val().length != 0) {								   
			jQuery('#usr-dob_field').removeClass('woocommerce-invalid');
			jQuery('#usr-dob_field').removeClass('woocommerce-invalid-required-field');
		}
	});
	
	
	
	
});