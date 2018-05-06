<?php


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

	<main class=""<?php //hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'page.php' );

		// Checks if any posts were found.
		if ( have_posts() ) :
		?>
<div class="inner_featured">
		<?php 
			// Display Featured Image if present
			if ( hoot_get_mod( 'post_featured_image' ) && !hybridextend_is_404() ) {
				$img_size = apply_filters( 'hoot_post_image_page', '' );
				hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
			}
			
			?>
			
</div>
		<?php

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
				
				
				
					
					if($_SESSION['item'] == 'man') {
						$args = array(
								'post_type' => 'product',
								'meta_key' => 'total_sales',
								'orderby' => 'meta_value_num',
								'posts_per_page' => 60,
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => 'man',
									),
								),
						);
					} else if($_SESSION['item'] == 'woman') {
						$args = array(
								'post_type' => 'product',
								'meta_key' => 'total_sales',
								'orderby' => 'meta_value_num',
								'posts_per_page' => 60,
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => 'woman',
									),
								),
						);
					} else if($_SESSION['item'] == 'combine'){
						$args = array(
								'post_type' => 'product',
								'meta_key' => 'total_sales',
								'orderby' => 'meta_value_num',
								'posts_per_page' => 60,
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => 'combine',
									),
								),
						);
					} else {
						$args = array(
								'post_type' => 'product',
								'meta_key' => 'total_sales',
								'orderby' => 'meta_value_num',
								'posts_per_page' => 60,
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => 'combine',
									),
								),
						);
					}
					
					
					
				
					$loop = new WP_Query( $args );
					echo '<ul class="products">';
					while ( $loop->have_posts() ) : $loop->the_post(); 
					global $product; 
					$currency = get_woocommerce_currency_symbol();
					$price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale = get_post_meta( get_the_ID(), '_sale_price', true);
						wc_get_template_part( 'content', 'product' );
					endwhile;
					echo '</ul>';
					wp_reset_query(); 							
				// End found posts loop.
				

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

	<?php //hybridextend_get_sidebar( 'primary' ); // Loads the template-parts/sidebar-primary.php template. ?>

</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>