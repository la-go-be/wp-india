<?php 
/*
template name: Checkout Login
*/

get_header();
?>

<?php
// Dispay Loop Meta at top


// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'page.php' );
?>

<div class="grid main-content-grid">
<?php global $redux_demo; ?>
	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'page.php' );
	?>

	<main>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'page.php' );

		// Checks if any posts were found.
		if ( have_posts() ) :

			// Display Featured Image if present
			if ( hoot_get_mod( 'post_featured_image' ) && !hybridextend_is_404() ) {
				$img_size = apply_filters( 'hoot_post_image_page', '' );
				hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
			}

			// Dispay Loop Meta in content wrap
			if ( ! hoot_page_header_attop() ) {
				hoot_display_loop_title_content( 'post', 'page.php' );
				get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
			}
			?>

			<div id="content-wrap">

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'page.php' );

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					hybridextend_get_content_template();

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hoot_loop_end', 'page.php' );
				?>
				
				<div class="checkout-login">
					<div id="site-logo" class="<?php
						echo 'site-logo-' . hoot_get_mod( 'logo' );
						if ( hoot_get_mod('logo_background_type') == 'accent' )
							echo ' accent-typo with-background';
						elseif ( hoot_get_mod('logo_background_type') == 'background' )
							echo ' with-background';
						?>">
						<?php
						// Display the Image Logo or Site Title
						//hoot_logo();
						?>
						<a href="<?php echo site_url(); ?>" class="custom-logo-link" rel="home" itemprop="url">
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo-chk.png" class="custom-logo" alt="<?php bloginfo('title'); ?>" itemprop="logo">
						</a>
					</div>
					
					<h2><?php echo $redux_demo['checkout_text_en']; ?></h2>
					
					<a href="<?php echo site_url(); ?>/checkout/?login=cart" class="btn"><?php echo $redux_demo['guest_text_en']; ?></a>
					<a href="<?php echo site_url(); ?>/my-account/?from=checkout" class="btn"><?php echo $redux_demo['login_text_en']; ?></a>
					
					 <?php dynamic_sidebar('checkout-login'); ?> 
					 
					 <span><a href="<?php echo site_url();?>/shop" class="btn cancel"><?php echo $redux_demo['cancel_text_en']; ?></a></span>
					 <p><?php echo $redux_demo['pci_text_en']; ?></p>
				</div>

			</div><!-- #content-wrap -->

			<?php
			// Template modification Hook
			do_action( 'hoot_template_after_content_wrap', 'page.php' );


		// If no posts were found.
		else :

			// Loads the template-parts/error.php template.
			get_template_part( 'template-parts/error' );

		// End check for posts.
		endif;

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'page.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'page.php' );
	?>

	<?php //hybridextend_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>