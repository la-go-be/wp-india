<?php 

/*
template name: Sale

*/
// Loads the header.php template.


get_header();

global $redux_demo; 

?>



<?php


// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'page.php' );
?>

<div class="grid main-content-grid">

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'page.php' );
	?>

	<main>
		
		<?php 
  // Display Featured Image if present
			if ( hoot_get_mod( 'post_featured_image' ) && !hybridextend_is_404() ) {
				$img_size = apply_filters( 'hoot_post_image_page', '' );
				hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
			}

  ?>
  
  <div id="loop-meta" class="loop-meta-wrap pageheader-bg-default">
			<div class="grid">

				<div class=" archive-header loop-meta  grid-span-12" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<?php $banner =  $redux_demo['shop-page-banner']; ?>
					<?php
					//	$id = get_queried_object_id();
						//$category = get_category($id);
						//$texo_metabox = get_term_meta($id, '_cmb2_banner_img', true);
						$image_id = pippin_get_image_id($banner['url']);
						$image_thumb = wp_get_attachment_image_src($image_id, 'loop-meta-img');
						?>
						<?php if($image_thumb != "") { ?>
						<img src="<?php echo $image_thumb[0]; ?>" />
						<?php } else { ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
						<?php } ?>
					
					<div class="title-sec">
					<h2><?php the_title(); ?>.</h2>
					<a href="<?php echo site_url(); ?>/man/collections/" class="btn">Discover</a>
					</div>
				</div><!-- .loop-meta -->

			</div>
		</div>
		
		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'page.php' );
		// Checks if any posts were found.
		if ( have_posts() ) :

			
			?>

			<div id="content-wrap" class="woocommerce-slide archive">

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'page.php' );

				// Begins the loop through found posts, and load the post data.
				while ( have_posts() ) : the_post();

					// Loads the template-parts/content-{$post_type}.php template.
					echo do_shortcode('[sale_products columns="3" per_page="12"]');

				// End found posts loop.
				endwhile;

				// Template modification Hook
				do_action( 'hoot_loop_end', 'page.php' );
				?>

			</div><!-- #content-wrap -->

			<?php
			// Template modification Hook
			do_action( 'hoot_template_after_content_wrap', 'page.php' );

			// Loads the comments.php template if this page is not being displayed as frontpage or a custom 404 page or if this is attachment page of media attached (uploaded) to a page.
			if ( !is_front_page() && !hybridextend_is_404() && !is_attachment() ) :

				// Loads the comments.php template
				comments_template( '', true );

			endif;

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



</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>