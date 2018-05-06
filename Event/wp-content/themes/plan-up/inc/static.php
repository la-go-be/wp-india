<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Include static files: javascript and css
 */

if ( is_admin() ) {
	return;
}


wp_enqueue_style(
	'plan-up-google-fonts',
	plan_up_theme_font_url(),
	array(),
	'1.0'
);


// Load our main stylesheet.
wp_enqueue_style(
	'plan-up-theme-style',
	get_stylesheet_uri(),
	array(),
	'1.2'
);

// Load the Internet Explorer specific stylesheet.
wp_enqueue_style(
	'fw-theme-ie',
	get_template_directory_uri() . '/css/ie.css',
	array( 'fw-theme-style', 'genericons' ),
	'1.0'
);
wp_style_add_data( 'fw-theme-ie', 'conditional', 'lt IE 9' );

if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

if ( is_singular() && wp_attachment_is_image() ) {
	wp_enqueue_script(
		'fw-theme-keyboard-image-navigation',
		get_template_directory_uri() . '/js/keyboard-image-navigation.js',
		array( 'jquery' ),
		'1.0'
	);
}

if ( is_active_sidebar( 'sidebar-1' ) ) {
	wp_enqueue_script( 'jquery-masonry' );
}

// Load library stylesheet
wp_enqueue_style(
	'fw-theme-plugin',
	get_template_directory_uri().'/css/plugins.css',
	array(),
	'1.0'
);

wp_enqueue_script( 'fw-theme-plugin', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '1.0', true );

if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) || true ) {
	wp_enqueue_script(
		'fw-theme-slider',
		get_template_directory_uri() . '/js/slider.js',
		array( 'jquery' ),
		'1.0',
		true
	);
	wp_localize_script( 'fw-theme-slider', 'featuredSliderDefaults', array(
		'prevText' => esc_html__( 'Previous', 'plan-up' ),
		'nextText' => esc_html__( 'Next', 'plan-up' )
	) );
}

wp_enqueue_script(
	'jquery-ui-tabs',
	get_template_directory_uri() . '/js/jquery-ui-1.10.4.custom.js',
	array( 'jquery' ),
	'1.0',
	true
);

//superfish style menu dropdown
wp_enqueue_script(
	'fw-superfish',
	get_template_directory_uri() . '/js/superfish.js',
	array( 'jquery' ),
	'1.0',
	true
);


$smooth_scroll = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option('c_smooth_scroll') : '';
if($smooth_scroll == true){
	wp_enqueue_script(
		'smooth-scroll',
		get_template_directory_uri() . '/js/smooth.scroll.js',
		array( 'jquery' ),
		'1.0',
		true
	);
}


wp_enqueue_script(
	'isotope',
	get_template_directory_uri() . '/js/isotope.pkgd.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_script(
	'easing',
	get_template_directory_uri() . '/js/jquery.easing.min.js',
	array( 'jquery' ),
	'1.3',
	true
);

wp_enqueue_script(
	'fw-theme-script',
	get_template_directory_uri() . '/js/functions.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Font Awesome stylesheet
wp_enqueue_style(
	'font-awesome',
	get_template_directory_uri() . '/css/font-awesome.min.css',
	array(),
	'1.0'
);

wp_enqueue_style(
	'ionicon',
	get_template_directory_uri() . '/css/ionicons.min.css',
	array(),
	'1.0'
);


wp_enqueue_script(
	'jquery-custom-input',
	get_template_directory_uri() . '/js/jquery.customInput.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_script(
	'custom-js',
	get_template_directory_uri() . '/js/custom.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_script(
	'modernizr',
	get_template_directory_uri() . '/js/modernizr.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_script(
	'skrollr',
	get_template_directory_uri() . '/js/skrollr.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_style(
	'animate',
	get_template_directory_uri().'/css/animate.css',
	array(),
	'1.0'
);

wp_enqueue_script(
	'wow',
	get_template_directory_uri() . '/js/wow.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

{
	wp_enqueue_script(
		'dlmenumodern',
		get_template_directory_uri() . '/js/modernizr.custom.js',
		array( 'jquery' ),
		'1.0',
		true
	);

	wp_enqueue_script(
		'dlmenu',
		get_template_directory_uri() . '/js/jquery.dlmenu.js',
		array( 'jquery' ),
		'1.0',
		true
	);
}
// Mobile menu

wp_enqueue_script(
	'menu-sticky',
	get_template_directory_uri() . '/js/jquery.nav.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_enqueue_script(
	'notie-js',
	get_template_directory_uri() . '/js/notie.js',
	array( 'jquery' ),
	'1.0',
	true
);