function wishlist_sec() {

    if (jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').hasClass('disabled-add-wishlist')) {
        if (jQuery('.tinvwl-before-add-to-cart').prev().hasClass('error')==false) {
            jQuery('.tinvwl-before-add-to-cart').before('<p class="error">Please choose product option</p>');
        }       
    }

    if (!jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').hasClass('disabled-add-wishlist')) {
        jQuery('.variations_form .error').remove();
    }
}


jQuery(document).ready(function () {

    var current_val = jQuery('.page-cart .quantity .qty').val();
    var cur_main = parseInt(current_val);
    var max_val = jQuery('.page-cart .quantity .qty').attr('max');
    var min_val = parseInt(jQuery('.page-cart .quantity .qty').attr('min'));


	
	/************************Wishlist Button*****************************************/
	if(jQuery('.singular-product .content .left-sec .cart .single_add_to_cart_button').hasClass('disabled')){
		jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').addClass('disabled');
	}
	
	jQuery(".singular-product .content .left-sec .yith-wcpsc-product-table tr th span").click(function() {
		if(jQuery('.singular-product .content .left-sec .cart .single_add_to_cart_button').hasClass('disabled')){
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').addClass('disabled');
		} else {
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').removeClass('disabled');
		}																								   
	});
	
	jQuery(".singular-product .content .left-sec .variations span.swatch-color .selected").click(function() {
		if(jQuery('.singular-product .content .left-sec .cart .single_add_to_cart_button').hasClass('disabled')){
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').addClass('disabled');
		} else {
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').removeClass('disabled');
		}																								   
	});
	
	/*********************End Wishlist Button***************************************/
	
	
	
    /*if (cur_main == min_val) {
        jQuery(this).parent().parent().parent().find('a.wac-btn-sub').addClass('disable');
    }*/

    if (cur_main == max_val) {
        jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-inc').addClass('disable');
    }
    jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-sub').removeClass('disable');




	jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-sub').each(function() {
	    var current_val = jQuery(this).parent().parent().parent().find('input').val();
	    var cur_main = parseInt(current_val);
	    var min_val = jQuery(this).parent().parent().parent().find('input').attr('min');
		debugger;
		if (cur_main == min_val) {
			
			jQuery(this).addClass('disable');
		}
	});


    jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-inc').on('click', function (e) {

        var current_val = jQuery(this).parents().prev().val();
        var cur_main = parseInt(current_val) + 1;
        var max_val = jQuery(this).parents().prev().attr('max');
        if (cur_main == max_val) {
            jQuery(this).addClass('disable');
        }
        var ab = jQuery(this).parent().parent().parent();
        jQuery(ab).find('a.wac-btn-sub').removeClass('disable')



    });

    jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-sub').on('click', function (e) {
		
		var cur_val = jQuery(this).parent().parent().parent().find('input').val();
		
		var crr_main = parseInt(cur_val);
    	var min_crr = parseInt(jQuery('.page-cart .quantity .qty').attr('min'));
		
		if (crr_main == min_crr) {
        	jQuery(this).parent().parent().parent().find('a.wac-btn-sub').addClass('disable');
    	}
		
        var qty = parseInt(jQuery(this).parent().parent().parent().find('input').val());
        if (qty == 2) {
            jQuery(this).addClass('disable');
            jQuery(this).parent().parent().parent().find('input').val(2);
        }
        else {

            var ab = jQuery(this).parent().parent().parent();
            jQuery(ab).find('a.wac-btn-inc').removeClass('disable')

            var current_val = jQuery('.page-cart .quantity .qty').val();
            var cur_main = parseInt(current_val) - 1;
            var min_val = jQuery('.page-cart .quantity .qty').attr('min');
            if (cur_main == min_val) {
                jQuery(this).addClass('disable');
            }
        }




    });






    jQuery('.tinvwl_add_to_wishlist_button').attr('onClick', 'wishlist_sec()');
	// jQuery('.singular-product .content .left-sec .cart .single_add_to_cart_button').attr('onClick', 'wishlist_sec()');


    if (jQuery('.singular-product .content .left-sec .woocommerce-variation-add-to-cart').hasClass('woocommerce-variation-add-to-cart-enabled')) {
        jQuery('.singular-product .content .error').remove();
    }

    jQuery('.woocommerce-checkout .woocommerce .form #shipping_address_1_field').insertAfter('.woocommerce-checkout .woocommerce .form #shipping_myfield10_field');







    /********************User Menu Toggle Open********************************/
    //var focusInput = true;
    jQuery(".top-menu .admin-menu").click(function () {
        if (jQuery('.top-menu .user-menu').is(':visible')) {
            jQuery(".top-menu .user-menu").hide("slide");
            jQuery(".top-menu .user-menu").addClass("menu-open");
            return false;
        } else {
            jQuery(".top-menu .user-menu").show("slide");
            jQuery(".top-menu .user-menu").removeClass("menu-open");

            if (jQuery(".search-form").hasClass("open")) {
                jQuery(".search-form").hide("slide");
                jQuery(".search-form").removeClass("open");
                jQuery(".dgwt-wcas-sf-wrapp input[type='search'].dgwt-wcas-search-input").blur();
            }
            //focusInput = !focusInput;

            return false;
        }
    });
    jQuery(".top-menu .user-menu .close").click(function () {
        jQuery(".top-menu .user-menu").hide("slow");
        jQuery(".top-menu .user-menu").removeClass("menu-open");
        return true;
    });

    jQuery(window).click(function (event) {
        if (jQuery(event.target).hasClass('user-menu')) {
            return false;
        }
        if (jQuery('.top-menu .user-menu').is(':visible')) {
            jQuery(".top-menu .user-menu").hide("slide");
            jQuery(".top-menu .user-menu").addClass("menu-open");
        }
        event.stopPropagation();
    });
    /*jQuery(".top-menu .admin-menu").click(function(e) { // Wont toggle on any click in the div
        e.stopPropagation();
    });*/
    /********************End User Menu Toggle Open********************************/


	
	
	


});

jQuery(window).load(function () {
    jQuery('#shipping_address_1_field').insertAfter('#shipping_myfield10_field');

});