<?php
/***********Shop Page Customization**************/

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 1000;' ), 20 );

//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_thumbnails', 10 );
//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_images', 10 ); 

//add_action( 'woocommerce_before_shop_loop_item', 'show_ratings_shop', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );

//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
//add_action('woocommerce_before_shop_loop_item_title','sharethis_for_woocommerce_shop',12);

add_action('woocommerce_single_product_summary','woocommerce_template_single_price',4);
remove_action('woocommerce_single_product_summary','woocommerce_template_loop_rating',5);
add_action('woocommerce_single_product_summary','custome_post_meta',10);
//add_action('woocommerce_single_product_summary','rasdasdadio',9);

add_action('woocommerce_single_product_summary','woocommerce_template_single_excerpt',12);

add_action('hoot_template_after_main', 'hooks_open_div', 7);
add_action('hoot_template_after_main','woocommerce_output_related_products',8);
add_action('hoot_template_after_main', 'hooks_close_div',11);
add_action('hoot_template_after_main','recent_product',10);


function hooks_open_div() {
    echo '<div class="related-products">';
}


function hooks_close_div() {
    echo '</div>';
}


add_action( 'woocommerce_after_single_product', 'woocommerce_productnav');
function woocommerce_productnav() {
?>
<div class="post-nav fix">
	<span class="previous"><?php previous_post_link('%link', 'Prev') ?></span>
	<span class="next"><?php next_post_link('%link', 'Next') ?></span>
</div>
<?php
}

remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',11);
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt',12);
remove_action('woocommerce_after_shop_loop_item_title','custome_post_meta',10);



remove_action('woocommerce_after_shop_loop_item','add_to_wish',15);
remove_action('woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',15);

//add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_review_display_comment_text', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_price',12);
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);

/***********End Shop Page Customization***********/




   
	
	
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
  // $cols contains the current number of products per page based on the value stored on Options -> Reading
  // Return the number of products you wanna show per page.
  $cols = 1000000;
  return $cols;
}

function recent_product(){
global $redux_demo; 
	//echo do_shortcode('[woocommerce_recently_viewed_products per_page="5"]');
	echo '<div class="recent_products">';
		?>
		<div class="cat-title">
			<h2><?php echo $redux_demo['recently_text_en']; ?>.</h2>
			<span><?php echo $redux_demo['recently_text_sub_en']; ?></span>
		</div>
		<a href="<?php echo site_url(); ?>/shop" class="btn"><?php echo $redux_demo['col_sec_btn_txt_en']; ?></a>
<?php	
	dynamic_sidebar('sidebar-recent');
	echo '</div>';
}




function product_quantity(){
global $product;
	if( $product->is_type( 'simple' ) ){
		$quantity = $product->get_stock_quantity();
		if($quantity >= 1){
			echo '<div class="rem-product">'.$quantity.' Products in Stock</div>';
		}
	}
	/*	if ($product->is_type( 'variable' )){

		// Get the available variations for the variable product
		$available_variations = $product->get_available_variations();

		// Initializing variables
		$variations_count = count($available_variations);
		$loop_count = 0;

		// Iterating through each available product variation
		foreach( $available_variations as $key => $values ) {
			$loop_count++;
			// Get the term color name
			$attribute_color = $values['attributes']['attribute_pa_color'];
			$wp_term = get_term_by( 'slug', $attribute_color, 'pa_color' );
			$term_name = $wp_term->name; // Color name

			// Get the variation quantity
			$variation_obj = wc_get_product( $values['variation_id'] );
			$stock_qty = $variation_obj->get_stock_quantity(); // Stock qty
			// The display
			$separator_string = " // ";
			$separator = $variations_count < $loop_count ? $separator_string : '';
			echo $term_name . ' = ' . $stock_qty . $separator;
		}
	}*/

}
add_action('woocommerce_before_add_to_cart_button','product_quantity',36);



function get_stock_variations_from_product(){
    global $product;
    $product_variations = $product->get_available_variations();

    foreach ($product_variations as $variation)  {
		
		$var_data = $variation['attributes'];
        $var_data['in_stock'] = $variation['is_in_stock'];
		
		$var_color = $var_data['attribute_pa_color'];
		$var_size = $var_data['attribute_pa_size'];
		$var_quantity = $variation['stock_quantity'];
		
		//echo '<p class="stock ava-product" data-color="'.$var_color.'" data-size="'.$var_size.'">'.$var_quantity.' In Stock</p>';
    }

    //List all attributes with stock available or not array..
    /*echo '<pre>';
    print_r($var_data);
    echo '</pre>';*/
    
}
add_action('woocommerce_before_add_to_cart_button','get_stock_variations_from_product',20);


add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );

