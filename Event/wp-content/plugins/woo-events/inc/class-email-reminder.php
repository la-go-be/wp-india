<?php
class WooEvent_Reminder_Email {
	public function __construct()
    {
		// Schedule the event when the order is completed.
		add_action( 'woocommerce_order_status_completed', array( $this, 'remind_email' ), 10, 1 );
		// Trigger the email.
		add_action( 'wooevent_review_reminder_email', array( $this, 'send_mail' ), 1,2 );
    }
	/**
	 * Gets permalinks from order.
	 *
	 * @param  int    $order_id Order ID.
	 *
	 * @return string           Permalinks.
	 */
	protected function get_permalinks_from_order( $order_id ) {
		global $wpdb;
		$permalinks = '<ul>';

		// Get all order items.
		$order_item_ids = $wpdb->get_col(
			$wpdb->prepare( "
				SELECT
				order_item_id
				FROM
				{$wpdb->prefix}woocommerce_order_items
				WHERE
				order_id = %d
			", $order_id )
		);

		// Get products ids.
		foreach ( $order_item_ids as $order_item_id ) {
			$product_id = $wpdb->get_row(
				$wpdb->prepare( "
					SELECT
					meta_value
					FROM
					{$wpdb->prefix}woocommerce_order_itemmeta
					WHERE
					order_item_id = %d
					AND
					meta_key = '_product_id'
				", $order_item_id ),
				ARRAY_N
			);

			// Test whether the product actually was found.
			if ( is_array( $product_id ) ) {
				$product_ids[] = implode( $product_id );
			}
		}

		// Creates products links.
		foreach ( $product_ids as $product_id ) {
			$permalinks .= sprintf( '<li><a href="%1$s" target="_blank">%1$s</a></li>', get_permalink( $product_id ) );
		}

		$permalinks .= '</ul>';

		return $permalinks;
	}
	/**
	 * Gets permalinks from order.
	 *
	 * @param  int    $order_id Order ID.
	 *
	 * @return string           Permalinks.
	 */
	protected function get_idproduct_from_order( $order_id ) {
		global $wpdb;
		// Get all order items.
		$order_item_ids = $wpdb->get_col(
			$wpdb->prepare( "
				SELECT
				order_item_id
				FROM
				{$wpdb->prefix}woocommerce_order_items
				WHERE
				order_id = %d
			", $order_id )
		);

		// Get products ids.
		foreach ( $order_item_ids as $order_item_id ) {
			$product_id = $wpdb->get_row(
				$wpdb->prepare( "
					SELECT
					meta_value
					FROM
					{$wpdb->prefix}woocommerce_order_itemmeta
					WHERE
					order_item_id = %d
					AND
					meta_key = '_product_id'
				", $order_item_id ),
				ARRAY_N
			);

			// Test whether the product actually was found.
			if ( is_array( $product_id ) ) {
				$product_ids[] = implode( $product_id );
			}
		}

		return $product_ids;
	}
	/**
	 * Remind review action.
	 *
	 * @param  int  $order_id Order ID.
	 *
	 * @return void
	 */
	public function remind_email( $order_id ) {
		$interval_type  = get_option( 'we_email_timeformat' )!='' ? get_option( 'we_email_timeformat' ) : 1;
		$interval_count = get_option( 'we_email_delay' )!='' ? get_option( 'we_email_delay' ) : 604800;
		$product_ids = $this->get_idproduct_from_order( $order_id );
		foreach ( $product_ids as $product_id ) {
			$we_startdate = get_post_meta( $product_id, 'we_startdate', true ) ;
			$interval = $we_startdate*1 - ($interval_count*$interval_type);
			$gmt_offset = get_option('gmt_offset');
			if(is_numeric($gmt_offset)){
				$interval = $interval - ($gmt_offset*3600);
			}
			//echo $interval.'  -now- '.time();exit;
			if(($we_startdate > time()) && ($interval > time())){
				wp_schedule_single_event( $interval, 'wooevent_review_reminder_email', array( $order_id, $product_id ) );
			}
		}
		//wp_schedule_single_event( $interval, 'wooevent_review_reminder_email', array( $order_id ) );
	}

	/**
	 * Sends the email notification.
	 *
	 * @param  int  $order_id Order ID.
	 *
	 * @return void
	 */
	public function send_mail( $order_id , $product_id) {
		global $woocommerce;
		$mailer = $woocommerce->mailer();
		$order = new WC_Order( $order_id );

		$subject = apply_filters(
			'wooevent_reminder_email_subject',
			esc_html__( 'Email Reminder from ', 'exthemes' ).get_bloginfo( 'name', 'display' ),
			$order
		);

		// Mail headers.
		$headers = array();
		$headers[] = "Content-Type: text/html\r\n";

		// Message title.
		$message_title = apply_filters(
			'wooevent_reminder_email_title',
			esc_html__( 'Email Reminder from ', 'exthemes' ).get_bloginfo( 'name', 'display' ),
			$order
		);

		// Message body.
		if ($order->billing_first_name){
			$first_name = ', '.$order->billing_first_name;
			if ($order->billing_last_name){
				$last_name = ' '.$order->billing_last_name;
			}
		}
		else{
			if ($order->billing_last_name){
				$last_name = ', '.$order->billing_last_name;
			}
		}
		$all_day = get_post_meta($product_id,'we_allday', true );
		$we_startdate = get_post_meta( $product_id, 'we_startdate', true ) ;
		$we_enddate = get_post_meta( $product_id, 'we_enddate', true ) ;
		$st_d = date_i18n( 'd', $we_startdate);
		$e_d = date_i18n( 'd', $we_enddate);
		if( $all_day!='1' && (date_i18n(get_option('time_format'), $we_startdate)!=date_i18n(get_option('time_format'), $we_enddate))){ 
			$date = date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate);
			if($st_d != $e_d){
				$date .= ' - '.date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate);
			}else{
				$date .= ' - '.date_i18n(get_option('time_format'), $we_enddate);
			}
		}
		$link = get_permalink( $product_id );
		$title = get_the_title($product_id);
		$body = '<p>' . esc_html__( 'This is an automatic reminder of the following event', 'exthemes' ) . '</p>' .
			'<h2><a href="'.$link.'">'.$title.'</a></h2>'.
			'<p><strong>' . esc_html__( 'Date', 'exthemes' ) . ': </strong>'.$date.'</p>'.
			'<p>' . esc_html__( 'Additional information', 'exthemes' ) . '</p>'.
			'<p>' . esc_html__( 'This is a reminder that you had registered for "','exthemes').$title.'".'.esc_html__('We look forward to seeing you', 'exthemes' ) . '</p>';
		$ct_email = get_option('we_email_content');
		if($ct_email!=''){
			$ct_email = str_replace('[eventitle]', $title, $ct_email);
			$ct_email = str_replace('[eventdate]', $date, $ct_email);
			$ct_email = str_replace('[eventlink]', $link, $ct_email);
			$body = $ct_email;
		}

		$message_body = apply_filters(
			'wooevent_reminder_email_message',
			$body,
			$order,
			$product_id
		);

		// Sets the message template.
		$message = $mailer->wrap_message( $message_title, $message_body );

		// Send the email.
		$mailer->send( $order->billing_email, $subject, $message, $headers, '' );
	}
}
$WooEvent_Reminder_Email = new WooEvent_Reminder_Email();