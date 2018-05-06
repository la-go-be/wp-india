<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<?php
// Fire the wp_head action required for hooking in scripts, styles, and other <head> tags.
wp_head();
?>
</head>
<body <?php hybridextend_attr( 'body' ); ?>>


<?php global $redux_demo; ?>
	<div <?php hybridextend_attr( 'page-wrapper' ); ?>>
		<div class="skip-link">
			<a href="#content" class="screen-reader-text"><?php _e( 'Skip to content', 'creattica' ); ?></a>
		</div><!-- .skip-link -->
		<?php
		// Template modification Hook
		do_action( 'hoot_template_site_start' );
		// Displays a friendly note to visitors using outdated browser (Internet Explorer 8 or less)
		hoot_update_browser();
		?>
	<div>
		
			<div class="single-header">
					<div id="site-logo" class="<?php
						echo 'site-logo-' . hoot_get_mod( 'logo' );
						if ( hoot_get_mod('logo_background_type') == 'accent' )
							echo ' accent-typo with-background';
						elseif ( hoot_get_mod('logo_background_type') == 'background' )
							echo ' with-background';
						?>">
						
						<?php hoot_logo(); ?>
					</div>
					
					<div class="desktop-menu">
						<?php if($_SESSION['item'] == 'man') { ?>
						<?php ubermenu( 'main' , array('menu' => 253 ) ); ?>
						<?php } else if($_SESSION['item'] == 'woman') { ?>
						<?php ubermenu( 'main' , array('menu' => 254 ) ); ?>
						<?php } else if($_SESSION['item'] == 'combine'){ ?>
						<?php ubermenu( 'main' , array( 'menu' => 60 ) ); ?>
						<?php } else { ?>
						<?php ubermenu( 'main' , array( 'menu' => 60 ) ); ?>
						<?php } ?>						
					</div>
					
					
				
					
					<div class="top-menu">
					<span>
					<?php if ( is_user_logged_in() ) { 
					global $current_user;
      				get_currentuserinfo();
					?>
					<?php echo $current_user->user_firstname; ?> 
					<?php } else { ?>
                     Welcome
					<?php } ?> 	
						<img src="<?php echo get_template_directory_uri(); ?>/images/admin.png" alt="admin" width="64" height="64" class="admin-menu"/>
					</span> 
					
					<div class="user-menu" style="display:none;">
						<span class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/cross-out.svg" alt="admin"/></span>
						<?php if ( is_user_logged_in() ) {
							$current_user = wp_get_current_user();
							wp_nav_menu( array(
								'menu'   => 'Login User Menu',
							) );
						} else {
							wp_nav_menu( array(
								'menu'   => 'Logout User Menu',
							) );
						}
						?>
					</div>
					

    					
					
				<div class="wishlist-sec">
						<?php echo do_shortcode('[ti_wishlist_products_counter]'); ?>
					<span>
						<?php $count = WC()->cart->cart_contents_count;?>
                        <div class="fly-cart">
                            <a class="cart-contents" title="<?php _e( 'View your shopping cart' ); ?>">
                    <span class="cart-contents-count cart-count"><?php echo sprintf ( _n( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span>
                            </a>
                        </div>
				    </span>
				</div>
					
				</div>
			</div>
			
				
			<div class="search">
					<i class="fa fa-search search-icon" aria-hidden="true"></i>
					<div class="search-form" style="display:none;">
						<?php echo do_shortcode('[wcas-search-form]'); ?>
					</div>
			</div>
			
			<?php
			
			// Template modification Hook
			do_action( 'hoot_template_main_wrapper_start' );
			