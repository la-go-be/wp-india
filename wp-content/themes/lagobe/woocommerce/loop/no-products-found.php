<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $redux_demo; 

?>


<p class="woocommerce-info no-tpoduct-info"><?php echo $redux_demo['search_result_no_en']; ?></p>
	<h3 class="also-like">You May Also Like.</h3>
		<ul class="products no-pro">
		
													<?php
													$args = array(
														'post_type' => 'product',
														'meta_key' => 'total_sales',
														'orderby' => 'meta_value_num',
														'posts_per_page' => 40,
													);
													 
													$loop = new WP_Query( $args );
													while ( $loop->have_posts() ) : $loop->the_post(); 
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
														<span class="price">
															<?php if($sale) : ?>
																<span class="woocommerce-Price-amount amount">
																	<del><?php echo $currency; echo $price; ?></del> 
																	<?php echo $currency; echo $sale; ?>
																</span>    
															<?php elseif($price) : ?>
																<span class="woocommerce-Price-amount amount"><?php echo $currency; echo $price; ?></span>    
															<?php endif; ?>
														</span>
														<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></span>
														</a>
													</li>	
													<?php endwhile; ?>
													<?php wp_reset_query(); ?>
													</ul>
		</div>
		<!--/.products-->
	