<?php

 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

add_action('plugins_loaded', 'woocommerce_ssys_recently_viewed_init_new', 0);

//require_once __DIR__ . '/inc/woocommerce-recently-viewed-products-from-all-visitor-by-samsys/ssys-recently-viewed-widget.php';

//require_once( plugin_dir_path( __FILE__ ) . 'ssys-recently-viewed-widget.php' );

/**
 * Initialize the plugin by setting localization and loading public scripts,
 * styles and Actions
 *
 * @since     1.0.0
 */
function woocommerce_ssys_recently_viewed_init_new() {
	
	//Hook Save Last Viewed Date to Single Product Page
	add_action( 'woocommerce_before_single_product','ssys_Generate_CF_save_visits_new' );
	
	// Load plugin text domain
	add_action( 'init', 'Ssys_WC_recently_viewed_load_plugin_textdomain_new' );
}

/**
 * Load the plugin text domain for translation.
 *
 * @since    1.0.0
 */
function Ssys_WC_recently_viewed_load_plugin_textdomain_new() {

	$domain = 'woocommerce-ssys-recently-viewed';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	
}

/**
 * Initialize Hidden Custom Field And Save This Product Last Viewed Date, Hooks to 
 *
 * @since     1.0.0
 */
function ssys_Generate_CF_save_visits_new(){
	global $post;
	
	update_post_meta($post->ID, '_ssys_Last_Viewed_Date', date('U') );
	
}



?>
