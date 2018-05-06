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
			if ( have_posts() ) :
			
?>
<main>
<div id="loop-meta" class="loop-meta-wrap pageheader-bg-default woocommerce-page archive">
			<div class="grid df">
				<div class=" archive-header loop-meta  grid-span-12" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<?php the_post_thumbnail(); ?>
					<h1 class="archive-title loop-title" itemprop="headline">Combine <br />Best Seller</h1>
				</div><!-- .loop-meta -->
			</div>
</div>
			<div id="content-wrap" class="grid main-content-grid">
			<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'page.php' );
				// Begins the loop through found posts, and load the post data.
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$custom_terms = get_terms('man');
				$args = array(
					'paged'          => $paged,
					'post_type' => 'product',
					'posts_per_page' => '12',
					'meta_key' => 'total_sales',
					'orderby' => 'meta_value_num',
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => 'combine',
						),
					),
				);
					$loop = new WP_Query( $args );
					echo '<ul class="products">';
					while ( $loop->have_posts() ) : $loop->the_post(); 
					global $product; 
					$currency = get_woocommerce_currency_symbol();
					$price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale = get_post_meta( get_the_ID(), '_sale_price', true);
					//wc_get_template_part( 'content', 'product' );
					?>
					<li class="product">
						<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link">
						<?php the_post_thumbnail(); ?>
							<span class="price">
								<?php if($sale) : ?>
								<span class="woocommerce-Price-amount amount">
									 <del>   <span class="woocommerce-Price-currencySymbol"><?php echo $currency; ?></span><?php echo $price;?></del></span>
								<?php elseif($price) : ?>
								<span class="woocommerce-Price-amount amount">
											 <span class="woocommerce-Price-currencySymbol"><?php echo $currency; ?></span><?php echo $price;?></span>
								<?php endif; ?>
							</span>
							<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2></a></li>
					
					
					<?php
					endwhile;
					echo '</ul>';
					?>
					 <nav>
						<ul class="woocommerce-pagination">
							<li><?php previous_posts_link( '&laquo; PREV', $loop->max_num_pages) ?></li> 
							<li><?php next_posts_link( 'NEXT &raquo;', $loop->max_num_pages) ?></li>
						</ul>
					</nav>
					<?php
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