function woo_hide_page_title() {

	if ( is_search() ) {
	global $redux_demo; 
	$refd = $redux_demo['search_result_txt_en'];
	//$page_title = sprintf( __($refd.': &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
	echo '<h1 class=" archive-title loop-title" itemprop="headline">'.sprintf( __('%s', 'woocommerce' ), get_search_query() ).'<br>'.$refd.'</h1>';
	
	}
	
	
	
	if (is_tax('collection')) {
		$myvalue = get_the_archive_title();
		$arr = explode(' ',trim($myvalue));
	echo '<h1 class=" archive-title loop-title" itemprop="headline">'.$arr[0].'<br>'.$arr[1].' '.$arr[2].'</h1>';
	}
}

add_filter( 'woocommerce_after_main_content' , 'woo_hide_page_footer',12);

function woo_hide_page_footer() {

	if ( is_search() ) {
	global $redux_demo; 
	 
	$refd = $redux_demo['search_result_txt_en'];
	//$page_title = sprintf( __($refd.': &ldquo;%s&rdquo;', 'woocommerce' ), get_search_query() );
	echo '<div class="bottom-title-sec">';
	echo '<div class="back-arrow"><a href="javascript: history.go(-1)"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div><h2>'.$refd.'<span>'.sprintf( __('%s', 'woocommerce' ), get_search_query() ).'</span></h2>';
	echo '</div>';

	}
	
	
	if (is_tax('collection')) {
	
	$myvalue = get_the_archive_title();
	$arr = explode(' ',trim($myvalue));

	
	echo '<div class="bottom-title-sec">';
	echo '<div class="back-arrow"><a href="javascript: history.go(-1)"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div><h2>'.$arr[0].'.<span>'.$arr[1].'</span></h2>';
	echo '</div>';
	
	}
	
}


/***********************************Add To Cart Button******************************************************/
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // < 2.1
function woo_archive_custom_cart_button_text() {
	global $product;
 	if (!$product->is_in_stock() || !$product->is_purchasable() ){ 
        return __( 'Out of Stock', 'woocommerce' );
 	} else {
		return __( 'Add To Cart', 'woocommerce' );
	}
}

add_action('woocommerce_before_add_to_cart_button', 'hooks_open_div_single',11);
add_action('woocommerce_after_add_to_cart_button','hooks_close_div_single',10);
function hooks_open_div_single() {
	global $product;
 	if (!$product->is_in_stock() || !$product->is_purchasable() ){ 
    echo '<div class="out-of-stock">';
	} else {
	echo '<div class="in-stock">';
	}
}
function hooks_close_div_single() {
	global $product;
 	if (!$product->is_in_stock() || !$product->is_purchasable() ){ 
    echo '</div>';
	} else {
	echo '</div>';
	}
}
/***********************************End Add To Cart Button******************************************************/



// Single Product Image
function wpis_show_product_image() {
	// Woocmmerce 3.0+ Slider Fix 
	
	
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;
$version = '3.0';
?>
<div class="images">
	<?php
		if ( has_post_thumbnail() ) 
		{
			if( version_compare( $woocommerce->version, $version, ">=" ) ) {
				$attachment_ids = $product->get_gallery_image_ids();
			}else{
				$attachment_ids = $product->get_gallery_attachment_ids();
			}
			
			$attachment_count = count( $attachment_ids);
			
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			
			$fullimage        = get_the_post_thumbnail( $post->ID, 'full', array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );

			// WPIS FOR SLIDER
			$html  = '<section class="slider wpis-slider-for">';
			
			$html .= sprintf(
						'<div class="zoom">%s%s<a href="%s" class="wpis-popup" data-fancybox="product-gallery">popup</a></div>',
						$fullimage,
						$image,
						$image_link
					);
			
			foreach( $attachment_ids as $attachment_id ) {
			   $imgfull_src = wp_get_attachment_image_src( $attachment_id,'full');
			   $image_src   = wp_get_attachment_image_src( $attachment_id,'shop_single');
			   $html .= '<div class="zoom"><img src="'.$imgfull_src[0].'" /><img src="'.$image_src[0].'" /><a href="'.$imgfull_src[0].'" class="wpis-popup" data-fancybox="product-gallery">popup</a></div>';
			}
			
			$html .= '</section>';
			
			echo apply_filters(
				'woocommerce_single_product_image_html',
				$html,
				$post->ID
			);
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}

		do_action( 'woocommerce_product_thumbnails' );
	?>
</div>
<?php

}

