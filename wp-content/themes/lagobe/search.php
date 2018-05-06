<?php 
get_header();
?>
<?php /*?><div class="title-sec">
	<?php
	$id = get_queried_object_id();
	$category = get_category($id);
	
	$texo_metabox = get_term_meta($id, '_cmb2_banner_img', true);
	$image = wp_get_attachment_image_url( $thumbnail_id, 'full' );
	?>
	<img src="<?php echo $texo_metabox; ?>" alt='' />

	<h2><?php single_cat_title(); ?>.</h2><span>All</span>
	<?php 
	$count = $category->category_count; 
	if($count >= 1){ ?>
	<p><?php echo $count; ?> articles</p>
	<a href="<?php echo site_url(); ?>/shop">See hotest articles</a>
	<?php
	}
	?>
</div><?php */?>


<div id="loop-meta" class="loop-meta-wrap pageheader-bg-default">
			<div class="grid">

				<div class=" archive-header loop-meta  grid-span-12">
					
	<?php
	$id = get_queried_object_id();
	$category = get_category($id);
	$texo_metabox = get_term_meta($id, '_cmb2_banner_img', true);
	$image_id = pippin_get_image_id($texo_metabox);
	$image_thumb = wp_get_attachment_image_src($image_id, 'loop-meta-img');
	?>
	<?php if($image_thumb != "") { ?>
	<img src="<?php echo $image_thumb[0]; ?>" />
	<?php } else { ?>
	<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
	<?php } ?>
	
	<div class="loop-meta-des">
	<h1 class=" archive-title loop-title" itemprop="headline"><?php single_cat_title(); ?>.</h1>
	
			
			<span><?php echo $redux_demo['all_text_en']; ?></span>
			
	
	<?php $count = $category->category_count; 	if($count >= 1){ ?>
	
			<p><?php echo $count; ?> <?php echo $redux_demo['art_text_en']; ?></p>
	
			<a href="<?php echo site_url(); ?>/shop" class="btn"><?php echo $redux_demo['hot_text_en']; ?></a>
	
	
	
	
	<?php
	}
	?>
					
					
	</div>
				</div><!-- .loop-meta -->

			</div>
		</div>


<div class="grid main-content-grid">

  <main id="content" class="content  grid-span-12 no-sidebar layout-full-width " role="main">
  
    <div class="collection-area">
      	<div class="cat-title">
			<h2><?php echo $redux_demo['sel_sec_title_en']; ?></h2>
		</div>
			<a href="<?php echo site_url(); ?>/shop" class="btn"><?php echo $redux_demo['sel_sec_btn_txt_en']; ?></a>
	  	<div class="categories">
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

    

		<?php if ( have_posts() ) : ?>
			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<?php woocommerce_product_loop_start(); ?>
				<?php woocommerce_product_subcategories(); ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>
					<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php endwhile; // end of the loop. ?>
			<?php woocommerce_product_loop_end(); ?>
			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>
		<?php endif; ?>
	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
		</div>
		
	</div>
	
	
	
	<!--<div class="collection-area">
      	<div class="cat-title">
			<h2>All Items.</h2>
		</div>
			
      	<div class="categories">
			<?php
			
				 $args = array(
				  'post_type' => 'product',
				  'posts_per_page' => 18,
				  'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'term_id',
						'terms'    => array($id),
					),
				 ),
				 );
				 $loop = new WP_Query( $args );
				  ?>
				 <ul id="all-items">
				 <?php 
					while ( have_posts() ) : the_post();
					global $product; 
					$currency = get_woocommerce_currency_symbol();
					$price = get_post_meta( get_the_ID(), '_regular_price', true);
					$sale = get_post_meta( get_the_ID(), '_sale_price', true);
				 ?>
				   <li><a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
														<?php if (has_post_thumbnail( $loop->post->ID )){ ?>
														<?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
														<?php } else { ?>
														<img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="product placeholder Image"/>'; 
														<?php } ?>
														<?php if($sale) : ?>
														<strong class="product-price-tickr"><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></strong>    
														<?php elseif($price) : ?>
														<strong class="product-price-tickr"><?php echo $currency; echo $price; ?></strong>    
														<?php endif; ?>
														<span><?php the_title(); ?></span>
														</a>
													</li>
			   	 <?php endwhile; ?>
				 </ul>
				 <?php 
				 wp_reset_postdata();
		   ?>
		
		</div>
		
	</div>-->
	
  </main>
</div>
<div class="bottom-title-sec">
	<h2><?php single_cat_title(); ?>.</h2><span>All</span>
</div>
<!-- .grid -->
<?php get_footer(); // Loads the footer.php template. ?>