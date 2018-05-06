<?php
function we_custom_admin_css() {
	$we_main_purpose = get_option('we_main_purpose');
	$we_layout_purpose = get_option('we_slayout_purpose');
	echo '<style>';
	if($we_layout_purpose == 'woo' && ($we_main_purpose!='event' && $we_main_purpose!='')){
		echo '
		.post-type-product .postbox-container #custom-field.postbox,
		.post-type-product .postbox-container #sponsors-of-event.postbox,
		.post-type-product .postbox-container #event-settings.postbox,
		.post-type-product .postbox-container #location-settings.postbox,
		.post-type-product .postbox-container #layout-settings.postbox{ height:0; overflow: hidden; margin-bottom:0; border:0;}
		.post-type-product .postbox-container #custom-field.postbox.active-c,
		.post-type-product .postbox-container #sponsors-of-event.postbox.active-c,
		.post-type-product .postbox-container #event-settings.postbox.active-c,
		.post-type-product .postbox-container #location-settings.postbox.active-c,
		.post-type-product .postbox-container #layout-settings.postbox.active-c{ height:auto; overflow: visible;    margin-bottom: 20px; border: 1px solid #e5e5e5;}
		';
	}
	echo '.post-type-product #ui-datepicker-div .ui-datepicker-year{display: inline-block !important;}</style>';
}
add_action( 'admin_head', 'we_custom_admin_css' );
function we_get_product_to_duplicate( $id ) {
	global $wpdb;
	
	$id = absint( $id );
	
	if ( ! $id ) {
		return false;
	}
	
	$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
	
	if ( isset( $post->post_type ) && $post->post_type == "revision" ) {
		$id   = $post->post_parent;
		$post = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE ID=$id" );
	}
	
	return $post[0];
}
function we_duplicate_post_taxonomies( $id, $new_id, $post_type ) {
	$exclude    = array_filter( apply_filters( 'woocommerce_duplicate_product_exclude_taxonomies', array() ) );
	$taxonomies = array_diff( get_object_taxonomies( $post_type ), $exclude );

	foreach ( $taxonomies as $taxonomy ) {
		$post_terms       = wp_get_object_terms( $id, $taxonomy );
		$post_terms_count = sizeof( $post_terms );

		for ( $i = 0; $i < $post_terms_count; $i++ ) {
			wp_set_object_terms( $new_id, $post_terms[ $i ]->slug, $taxonomy, true );
		}
	}
}

/**
 * Copy the meta information of a post to another post.
 *
 * @param mixed $id
 * @param mixed $new_id
 */
