<?php
class WooEvent_ShowMeta {
	public function __construct()
    {
		add_action( 'woocommerce_single_product_summary', array( &$this,'woocommerce_single_ev_meta') );
		add_action( 'woocommerce_after_single_product_summary', array( &$this,'woocommerce_single_ev_schedu') );
		add_action( 'woocommerce_archive_description', array( &$this,'woocommerce_shop_search_view_bar') );
		add_action( 'pre_get_posts', array( &$this,'remove__shop_loop'),99 );
		add_filter('loop_shop_columns', array( &$this,'ex_loop_columns'));
		add_action( 'woocommerce_before_shop_loop_item', array( &$this,'woocommerce_shopitem_ev_meta'),99 );
		//add_action( 'woocommerce_after_shop_loop_item', array( &$this,'woocommerce_shopitem_ev_short_des') );
		add_action( 'woocommerce_shop_loop_item_title', array( &$this,'woocommerce_shopitem_ev_more_meta') );
		//add_action( 'woocommerce_product_thumbnails', array( &$this,'ical_google_calendar') );
		//add_action( 'woocommerce_after_main_content', array( &$this,'woocommerce_shopitem_ev_share') );
		add_filter( 'woocommerce_loop_add_to_cart_link', array( &$this,'change_product_link') );
		add_filter( 'woocommerce_catalog_orderby', array( &$this,'change_product_orderby'),10,11 );
		add_action( 'init', array( &$this,'remove_upsell') );
		add_action( 'widgets_init', array( &$this,'we_widgets_init') );
 		add_filter( 'woocommerce_output_related_products_args', array( &$this,'related_products_item'), 99 );
		add_filter( 'woocommerce_product_tabs', array( &$this,'woo_remove_reviews_tab'), 98 );
		add_filter( 'woocommerce_product_description_heading',  array( &$this,'wc_change_product_description_tab_title'), 10, 1 );
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( &$this,'woo_custom_cart_button_text'));  
		//add_filter( 'gettext', array( &$this,'related_chage'), 20, 3 );
		add_action('woocommerce_before_single_product',array( &$this,'add_info_before_single'),11);
		add_filter( 'woocommerce_product_tabs', array( &$this,'woo_remove_product_tabs'), 98 );
		add_filter( 'woocommerce_single_product_image_html', array( &$this,'woo_remove_product_image'), 98 );
		add_action( 'woocommerce_email_before_order_table', array( &$this,'woocommerce_email_hook'));
		add_filter( 'woocommerce_cart_item_name', array( &$this,'woocommerce_cart_hook'), 10, 3 );
		add_filter ('woocommerce_add_to_cart_redirect', array( &$this,'woocommerce_redirect_to_checkout'));
		add_action( 'woocommerce_after_main_content', array( &$this,'woocommerce_next_previous_event'));
		add_filter('woocommerce_related_products_args',array( &$this,'wc_remove_related_products'), 10); 
		add_filter( 'woocommerce_add_to_cart_validation', array( &$this,'validate_add_cart_item'), 10, 5 );
    }
	// Stop event booking before X day event start
	function validate_add_cart_item( $passed, $product_id, $quantity, $variation_id = '', $variations= '' ) {
	
		// do your validation, if not met switch $passed to false
		if ( we_hide_booking_form()!='' ){
			$passed = false;
			$t_stopb = get_option('we_text_stopb')!='' ? get_option('we_text_stopb') : esc_html__('Tickets not available','exthemes');
			wc_add_notice( $t_stopb, 'error' );
		}
		return $passed;
	
	}
	//remove product tabs if layout 2
	function woo_remove_product_tabs( $tabs ) {
		global $woocommerce, $post;
		$we_enable_review = get_option('we_enable_review');
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose == 'woo' || $we_enable_review == 'on'){
			if(wooevent_global_layout() =='layout-2' || wooevent_global_layout() =='layout-3'){
				unset( $tabs['description'] ); 
			}
		}else{
			if(wooevent_global_layout() =='layout-2' || wooevent_global_layout() =='layout-3'){
				unset( $tabs['description'] );      	// Remove the description tab
				unset( $tabs['reviews'] ); 			// Remove the reviews tab
				unset( $tabs['additional_information'] );  	// Remove the additional information tab
			}
		}
		return $tabs;
	
	}
	//remove review
	function woo_remove_reviews_tab($tabs) {
		$we_main_purpose = we_global_main_purpose();
		$we_enable_review = get_option('we_enable_review');
		if($we_main_purpose=='woo' || $we_main_purpose=='custom' || $we_enable_review == 'on' ){return $tabs;}
		unset($tabs['reviews']);
		return $tabs;
	}
	function woo_remove_product_image( $image ) {
		if(wooevent_global_layout() =='layout-2' || wooevent_global_layout() =='layout-3'){
			$image ='';
		}
		return $image;
	
	}
	//remove button if event pass
	function add_info_before_single(){
		global $woocommerce, $post;
		$time_now =  strtotime("now");
		$we_enddate = we_global_enddate() ;
		$we_main_purpose = we_global_main_purpose();
		$we_enable_sginfo = get_option('we_enable_sginfo');
		echo we_hide_booking_form();
		$id_user = get_current_user_id();
		
		$we_time_zone = get_post_meta($post->ID,'we_time_zone',true);
		if($we_time_zone!='' && $we_time_zone!='def'){
			$we_time_zone = $we_time_zone * 60 * 60;
			$time_now = $we_time_zone + $time_now;
		}
		//echo $time_now;
		if($time_now > $we_enddate && $we_enddate!='' && $we_main_purpose!='woo'){
			$evpasstrsl = get_option('we_text_event_pass')!='' ? get_option('we_text_event_pass') : esc_html__('This event has passed','exthemes');
			echo '
			<div class="alert alert-warning event-info"><i class="fa fa-exclamation-triangle"></i>'.$evpasstrsl.'</div>
			<style type="text/css">.woocommerce div.product form.cart, .woocommerce div.product p.cart{ display:none !important}</style>';
		}else if($we_enable_sginfo=='on' && $id_user!=0 && wc_customer_bought_product('',$id_user, get_the_ID())){
			$evsg_info = get_option('we_text_usersg')!='' ? get_option('we_text_usersg') : esc_html__('You already signed up this event','exthemes');
			echo '<div class="alert alert-warning event-info"><i class="fa fa-exclamation-triangle"></i>'.$evsg_info.'</div>';
		}
		if(wooevent_global_layout() =='layout-2' || wooevent_global_layout() =='layout-3'){
			wooevent_template_plugin('layout-2');
		}
	}// global $date
	
	//Add to cart text
	function related_chage( $translated_text, $text, $domain ) {
		$we_main_purpose = get_option('we_main_purpose');
		if($we_main_purpose!='custom'){
			switch ( $translated_text ) {
				case 'Related Products' :
					$translated_text = get_option('we_text_related')!='' ? get_option('we_text_related') : esc_html__( 'Related Events', 'exthemes' );
					break;
			}
		}
		return $translated_text;
	}
	function woo_custom_cart_button_text() {
	 	$we_text_join_ev = get_option('we_text_join_ev');
		global $woocommerce, $post;
		$we_main_purpose = we_global_main_purpose();
		$we_layout_purpose = get_post_meta($post->ID,'we_layout_purpose',true);
		if($we_main_purpose=='custom' && $we_layout_purpose=='woo' || $we_main_purpose=='woo'){
			return get_option('we_text_add_to_cart')!='' ? get_option('we_text_add_to_cart') : esc_html__( 'Add To Cart', 'exthemes' );
		}
		if($we_text_join_ev!=''){
			return $we_text_join_ev;
		}else{
			return esc_html__( 'Join this Event', 'exthemes' );
		}
	 
	}
	//change text
	function wc_change_product_description_tab_title( $heading ) {
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose=='custom'){
			$heading = get_option('we_text_details')!='' ? get_option('we_text_details') : esc_html__('Details','exthemes');
		}else if($we_main_purpose!='woo'){
			$heading = get_option('we_text_evdetails')!='' ? get_option('we_text_evdetails') : esc_html__('Event Details','exthemes');
		}
		return $heading;
	}
	
	function related_products_item( $args ) {
		$we_related_count = get_option('we_related_count');
		if(!is_numeric($we_related_count) || $we_related_count==''){
			$we_related_count = 3;
		}
		$args['posts_per_page'] = $we_related_count; // number related products
		$args['columns'] = 3; 
		return $args;
	}
	//
	//Register sidebars
	function we_widgets_init() {
		if(get_option('we_sidebar') !='hide'){
			register_sidebar( array(
				'name' => esc_html__('WooEvent','exthemes'),
				'id' => 'wooevent-sidebar',
				'description' => esc_html__('Sidebar for all pages of WooEvents.','exthemes'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '<div class="clear"></div></div></div></div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3><div class="wooe-sidebar"><div class="wooe-wrapper">',
			) );
		}
	}
	// change orderby
	function remove_upsell() {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	}
	// change orderby
	function change_product_orderby( $order ) {
		global $product;
		$we_listing_order = get_option('we_listing_order');
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
			$we_listing_order = 'def';
		}
		$upc = get_option('we_text_upc')!='' ? get_option('we_text_upc') : esc_html__('Upcoming Events','exthemes');
		$def = get_option('we_text_defa')!='' ? get_option('we_text_defa') : esc_html__('Default','exthemes');
		$ong = get_option('we_text_ong')!='' ? get_option('we_text_ong') : esc_html__('Ongoing Events','exthemes');
		$pas = get_option('we_text_pas')!='' ? get_option('we_text_pas') : esc_html__('Past Events','exthemes');
		if( $we_listing_order == 'all' || $we_listing_order == 'ontoup' || is_search()){
			$order = array(
				'' => $def,
				'upcoming' => $upc,
				'ongoing' => $ong,
				'past' => $pas,
				
			);
		}elseif( $we_listing_order!= 'def'){
			$order = array(
				'upcoming' => $upc,
				'ongoing' => $ong,
				'past' => $pas,
				
			);
		}
		return $order;
	}
	// change add to cart link
	function change_product_link( $link ) {
		global $product;
		$product_id = $product->get_id();
		$product_sku = $product->get_sku();
		$vialltrsl = get_option('we_text_viewdetails')!='' ? get_option('we_text_viewdetails') : esc_html__( 'View Details', 'exthemes' );
		$link = '<a href="'.get_permalink().'" rel="nofollow" data-product_id="'.$product_id.'" data-product_sku="'.$product_sku.'" data-quantity="1" class="button add_to_cart_button product_type_variable">'.$vialltrsl.'</a>';
		return $link;
	}
	// change add to cart link
	function ical_google_calendar() {
		global $woocommerce, $post;
		$we_enddate = we_global_enddate();
		$we_startdate = we_global_startdate();?>
        <div class="we-icl-import">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn btn-primary"><a href="<?php echo home_url().'?ical_product='.$post->ID; ?>"><?php echo get_option('we_text_ical')!='' ? get_option('we_text_ical') : esc_html__('+ Ical Import','exthemes');?></a></div>
                    <div class="btn btn-primary"><a href="https://www.google.com/calendar/render?dates=<?php  echo gmdate("Ymd\THis", $we_startdate);?>/<?php echo gmdate("Ymd\THis", $we_enddate);?>&action=TEMPLATE&text=<?php echo get_the_title(get_the_ID());?>&location=<?php echo get_post_meta(get_the_ID(),'we_adress', true );?>&details=<?php echo get_the_excerpt();?>"><?php echo get_option('we_text_ggcal')!='' ? get_option('we_text_ggcal') : esc_html__('+ Google calendar','exthemes');?></a></div>
                </div>
            </div>
        </div>
        <?php
	}
	//List item per row
	function ex_loop_columns() {
		return 3; // 3 products per row
	}
	// Shop toolbar
	function woocommerce_shop_search_view_bar() {
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose!='woo' && $we_main_purpose!='custom'){
			$we_firstday = get_option('we_firstday');
			echo do_shortcode('[we_calendar show_search="1" use_shortcode="0" firstday="'.$we_firstday.'"]');
		}
	}
	// Single Custom meta 
	function woocommerce_single_ev_meta() {
		global $woocommerce, $post;
		if(wooevent_global_layout() !='layout-2' && wooevent_global_layout() !='layout-3'){
			wooevent_template_plugin('event-meta');
		}
	}
	function woocommerce_single_ev_schedu() {
		global $woocommerce, $post;
		wooevent_template_plugin('event-schedu');
	}
	function remove__shop_loop( $query ) {
		$qobj = get_queried_object();
      	if (empty($qobj)){ return;}
  		$time_now =  strtotime("now");
		$we_shop_view = get_option('we_shop_view');
		$we_listing_order = get_option('we_listing_order');
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
			
		}else{
		
			if ( ! is_admin() && (is_shop() || is_product_category() && $query->is_main_query() || is_product_tag()) && $query->is_main_query()) {
				if((!isset($_GET['orderby']) && !is_search() && $we_listing_order != 'all' && $we_listing_order != 'def' && $we_listing_order != 'ontoup') || isset($_GET['orderby']) && $_GET['orderby']=='upcoming' ){
					$meta_valu = array(
						array(
							'key'     => 'we_startdate',
							'value'   => $time_now,
							'compare' => '>',
						),
					);
					$query->set('orderby', 'meta_value_num');
					$query->set('order', 'ASC');
					$query->set('meta_key', 'we_startdate');
					$query->set('meta_query', $meta_valu);
				}elseif(!isset($_GET['orderby']) && $we_listing_order =='ontoup' ){
					$meta_valu = array(
						'relation' => 'OR',
						array(
							'key'     => 'we_startdate',
							'value'   => $time_now,
							'compare' => '>',
						),
						array(
							'key'     => 'we_enddate',
							'value'   => $time_now,
							'compare' => '>',
						),
					);
					$query->set('orderby', 'meta_value_num');
					$query->set('order', 'ASC');
					$query->set('meta_key', 'we_startdate');
					$query->set('meta_query', $meta_valu);
				}elseif(isset($_GET['orderby']) && $_GET['orderby']=='ongoing' ){
					$meta_valu = array(
						array(
							'key'     => 'we_startdate',
							'value'   => $time_now,
							'compare' => '<=',
						),
						array(
							'key'     => 'we_enddate',
							'value'   => $time_now,
							'compare' => '>',
						),
					);
					$query->set('orderby', 'meta_value_num');
					$query->set('order', 'ASC');
					$query->set('meta_key', 'we_startdate');
					$query->set('meta_query', $meta_valu);
					return;
				}elseif(isset($_GET['orderby']) && $_GET['orderby']=='past' ){
					$meta_valu = array(
						array(
							'key'     => 'we_enddate',
							'value'   => $time_now,
							'compare' => '<',
						),
					);
					$query->set('orderby', 'meta_value_num');
					$query->set('order', 'DESC');
					$query->set('meta_key', 'we_startdate');
					$query->set('meta_query', $meta_valu);
				}
				
				//search map
				if(is_search() && is_shop() && we_global_search_result_page()=='map'){
					$query->set('posts_per_page', -1);
				}
			}
		}
		
	}
	// Add meta to item of shop
	function woocommerce_shopitem_ev_meta(){
		global $woocommerce, $post;
		$we_startdate = get_post_meta( $post->ID, 'we_startdate', true );
		
		$we_eventcolor = we_event_custom_color($post->ID);
		if($we_eventcolor==''){$we_eventcolor = we_autochange_color();}
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
			$we_startdate ='';
		}
		$bgev_color = '';
		if($we_eventcolor!=""){
			$bgev_color = 'style="background-color:'.$we_eventcolor.'"';
		}

		if($we_startdate!=''){ 
			echo '<div class="shop-we-stdate" '.$bgev_color.'><span class="day">'.date_i18n('d', $we_startdate).'</span>';
			echo '<span class="month">'.date_i18n('M', $we_startdate).'</span></div>';
		}
	}
	// Add more meta to item of shop
	function woocommerce_shopitem_ev_more_meta(){
		global $woocommerce, $post;
		$we_startdate = get_post_meta( $post->ID, 'we_startdate', true );
		$we_enddate = get_post_meta( $post->ID, 'we_enddate', true );
		$we_adress = get_post_meta( $post->ID, 'we_adress', true ) ;
		global $product;	
		$type = $product->get_type();
		$price_html = $product->get_price();
		if($type=='variable'){
			$price = we_variable_price_html();
		}else{
			if ( $price_html = $product->get_price_html() ) :
				$price = $price_html;
			endif; 	
		}
		$hml = '
		<div class="shop-we-more-meta">';
			if($we_startdate!=''){ 
				$hml .= '
				<span><i class="fa fa-calendar"></i>'.date_i18n( get_option('date_format'), $we_startdate).'</span>';
			}
			$hml .= '
			<span><i class="fa fa-shopping-basket"></i>'.$price.'</span>';
			$hml .= '
			<span>
				<i class="fa fa-ticket"></i>
				'.woo_event_status( $post->ID, $we_enddate).'
			</span>';
			$hml .= '
		</div>';
		$ft_html = apply_filters( 'we_shop_ev_meta', $hml, $we_startdate, $price, $we_enddate );
		echo $ft_html;
	}
	// Add short des to item of shop
	function woocommerce_shopitem_ev_short_des(){
		global $woocommerce, $post;
		echo '
		<div class="shop-we-short-des">
			'.apply_filters( 'woocommerce_short_description', $post->post_excerpt ).'
			<div class="cat-meta">'.ex_cat_info('on','product').'</div>
		</div>';
	}
	// Add Social share to item of shop
	function woocommerce_shopitem_ev_share(){
		global $woocommerce, $post;
		echo '<div class="shop-we-social-share">
			'.we_social_share().'
		</div>';
	}
	// Email hook
	function woocommerce_email_hook($order){
		$event_details = new WC_Order( $order->id );
		global $event_items;
		$event_items = $event_details->get_items();
		wooevent_template_plugin('email-event-details');

	}
	// Cart hook
	function woocommerce_cart_hook($_product_title,$cart_item, $cart_item_key){
		$we_startdate = get_post_meta( $cart_item['product_id'], 'we_startdate', true );
		$we_enddate = get_post_meta( $cart_item['product_id'], 'we_enddate', true );
		$all_day = get_post_meta($cart_item['product_id'],'we_allday', true );
		$html = '<h4>'.$_product_title.'</h4>';
		if($all_day!='1' && $we_startdate!=''){
			$stdatetrsl = get_option('we_text_stdate')!='' ? get_option('we_text_stdate') :  esc_html__('Start Date','exthemes');
			$edatetrsl = get_option('we_text_edate')!='' ? get_option('we_text_edate') : esc_html__('End Date','exthemes');
			$alltrsl = get_option('we_text_allday')!='' ? get_option('we_text_allday') : esc_html__('(All day)','exthemes');
			$html .='<span class="meta-stdate">'.$stdatetrsl.': '.date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate).'</span>';
			$html .='<span class="meta-eddate">'.$edatetrsl.': '.date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate).'</span>';
		}elseif($we_startdate!=''){
			$html .='<span class="meta-stdate">'.$stdatetrsl.': '.date_i18n( get_option('date_format'), $we_startdate).'</span>';
			$html .='<span class="meta-eddate">'.$edatetrsl.': '.date_i18n( get_option('date_format'), $we_enddate).' '.$alltrsl.'</span>';
		}
		return $html;

	}
	// redirect to checkout
	function woocommerce_redirect_to_checkout($wc) {
		if(get_option('we_enable_cart')=='off'){
			global $woocommerce;
			$checkout_url = $woocommerce->cart->get_checkout_url();
			return $checkout_url;
		}
		return $wc;
	}
	// Next Previous link
	function woocommerce_next_previous_event(){
		$we_sevent_navi = get_option('we_sevent_navi');
		if(is_singular('product') && $we_sevent_navi!='off'){
			global $post;
			$args = array( 'post_type' => 'product', 'posts_per_page' => 1, 'orderby'=> 'meta_value_num', 'order' => 'ASC','meta_key' => 'we_startdate', 'meta_value' => get_post_meta( $post->ID, 'we_startdate', true ),  'meta_compare' => '>', );
			$post_nex = get_posts( $args );
			$next_l ='';
			foreach ( $post_nex as $post ) : setup_postdata( $post );
				$next_l = get_the_permalink();
			endforeach; 
			wp_reset_postdata();
			$args_pre = array( 'post_type' => 'product', 'posts_per_page' => 1, 'orderby'=> 'meta_value_num', 'order' => 'DESC','meta_key' => 'we_startdate', 'meta_value' => get_post_meta( $post->ID, 'we_startdate', true ),  'meta_compare' => '<', );
			$post_pre = get_posts( $args_pre );
			$previous_l = '';
			foreach ( $post_pre as $post ) : setup_postdata( $post );
				$previous_l = get_the_permalink();
			endforeach; 
			wp_reset_postdata();
			$we_main_purpose = we_global_main_purpose();
			$html ='<div class="we-navigation">';
			if($previous_l!=''){
				if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
					$pretrsl = get_option('we_text_previous')!='' ? get_option('we_text_previous') :  esc_html__('Previous','exthemes');
					$html .='<div class="previous-event"><a href="'.$previous_l.'" class="btn btn-primary"><i class="fa fa-angle-double-left"></i>'.$pretrsl.'</a></div>';
				}else{
					$preevtrsl = get_option('we_text_previousev')!='' ? get_option('we_text_previousev') : esc_html__('Previous Event','exthemes');
					$html .='<div class="previous-event"><a href="'.$previous_l.'" class="btn btn-primary"><i class="fa fa-angle-double-left"></i>'.$preevtrsl.'</a></div>';
				}
			}
			if($next_l!=''){
				if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
					$nexttrsl = get_option('we_text_next')!='' ? get_option('we_text_next') : esc_html__('Next','exthemes');
					$html .='<div class="next-event"><a href="'.$next_l.'" class="btn btn-primary">'.$nexttrsl.'<i class="fa fa-angle-double-right"></i></a></div>';
				}else{
					$nextevtrsl = get_option('we_text_nextev')!='' ? get_option('we_text_nextev') : esc_html__('Next Event','exthemes');
					$html .='<div class="next-event"><a href="'.$next_l.'" class="btn btn-primary">'.$nextevtrsl.'<i class="fa fa-angle-double-right"></i></a></div>';
				}
			}
			$html .='</div><div class="clear"></div>';
			echo  $html;
		}
	}
	// remove related
	function wc_remove_related_products( $args ) {
		$we_srelated = get_option('we_srelated');
		if($we_srelated =='off'){
			return array();
		}else{
			return $args;
		}
	}
}
$WooEvent_ShowMeta = new WooEvent_ShowMeta();