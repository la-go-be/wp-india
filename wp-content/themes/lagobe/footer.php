		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_wrapper_end' );
		?>
		</div><!-- #main -->
		<?php //get_template_part( 'template-parts/footer', 'subfooter' ); // Loads the template-parts/footer-subfooter.php template. ?>
		<?php //get_template_part( 'template-parts/footer', 'footer' ); // Loads the template-parts/footer-footer.php template. ?>
		<?php //get_template_part( 'template-parts/footer', 'postfooter' ); // Loads the template-parts/footer-postfooter.php template. ?>
	</div><!-- #page-wrapper -->
<?php $_SESSION['item'] = $_GET['item']; ?>
<?php
if($_SESSION['from'] == 'checkout'){
add_filter('woocommerce_login_redirect', 'login_redirect');
function login_redirect($redirect_to) {
	   return WC()->cart->get_checkout_url();
	}	
}
if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
	add_filter('login_redirect', 'my_login_redirect', 10, 3);
	function my_login_redirect() {
		$location = $_SERVER['HTTP_REFERER'];
		wp_safe_redirect($location);
		exit();
	}
}
if ( (isset($_GET['action']) && $_GET['action'] != 'logout') || (isset($_POST['login_location']) && !empty($_POST['login_location'])) ) {
	add_filter('woocommerce_registration_redirect', 'my_regis_redirect', 10, 3);
	function my_regis_redirect() {
		$location = $_SERVER['HTTP_REFERER'];
		wp_safe_redirect($location);
		exit();
	}
}
add_action('wp_logout','logout_redirect');
function logout_redirect(){
    if( function_exists('WC') ){
		global $woocommerce;
  		// get user details
		global $current_user;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		$cart_contents = $woocommerce->cart->get_cart();
		$meta_key = 'cart-'.$user_id;
		$meta_value = $cart_contents;
		//update_user_meta( $user_id, $meta_key, $meta_value);
		update_option( $meta_key, $meta_value );
        WC()->cart->empty_cart();
    }
    wp_safe_redirect( home_url() );
    exit();
}
?>
<?php
add_filter( 'query_vars', 'addnew_query_vars', 10, 1 );
function addnew_query_vars($vars)
{   
    $vars[] = 'var1'; // var1 is the name of variable you want to add       
    return $vars;
}
?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
jQuery(window).load(function() {
	
	setInterval(function()
	{ 
	<?php if($_SESSION['item'] == 'man') { ?>
	jQuery(".fly-cart a").attr("href",'<?php site_url(); ?>/cart/?item=man');
	<?php } else if($_SESSION['item'] == 'woman') { ?> 
	jQuery(".fly-cart a").attr("href",'<?php site_url(); ?>/cart/?item=woman');
	<?php } else if($_SESSION['item'] == 'combine'){ ?>  
	jQuery(".fly-cart a").attr("href",'<?php site_url(); ?>/cart/?item=combine');
	<?php } else { ?>
	jQuery(".fly-cart a").attr("href",'<?php site_url(); ?>/cart/?item=combine');
	<?php } ?>	
	}, 1000);
});	
jQuery( document ).ready(function() {
 	
	jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button.disabled-add-wishlist').click(function() {
		jQuery('.tinvwl-before-add-to-cart').before('<p class="error">Please suggest product Option</p>');
	});
	
	jQuery('.vb-registration-form .slider, .vb-registration-form .mail-span').appendTo('.vb-registration-form > #mailpoet_checkout_subscription_field label');
	
	var shipping_first = jQuery('.vb-registration-form #billing_first_name_n').val();
	jQuery('.woocommerce-shipping-fields #shipping_first_name').val(shipping_first);
	
	var shipping_last = jQuery('.vb-registration-form #billing_last_name_n').val();
	jQuery('.woocommerce-shipping-fields #shipping_last_name').val(shipping_last);
	
	
	
	/*jQuery('.product-quantity .wac-qty-button .wac-btn-inc').addClass('enable');
	jQuery('.page-cart .product-quantity .wac-qty-button .wac-btn-inc').on('click', function(e) {
		
		jQuery('.product-quantity .wac-qty-button .wac-btn-sub').removeClass('disable');
		
		var quantity = jQuery('.page-cart .quantity .qty').val();
		var maximum = jQuery('.page-cart .quantity .qty').attr('max');
		var maxi = maximum-1;
		
		if(quantity == maxi){
			jQuery(this).addClass('disable');
			jQuery(this).off('click');
			jQuery(this).removeClass('enable');
		} else if(quantity < maxi){
			jQuery(this).addClass('enable');
			jQuery(this).unbind('click');
			jQuery(this).removeClass('disable');
		}
	});
	
	jQuery('.product-quantity .wac-qty-button .wac-btn-sub').on('click', function(e) {
		var quantity = jQuery('.page-cart .quantity .qty').val();
		var minimum = jQuery('.page-cart .quantity .qty').attr('min');
		var mimi = minimum+2; 
		
		jQuery('.product-quantity .wac-qty-button .wac-btn-inc').removeClass('disable');
		
		if(quantity == '1'){
			jQuery(this).addClass('disable');
			jQuery(this).removeClass('enable');
		} else if(quantity > '1'){
			jQuery(this).addClass('enable');
			jQuery(this).removeClass('disable');
		}
	
	});*/
	
	/*jQuery('.wac-btn-inc').on('click', function(e) {
		var val = parseInt(jQuery('.input-text').val());
			var max = parseInt(jQuery('.input-text').attr('max'));
			if(val < max) {
			  jQuery('.input-text').attr('value', val + 1);
			}
	});
	
	jQuery('.wac-btn-sub').on('click', function(e) {
		var val = parseInt(jQuery('.input-text').val());
		if (val !== 0) {
			jQuery('.input-text').attr('value', val - 1);
		}
	});*/
	jQuery('.wish-rmv').attr('href','javascript:void(0)');
 	jQuery('.wish-rmv').click(function(){
		 	var $checkbox = jQuery('li').find(':checkbox');
       			$checkbox.attr('checked', !$checkbox.attr('checked'));
	});
	
	/*if (jQuery(".single_variation_wrap button").hasClass('disabled')) {
  		jQuery('.tinv-wishlist').addClass('disabled');
	} else if(!jQuery(".single_variation_wrap button").hasClass('disabled')){
		jQuery('.tinv-wishlist').removeClass('disabled');
	}*/
