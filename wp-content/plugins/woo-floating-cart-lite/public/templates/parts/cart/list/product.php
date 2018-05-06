<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the cart list product item.
 *
 * This template can be overridden by copying it to yourtheme/woo-floating-cart/parts/cart/list/product.php.
 *
 * Available global vars: $cart_item, $cart_item_key, $product
 * 
 * HOWEVER, on occasion we will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.6.9
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/public/templates/parts
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} 

$product_id   = $cart_item['product_id'];
$is_variable = woofc_item_attributes($cart_item);

$classes = array();
$classes[] = 'woofc-product'; 
$classes[] = 'woofc-'.$product->product_type;

if(!empty($is_variable)) {
	$classes[] = 'woofc-variable-product';
}

$bundled_product = false;
if(function_exists('wc_pb_is_bundled_cart_item') && wc_pb_is_bundled_cart_item($cart_item)) {
	$bundled_product = true;
}

$classes = implode(' ', $classes);

$vars = array(
	'product' => $product,
	'cart_item' => $cart_item,
	'cart_item_key' => $cart_item_key
);

if(!$bundled_product):
?>
	
<li class="<?php echo esc_attr($classes); ?>" 
	data-key="<?php echo esc_attr($cart_item_key);?>" 
	data-id="<?php echo esc_attr($product_id);?>" 
>

	<div class="woofc-product-image">
		
		<?php 
		woo_floating_cart_template('parts/cart/list/product/thumbnail', $vars); 
		?>
		
	</div>
	
	<div class="woofc-product-details">
		
		<?php 
		woo_floating_cart_template('parts/cart/list/product/title', $vars); 

		woo_floating_cart_template('parts/cart/list/product/price', $vars); 
		?>
		
		<div class="woofc-clearfix"></div>
		
		<?php
		woo_floating_cart_template('parts/cart/list/product/quantity', $vars); 
		
		woo_floating_cart_template('parts/cart/list/product/actions', $vars); 
		?>
		
	</div>
</li>
<?php endif; ?>