jQuery( document ).ready(function() {
	
	
	jQuery('.vb-registration-form .slider, .vb-registration-form .mail-span').appendTo('#mailpoet_checkout_subscription_field label');
	
	
	jQuery('#billing_phone, #billing_postcode, #shipping_myfield4, #shipping_postcode').keydown(function (e) {
		if (e.shiftKey || e.ctrlKey || e.altKey) {
		e.preventDefault();
		} else {
		var key = e.keyCode;
		if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
		e.preventDefault();
		}
		}
	});
	
	
	jQuery(".vb-registration-form #usr-dob").change(function(){
		jQuery('.woocommerce-billing-fields #billing_myfield15').val(jQuery(this).val());
	});
	
	jQuery('.vb-registration-form #gender').change(function() {
      jQuery('.woocommerce-billing-fields #billing_myfield16').val(jQuery(this).val());
	  //jQuery('.woocommerce-shipping-fields #user_dob').val(jQuery(this).val());
	});
	
	jQuery(".vb-registration-form #account_password").change(function(){
		jQuery('.woocommerce-billing-fields #billing_myfield17').val(jQuery(this).val());
	});
	
	
	jQuery("#billing_phone, #shipping_myfield4").attr('maxlength','10');
	jQuery('#billing_postcode, #shipping_postcode').attr('maxlength','5');
	
	jQuery('.vb-registration-form #account_password').change(function() {
      jQuery('.woocommerce-billing-fields #account_password').val(jQuery(this).val());
	});
	
	
	jQuery('.vb-registration-form #billing_email_n').change(function() {
      jQuery('.woocommerce-billing-fields #billing_email').val(jQuery(this).val());
	  jQuery('.woocommerce-shipping-fields #shipping_email').val(jQuery(this).val());
	});
	
	jQuery('.vb-registration-form #billing_first_name_n').change(function() {
      jQuery('.woocommerce-billing-fields #billing_first_name').val(jQuery(this).val());
	  jQuery('.woocommerce-shipping-fields #shipping_first_name').val(jQuery(this).val());
	});
	

	
	jQuery('.vb-registration-form #billing_last_name_n').change(function() {
      jQuery('.woocommerce-billing-fields #billing_last_name').val(jQuery(this).val());
	  jQuery('.woocommerce-shipping-fields #shipping_last_name').val(jQuery(this).val());
	});
	
	
	
	//jQuery('.vb-registration-form #billing_email_n').val(jQuery('.woocommerce-billing-fields #billing_email').val());
	//jQuery('.vb-registration-form #billing_email_n').val(jQuery('.woocommerce-billing-fields #billing_email').val());
	
/*	jQuery('.woocommerce-billing-fields #billing_email').val('.vb-registration-form #billing_email_n');
	jQuery('.woocommerce-billing-fields #billing_first_name').val('.vb-registration-form #billing_first_name_n');
	jQuery('.woocommerce-billing-fields #billing_last_name').val('.vb-registration-form #billing_last_name_n');*/
	
	var user_email = jQuery('.woocommerce-billing-fields #billing_email').val();
	var user_first = jQuery('.woocommerce-billing-fields #billing_first_name').val();
	var user_last = jQuery('.woocommerce-billing-fields #billing_last_name').val();
	var user_dob = jQuery('.woocommerce-billing-fields #billing_myfield15').val();
	var user_gender = jQuery('.woocommerce-billing-fields #billing_myfield16').val();
	
	jQuery('.vb-registration-form #billing_email_n').val(user_email);
	jQuery('.vb-registration-form #billing_first_name_n').val(user_first);
	jQuery('.vb-registration-form #billing_last_name_n').val(user_last);
	
	jQuery('.vb-registration-form #gender').val(user_gender);
	jQuery('.vb-registration-form #usr-dob').val(user_dob);
	
	/*jQuery('.vb-registration-form #gender').val(jQuery('.woocommerce-billing-fields #billing_myfield15').val());
	jQuery('.vb-registration-form #user_date').val(jQuery('.woocommerce-billing-fields #billing_myfield16').val());
	jQuery('.vb-registration-form #account_password').val(jQuery('.woocommerce-billing-fields #billing_myfield17').val());
	
	jQuery('.vb-registration-form #billing_email_n').val(jQuery('.woocommerce-shipping-fields #shipping_email').val());
	jQuery('.vb-registration-form #billing_first_name_n').val(jQuery('.woocommerce-shipping-fields #shipping_first_name').val());
	jQuery('.vb-registration-form #billing_last_name_n').val(jQuery('.woocommerce-shipping-fields #shipping_last_name').val());*/
	
	
	jQuery('.woocommerce-billing-fields #account_password').hide();
	
	
	//jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_email_field').remove();
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_email_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_first_name_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_last_name_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_state_field').addClass('hidden-field');

	
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_myfield15_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_myfield16_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_myfield17_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_company_field').addClass('hidden-field');	
	
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #billing_country_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-billing-fields #user_dob_field').addClass('hidden-field');
	
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #shipping_state_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #user_dob_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #shipping_country_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #shipping_email_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #shipping_first_name_field').addClass('hidden-field');
	jQuery('.page-checkout .checkout .woocommerce-shipping-fields #shipping_last_name_field').addClass('hidden-field');
	
	
	jQuery( ".wizard .steps" ).insertAfter( ".wizard .actions " );
	jQuery(".wizard input#reg_email").attr("placeholder", "Email");
	jQuery(".wizard input#reg_password ").attr("placeholder", "Password");
	jQuery('.login-step #customer_login .col-2 h2').before('<h1>Guest</h1>');
	
	jQuery('#wizard .steps').insertAfter('#wizard .actions');
	jQuery('#mailpoet_subscription_section').insertAfter('#wizard .content .my-custom-step .vb-registration-form');
	
	
	
	/*jQuery('#billing_first_name_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_last_name_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_company_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_country_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_address_1_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_city_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_state_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_postcode_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#billing_city_field').appendTo('.woocommerce-additional-fields__field-wrapper');*/
	
	
	
	
	/*jQuery('#shipping_first_name_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_last_name_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_country_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_address_1_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_city_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_state_field').appendTo('.woocommerce-additional-fields__field-wrapper');
	jQuery('#shipping_postcode_field').appendTo('.woocommerce-additional-fields__field-wrapper');*/
	
	jQuery('<div class="shipping-label"><h1>Shipping Address</h1></div>').insertBefore('#shipping_first_name_field');
	
	/*jQuery('<div class="shipping-label"><h1>Billing Address</h1></div>').insertBefore('#billing_first_name_field');
	jQuery('#ship-to-different-address').insertAfter('.woocommerce-additional-fields');*/
	
	jQuery('#mailpoet_subscription_section .checkbox .input-checkbox ').after('<div class="slider round"></div>');
	
	jQuery('h3#ship-to-different-address label input').after('<div class="slider round"></div>');
	
	jQuery('#mailpoet_subscription_section .checkbox').contents().eq(3).wrap('<span class="new"/>')
	
	
	jQuery('.variations_form .out-of-stock').html('<a href="javascript: history.go(-1)" class="btn btn-cancle">Cancel</a><button type="submit" name="add-to-cart" class="single_add_to_cart_button button alt btn btn-cancle" disabled="">Sold Out</button>');
	
	jQuery('.out-of-stock button').text('Sold Out');
	//jQuery('#mailpoet_subscription_section .checkbox .input-checkbox').after('<p>Receive Exclusive LAGOBE offers & updates.</p>');
	//jQuery('#mailpoet_subscription_section .checkbox').text().append('<p></p>');
	//jQuery(texter).wrapInner("<span></span>");
	//jQuery('.woocommerce-shipping-fields').appendTo('.woocommerce-additional-fields__field-wrapper');
	
		/*if (jQuery('.sel-dropdown font').length > 0) {
			jQuery('.sel-dropdown a').addClass('active');
		} else {
			jQuery('.sel-dropdown a').addClass('active');
		}*/
		
		jQuery('.sel-dropdown a').click(function(e){
												 
			if(jQuery('.sel-dropdown font').length){
				//alert('rere');
				jQuery('.sel-dropdown a:nth-of-type(2)').removeClass('active');
				jQuery('.sel-dropdown a:nth-of-type(1)').addClass('active');
			} else {
				//alert('rsdfsdf');
				jQuery('.sel-dropdown a:nth-of-type(1)').removeClass('active');
				jQuery('.sel-dropdown a:nth-of-type(2)').addClass('active');
			}
			
		});
		
		
		
			
			
			
		jQuery('.left-sec .yith-wcpsc-product-table').before('<div id="r"></div>')
		
		jQuery('#pa_size').select2OptionPicker();
		jQuery('body').addClass('cbp-spmenu-push');
		
	
		$height = jQuery(window).height();
		
		//jQuery('.singular-product #content').css('min-height',$height);
		//jQuery('.singular-product #content').css('max-height',$height);
		
		jQuery('.page-thank-you main').css('min-height',$height);
		jQuery('.page-thank-you main').css('max-height',$height);
		
		jQuery('.woocommerce-lost-password .woocommerce').css('min-height',$height);
		jQuery('.woocommerce-lost-password .woocommerce').css('max-height',$height);
		
		//jQuery( '#user_dob' ).datepicker();
		
jQuery('.singular-product .quantity input').after('<div class="wac-qty-button plus"><b><a href="" class="wac-btn-inc btn-number" data-type="plus" data-field="quantity">+</a></b></div>');
jQuery('.singular-product .quantity input').before('<div class="wac-qty-button minus"><b><a href="" class="wac-btn-inc btn-number" data-type="minus" data-field="quantity">-</a></b></div>');


		//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
currentmax = jQuery("input[name='quantity']").attr('max');
if(currentmax == ""){
	jQuery("input[name='quantity']").attr('max','100');
}

jQuery('.singular-product .wac-qty-button .btn-number').click(function(e){
    e.preventDefault();
    fieldName = jQuery(this).attr('data-field');
    type      = jQuery(this).attr('data-type');
    var input = jQuery("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                jQuery(this).attr('disabled', true);
            }
        } else if(type == 'plus') {
            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                jQuery(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});



jQuery('.singular-product .input-text').focusin(function(){
   jQuery(this).data('oldValue', jQuery(this).val());
});
jQuery('.singular-product .input-text').change(function() {
    
    minValue =  parseInt(jQuery(this).attr('min'));
    maxValue =  parseInt(jQuery(this).attr('max'));
    valueCurrent = parseInt(jQuery(this).val());
    
    name = jQuery(this).attr('name');
    /*if(valueCurrent >= minValue) {
        jQuery(".singular-product .wac-qty-button .btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        jQuery(this).val(jQuery(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        jQuery(".singular-product .wac-qty-button .btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        
        jQuery(this).val(jQuery(this).data('oldValue'));
    }*/
    
    
});
jQuery(".singular-product .input-text").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
});
		
		
		
		    /*jQuery('.quantity').on('click', '.plus', function(e) {
				$input = jQuery(this).prev('input.qty');
				var val = parseInt($input.val());
				var step = $input.attr('step');
				step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
				$input.val( val + step ).change();
			});
    		jQuery('.quantity').on('click', '.minus', 
				function(e) {
				$input = jQuery(this).next('input.qty');
				var val = parseInt($input.val());
				var step = $input.attr('step');
				step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
				if (val > 0) {
					$input.val( val - step ).change();
				} 
			});*/
		
		
		/*jQuery('#cart-products .quantity').on('click', '.plus', function(e) {
			$input = jQuery(this).prev('input.qty');
			var val = parseInt($input.val());
			var step = $input.attr('step');
			step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
			$input.val( val + step ).change();
    	});
		jQuery('#cart-products .quantity').on('click', '.minus', 
			function(e) {
			$input = jQuery(this).next('input.qty');
			var val = parseInt($input.val());
			var step = $input.attr('step');
			step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
			if (val > 0) {
				$input.val( val - step ).change();
			} 
		});*/
		jQuery('#checkout_timeline').insertAfter('#checkout-wrapper');
		jQuery(".cart_addresses").prepend(jQuery(".register"))
		jQuery('.page-checkout .woocommerce-billing-fields__field-wrapper #billing_email_field').removeClass('form-row-last');
		
		jQuery('#timeline-0').hide();
		jQuery('#timeline-1').trigger('click');
		
		
		
		if (jQuery('#timeline-1').hasClass('active')) {
        	jQuery('.yith-wcms-button.prev').hide()
    	}
		
		var totalwis = jQuery('.tinv-wishlist ul#wishlist-products li').length;
		if(totalwis > 0){
		jQuery('.wishlist-sec a .wishlist-count').append(totalwis);
		} else {
		jQuery('.wishlist-sec a .wishlist-count').append(0);
		}
		
		
		
		var lostform = jQuery('.woocommerce-lost-password form').length;
		if(lostform > 0){
		jQuery('body').addClass('form-exits');
		} else {
		jQuery('body').removeClass('form-exits');
		}
		
		//woocommerce-message
		
		
		
		
		jQuery('.page-wishlist .title-sec span').append(totalwis+' items');
		
		jQuery('.page-wishlist .foot').hide();
		jQuery('#tinvwl_product_actions option[value="remove"]').attr("selected", "selected");
		jQuery('.page-wishlist .wish-rmv').click(function() {
			//alert('click');											  
			jQuery('.tinv-wishlist ul#wishlist-products li').each(function() {
				jQuery('.tinv-wishlist ul#wishlist-products li .product-cb input').prop( "checked", true );						   
			});
			jQuery('.input-group-btn .button').trigger('click');
		});
		
		
		//jQuery('.home .main-page .right-sec a img').addClass('gray');
		//jQuery('.home .main-page .right-sec a').addClass('grayscale');
		/*jQuery('.home .main-page .left-sec a img').hover(function () {
					jQuery('.home .main-page .right-sec a img').removeClass('gray');
		});*/		
   			
			
		
		
		
		/*jQuery('.home .main-page .left-sec a').mouseover(function() {
				jQuery('.home .main-page .left-sec a img').addClass("gray");
				jQuery('.home .main-page .right-sec a img').removeClass("gray");
				jQuery('.home .main-page .right-sec a').removeClass('grayscale');
				jQuery('.home .main-page .left-sec a').addClass('grayscale');
				jQuery('.home .main-page .left-sec a i').addClass('animated shake');
				jQuery('.home .main-page .right-sec a i').removeClass('animated shake');
		});
		
		jQuery('.home .main-page .logo-sec').mouseover(function() {
				jQuery('.home .main-page .left-sec a img').addClass("gray");
				jQuery('.home .main-page .right-sec a img').removeClass("gray");
				jQuery('.home .main-page .right-sec a').removeClass('grayscale');
				jQuery('.home .main-page .left-sec a').addClass('grayscale');
				jQuery('.home .main-page .left-sec a i').removeClass('animated shake');
				jQuery('.home .main-page .right-sec a i').addClass('animated shake');
		});*/
		
		
		
		/*jQuery('.home .main-page .right-sec a').mouseover(function() {
																   	
				jQuery('.home .main-page .right-sec a img').addClass("gray");
				jQuery('.home .main-page .left-sec a img').removeClass("gray");
				jQuery('.home .main-page .left-sec a').removeClass('grayscale');
				jQuery('.home .main-page .right-sec a').addClass('grayscale');
				//jQuery('.home .main-page .right-sec a:after').css('background','#fff');
			//	jQuery("head").append(jQuery('<style>.home .main-page .right-sec a:after { background: #fff; }</style>'));
				
		});*/
		
		
