<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }



/**

 * Theme Includes

 */

require_once get_template_directory() .'/inc/init.php';



/**

 * TGM Plugin Activation

 */

{

	require_once get_template_directory() . '/TGM-Plugin-Activation/class-tgm-plugin-activation.php';



	require_once get_template_directory() . '/TGM-Plugin-Activation/recommend_plugins.php';

}



function wpdocs_theme_name_scripts() {
    
  wp_enqueue_script( 'custome-new', get_template_directory_uri() . '/js/custome-new.js', array(), false );
}
add_action( 'wp_footer', 'wpdocs_theme_name_scripts' );


add_action('woocommerce_before_main_content', 'remove_sidebar' );
    function remove_sidebar()
    {
        if ( is_shop() ) { 
         remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
       }
    }
	
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );



add_filter( 'add_to_cart_text', 'woo_custom_single_add_to_cart_text' );                // < 2.1
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
  
function woo_custom_single_add_to_cart_text() {
  
    return __( 'Join The Event', 'woocommerce' );
  
}

function woo_remove_all_quantity_fields( $return, $product ) { return true; } add_filter( 'woocommerce_is_sold_individually', 'woo_remove_all_quantity_fields', 10, 2 );

add_filter( 'woocommerce_create_account_default_checked', '__return_true' );
add_filter('woocommerce_enable_order_notes_field', '__return_false');


add_filter( 'body_class', 'sk_body_class_for_pages' );
/**
 * Adds a css class to the body element
 *
 * @param  array $classes the current body classes
 * @return array $classes modified classes
 */
function sk_body_class_for_pages( $classes ) {

	if ( is_singular( 'page' ) ) {
		global $post;
		$classes[] = 'page-' . $post->post_name;
	}

	return $classes;

}