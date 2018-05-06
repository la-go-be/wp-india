<?php

// Apply this to only woocommerce pages
if ( !is_woocommerce() )
	return;
	
	
//global $redux_demo  // This is your opt_name.
//print_r($redux_demo);
/**
 * Template modification Hooks
 */
$display_loop_meta = apply_filters( 'hoot_woo_loop_meta', true );
do_action ( 'hoot_woo_loop_meta', 'start' );

if ( !$display_loop_meta )
	return;

/**
 * If viewing a multi product page 
 */
if ( !is_product() && !is_singular() ) :
global $redux_demo; 
	$display_title = apply_filters( 'wooloop_meta_display_title', true, 'plural' );
	if ( $display_title !== 'hide' ) :
	?>

		<div <?php hybridextend_attr( 'loop-meta-wrap', 'woocommerce' ); ?>>
			<div class="grid df">
				<div <?php hybridextend_attr( 'loop-meta', '', 'grid-span-12' ); ?>>
					<?php $banner =  $redux_demo['shop-page-banner']; ?>
<?php
//	$id = get_queried_object_id();
	//$category = get_category($id);
	//$texo_metabox = get_term_meta($id, '_cmb2_banner_img', true);
	$image_id = pippin_get_image_id($banner['url']);
	$image_thumb = wp_get_attachment_image_src($image_id, 'loop-meta-img');
	
	$term_id = get_queried_object()->term_id;
	
	$texo_metabox = get_term_meta($term_id, '_cmb2_banner_img', true);
	//$texo_metabox = get_term_meta($term_id, 'pwb_brand_banner', true);
	$image_term_id = pippin_get_image_id($texo_metabox);
	$term_image = wp_get_attachment_image_src($image_term_id, 'loop-meta-img');
	
	?>
	
	
	
	
	<?php if(is_page('shop')){ ?>
		<?php if($image_thumb != "") { ?>
		<img src="<?php echo $image_thumb[0]; ?>" />
        <h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php the_title(); ?></h1>
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
        <h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php the_title(); ?></h1>
		<?php } ?>
	<?php } else if (is_search()) { ?>	
		<?php if($term_image != "") { ?>
		<img src="<?php echo $term_image[0]; ?>" />
		<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php echo get_search_query(); ?></h1>
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
		<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php echo get_search_query(); ?></h1>
		<?php } ?>
	<?php } else { ?>
		<?php if($term_image != "") { ?>
		<img src="<?php echo $term_image[0]; ?>" />
		<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php single_cat_title(); ?></h1>
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
		<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php single_cat_title(); ?></h1>
		<?php } ?>
	<?php } ?>
	
	
					
					<?php /*if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
						<h1 <?php hybridextend_attr( 'loop-title' ); ?>><?php woocommerce_page_title(); ?></h1>
					<?php endif; */?>
					<div <?php hybridextend_attr( 'loop-description' ); ?>>
						<?php do_action( 'woocommerce_archive_description' ); ?>
					</div><!-- .loop-description -->
					
					

				</div><!-- .loop-meta -->

			</div>
		</div>

	<?php
	
	
	endif;


/**
 * If viewing a single product
 */
elseif ( is_product() ) :



	add_filter( 'loop_meta_display_title', 'hoot_hide_loop_meta_woo_product' );
	get_template_part( 'template-parts/loop-meta' );

endif;

/**
 * Template modification Hooks
 */
do_action ( 'hoot_woo_loop_meta', 'end' );