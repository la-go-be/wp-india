<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wpis_single_image_filter()
{
	global $post, $woocommerce, $product;

	if( has_post_thumbnail())
	{
		$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
		$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			'title' 		  => $image_title,
			'data-zoom-image' => $image_link,
			'id' 		      => 'zoom-image',
		));
		
		$attachment_ids   = $product->get_gallery_attachment_ids();
		$attachment_count = count( $attachment_ids);

		if ( $attachment_count > 0 ) {
			$gallery = '[wpis-gallery]';
		} else {
			$gallery = '';
		}
		
		// WPIS FOR SLIDER
		echo '<section class="slider wpis-slider-for">';
		
		echo sprintf( '<div>%s<a href="%s" class="wpis-popup" data-rel="prettyPhoto' . $gallery . '">popup</a></div>', $image, $image_link );

		foreach( $attachment_ids as $attachment_id ) {
		   $imgfull_src = wp_get_attachment_image_src( $attachment_id,'full');
		   $image_src   = wp_get_attachment_image_src( $attachment_id,'shop_single');
		   echo '<div><img src="'.$image_src[0].'" /><a href="'.$imgfull_src[0].'" class="wpis-popup" data-rel="prettyPhoto' . $gallery . '">popup</a></div>';
		}
		
		echo '</section>';
		
		// WPIS NAV SLIDER
		if($gallery)
		{
			echo '<section id="wpis-gallery" class="slider wpis-slider-nav">';
			
			$fimgfull_src  = wp_get_attachment_image_src( get_post_thumbnail_id(),'full');
			$fimgthumb_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'shop_thumbnail');
			
			echo '<div><a data-zoom-image="'.$fimgfull_src[0].'"><img src="'.$fimgthumb_src[0].'" /></a></div>';
		
			foreach( $attachment_ids as $attachment_id ){
			   $fullimg_src  = wp_get_attachment_url( $attachment_id );
			   $thumbimg_src = wp_get_attachment_image_src( $attachment_id,'shop_thumbnail');
			   echo '<div><a data-zoom-image="'.$fullimg_src.'"><img src="'.$thumbimg_src[0].'" /></a></div>';
			}
			
			echo '</section>';
		}
	
	} else {

		return sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce-image-zoom' ) );

	}
}

add_filter( 'woocommerce_single_product_image_html', 'wpis_single_image_filter' );