/*jQuery( '<input type="search" id="dgwt-wcas-search" class="dgwt-wcas-search-input" name="s" value="" placeholder="Search for products..."  autocomplete="off" autofocus>').insertAfter( ".dgwt-wcas-search-form label" );*/

		jQuery('.home .main-page').css("height",$height);
		var focusInput = true;
        jQuery( ".search-icon" ).click(function() {
			if(focusInput) {									
				jQuery(".dgwt-wcas-sf-wrapp input[type='search'].dgwt-wcas-search-input").focus();
				jQuery( ".search-form" ).show("slide");
				jQuery(".search-form" ).addClass("open");
			}
			focusInput = !focusInput;
			//evev.preventDefault();
		});
		
		jQuery( ".dgwt-wcas-preloader" ).click(function() {
			jQuery(".dgwt-wcas-sf-wrapp input[type='search'].dgwt-wcas-search-input").blur();
  			jQuery( ".search-form" ).hide("slide");
			jQuery(".search-form" ).removeClass("open");
			//jQuery( ".search" ).toggleClass("open");
			//eve.preventDefault();
			focusInput = !focusInput;
			
		});
		
		jQuery(window).click(function() {
			
  			if(jQuery( ".search-form" ).hasClass("open")){
				jQuery( ".search-form" ).hide("slide");
				jQuery( ".search-form" ).removeClass("open");
				jQuery(".dgwt-wcas-sf-wrapp input[type='search'].dgwt-wcas-search-input").blur();
			}
			focusInput = !focusInput;
			//rew.preventDefault();
			//jQuery( ".search" ).toggleClass("open");
		});
		
		jQuery(".search").click(function(e) { // Wont toggle on any click in the div
			e.stopPropagation();
		});
		
		
		jQuery( ".close-review" ).click(function() {
			jQuery( ".review-inner" ).hide("slow");
			jQuery( ".review-wrapper" ).removeClass("review-open");
		});
		
		jQuery( "#rat-tag" ).click(function() {
  			jQuery( ".review-inner" ).toggle("slide");
			jQuery( ".review-wrapper" ).toggleClass("review-open");
		});
		
		jQuery( "#filter-by" ).click(function() {
  			jQuery( "#side-left" ).toggle("slide");
			//jQuery( ".review-wrapper" ).toggleClass("review-open");
		});
		
		jQuery( "#short-by" ).click(function() {
  			jQuery( "#side-left-btm" ).toggle("slide");
			//jQuery( ".review-wrapper" ).toggleClass("review-open");
		});
		
		
		
		jQuery( ".mobile-menu #top-menu").hide(); 
		jQuery( ".mobile-menu .menu-toggle-left" ).click(function() {
				jQuery( ".mobile-menu #top-menu" ).toggle('slide');
				jQuery( ".mobile-menu #top-menu" ).toggleClass('active');
			//jQuery( ".mobile-menu #top-menu" ).toggleClass("active");
		});
		
		
		/************************Add Query String on Landing page*************/
		
		
		
		
		
		/*********************End Query String On Landing Page**************/
		
		
		/****************************Start Woocommerce jQuery**********************/
		jQuery(window).load(function(){
									 
			jQuery(".single_variation_wrap").show();
			if(jQuery("#pa_size").val() == ''){
				jQuery('.single_add_to_cart_button.disabled').css('pointer-event','none');
			}
			jQuery(".single_add_to_cart_button").click(function(event){
				if(jQuery("#pa_size").val() == ''){
					
					//jQuery('.singular-product form table').after('<p class="error">Please choose product options..</p>');
					jQuery( this ).off( event );
					jQuery(this).addClass('animated shake');
					
					return false;
					
				}
			});
			alert = function(){};
			if(jQuery("#pa_size").val() != ''){
					jQuery('.singular-product .yith-wcpsc-product-table-responsive-container .error').empty();
					return false;
			}
   		});
		
		/***************************End Woocommerce jQuery************************/
		
		
		/***************************jQuery Fly to Cart******************************/
		
		
		
		
		
		
		
		jQuery( ".single-wish .shar-btn" ).click(function() {
  			jQuery( ".single-wish .social" ).toggle("slide");
			//jQuery( ".review-wrapper" ).toggleClass("review-open");
		});
		
		jQuery( ".share-sec .shar-btn" ).click(function() {
  			jQuery(this).next().toggle(1000);
			//jQuery( ".review-wrapper" ).toggleClass("review-open");
		});
		
		
		
		
		jQuery(".iconic-woothumbs-all-images-wrap").appendTo(".right-sec");
		jQuery('.entry-summary form.cart').appendTo(".left-sec");
		
		jQuery('.entry-summary .pwb-single-product-brands').hide();
		
		
