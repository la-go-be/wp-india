<!DOCTYPE html>
<html <?php language_attributes( 'html' ); ?> class="no-js">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<?php
// Fire the wp_head action required for hooking in scripts, styles, and other <head> tags.
wp_head();
?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/default.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/component.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.custom-n.js"></script>
<style>
#seller-area .site-logo-mixed-text {
display:none;
}

#seller-area #showLeftPush img{
    z-index: 999999;
    position: relative;
}	


	
</style>		
</head>

<body <?php hybridextend_attr( 'body' ); ?> id="seller-area">
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
			<div class="top-menu">
					<span>
						<p>Lagobetech Ltd</p>
						<img src="<?php echo get_template_directory_uri(); ?>/images/admin.png" alt="admin" width="64" height="64" class="admin-menu"/>
					</span> 
				</div>
		</div>
		
		
		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<div <?php hybridextend_attr( 'leftbar-inner' ); ?>>
				<?php
				// Display Leftbar Top
				get_template_part( 'template-parts/leftbar', 'top' );
				?>
				<header <?php hybridextend_attr( 'header' ); ?>>
					<div class="grid">
						<div class="grid-span-12">
			
							<div <?php hybridextend_attr( 'branding' ); ?>>
								<div id="site-logo" class="<?php
									echo 'site-logo-' . hoot_get_mod( 'logo' );
									if ( hoot_get_mod('logo_background_type') == 'accent' )
										echo ' accent-typo with-background';
									elseif ( hoot_get_mod('logo_background_type') == 'background' )
										echo ' with-background';
									?>">
									<?php
									// Display the Image Logo or Site Title
									hoot_logo();
									?>
									<i class="fa fa-times" style="color:#fff";  aria-hidden="true"></i>
								</div>
							</div><!-- #branding -->
							<h2>Menu</h2>
						</div>
					</div>
					<div class="menu-items sf-menu menu" id="menu-seller-items">
						<?php
						/* Create Menu Args Array */
						$menu_args = array(
							'menu'  => 'Seller Menu',
							'container'       => false,
							'fallback_cb'     => '',
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							);
						/* Display Main Menu */
						wp_nav_menu( $menu_args ); ?>
					</div>
				</header><!-- #header -->
				<?php
				// Display Leftbar Bottom
				get_template_part( 'template-parts/leftbar', 'bottom' );
				?>

			</div><!-- #leftbar-inner -->
		</div>	
					<div id="showLeftPush">
					<img src="<?php echo get_template_directory_uri(); ?>/images/shopping_bag.png">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
					</div>
		<!-- Classie - class helper functions by @desandro https://github.com/desandro/classie -->
		<script src="<?php echo get_template_directory_uri(); ?>/js/classie-n.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showBottom = document.getElementById( 'showBottom' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				showRightPush = document.getElementById( 'showRightPush' ),
				body = document.body;

			
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			showRightPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toleft' );
				classie.toggle( menuRight, 'cbp-spmenu-open' );
				disableOther( 'showRightPush' );
			};

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
				
			}
		</script>