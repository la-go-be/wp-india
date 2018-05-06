<?php
function select_gender($text){

	$text = "";
	
	$text .=  '<div class="best-sell-widget">';
	$text .=  '<ul class="best-sell-slide">';
	
			if($_SESSION['item'] == 'man') {
						$args = array(
								'post_type' => 'product',
								'meta_key' => 'total_sales',
								'orderby' => 'meta_value_num',
								'posts_per_page' => 10,
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
								'posts_per_page' => 10,
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
								'posts_per_page' => 10,
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
								'posts_per_page' => 10,
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
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product; 
			$currency = get_woocommerce_currency_symbol();
			$price = get_post_meta( get_the_ID(), '_regular_price', true);
			$sale = get_post_meta( get_the_ID(), '_sale_price', true);
	
	
	$text .=  '<li><a id="id-'.get_the_id().'" href="'.get_the_permalink().'" title="'.get_the_title().'">';
				if (has_post_thumbnail( $loop->post->ID )){ 
	$text .=  get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
				} else { 
	$text .=  '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image"/>'; 
				}
				if($sale) :
	$text .=  '<strong class="product-price-tickr"><del>'.$currency.' '.$price.'</del>'.$currency.' '.$sale.'</strong>';    
				elseif($price) :
	$text .=  '<strong class="product-price-tickr">'.$currency.' '.$price.'</strong>';    
				endif; 
	$text .=  '<span>'.get_the_title().'</span>';
	$text .=  '</a></li>';	
	
	 endwhile; 
	 wp_reset_query();										
													
	$text .=  '</ul></div>';
	//$text .=  '</div></div>';



	return $text;
}
add_shortcode('short-gender','select_gender');




function select_product($text){
	$text = "";
	
	$text .=  '<div class="best-sell-widget">';
	$text .=  '<ul class="best-pro-slide">';
	$args = array(
				'post_type' => 'product',
				'posts_per_page' => 10,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
            			'terms'    => 'posters',
					)
				)
			);
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post(); 
			global $product; 
			$currency = get_woocommerce_currency_symbol();
			$price = get_post_meta( get_the_ID(), '_regular_price', true);
			$sale = get_post_meta( get_the_ID(), '_sale_price', true);
	
	
	$text .=  '<li><a id="id-'.get_the_id().'" href="'.get_the_permalink().'" title="'.get_the_title().'">';
				if (has_post_thumbnail( $loop->post->ID )){ 
	$text .=  get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); 
				} else { 
	$text .=  '<img src="'.woocommerce_placeholder_img_src().'" alt="product placeholder Image"/>'; 
				}
				if($sale) :
	$text .=  '<strong class="product-price-tickr"><del>'.$currency.' '.$price.'</del>'.$currency.' '.$sale.'</strong>';    
				elseif($price) :
	$text .=  '<strong class="product-price-tickr">'.$currency.' '.$price.'</strong>';    
				endif; 
	$text .=  '<span>'.get_the_title().'</span>';
	$text .=  '</a></li>';	
	
	 endwhile; 
	 wp_reset_query();										
													
	$text .=  '</ul></div>';
	


	return $text;
}
add_shortcode('products-slider','select_product');