/*******************************Cart Page Grid View*******************************************************/
		/*jQuery(".page-cart .grid-view").hide();
		jQuery("#cart-g").click(function() {
			jQuery(this).toggleClass('active');
			jQuery(".page-cart .grid-view").show('slow');
			jQuery(".page-cart .slider-view").hide('slow');										 
		});
		jQuery("#cart-s").click(function() {
			jQuery(this).toggleClass('active');
			jQuery(".page-cart .grid-view").hide('slow');
			jQuery(".page-cart .slider-view").show('slow');										 
		});*/
/*******************************End Cart Page Grid View*******************************************************/		
		//jQuery(".page-cart .grid-view").hide();
		jQuery("#cart-g").click(function() {
			jQuery(this).toggleClass('active');
			jQuery("#cart-s").toggleClass('active');
			jQuery(".page-cart #cart-products").addClass('grid-view');
			jQuery('#cart-products.slider-view').slick("unslick");
			jQuery(".page-cart #cart-products").removeClass('slider-view');	
			//jQuery( ".wrap-div" ).wrapAll( "<div class='grid-product-right' />");
		});
		jQuery("#cart-s").click(function() {
			//jQuery(this).toggleClass('active');
			jQuery(this).toggleClass('active');
			jQuery("#cart-g").toggleClass('active');
			jQuery(".page-cart #cart-products").removeClass('grid-view');
			jQuery(".page-cart #cart-products").addClass('slider-view');	
			
			jQuery('#cart-products.slider-view').slick({
			  dots: true,
			  infinite: false,
			  speed: 300,
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1199,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{

				  breakpoint: 767,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
											 
		});
/********************************End Cart Page Grid View********************************************************/
/*******************************Wishlist Page Grid View*******************************************************/
		jQuery(".page-wishlist .grid-view").hide();
		jQuery("#wish-g").click(function() {
			jQuery(this).addClass('active');
			jQuery("#wish-s").removeClass('active');
			
			jQuery(".page-wishlist .grid-view").show('slow');
			jQuery(".page-wishlist .slider-view").hide('slow');										 
		});
		jQuery("#wish-s").click(function() {
			jQuery(this).addClass('active');
			jQuery("#wish-g").removeClass('active');
			jQuery(".page-wishlist .grid-view").hide('slow');
			jQuery(".page-wishlist .slider-view").show('slow');										 
		});
/********************************End Wishlist Page Grid View********************************************************/
		
		
		
		
jQuery('#best-seller').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
		});
jQuery('#all-items').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
		});