/*jQuery(window).click(function(e){
	if (jQuery(".single_variation_wrap button").hasClass('disabled')) {
  		jQuery('.tinv-wishlist').addClass('disabled');
	} else if(!jQuery(".single_variation_wrap button").hasClass('disabled')){
		jQuery('.tinv-wishlist').removeClass('disabled');
	}
});*/
 	
	jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button.disabled-add-wishlist').click(function() {
		jQuery('.tinvwl-before-add-to-cart').before('<p class="error">Please choose product option</p>');
	});
	
<?php if(is_front_page()){ ?>
jQuery(document).keypress(function(e) {
  if(e.which == 13) {
	window.location.replace("<?php echo esc_url( get_permalink(465)); ?>");
  }
});
<?php }?> 
  
  function GetParameterValues(param) {
	var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < url.length; i++) {
			var urlparam = url[i].split('=');
			if (urlparam[0] == param) {
			return urlparam[1];
			}
		}
	}
  
  
<?php if (strpos($_SERVER['REQUEST_URI'], "/man") !== false){ ?>
	var url = window.location.toString();            
      	if (url.indexOf('?') == -1) {
         window.location = url + "?item=man";
    }
<?php } else if (strpos($_SERVER['REQUEST_URI'], "/woman") !== false){ ?>
	var url = window.location.toString();            
      	if (url.indexOf('?') == -1) {
         window.location = url + "?item=woman";
    }
<?php }	else if (strpos($_SERVER['REQUEST_URI'], "/combine") !== false){ ?>
	var url = window.location.toString();            
      	if (url.indexOf('?') == -1) {
         window.location = url + "?item=combine";
    }
<?php } else { ?>
	var url = window.location.toString();            
      	if (url.indexOf('?') == -1) {
         window.location = url + "?item=main";
    }
<?php } ?>
	
	<?php /*if($_SESSION['item'] == '') { ?>
	var url = window.location.toString();            
      	if (url.indexOf('?') == -1) {
         window.location = url + "?item=main";
    	}
	<?php }*/ ?>	
		
		
	
	
	//jQuery( ".entry-content input[type=password]").after('<div class="icon"><i class="fa fa-eye" aria-hidden="true"></i></div>');
	jQuery( ".entry-content input[type=password]").hidePassword(true);
	
	  jQuery(".icon").click(function() {
			if (jQuery(".entry-content input[type=password]").attr("type") == "password") {
			  jQuery(".entry-content input[type=password]").attr("type", "text");
			} 
		});	
	jQuery(".icon").click(function() {
			if (jQuery(".entry-content input[type=password]").attr("type") == "text") {
		  		jQuery(".entry-content input[type=password]").attr("type", "password");
			}
	  });
  
	
	<?php if($_SESSION['item'] == 'man') { ?>
	jQuery(".site-logo-mixed-image a").attr("href", "<?php echo site_url(); ?>/man?item=man");
	<?php } else if($_SESSION['item'] == 'woman') { ?>
	jQuery(".site-logo-mixed-image a").attr("href", "<?php echo site_url(); ?>/woman?item=woman");
	<?php } else if($_SESSION['item'] == 'combine' || $_SESSION['item'] == 'main') { ?>
	jQuery(".site-logo-mixed-image a").attr("href", "<?php echo site_url(); ?>/combine?item=combine");
	<?php } else { ?>
	jQuery(".site-logo-mixed-image a").attr("href", "<?php echo site_url(); ?>/combine?item=combine");
	<?php }?>
	var qsString = GetParameterValues('orderby');
	
	  jQuery(".sidebar-left-bottom #side-left-btm .woocommerce-ordering select > option").each(function() {
		if (this.value == qsString) {
		  this.selected = 'selected';
		}
	  });
  
	
	/**/
		
	
	
	
	jQuery('a').not( ".ubermenu-target-with-image, .choose, .custom-logo-link, .tinvwl_add_to_wishlist_button, .btn-cancle, .back-arrow a, .page-checkout .actions ul li a, .close-icn a, .close-arrow a, .main-a a" ).attr( 'href', function(index, value) {
		<?php if($_SESSION['item'] == 'man') { ?>
			var queryString = (!/\?/.test(value) ? '?' : '&')+'item=man';
		  	return value + queryString;  
			
		<?php } else if($_SESSION['item'] == 'woman') { ?>  
			  var queryString = (!/\?/.test(value) ? '?' : '&')+'item=woman';
			  return value + queryString;  
		  	
		<?php } else if($_SESSION['item'] == 'combine') { ?>  
		  var queryString = (!/\?/.test(value) ? '?' : '&')+'item=combine';
		  return value + queryString;  
		<?php } ?>
	});
	
	
	jQuery(".wizard input#reg_email").attr("placeholder", "Email");
	
	jQuery(".wizard input#reg_password ").attr("placeholder", "Password");
	
	jQuery('.login-step #customer_login .col-2 h2').before('<h1>Guest.</h1>');
	
	
	jQuery("#customer_login .register").validate({
        rules: {
            reg_billing_first_name: {
                required: true,
                minlength: 5
            },
            reg_billing_last_name: {
                required: true
            },
            reg_email: {
                required: true
            },
            
        },
        messages: {
             reg_billing_first_name: "Please specify the First Name.",
             reg_billing_last_name: "Please specify the Last Name",
             reg_email: "Please specify the Email",
             
           },
        errorPlacement: function(error, element) {
            element.focus(function(){
            jQuery("span").html(error);
            }).blur(function() {
            jQuery("span").html('');
            });
        }
        });
	jQuery('.actions li a').click(function() {
		if (jQuery("#customer_login .register").valid()) {
			alert('form-valid');
		}	
	});
	
	
	
	
	
	
	var attr_size = '<?php echo $_GET['attribute_pa_size']?>';
	var attr_color = '<?php echo $_GET['attribute_pa_color']?>';
	
	jQuery(".singular-product .content .left-sec .yith-wcpsc-product-table tr th span").each(function() {
		if(jQuery(this).data('size')=='<?php echo $_GET['attribute_pa_size']?>'){
			jQuery(this).trigger("click");
		}
	});	
	
	
	jQuery(".singular-product .content .left-sec .variations span.swatch-color").each(function() {
		if(jQuery(this).data('value')=='<?php echo $_GET['attribute_pa_color']?>'){
			jQuery(this).trigger("click");
		}
	});	
	
	
	
	/*jQuery('.singular-product .content .left-sec .yith-wcpsc-product-table tr th span').click(function(){
		var body_size = jQuery(this).data('size');
		var body_color = jQuery('.singular-product .content .left-sec .variations span.swatch-color.selected').data('value');
		
		console.log(body_size);
		console.log(body_color);
		
		if((jQuery('.woocommerce div.product p.ava-product').data('color') == body_color) && (jQuery('.woocommerce div.product p.ava-product').data('size') == body_size)){
				if(body_color == 'navy-blue')
				{
						console.log('blue show');
				}
				else
				{
						console.log('red show');
				}
		} 
		else 
		{
		if((jQuery('.woocommerce div.product p.ava-product').data('color') == body_color) && (jQuery('.woocommerce div.product p.ava-product').data('size') == body_size)){
				console.log('No');
		}
		}
	});
	
	
	jQuery('.singular-product .content .left-sec .variations span.swatch-color.selected').click(function(){
		var body_color = jQuery(this).data('value');
		var body_size = jQuery('.singular-product .content .left-sec .yith-wcpsc-product-table tr th span active').data('size');
		
		console.log(body_size);
		console.log(body_color);
		
		if((jQuery('.woocommerce div.product p.ava-product').data('color') == body_color) && (jQuery('.woocommerce div.product p.ava-product').data('size') == body_size)){
				console.log('confirm');
		} 
		else 
		{
			if((jQuery('.woocommerce div.product p.ava-product').data('color') == body_color) && (jQuery('.woocommerce div.product p.ava-product').data('size') == body_size)){
					console.log('No');
			}
		}
	});*/
	
	
	jQuery('body').click(function(){
		if(jQuery('.singular-product .content .left-sec .cart .single_add_to_cart_button').hasClass('disabled')){
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').addClass('disabled');
		} else {
			jQuery('.singular-product .content .left-sec .cart .tinv-wishlist .tinvwl_add_to_wishlist_button').removeClass('disabled');
		}
	})
	
	
	
	<?php if ( is_user_logged_in() ) { ?>
	<?php 
	$current_user = wp_get_current_user();
	$ID = $current_user->ID;
	$billing_myfield14 = get_user_meta($ID, 'billing_myfield14', true); 
	$billing_myfield13 = get_user_meta($ID, 'billing_myfield13', true);
	$billing_myfield12 = get_user_meta($ID, 'billing_myfield12', true);
	
	$shipping_myfield12 = get_user_meta($ID, 'shipping_myfield12', true);
	$shipping_myfield11 = get_user_meta($ID, 'shipping_myfield11', true);
	$shipping_myfield10 = get_user_meta($ID, 'shipping_myfield10', true);
	
	
				
	
	?>
	
	jQuery("#billing_myfiel	d14").empty();
	jQuery("#billing_myfield14").append(jQuery("<option value='<?php echo $billing_myfield14; ?>' selected><?php echo $billing_myfield14; ?></option>"));
	
	jQuery("#billing_myfield13").empty();
	jQuery("#billing_myfield13").append(jQuery("<option value='<?php echo $billing_myfield13; ?>' selected><?php echo $billing_myfield13; ?></option>"));
	
	jQuery("#billing_myfield12").empty();
	jQuery("#billing_myfield12").append(jQuery("<option value='<?php echo $billing_myfield12; ?>' selected><?php echo $billing_myfield12; ?></option>"));
	
	
	jQuery("#shipping_myfield12").empty();
	jQuery("#shipping_myfield12").append(jQuery("<option value='<?php echo $shipping_myfield12; ?>' selected><?php echo $shipping_myfield12; ?></option>"));
	
	jQuery("#shipping_myfield11").empty();
	jQuery("#shipping_myfield11").append(jQuery("<option value='<?php echo $shipping_myfield11; ?>' selected><?php echo $shipping_myfield11; ?></option>"));
	
	jQuery("#shipping_myfield10").empty();
	jQuery("#shipping_myfield10").append(jQuery("<option value='<?php echo $shipping_myfield10; ?>' selected><?php echo $shipping_myfield10; ?></option>"));
	
	<?php } ?>	
	
	
	
	
	
	
		jQuery("#billing_postcode").keyup(function () {
				jQuery("#billing_myfield14").empty();
				jQuery("#billing_myfield13").empty();
				jQuery("#billing_myfield12").empty();
                $.ajax({
                    url: "https://sc.lagobe.com/apis/location/provinces?zipcode=" + jQuery('#billing_postcode').val() + "",
                    type: "Get",
                    success: function (data)
                    { 
                        jQuery("#billing_myfield14").empty();
                        jQuery("#billing_myfield14").append(jQuery("<option value='Seelct'> Seelct Province</option>"));
                       
                        for (var i = 0; i < data.length; i++)
                        {
                            jQuery("#billing_myfield14").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                        }  
                    },
                    error: function (msg) { alert(msg); }
                });
        });
        jQuery("#billing_myfield14").change(function () {
            $.ajax({
                url: "https://sc.lagobe.com/apis/location/amphurs?zipcode=" + jQuery('#billing_postcode').val() + "&province=" + jQuery('#billing_myfield14').val() + "",
                type: "Get",
                success: function (data) {
                    jQuery("#billing_myfield13").empty();
					jQuery("#billing_myfield12").empty();
                    jQuery("#billing_myfield13").append(jQuery("<option value='Seelct'> Seelct Amphur</option>"));
                    for (var i = 0; i < data.length; i++) {
                         
                        jQuery("#billing_myfield13").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                    }
                },
                error: function (msg) { alert(msg); }
            }); 
        });
        jQuery("#billing_myfield13").change(function () {
            $.ajax({
                url: "https://sc.lagobe.com/apis/location/districts?zipcode=" + jQuery('#billing_postcode').val() + "&province=" + jQuery('#billing_myfield14').val() + "&amphur=" + jQuery('#billing_myfield13').val() + "",
                type: "Get",
                success: function (data) {
                    jQuery("#billing_myfield12").empty();
                    jQuery("#billing_myfield12").append(jQuery("<option value='Seelct'> Seelct District</option>"));
                    for (var i = 0; i < data.length; i++) {
                        jQuery("#billing_myfield12").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                    }
                },
                error: function (msg) { alert(msg); }
            });
        });
		
		jQuery("#shipping_postcode").keyup(function () {
				jQuery("#shipping_myfield12").empty();
				jQuery("#shipping_myfield11").empty();
				jQuery("#shipping_myfield10").empty();
				
                $.ajax({
                    url: "https://sc.lagobe.com/apis/location/provinces?zipcode=" + jQuery('#shipping_postcode').val() + "",
                    type: "Get",
                    success: function (data)
                    { 
                        jQuery("#shipping_myfield12").empty();
                        jQuery("#shipping_myfield12").append(jQuery("<option value='Seelct'> Seelct Province</option>"));
                       
                        for (var i = 0; i < data.length; i++)
                        {
                            jQuery("#shipping_myfield12").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                        }  
                    },
                    error: function (msg) { alert(msg); }
                });
        });
        jQuery("#shipping_myfield12").change(function () {
            $.ajax({
                url: "https://sc.lagobe.com/apis/location/amphurs?zipcode=" + jQuery('#shipping_postcode').val() + "&province=" + jQuery('#shipping_myfield12').val() + "",
                type: "Get",
                success: function (data) {
                    jQuery("#shipping_myfield11").empty();
                    jQuery("#shipping_myfield11").append(jQuery("<option value='Seelct'> Seelct Amphur</option>"));
                    for (var i = 0; i < data.length; i++) {
                         
                        jQuery("#shipping_myfield11").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                    }
                },
                error: function (msg) { alert(msg); }
            }); 
        });
        jQuery("#shipping_myfield11").change(function () {
            $.ajax({
                url: "https://sc.lagobe.com/apis/location/districts?zipcode=" + jQuery('#shipping_postcode').val() + "&province=" + jQuery('#shipping_myfield12').val() + "&amphur=" + jQuery('#shipping_myfield11').val() + "",
                type: "Get",
                success: function (data) {
                    jQuery("#shipping_myfield10").empty();
                    jQuery("#shipping_myfield10").append(jQuery("<option value='Seelct'> Seelct District</option>"));
                    for (var i = 0; i < data.length; i++) {
                        jQuery("#shipping_myfield10").append(jQuery("<option></option>").val(data[i]).html(data[i]));
                    }
                },
                error: function (msg) { alert(msg); }
            });
        });
		
});	
jQuery( function() {
    jQuery( "#user_dob, #usr-dob" ).datepicker({
				dateFormat : 'dd/mm/yy',
				changeMonth : true,
				changeYear : true,
				yearRange: '-100y:c+nn',
				maxDate: '-1d'
			});
  } );
