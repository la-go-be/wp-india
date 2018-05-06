<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">
<head>
<?php
// Fire the wp_head action required for hooking in scripts, styles, and other <head> tags.
wp_head();
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".se-pre-con").fadeOut(5000);
	
});
</script>
</head>
<?php load_theme_textdomain('lagobe'); ?>
<body <?php hybridextend_attr( 'body' ); ?>>
<div class="se-pre-con"></div>
<?php global $redux_demo;  // This is your opt_name. 
//print_r($redux_demo);
?>
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
		
		<div class="top-header mobile-header">
				
				<ul>
					<li><?php echo $redux_demo['add-services'][0]; ?></li>
					<li><?php echo $redux_demo['add-services'][1]; ?></li>
					<li><?php echo $redux_demo['add-services'][2]; ?></li>
				</ul>
				
				<div class="top-menu">
					<span>
						<?php echo $redux_demo['wel_text_en']; ?> 	
						<img src="<?php echo get_template_directory_uri(); ?>/images/admin.png" alt="admin" width="64" height="64" class="admin-menu"/>
					</span> 
					
					<!--<div class="user-menu" style="display:none;">
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
					</div>-->
					
					
					
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
		
		<div <?php hybridextend_attr( 'leftbar' ); ?>>
			<div <?php hybridextend_attr( 'leftbar-inner' ); ?>>
				<?php
				// Display Leftbar Top
				get_template_part( 'template-parts/leftbar', 'top' );
				?>
				<header <?php hybridextend_attr( 'header' ); ?>>
					<?php
					// Display Branding
					hoot_header_branding();
					// Display Menu
					hoot_header_aside();
				?>
				
				
				
				
				</header><!-- #header -->
				<?php
				// Display Leftbar Bottom
				get_template_part( 'template-parts/leftbar', 'bottom' );
				?>
			</div><!-- #leftbar-inner -->
		</div>
		<!-- #leftbar -->
		<div <?php hybridextend_attr( 'main' ); ?>>
			<div class="top-header">
				
				<ul>
					<li><?php echo $redux_demo['add-services'][0]; ?></li>
					<li><?php echo $redux_demo['add-services'][1]; ?></li>
					<li><?php echo $redux_demo['add-services'][2]; ?></li>
				</ul>
				
				<div class="top-menu">
					<span>
					<?php if ( is_user_logged_in() ) { 
					global $current_user;
      				get_currentuserinfo();
					?>
					<?php echo $current_user->user_firstname; ?> 
					<?php } ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/admin.png" alt="admin" width="64" height="64" class="admin-menu"/>
					</span> 
					<div class="user-menu" style="display:none;">
						<span class="close"><img src="<?php echo get_template_directory_uri(); ?>/images/cross-out.svg" alt="admin"/></span>
						<?php
						if ( is_user_logged_in() ) {
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
			
			
			