// Single Product Thumbnails 
function wpis_show_product_thumbnails() {
	// Woocmmerce 3.0+ Slider Fix 
	
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;
$version = '3.0';
		
if( version_compare( $woocommerce->version, $version, ">=" ) ) {
	$attachment_ids = $product->get_gallery_image_ids();
	$wooLatest = true;
}else{
	$attachment_ids = $product->get_gallery_attachment_ids();
	$wooLatest = false;
}

if ( has_post_thumbnail() ) {
	$thumbanil_id   = array(get_post_thumbnail_id());
	$attachment_ids = array_merge($thumbanil_id,$attachment_ids);
}

if ( $attachment_ids ) 
{
	?>
	<section id="wpis-gallery" class="slider wpis-slider-nav"><?php

		foreach ( $attachment_ids as $attachment_id ) 
		{
			$props = wc_get_product_attachment_props( $attachment_id, $post );
			
			if($wooLatest){
				$thumbnails_catlog = $props['thumb_src'];
			}else{
				$thumbnails_catlog = '';
			}

			if ( ! $props['url'] ) {
				continue;
			}

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a title="%s">%s</a>',
					esc_attr( $props['caption'] ),
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $thumbnails_catlog )
				),
				$attachment_id,
				$post->ID
			);
		}

	?></section>
	<?php
	
	
}
}





function sharethis_for_woocommerce_shop() {

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




function my_text_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Related Products' :
            $translated_text = __( 'Check out these related products', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'my_text_strings', 20, 3 );






add_action( 'woocommerce_before_add_to_cart_button', 'echo_qty_front_add_cart' );

function echo_qty_front_add_cart() {
 global $redux_demo; 
 
 echo '<div class="qty-txt">'.$redux_demo["quan_text_en"].':</div>'; 
 
 echo '<a href="javascript:" onclick="history.go(-1); return false" class="btn btn-cancle">'.$redux_demo["cancel_text_en"].'</a>';
}




add_filter('login_errors','login_error_message');

function login_error_message($error){
 global $redux_demo; 
    //check if that's the error you are looking for
    $pos = strpos($error, 'incorrect');
    if (is_int($pos)) {
        //its the right error so you can overwrite it
        $error = "<span><strong>".$redux_demo['loginerror_text_en']."</strong>".$redux_demo['loginerrorn_text_en'].".</span><p>".$redux_demo['loginerrorw_text_en'].".</p>";
    }
    return $error;
}









function new_nav_menu_items($items,$args) {
if (function_exists('icl_get_languages')) {
$languages = icl_get_languages('skip_missing=0');
if(1 < count($languages)){
foreach($languages as $l){
$items .='<a href="'.$l['url'].'">'.strtoupper($l['language_code']).'</a>';
}
}
}
return $items;
}
add_shortcode( 'menu_switch', 'new_nav_menu_items');






function ffl_show_user_profile($user)
{
?>
<script>
	jQuery(document).ready(function() {
		//jQuery('#display_name').parent().parent().hide();
	});
</script>
<?php
}
add_action( 'show_user_profile', 'ffl_show_user_profile' );
add_action( 'edit_user_profile', 'ffl_show_user_profile' );

/*
	Fix first last on profile saves.
*/
function ffl_save_extra_profile_fields( $user_id ) 
{
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	//set the display name
	$display_name = trim($_POST['first_name'] . " " . $_POST['last_name']);
	if(!$display_name)
		$display_name = $_POST['user_login'];
		
	$_POST['display_name'] = $display_name;
	
	$args = array(
			'ID' => $user_id,
			'display_name' => $display_name
	);   
	wp_update_user( $args ) ;
}
add_action( 'personal_options_update', 'ffl_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'ffl_save_extra_profile_fields' );

/*
	Fix first last on register.
*/
function ffl_fix_user_display_name($user_id)
{
	//set the display name
	$info = get_userdata( $user_id );
               
	$display_name = trim($info->first_name . ' ' . $info->last_name);
	if(!$display_name)
		$display_name = $info->user_login;
			   
	$args = array(
			'ID' => $user_id,
			'display_name' => $display_name
	);
   
	wp_update_user( $args ) ;
}
add_action("user_register", "ffl_fix_user_display_name");

/*
	Settings Page
*/
function ffl_settings_menu_item()
{
	add_options_page('Force First Last', 'Force First Last', 'manage_options', 'ffl_settings', 'ffl_settings_page');
}
add_action('admin_menu', 'ffl_settings_menu_item', 20);

//affiliates page (add new)
function ffl_settings_page()
{
	if(!empty($_REQUEST['updateusers']) && current_user_can("manage_options"))
	{
		global $wpdb;
		$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users");
		
		foreach($user_ids as $user_id)
		{
			ffl_fix_user_display_name($user_id);		 
			set_time_limit(30);			
		}
		
		?>
		<p><?php echo count($user_ids);?> users(s) fixed.</p>
		<?php
	}
	
	?>
	<p>The <em>Force First and Last Name as Display Name</em> plugin will only fix display names at registration or when a profile is updated.</p>
	<p>If you just activated this plugin, please click on the button below to update the display names of your existing users.</p>
	<p><a href="?page=ffl_settings&updateusers=1" class="button-primary">Update Existing Users</a></p>
	
	<?php
	
}