/********************Start Cart Page Slider********************************/
/********************End Cart Page Slider********************************/
/***************************Wish List Page Slider********************************************/
jQuery('#wishlist-products').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1199,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/***************************End Wish List Page Slider**********************************************/
/**************************Instragram Slider****************************************************/
jQuery('.jr-insta-thumb ul').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow:6,
			  slidesToScroll:3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1199,
				  settings: {
					slidesToShow:4,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				
				{
				  breakpoint: 768,
				  settings: {
					slidesToShow: 4,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				  
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 480,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/*************************End instragram Slider**********************************************/
jQuery('.mat-tester').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
		});
    /*var $status = jQuery('.pagingInfo');
    var $slickElement = jQuery('#content-wrap ul.products');
    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
        //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
        var i = (currentSlide ? currentSlide : 0) + 1;
        $status.text(i + '/' + slick.slideCount);
    });*/
	
/********************Shop Page Slider Content*****************************/
var lis = jQuery(".shop.archive-product #content-wrap li");
    for(var i = 0; i < lis.length; i+=15) {
      lis.slice(i, i+15)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.shop.archive-product #content-wrap ul.products').unwrap();
jQuery('.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/********************End Shop Page Slider Content*****************************/
/********************Start Collection page Slider Content*****************************/
/*var dwd = jQuery(".collection-area ul.products li");
    for(var i = 0; i < dwd.length; i+=7) {
      dwd.slice(i, i+7)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.collection-area ul.products').unwrap();
jQuery('.collection-area ul.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});*/
/********************End Collection page Slider Content*****************************/
/********************Start Collection Category page Slider Content*****************************/
/*var dwd = jQuery(".taxonomy-collection ul.products li");
    for(var i = 0; i < dwd.length; i+=7) {
      dwd.slice(i, i+7)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.taxonomy-collection ul.products').unwrap();
jQuery('.taxonomy-collection ul.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});*/
/********************End Collection Category page Slider Content*****************************/
/********************No products page Slider Content*****************************/
var nopro = jQuery("ul.no-pro li");
    for(var i = 0; i < nopro.length; i+=7) {/*
      nopro.slice(i, i+7)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    */}
	
	
	
jQuery('ul.no-pro').unwrap();
jQuery('ul.no-pro ul.list_unstyled').slick({/*
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
*/});
/********************End No products page Slider Content*****************************/
/************************Related Products Content*************************************/
var relat = jQuery(".singular-product ul.products li");
    for(var i = 0; i < relat.length; i+=12) {
      relat.slice(i, i+12)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.singular-product ul.products').unwrap();
jQuery('.singular-product ul.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 8,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/**************End Related Products***************************************************/
/************************Recently View Products Content*************************************/
var sddw = jQuery(".recent_products ul.product_list_widget li");
    for(var i = 0; i < sddw.length; i+=12) {
      sddw.slice(i, i+12)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.recent_products ul.product_list_widget').unwrap();
jQuery('.recent_products ul.product_list_widget ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 8,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/**************End Recently View Products***************************************************/
/*************************Brand Product Carsual********************************************/
/*var brand = jQuery(".taxonomy-pwb-brand ul.products li");
    for(var i = 0; i < brand.length; i+=7) {
      brand.slice(i, i+7)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.taxonomy-pwb-brand ul.products').unwrap();
jQuery('.taxonomy-pwb-brand ul.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});*/
/*************************End Brand Product Carsual********************************************/
/**************************Sale Product Slider************************************************/
var sale = jQuery(".page-template-sale ul.products li");
    for(var i = 0; i < sale.length; i+=8) {
      sale.slice(i, i+8)
         .wrapAll("<ul class='list_unstyled' id='"+i+"'></ul>");
    }
	
jQuery('.page-template-sale ul.products').unwrap();
jQuery('.page-template-sale ul.products ul.list_unstyled').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
});
/**************************End Sale Product Slider************************************************/
/***************************Menu Widget Carsual***********************************************/
jQuery('.best-sell-slide').slick({
			  //setPosition: slick,					 
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 4,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
			  
});
jQuery('.best-pro-slide').slick({
		      dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
			  
});
/*************************End Menu Widget Carsual**************************************/
jQuery('.category-area .categories ul').slick({
		      dots: false,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 1,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
			  
	});




jQuery('.sellers-area .categories ul').slick({
		      dots: false,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 6,
			  slidesToScroll: 3,
			  nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
			  prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			  responsive: [
				{
				  breakpoint: 1024,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				  }
				},
				{
				  breakpoint: 767,
				  settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				  }
				},
				{
				  breakpoint: 481,
				  settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				  }
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			  ]
			  
	});



});



// JavaScript Document
//qTranslate hack for custom text input
//source input has to have class qtranslatable-input for this to work
var qtranslatable_inputs_init = function(){
    var selector = ".qtranslatable-input";
    jQuery(selector).each(function(index){       
        var input_id = jQuery(this).attr("id");
        var input_class = jQuery(this).attr("class");
        var _this = this;
        var integrated = jQuery(this).attr('value');
        var splitted = qtrans_split(integrated);
        jQuery.each(Qtranslate.enabled_languages, function(value){
            var new_id = input_id+'_'+Qtranslate.enabled_languages[value];
            jQuery(_this).before('<label for="'+new_id+'">'+Qtranslate.enabled_languages[value]+'</label>');
            jQuery(_this).before('<input id="'+new_id+'" type="text" class="'+input_class+'" value="'+splitted[Qtranslate.enabled_languages[value]]+'" >');
            var lang_input = jQuery('#'+new_id);            
            jQuery(_this).css( "display", "none" );
            jQuery(lang_input).on("input", null, null,function(){
                jQuery.each(Qtranslate.enabled_languages, function(v){   
                    var _new_id = input_id+'_'+Qtranslate.enabled_languages[v];
                    var _lang_input = jQuery('#'+_new_id); 
                    jQuery(_this).attr("value", qtrans_integrate(Qtranslate.enabled_languages[v],_lang_input.attr('value'),jQuery(_this).attr('value')));
                });
            });	                        
        });
    });
}
jQuery(document).ready(function() {
								
	
	jQuery('form').attr('autocomplete','off');
	
    qtranslatable_inputs_init();
	
	jQuery( "#tabs" ).tabs();
	
	
	var height = jQuery("#cart-products").height();
	jQuery(".woocommerce-cart-form #cart-products").css('height',height);
	
	
	
	/*if('.singular-product div').hasClass('pswp--open'){
		jQuery('body').addClass('zoom-in');	
	}*/
	
	
	
	
	
	
	
	jQuery('.ubermenu-target-description').hide();
	
	jQuery('.singular-product .qty-txt').prependTo('.singular-product .quantity');
	jQuery('.singular-product .btn-cancle').insertAfter('.singular-product .quantity');
	
	
	
	if (jQuery(window).width() < 969) {
   		jQuery('.singular-product #content-wrap .right-sec').insertBefore('.singular-product #content-wrap .left-sec');
	}
	
	
	
	
	
	jQuery('.out-of-stock .single_add_to_cart_button').prop('disabled', true);
	
	/*****************************Disable submit button jQuery***************************/
	
	/*jQuery('.woocommerce-form-login :input[type="submit"]').prop('disabled', true);
     jQuery('.woocommerce-form-login input[type="text"]').keyup(function() {
			if(jQuery(this).val().length !=0){
				jQuery('.woocommerce-form-login input[type="password"]').keyup(function() {
					if(jQuery('.woocommerce-form-login input[type="password"]').val().length !=0){																	   
						jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled', false);
					} else {
						jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled',true);	
					}
				});
				return false;
			}
			else {
				jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled',true);
				return false;
			}
    });
	jQuery('.woocommerce-form-login input[type="password"]').keyup(function() {
			if(jQuery(this).val().length !=0){
				if(jQuery('.woocommerce-form-login input[type="text"]').val().length !=0){																	   
						jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled', false);
					} else {
						jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled',true);	
				}
			}
			else {
				jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled',true);
			}
     });*/
	
	jQuery('.woocommerce-form-login :input[type="submit"]').prop('disabled', true);
	jQuery('.woocommerce-form-login input').keyup(function() {

        var empty = false;
        jQuery('.woocommerce-form-login input').each(function() {
            if (jQuery(this).val().length == 0) {
                empty = true;
            }
        });

        if (empty) {
            jQuery('.woocommerce-form-login :input[type="submit"]').attr('disabled', 'disabled');
        } else {
            jQuery('.woocommerce-form-login :input[type="submit"]').removeAttr('disabled');
        }
    });
	/*************************End Siable submit button jQuery*******************************/	
		
	
	/********Change Login Page error*************/
	if(jQuery('.woocommerce #customer_login .u-column1').hasClass('login-form')){
		jQuery('.woocommerce .woocommerce-error').addClass('login-error');
		jQuery('.woocommerce .woocommerce-error li').empty();
		jQuery('.woocommerce .woocommerce-error li').after('<span><strong>Login failed</strong> Username or password are not correct.</span><p>Please try again or register account.</p>');
	}
	
	if(jQuery('.woocommerce #customer_login .u-column2').hasClass('registration-form')){
		jQuery('.woocommerce .woocommerce-error').addClass('signup-error');
	}
	
	
	
	
	/********End Login page Error*************/
	
	//jQuery(".post-nav").appendTo(".right-sec");
	
	
	var itemsCount = jQuery(".yith-wcpsc-product-table th").length;
	if(itemsCount == 6){
		 jQuery(".yith-wcpsc-product-table").addClass('row-xxl');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
})


    





