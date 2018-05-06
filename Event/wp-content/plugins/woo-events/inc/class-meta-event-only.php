<?php
/* Category Layout purpose */
add_action( 'product_cat_add_form_fields', 'we_sglayout_purpose_fields', 10 );
add_action ( 'product_cat_edit_form_fields', 'we_sglayout_purpose_fields');

function we_sglayout_purpose_fields( $tag ) {
	$t_id 					= isset($tag->term_id) ? $tag->term_id : '';
	$we_cat_sglayout 			= get_option( "we_cat_sglayout_$t_id")?get_option( "we_cat_sglayout_$t_id"):'';
	?>
	<tr class="form-field" style="">
		<th scope="row" valign="top">
			<label for="we_cat_sglayout"><?php esc_html_e('Layout Purpose','exthemes'); ?></label>
		</th>
		<td>
			<select name="we_cat_sglayout" id="we_cat_sglayout">
                <option value=""><?php esc_html_e('Default','exthemes'); ?></option>
                <option value="woo" <?php echo $we_cat_sglayout=='woo'?'selected="selected"':'' ?>><?php esc_html_e('WooCommerce','exthemes'); ?></option>
                <option value="event" <?php echo $we_cat_sglayout=='event'?'selected="selected"':'' ?>><?php esc_html_e('Events','exthemes'); ?></option>
            </select>
		</td>
	</tr>
	<?php
}
//save layout fields
add_action ( 'edited_product_cat', 'we_save_extra_sglayout_fileds', 10, 2);
add_action( 'created_product_cat', 'we_save_extra_sglayout_fileds', 10, 2 );
function we_save_extra_sglayout_fileds( $term_id ) {
	if ( isset( $_POST[sanitize_key('we_cat_sglayout')] ) ) {
		$we_cat_sglayout = $_POST['we_cat_sglayout'];
		update_option( "we_cat_sglayout_$term_id", $we_cat_sglayout );
	}
}
if(!function_exists('we_event_cat_custom_layout')){
	function we_event_cat_custom_layout($id){
		if($id==''){
			return;	
		}
		$args = array(
			'hide_empty'        => true, 
		);
		$we_eventlayout ='';
		$terms = wp_get_post_terms($id, 'product_cat', $args);
		if(!empty($terms) && !is_wp_error( $terms )){
			foreach ( $terms as $term ) {
				$we_eventlayout = get_option('we_cat_sglayout_' . $term->term_id);
				if($we_eventlayout!=''){
					break;
				}
			}
		}
		$we_eventlayout = apply_filters( 'we_cat_sglayout', $we_eventlayout,$id );
		return $we_eventlayout;
	}
}

class WooEvent_ShowMeta {
	public function __construct()
    {
		add_action( 'woocommerce_single_product_summary', array( &$this,'woocommerce_single_ev_meta') );
		add_action( 'woocommerce_after_single_product_summary', array( &$this,'woocommerce_single_ev_schedu') );
		
		add_filter( 'woocommerce_product_description_heading',  array( &$this,'wc_change_product_description_tab_title'), 10, 1 );
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( &$this,'woo_custom_cart_button_text'));  

		add_action('woocommerce_before_single_product',array( &$this,'add_info_before_single'),11);

		add_action( 'woocommerce_email_before_order_table', array( &$this,'woocommerce_email_hook'));
		add_filter( 'woocommerce_cart_item_name', array( &$this,'woocommerce_cart_hook'), 10, 3 );
		add_filter ('woocommerce_add_to_cart_redirect', array( &$this,'woocommerce_redirect_to_checkout'));
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
	//change text
	function wc_change_product_description_tab_title( $heading ) {
		global $woocommerce, $post;
		$we_layout_purpose = we_global_default_spurpose();
		if($we_layout_purpose!='event'){
			$heading = get_option('we_text_details')!='' ? get_option('we_text_details') : esc_html__('Details','exthemes');
		}else{
			$heading = get_option('we_text_evdetails')!='' ? get_option('we_text_evdetails') : esc_html__('Event Details','exthemes');
		}
		return $heading;
	}
	//remove button if event pass
	function add_info_before_single(){
		global $woocommerce, $post;
		$time_now =  strtotime("now");
		$we_enddate = we_global_enddate() ;
		$we_layout_purpose = we_global_default_spurpose();
		echo we_hide_booking_form();
		
		$we_time_zone = get_post_meta($post->ID,'we_time_zone',true);
		if($we_time_zone!='' && $we_time_zone!='def'){
			$we_time_zone = $we_time_zone * 60 * 60;
			$time_now = $we_time_zone + $time_now;
		}
		
		if($time_now > $we_enddate && $we_enddate!='' && $we_layout_purpose=='event'){
			$evpasstrsl = get_option('we_text_event_pass')!='' ? get_option('we_text_event_pass') : esc_html__('This event has passed','exthemes');
			echo '
			<div class="alert alert-warning event-info"><i class="fa fa-exclamation-triangle"></i>'.$evpasstrsl.'</div>
			<style type="text/css">.woocommerce div.product form.cart, .woocommerce div.product p.cart{ display:none !important}</style>';
		}
	}// global $date
	
	function woo_custom_cart_button_text() {
	 	$we_text_join_ev = get_option('we_text_join_ev');
		global $woocommerce, $post;
		$we_main_purpose = we_global_main_purpose();
		$we_layout_purpose = we_global_default_spurpose();
		if($we_layout_purpose!='event'){
			return get_option('we_text_add_to_cart')!='' ? get_option('we_text_add_to_cart') : esc_html__( 'Add To Cart', 'exthemes' );
		}
		if($we_text_join_ev!=''){
			return $we_text_join_ev;
		}else{
			return esc_html__( 'Join this Event', 'exthemes' );
		}
	 
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
	// Single Custom meta 
	function woocommerce_single_ev_meta() {
		global $woocommerce, $post;
		$we_layout_purpose = we_global_default_spurpose();
		if($we_layout_purpose=='event'){
			wooevent_template_plugin('event-meta');
		}
			
	}
	function woocommerce_single_ev_schedu() {
		global $woocommerce, $post;
		$we_layout_purpose = we_global_default_spurpose();
		
		if($we_layout_purpose=='event'){
			wooevent_template_plugin('event-schedu');
		}
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
		if(!is_cart() && !is_checkout()){ return $_product_title;}
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
}
$WooEvent_ShowMeta = new WooEvent_ShowMeta();