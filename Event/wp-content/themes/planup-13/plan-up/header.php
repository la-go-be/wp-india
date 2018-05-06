<?php

$customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');

$logo = isset($customizer['logo']) ? $customizer['logo'] : array('attachment_id' => '', 'url' => get_template_directory_uri().'/images/df-logo.png');

$logo_2 = isset($customizer['logo_2']) ? $customizer['logo_2'] : array('attachment_id' => '', 'url' => get_template_directory_uri().'/images/df-logo.png');

$sticky_nav = isset($customizer['sticky_nav']) ? $customizer['sticky_nav'] : false;

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>

<link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/css/bootstrap-glyphicons.css' type='text/css' media='all' />


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
 jQuery(document).ready(function(){
 		
		var cur_val = jQuery('.no_part').val();
		if(cur_val == '1'){
			jQuery('table.wccpf_fields_table.Participate-1.part-name-wrapper').hide();
			//jQuery('.single_add_to_cart_button').removeAttr('disabled','disable');
		}
		
		/*jQuery('input.wccpf-field.part-name.enable').blur(function(){
			jQuery('input.wccpf-field.part-name.enable').each(function() {
			
				  var inp = jQuery('input.wccpf-field.part-name.enable').val();
				  if(jQuery.trim(inp).length > 0)
				  {
					 jQuery('.single_add_to_cart_button').removeAttr('disabled','disable');
				  } else if(jQuery.trim(inp).length = 0){
				  	jQuery('.single_add_to_cart_button').attr('disabled','disable');
				  }
			  } );
 		});*/
		
		
 
		
		
		//jQuery('.single_add_to_cart_button').attr('disabled','disable');
		
		jQuery('.no_part').before('<button type="button" class="btn btn-default btn-number minus" disabled="disabled" data-type="minus" data-field="no_of_participate"><span class="glyphicon glyphicon-minus"></span></button>');
		
		jQuery('.no_part').after('<button type="button" class="btn btn-default btn-number plus" data-type="plus" data-field="no_of_participate"><span class="glyphicon glyphicon-plus"></span></button>');
		
		
		jQuery('.btn-number').click(function(e){
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


		jQuery('.no_part').focusin(function(){
		   jQuery(this).data('oldValue', jQuery(this).val());
		});


		jQuery('.no_part').change(function() {
			
			minValue =  parseInt(jQuery(this).attr('min'));
			maxValue =  parseInt(jQuery(this).attr('max'));
			valueCurrent = parseInt(jQuery(this).val());
			
			name = jQuery(this).attr('name');
			if(valueCurrent >= minValue) {
				jQuery(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the minimum value was reached');
				jQuery(this).val(jQuery(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
				jQuery(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the maximum value was reached');
				jQuery(this).val(jQuery(this).data('oldValue'));
			}
			
			
		});
		jQuery(".no_part").keydown(function (e) {
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
	
		var min_val = jQuery('.wccpf_fields_table .min_part').val();
		var max_val = jQuery('.wccpf_fields_table .max_part').val();
		
		
		if(min_val == max_val){
			jQuery('.max_part-wrapper').hide();
		}
		
		jQuery('.wccpf_fields_table .no_part').attr('min',min_val);
		jQuery('.wccpf_fields_table .no_part').attr('max',max_val);
		
		jQuery('.wccpf_fields_table .no_part').val(min_val);
		
		jQuery('table.wccpf_fields_table.part-name-wrapper').hide();
		
		
    		var select_val = jQuery('.wccpf_fields_table .no_part').val();
			
			for (i =2; i<=select_val; i++) {
				jQuery('table.wccpf_fields_table.Participate-'+i+'.part-name-wrapper').show();
				jQuery('table.wccpf_fields_table.Participate-'+i+'.part-name-wrapper input[type="text"]').addClass('enable');
			}
		
		
		
		jQuery(".wccpf_fields_table .plus").click(function() {
    		var select_val = jQuery('.wccpf_fields_table .no_part').val();
			
			
			//jQuery('.single_add_to_cart_button').attr('disabled','disable');
			for (i =2; i<=select_val; i++) {
				jQuery('table.wccpf_fields_table.Participate-'+i+'.part-name-wrapper').show();
				jQuery('table.wccpf_fields_table.Participate-'+i+'.part-name-wrapper input[type="text"]').addClass('enable');
				
				
			}
		});
		
		jQuery(".wccpf_fields_table .minus").click(function() {
			var sele_val = jQuery('.wccpf_fields_table .no_part').val();
    		var select_minus = +jQuery('.wccpf_fields_table .no_part').val()+1;
			
			if(sele_val == '1'){
				//jQuery('table.wccpf_fields_table.Participate-1.part-name-wrapper').hide();
				jQuery('.single_add_to_cart_button').removeAttr('disabled','disable');
			}
			
			//var sel_plus = select_minus+1;
			
			//for (i=select_minus; i>=1; i--) {
				jQuery('table.wccpf_fields_table.Participate-'+select_minus+'.part-name-wrapper').hide();
				jQuery('table.wccpf_fields_table.Participate-'+select_minus+'.part-name-wrapper input[type="text"]').removeClass('enable');
			//}
		});
		
		
		//jQuery('table.wccpf_fields_table.part-name-wrapper.enable').
		var minVal=parseInt(jQuery('.wccpf_fields_table .min_part').val());
		
		for (i =2; i<=minVal; i++) {
			jQuery('table.wccpf_fields_table.Participate-'+i+'.part-name-wrapper input[type="text"]').addClass('ab');
			}
			
		var result=false;
		jQuery('.single_add_to_cart_button ').click(function(){
		  
		
		  
		  		 debugger;		  
		  jQuery('.ab').each
		  (
		  	function(index, elem)
			 { 
		     if(jQuery(elem).val()!="")
	 				{
					  result = true;					  
	 				}
	 		else
	 				{

					  result = false;
					  return result;
	 				}
			 }
		   )
		   
		   if(result==false)
		   {
		   						alert('Please Add Participate Name');
		   }
		   
		   return result;	 				  		  			  
		  });
		 
		 
 });
 


		 
 	
	
	
</script>
</head>



<body <?php body_class(); ?>>

<?php if (isset($customizer['c_back_to_top_show']) && $customizer['c_back_to_top_show']): ?>

	<i class="ion-arrow-up-a" id="back-to-top"></i>

<?php endif ?>

<div id="page" class="hfeed site">

	<?php if( !is_page_template('page-templates/template-comming.php' ) ): ?>

	<header id="masthead" class="site-header">

		<div class="blog-header-wrapper <?php echo ($sticky_nav) ? 'has_sticky' : ''; ?>">

			<div class="blog-header">

				<div class="site-branding">

					<h1 class="site-title">

						<a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">

							<img class="logo-df" src="<?php echo esc_url($logo['url']); ?>" alt="<?php bloginfo( 'name' ); ?>">

							<img class="logo-sticky" src="<?php echo esc_url($logo_2['url']); ?>" alt="<?php bloginfo( 'name' ); ?>">

						</a>

					</h1>

				</div><!-- .site-branding -->

				<div class="blog-navigation">

					<nav id="site-navigation" class="main-navigation">

						<?php

							$menu_position = 'primary';

							if ( has_nav_menu( $menu_position ) ) {

								wp_nav_menu(array(

									'theme_location' => $menu_position,

									'menu_class'      => 'menu '.$menu_position,

									'walker' => new PlanUp_Walker_Nav_Menu()

								));

							}

						?>

					</nav><!-- #site-navigation -->

				</div>

			</div>

			<div id="dl-menu" class="dl-menuwrapper">

				<button class="dl-trigger">Open Menu</button>

				<ul class="dl-menu <?php echo esc_attr($menu_position); ?>">

					<?php

						if ( has_nav_menu( $menu_position ) ) {

							// User has assigned menu to this location;

							// output it

							wp_nav_menu( array(

								'theme_location' => $menu_position,

								'items_wrap'      => '%3$s',

								'container'       => false,

								'walker' => new HTDL_Walker_Nav_Menu()

							) );

						}

					?>

				</ul>

			</div><!-- /dl-menuwrapper -->

		</div>

		<?php get_template_part( 'template','banner' ); ?>

	</header><!-- #masthead -->

	<?php endif; ?>

	<div class="ht-flash-message">

		<?php if (defined('FW')) { FW_Flash_Messages::_print_frontend(); } ?>

	</div>

	<div id="site-content" class="site-content">