function we_duplicate_post_meta( $id, $new_id ) {
	global $wpdb;

	$sql     = $wpdb->prepare( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id = %d", absint( $id ) );
	$exclude = array_map( 'esc_sql', array_filter( apply_filters( 'woocommerce_duplicate_product_exclude_meta', array( 'total_sales' ) ) ) );

	if ( sizeof( $exclude ) ) {
		$sql .= " AND meta_key NOT IN ( '" . implode( "','", $exclude ) . "' )";
	}

	$post_meta = $wpdb->get_results( $sql );

	if ( sizeof( $post_meta ) ) {
		$sql_query_sel = array();
		$sql_query     = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";

		foreach ( $post_meta as $post_meta_row ) {
			$sql_query_sel[] = $wpdb->prepare( "SELECT %d, %s, %s", $new_id, $post_meta_row->meta_key, $post_meta_row->meta_value );
		}

		$sql_query .= implode( " UNION ALL ", $sql_query_sel );
		$wpdb->query( $sql_query );
	}
}
function we_duplicate_product( $post, $parent = 0, $post_status = '' ) {
	global $wpdb;

	$new_post_author    = wp_get_current_user();
	$new_post_date      = current_time( 'mysql' );
	$new_post_date_gmt  = get_gmt_from_date( $new_post_date );

	if ( $parent > 0 ) {
		$post_parent        = $parent;
		$post_status        = $post_status ? $post_status : 'publish';
	} else {
		$post_parent        = $post->post_parent;
		$post_status        = $post_status ? $post_status : 'draft';
	}

	// Insert the new template in the post table
	$wpdb->insert(
		$wpdb->posts,
		array(
			'post_author'               => $new_post_author->ID,
			'post_date'                 => $new_post_date,
			'post_date_gmt'             => $new_post_date_gmt,
			'post_content'              => $post->post_content,
			'post_content_filtered'     => $post->post_content_filtered,
			'post_title'                => $post->post_title,
			'post_excerpt'              => $post->post_excerpt,
			'post_status'               => $post_status,
			'post_type'                 => $post->post_type,
			'comment_status'            => $post->comment_status,
			'ping_status'               => $post->ping_status,
			'post_password'             => $post->post_password,
			'to_ping'                   => $post->to_ping,
			'pinged'                    => $post->pinged,
			'post_modified'             => $new_post_date,
			'post_modified_gmt'         => $new_post_date_gmt,
			'post_parent'               => $post_parent,
			'menu_order'                => $post->menu_order,
			'post_mime_type'            => $post->post_mime_type
		)
	);

	$new_post_id = $wpdb->insert_id;

	// Copy the taxonomies
	we_duplicate_post_taxonomies( $post->ID, $new_post_id, $post->post_type );

	// Copy the meta information
	we_duplicate_post_meta( $post->ID, $new_post_id );

	// Copy the children (variations)
	if ( ( $children_products = get_children( 'post_parent=' . $post->ID . '&post_type=product_variation' ) ) ) {
		foreach ( $children_products as $child ) {
			we_duplicate_product( we_get_product_to_duplicate( $child->ID ), $new_post_id, $child->post_status );
		}
	}

	return $new_post_id;
}
function woometa_update($_post_e,$we_ID,$post_id){
	if(isset($_post_e['_downloadable'])){
		update_post_meta($we_ID, '_downloadable', $_post_e['_downloadable']);
	}
	if(isset($_POST['_virtual'])){
		update_post_meta($we_ID, '_virtual', $_post_e['_virtual']);
	}
	update_post_meta($we_ID, '_visibility', $_post_e['_visibility']);
	update_post_meta($we_ID, '_stock_status', $_post_e['_stock_status']);
	update_post_meta( $we_ID, '_visibility', 'visible' );
    update_post_meta( $we_ID, '_stock_status', 'instock');
	update_post_meta($we_ID, '_regular_price', $_post_e['_regular_price']);
	update_post_meta($we_ID, '_sale_price', $_post_e['_sale_price']);
	update_post_meta($we_ID, '_sold_individually', $_post_e['_sold_individually']);
	//deposit plugin support
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (is_plugin_active( 'woocommerce-deposits/woocommmerce-deposits.php' ) ) {
		$enable_deposit = isset($_post_e['_wc_deposits_enable_deposit']) ? 'yes' : 'no';
		$force_deposit = isset($_post_e['_wc_deposits_force_deposit']) ? 'yes' : 'no';
		$enable_persons = isset($_post_e['_wc_deposits_enable_per_person']) ? 'yes' : 'no';
		$amount_type = (isset($_post_e['_wc_deposits_amount_type']) &&
							   ($_post_e['_wc_deposits_amount_type'] === 'fixed' ||
								$_post_e['_wc_deposits_amount_type'] === 'percent')) ?
								  $_post_e['_wc_deposits_amount_type'] : 'fixed';
		$amount = isset($_post_e['_wc_deposits_deposit_amount']) &&
				  is_numeric($_post_e['_wc_deposits_deposit_amount']) ? floatval($_post_e['_wc_deposits_deposit_amount']) : 0.0;
	
		if ($amount <= 0 || ($amount_type === 'percent' && $amount >= 100)) {
		  $enable_deposit = 'no';
		  $amount = '';
		}
	
		update_post_meta($we_ID, '_wc_deposits_enable_deposit', $enable_deposit);
		update_post_meta($we_ID, '_wc_deposits_force_deposit', $force_deposit);
		update_post_meta($we_ID, '_wc_deposits_amount_type', $amount_type);
		update_post_meta($we_ID, '_wc_deposits_deposit_amount', $amount);
	}
	//end
	
	if($_post_e['_sale_price']==''){
		update_post_meta( $we_ID, '_price', $_post_e['_regular_price']?$_post_e['_regular_price']:0 );
	}else{
		update_post_meta( $we_ID, '_price', $_post_e['_sale_price']?$_post_e['_sale_price']:0 );
	}
	update_post_meta($we_ID, '_purchase_note', $_post_e['_purchase_note']);
	update_post_meta($we_ID, '_featured', $_post_e['current_featured']);
	update_post_meta($we_ID, '_weight', $_post_e['_weight']);
	update_post_meta($we_ID, '_length', $_post_e['_length']);
	update_post_meta($we_ID, '_width', $_post_e['_width']);
	update_post_meta($we_ID, '_height', $_post_e['_height']);
	update_post_meta($we_ID, '_sku', $_post_e['_sku']);
	update_post_meta($we_ID, '_product_attributes', get_post_meta($post_id,'_product_attributes', true ));
	update_post_meta($we_ID, '_sale_price_dates_from', $_post_e['_sale_price_dates_from']);
	update_post_meta($we_ID, '_sale_price_dates_to', $_post_e['_sale_price_dates_to']);
	update_post_meta($we_ID, '_manage_stock', $_post_e['_manage_stock']);
	update_post_meta($we_ID, '_backorders', $_post_e['_backorders']);
	update_post_meta($we_ID, '_stock', $_post_e['_stock']);
	update_post_meta($we_ID, '_product_image_gallery', $_post_e['product_image_gallery']); //the comma separated attachment id's of the product images
	//variation
	update_post_meta($we_ID, '_min_variation_price', get_post_meta($post_id,'_min_variation_price', true ));
	update_post_meta($we_ID, '_max_variation_price', get_post_meta($post_id,'_max_variation_price', true ));
	update_post_meta($we_ID, '_min_price_variation_id', get_post_meta($post_id,'_min_price_variation_id', true ));
	update_post_meta($we_ID, '_max_price_variation_id', get_post_meta($post_id,'_max_price_variation_id', true ));
	update_post_meta($we_ID, '_min_variation_regular_price', get_post_meta($post_id,'_min_variation_regular_price', true ));
	update_post_meta($we_ID, '_max_variation_regular_price', get_post_meta($post_id,'_max_variation_regular_price', true ));
	update_post_meta($we_ID, '_min_regular_price_variation_id', get_post_meta($post_id,'_min_regular_price_variation_id', true ));
	update_post_meta($we_ID, '_max_regular_price_variation_id', get_post_meta($post_id,'_max_regular_price_variation_id', true ));
	update_post_meta($we_ID, '_min_variation_sale_price', get_post_meta($post_id,'_min_variation_sale_price', true ));
	update_post_meta($we_ID, '_max_variation_sale_price', get_post_meta($post_id,'_max_variation_sale_price', true ));
	update_post_meta($we_ID, '_min_sale_price_variation_id', get_post_meta($post_id,'_min_sale_price_variation_id', true ));
	update_post_meta($we_ID, '_max_sale_price_variation_id', get_post_meta($post_id,'_max_sale_price_variation_id', true ));
	
	
	// Assign sizes and colors to the main product
	if ($children_products = get_children( 'post_parent=' . $post_id . '&post_type=product_variation' )) {
		foreach ( $children_products as $child ) {
			we_duplicate_product( we_get_product_to_duplicate( $child->ID ), $we_ID, $child->post_status );
		}
	}
	we_duplicate_post_taxonomies($post_id, $we_ID, 'product' );	
	//remove the product categories
//	wp_set_object_terms($we_ID, '', 'product_cat', true);
//	//array list of all the categories this product belongs to
//	$product_categories = $_post_e['tax_input']['product_cat'];
//	//add product categories to the product
//	foreach($product_categories as $product_category) {
//		wp_set_object_terms($we_ID, intval($product_category), 'product_cat', true);
//	}
//	//remove the product tags
//	wp_set_object_terms($we_ID, '', 'product_tag', true);
//	//array list of all the categories this product belongs to
//	$product_tags = $_post_e['tax_input']['product_tag'];
//	//add product categories to the product
//	foreach($product_tags as $product_tag) {
//		$term_object = term_exists($product_tag, 'product_tag');
//		if($term_object == NULL) {
//			//create the category
//			$term_object = wp_insert_term($product_category, 'product_cat', array(
//				'parent' => 0 //parent term id if it should be a sub-category
//			));
//		}
//		 
//		wp_set_object_terms($we_ID, intval($term_object['term_id']), 'product_tag', true);
//		 
//		unset($term_object);
//	}
//	 
//	/*
//	* update the product type.
//	*
//	* the product type can be eiher simple, grouped, external or variable.
//	*/
//	$term_object = term_exists($_post_e['product-type'], 'product_type');
//	if($term_object == NULL) {
//	$term_object = wp_insert_term($_post_e['product-type'], 'product_type');
//	}
//	wp_set_object_terms($we_ID, intval($term_object['term_id']), 'product_type', true);
//	unset($term_object);

}
//update recurren event
function we_update_recurren($_post_e,$we_ID,$post_id,$stdate){
	
	$arr = array(
		'ID'           				=> $we_ID,
		'post_author'               => $_post_e['post_author'],
		'post_content'              => $_post_e['post_content'],
		'post_title'                => $_post_e['post_title'],
		'post_excerpt'              => $_post_e['post_excerpt'],
		'post_status'               => $_post_e['post_status'],
		'comment_status'            => $_post_e['comment_status'],
		'ping_status'               => $_post_e['ping_status'],
		'post_password'             => $_post_e['post_password'],
		'post_parent'               => $_post_e['post_parent'],
		'menu_order'                => $_post_e['menu_order'],
		'post_mime_type'            => $_post_e['post_mime_type']
	);
	if(isset($stdate)){
		$arr['post_title'] = apply_filters( 'we_change_title_recurring', $arr['post_title'], $stdate );
	}
	wp_update_post( $arr );
	
	if(isset($_post_e['_downloadable'])){
		update_post_meta($we_ID, '_downloadable', $_post_e['_downloadable']);
	}
	if(isset($_POST['_virtual'])){
		update_post_meta($we_ID, '_virtual', $_post_e['_virtual']);
	}
	update_post_meta($we_ID, '_visibility', $_post_e['_visibility']);
	update_post_meta($we_ID, '_stock_status', $_post_e['_stock_status']);
	update_post_meta( $we_ID, '_visibility', 'visible' );
    update_post_meta( $we_ID, '_stock_status', 'instock');
	update_post_meta($we_ID, '_regular_price', $_post_e['_regular_price']);
	update_post_meta($we_ID, '_sale_price', $_post_e['_sale_price']);
	update_post_meta($we_ID, '_sold_individually', $_post_e['_sold_individually']);
	//deposit plugin support
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (is_plugin_active( 'woocommerce-deposits/woocommmerce-deposits.php' ) ) {
		$enable_deposit = isset($_post_e['_wc_deposits_enable_deposit']) ? 'yes' : 'no';
		$force_deposit = isset($_post_e['_wc_deposits_force_deposit']) ? 'yes' : 'no';
		$enable_persons = isset($_post_e['_wc_deposits_enable_per_person']) ? 'yes' : 'no';
		$amount_type = (isset($_post_e['_wc_deposits_amount_type']) &&
							   ($_post_e['_wc_deposits_amount_type'] === 'fixed' ||
								$_post_e['_wc_deposits_amount_type'] === 'percent')) ?
								  $_post_e['_wc_deposits_amount_type'] : 'fixed';
		$amount = isset($_post_e['_wc_deposits_deposit_amount']) &&
				  is_numeric($_post_e['_wc_deposits_deposit_amount']) ? floatval($_post_e['_wc_deposits_deposit_amount']) : 0.0;
	
		if ($amount <= 0 || ($amount_type === 'percent' && $amount >= 100)) {
		  $enable_deposit = 'no';
		  $amount = '';
		}
	
		update_post_meta($we_ID, '_wc_deposits_enable_deposit', $enable_deposit);
		update_post_meta($we_ID, '_wc_deposits_force_deposit', $force_deposit);
		update_post_meta($we_ID, '_wc_deposits_amount_type', $amount_type);
		update_post_meta($we_ID, '_wc_deposits_deposit_amount', $amount);
	}
	//end
	if($_post_e['_sale_price']==''){
		update_post_meta( $we_ID, '_price', $_post_e['_regular_price']?$_post_e['_regular_price']:0 );
	}else{
		update_post_meta( $we_ID, '_price', $_post_e['_sale_price']?$_post_e['_sale_price']:0 );
	}
	update_post_meta($we_ID, '_purchase_note', $_post_e['_purchase_note']);
	update_post_meta($we_ID, '_featured', $_post_e['current_featured']);
	update_post_meta($we_ID, '_weight', $_post_e['_weight']);
	update_post_meta($we_ID, '_length', $_post_e['_length']);
	update_post_meta($we_ID, '_width', $_post_e['_width']);
	update_post_meta($we_ID, '_height', $_post_e['_height']);
	update_post_meta($we_ID, '_sku', $_post_e['_sku']);
	update_post_meta($we_ID, '_product_attributes', get_post_meta($post_id,'_product_attributes', true ));
	update_post_meta($we_ID, '_sale_price_dates_from', $_post_e['_sale_price_dates_from']);
	update_post_meta($we_ID, '_sale_price_dates_to', $_post_e['_sale_price_dates_to']);
	update_post_meta($we_ID, '_manage_stock', $_post_e['_manage_stock']);
	update_post_meta($we_ID, '_backorders', $_post_e['_backorders']);
	update_post_meta($we_ID, '_stock', $_post_e['_stock']);
	update_post_meta($we_ID, '_product_image_gallery', $_post_e['product_image_gallery']); //the comma separated attachment id's of the product images
	//variation
	update_post_meta($we_ID, '_min_variation_price', get_post_meta($post_id,'_min_variation_price', true ));
	update_post_meta($we_ID, '_max_variation_price', get_post_meta($post_id,'_max_variation_price', true ));
	update_post_meta($we_ID, '_min_price_variation_id', get_post_meta($post_id,'_min_price_variation_id', true ));
	update_post_meta($we_ID, '_max_price_variation_id', get_post_meta($post_id,'_max_price_variation_id', true ));
	update_post_meta($we_ID, '_min_variation_regular_price', get_post_meta($post_id,'_min_variation_regular_price', true ));
	update_post_meta($we_ID, '_max_variation_regular_price', get_post_meta($post_id,'_max_variation_regular_price', true ));
	update_post_meta($we_ID, '_min_regular_price_variation_id', get_post_meta($post_id,'_min_regular_price_variation_id', true ));
	update_post_meta($we_ID, '_max_regular_price_variation_id', get_post_meta($post_id,'_max_regular_price_variation_id', true ));
	update_post_meta($we_ID, '_min_variation_sale_price', get_post_meta($post_id,'_min_variation_sale_price', true ));
	update_post_meta($we_ID, '_max_variation_sale_price', get_post_meta($post_id,'_max_variation_sale_price', true ));
	update_post_meta($we_ID, '_min_sale_price_variation_id', get_post_meta($post_id,'_min_sale_price_variation_id', true ));
	update_post_meta($we_ID, '_max_sale_price_variation_id', get_post_meta($post_id,'_max_sale_price_variation_id', true ));
	
	
	// Assign sizes and colors to the main product
	//if ($children_products = get_children( 'post_parent=' . $post_id . '&post_type=product_variation' )) {
//		foreach ( $children_products as $child ) {
//			we_duplicate_product( we_get_product_to_duplicate( $child->ID ), $we_ID, $child->post_status );
//		}
//	}
	//remove the product categories
	wp_set_object_terms($we_ID, '', 'product_cat', true);
	//array list of all the categories this product belongs to
	$product_categories = $_post_e['tax_input']['product_cat'];
	//add product categories to the product
	foreach($product_categories as $product_category) {
		wp_set_object_terms($we_ID, intval($product_category), 'product_cat', true);
	}
	//remove the product tags
	wp_set_object_terms($we_ID, '', 'product_tag', true);
	//array list of all the categories this product belongs to
	$product_tags = $_post_e['tax_input']['product_tag'];
	//add product categories to the product
	foreach($product_tags as $product_tag) {
		$term_object = term_exists($product_tag, 'product_tag');
		if($term_object == NULL) {
			//create the category
			$term_object = wp_insert_term($product_category, 'product_cat', array(
				'parent' => 0 //parent term id if it should be a sub-category
			));
		}
		 
		wp_set_object_terms($we_ID, intval($term_object['term_id']), 'product_tag', true);
		 
		unset($term_object);
	}
	 
	
//	* update the product type.
//	*
//	* the product type can be eiher simple, grouped, external or variable.
//	
	$term_object = term_exists($_post_e['product-type'], 'product_type');
	if($term_object == NULL) {
	$term_object = wp_insert_term($_post_e['product-type'], 'product_type');
	}
	wp_set_object_terms($we_ID, intval($term_object['term_id']), 'product_type', true);
	unset($term_object);

}
//edit link recurrence
add_filter( 'get_edit_post_link', 'we_edit_post_link', 10, 3 );
function we_edit_post_link( $url, $post_id, $context) {
    $ex_recurr = get_post_meta($post_id,'recurren_ext', true );
	if($ex_recurr!=''){
		$ex_recurr  = explode("_",$ex_recurr);
		if(isset($ex_recurr[1]) && $ex_recurr[1]!=''){
			$url = add_query_arg( array('post'=>$ex_recurr[1]),  $url);
		}
	}
    return $url;
}
//
add_filter('post_row_actions','we_change_edit_product_rows',10, 2 );
function we_change_edit_product_rows($actions,$post) {
	$ex_recurr = get_post_meta($post->ID,'recurren_ext', true );
	$ex_recurr  = explode("_",$ex_recurr);
	if(isset($ex_recurr[1]) && $ex_recurr[1]!=''){
		$can_edit_post = current_user_can( 'edit_post', $post->ID );
		if ( $can_edit_post ) {
		  $actions['edit'] = '<a href="' . get_edit_post_link( $post->ID, true ) . '" title="' . esc_attr( esc_html__( 'Edit all','exthemes' ) ) . '">' . esc_html__( 'Edit all','exthemes' ) . '</a>';
		  $actions['inline hide-if-no-js'] = '<a href="' . add_query_arg( array('post'=>$post->ID), get_edit_post_link( $post->ID, true )) . '" class="editsingle" title="' . esc_attr( esc_html__( 'Edit single','exthemes' ) ) . '">' . esc_html__( 'Edit single','exthemes' ) . '</a>';
		  
		  $trash_link = str_replace('action=edit', 'action=trash-all', get_edit_post_link( $post->ID, true ));
		  $actions['trash trash-all'] = '<a href="' . add_query_arg( array('post_type'=> 'product'),$trash_link ) . '" class="editsingle" title="' . esc_attr( esc_html__( 'Trash all','exthemes' ) ) . '">' . esc_html__( 'Trash all','exthemes' ) . '</a>';
		}
	}
	return $actions;
}
add_action('init','we_trash_all_recurring');
if(!function_exists('we_trash_all_recurring')){
	function we_trash_all_recurring() {
		if(is_admin() && isset($_GET['action']) && $_GET['action'] =='trash-all' && isset($_GET['post_type']) && $_GET['post_type'] =='product' && isset($_GET['post']) && $_GET['post'] !=''){
			if ( current_user_can( 'edit_post', $_GET['post'] ) ) {
				$ex_recurr = get_post_meta($_GET['post'],'recurren_ext', true );
				if($ex_recurr!=''){
					$args = array(
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => -1,
						'order' => 'ASC',
						'meta_key' => 'recurren_ext',
						'orderby' => 'meta_value_num',
						'meta_query' => array(
							array(
								'key'     => 'recurren_ext',
								'value'   => $ex_recurr,
								'compare' => '=',
							),
						),
					);
					$ex_posts = get_posts( $args );
					foreach($ex_posts as $item){
						wp_trash_post($item->ID);
					}
					wp_redirect( admin_url('edit.php?post_type=product') );
					exit;
				}
			}
			return;
		}
	}
}
//bubble
add_action( 'admin_menu', 'we_pending_posts_bubble', 999 );
function we_pending_posts_bubble() 
{
    global $menu;

    // Get all post types and remove Attachments from the list
    // Add '_builtin' => false to exclude Posts and Pages
    $args = array( 'public' => true ); 
    $post_types = get_post_types( $args );

    foreach( $post_types as $pt ){
		if( $pt == 'product'){
			// Count posts
			$cpt_count = wp_count_posts( $pt );
	
			if ( $cpt_count->pending ) 
			{
				// Menu link suffix, Post is different from the rest
				$suffix = ( 'post' == $pt ) ? '' : "?post_type=$pt";
	
				// Locate the key of 
				$key = we_recursive_array_search_php( "edit.php$suffix", $menu );
	
				// Not found, just in case 
				if( !$key )
					return;
	
				// Modify menu item
				$menu[$key][0] .= sprintf(
					'<span class="update-plugins count-%1$s" style="background-color:white;color:red; margin-left:5px;"><span class="plugin-count">%1$s</span></span>',
					$cpt_count->pending 
				);
			}
		}
    }
}
function we_recursive_array_search_php( $needle, $haystack ) 
{
    foreach( $haystack as $key => $value ) 
    {
        $current_key = $key;
        if( 
            $needle === $value 
            OR ( 
                is_array( $value )
                && we_recursive_array_search_php( $needle, $value ) !== false 
            )
        ) 
        {
            return $current_key;
        }
    }
    return false;
}
// edit column admin 
add_filter( 'manage_product_posts_columns', 'we_edit_columns',99 );
function we_edit_columns( $columns ) {
	global $wpdb;
	unset($columns['date']);
	unset($columns['sku']);
	unset($columns['product_type']);
	$columns['we_startdate'] = esc_html__( 'Start Date' , 'exthemes' );
	$columns['we_enddate'] = esc_html__( 'End Date' , 'exthemes' );
			
	return $columns;
}
add_action( 'manage_product_posts_custom_column', 'we_custom_columns',12);
function we_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'we_startdate':
			$we_startdate = get_post_meta($post->ID, 'we_startdate', true);
			if($we_startdate!=''){
				echo date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate);
			}
			break;
		case 'we_enddate':
			$we_enddate = get_post_meta($post->ID, 'we_enddate', true);
			if($we_enddate!=''){
				echo date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate);
			}
			break;		
	}
}
// default venue
add_action('wp_ajax_we_add_venue', 'we_add_venue_func' );
if(!function_exists('we_add_venue_func')){
	function we_add_venue_func(){
		$value = $_POST['value'];
		$we_adress = $we_phone = $we_email = $we_website ='';
		if(isset($value) && $value != '')
		{
			$we_adress = get_post_meta( $value, 'we_adress', true ) ;
			$we_latitude_longitude = get_post_meta( $value, 'we_latitude_longitude', true ) ;
			$we_phone = get_post_meta( $value, 'we_phone', true ) ;
			$we_email = get_post_meta( $value, 'we_email', true ) ;
			$we_website = get_post_meta( $value, 'we_website', true ) ;
		}
		$output =  array('we_adress'=>$we_adress,'we_latitude_longitude'=> $we_latitude_longitude,'we_phone'=> $we_phone,'we_email'=> $we_email,'we_website'=> $we_website);
		echo str_replace('\/', '/', json_encode($output));
		die;
	}
}
if(!function_exists('we_add_new_venue')){
	add_action( 'save_post', 'we_add_new_venue' );
	function we_add_new_venue(){
		$value = isset($_POST['we_default_venue']) ? $_POST['we_default_venue'] :'';
		if(isset ($value['exc_mb-field-0']) && $value['exc_mb-field-0'] == '')
		{
			$venue_check = get_page_by_title($_POST['we_adress']['exc_mb-field-0'],'OBJECT','we_venue');
			if($venue_check->ID){
				return;
			}
			$attr = array(
				'post_title'    => wp_strip_all_tags( $_POST['we_adress']['exc_mb-field-0'] ),
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => get_current_user_id(),
				'post_type'      => 'we_venue',
			);
			remove_action( 'save_post', 'we_add_new_venue');
			if($new_ID = wp_insert_post( $attr, false )){
				// update meta
				update_post_meta( $new_ID, 'we_adress', $_POST['we_adress']['exc_mb-field-0']);
				update_post_meta( $new_ID, 'we_latitude_longitude', $_POST['we_latitude_longitude']['exc_mb-field-0']);
				update_post_meta( $new_ID, 'we_phone', $_POST['we_phone']['exc_mb-field-0']);
				update_post_meta( $new_ID, 'we_email', $_POST['we_email']['exc_mb-field-0']);
				update_post_meta( $new_ID, 'we_website', $_POST['we_website']['exc_mb-field-0']);
				$_POST['we_default_venue']['exc_mb-field-0'] = $new_ID;
			}
			add_action( 'save_post', 'we_add_new_venue' );
		}
	}
}