jQuery(window).load(function() {  
	jQuery('#billing_address_1_field').insertAfter('#billing_myfield12_field');
	jQuery('#shipping_postcode_field').insertAfter('#shipping_myfield4_field');
	
	/*jQuery('.new-order').on('change', function() {
		 var selec =  this.value;
		 var url = window.location.href;
		 //console.log(url+"?FFFF=SSS");
		 window.location = url+"&orderby="+selec+" ";
	})*/
	jQuery('select').blur( function(){
	if( '' != jQuery('input.variation_id').val() )
		{
		var var_id = jQuery('input.variation_id').val();
		jQuery('.quantity-rem .varition-pro').each(function() {
        	var var_fd = jQuery(this).attr('id');
			
			if (jQuery(this).attr('id') == var_id) {
				jQuery('.quantity-rem .varition-pro').removeClass('active');
                jQuery(this).addClass('active');
            } 
        });
		} else {
			jQuery('.quantity-rem .varition-pro').removeClass('active');
		}
});
	
jQuery('select').blur( function(){
	if('' != jQuery('input.variation_id').val())
		{
		var var_id = jQuery('input.variation_id').val();
		jQuery('.rem-qty .cart-itm').each(function() {
        	var var_fd = jQuery(this).attr('data-id');
			if (jQuery(this).attr('data-id') == var_id) {
				jQuery('.rem-qty .cart-itm').removeClass('active');
                jQuery(this).addClass('active');
            } 
        });
		
		jQuery('.rem-qty .cart-itm').each(function() {
			console.log(jQuery(this).find(".active").attr('class'));
		});
		} else {
			jQuery('.rem-qty .cart-itm').removeClass('active');
		}
		
	});
	
	
	
	
	
	jQuery('select').blur(function(){
		jQuery('.woocommerce .quantity .qty').val('1');
			if( '' != jQuery('input.variation_id').val() )
			{
					var rem_pro = jQuery(".rem-qty .cart-itm.active").attr('data-rem');
					if (rem_pro != undefined || variable >= 0) {
					jQuery('.woocommerce .quantity .qty').attr('max',rem_pro);
				}
			} 
	});
});
</script>
<?php wp_footer(); // WordPress hook for loading JavaScript, toolbar, and other things in the footer. ?>
</body>
</html>