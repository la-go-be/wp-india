<?php
class WooEvent_Checkouthook {
	public function __construct()
    {
		add_action('woocommerce_after_order_notes', array( &$this,'add_user_data_booking'));
		//add_action( 'woocommerce_before_checkout_process', array( &$this,'custom_checkout'));
		add_action( 'woocommerce_checkout_update_order_meta', array( &$this,'saveto_order_meta'));
		
		//add_action( 'woocommerce_admin_order_data_after_shipping_address', array( &$this,'my_custom_checkout_field'), 10, 1 );
		add_action( 'woocommerce_after_order_itemmeta', array( &$this,'show_adminorder_ineach_metadata'), 10, 3 );
		add_action( 'woocommerce_order_item_meta_end', array( &$this,'show_order_ineach_metadata'), 10, 3 ); 
    }


	//function my_custom_checkout_field($order){
//		echo '<p><strong>'.__('Phone From Checkout Form').':</strong> ' . get_post_meta( $order->id, 'my_field_name', true ) . '</p>';
//	}
	
	function custom_checkout(){

		//Your code here
		
		echo '<pre>';print_r($_POST);echo '</pre>';
		echo count($_POST['we_if_name'][7031]);
		//echo sanitize_text_field($_POST['we_if_name'][7031][0]);
		//exit;
		//wc_add_order_item_meta('7031','_urser','okk');
		
	}
	function add_user_data_booking( $checkout ) {
		$c_it = 0;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$id = $cart_item['product_id'];
			$_product = wc_get_product ($id);
			if(get_post_meta( $id,'we_startdate', true) !=''){
				$c_it ++;
				if($c_it==1){
					$t_atten = get_option('we_text_attende_')!='' ? get_option('we_text_attende_') : esc_html__('Attendees info','exthemes');
					echo '<div class="user_checkout_field"><h3>' . $t_atten . '</h3>';
				}
				$t_fname = get_option('we_text_fname_')!='' ? get_option('we_text_fname_') : esc_html__('First Name: ','exthemes');
				$t_lname = get_option('we_text_lname_')!='' ? get_option('we_text_lname_') : esc_html__('Last Name: ','exthemes');
				$t_email = get_option('we_text_email_')!='' ? get_option('we_text_email_') : esc_html__('Email: ','exthemes');
				echo '<div class="gr-product">';
					echo '<h4>('.$c_it.')'. $_product->get_title() . '</h4>';
					echo '<input type="hidden" name="we_ids[]" value="'.$id.'">';
					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0) {
						echo '<div class="w-product">';
						for($i=0; $i < $cart_item['quantity']; $i++){
							woocommerce_form_field( 
								'we_if_name['.$id.']['.$i.']', 
								array(
									'type'          => 'text',
									'class'         => array('we-ct-class form-row-wide first-el'),
									'label'         => $t_fname.'('.($i+1).')',
									'placeholder'   => '',
								), 
								''
							);
							woocommerce_form_field( 
								'we_if_lname['.$id.']['.$i.']', 
								array(
									'type'          => 'text',
									'class'         => array('we-ct-class form-row-wide'),
									'label'         => $t_lname.'('.($i+1).')',
									'placeholder'   => '',
								), 
								''
							);
							woocommerce_form_field( 'we_if_email['.$id.']['.$i.']', 
								array(
									'type'          => 'text',
									'class'         => array('we-ct-class form-row-wide'),
									'label'         => $t_email.'('.($i+1).')',
									'placeholder'   => '',
								), 
								''
							);
							do_action( 'we_after_custom_field', $id, $i );
						}
						echo '</div>';
					}
				echo '</div>';
				if($c_it==1){
					echo '</div>';
				}
			}
		}
	
	}
	function saveto_order_meta( $order_id ) {
		if ( ! empty( $_POST['we_ids'] ) ) {
			foreach($_POST['we_ids'] as $item){
				if ( ! empty( $_POST['we_if_name'][$item] ) ) {
					$nl_meta = '';
					$nbid= count($_POST['we_if_name'][$item]);
					for( $i = 0 ; $i < $nbid; $i++){
						$name = sanitize_text_field( $_POST['we_if_name'][$item][$i] );
						$lname = sanitize_text_field( $_POST['we_if_lname'][$item][$i] );
						$email = sanitize_text_field( $_POST['we_if_email'][$item][$i] );
						if($nl_meta!=''){
							$nl_meta = $nl_meta.']['.$email.'||'.$name.'||'.$lname;
						}else{
							$nl_meta = $email.'||'.$name.'||'.$lname;
						}
						$nl_meta = apply_filters( 'we_custom_field_extract', $nl_meta,$_POST,$item, $i);
					}
					update_post_meta( $order_id, 'att_info-'.$item, $nl_meta );
				}
			}
		}
	}
	function show_adminorder_ineach_metadata($item_id, $item, $_product){
		$id = $item['product_id'];
		$metadata = get_post_meta($_GET['post'],'att_info-'.$id, true);
		if($metadata !=''){
			
			$t_atten = get_option('we_text_attende_')!='' ? get_option('we_text_attende_') : esc_html__('Attendees info','exthemes');
			$t_name = get_option('we_text_name_')!='' ? get_option('we_text_name_') : esc_html__('Name: ','exthemes');
			$t_email = get_option('we_text_email_')!='' ? get_option('we_text_email_') : esc_html__('Email: ','exthemes');
			
			$metadata = explode("][",$metadata);
			if(!empty($metadata)){
				$i=0;
				foreach($metadata as $item){
					$i++;
					$item = explode("||",$item);
					$f_name = isset($item[1]) && $item[1]!='' ? $item[1] : '';
					$l_name = isset($item[2]) && $item[2]!='' ? $item[2] : '';
					echo '<div class="we-user-info">'.$t_atten.' ('.$i.') ';
					echo  $f_name!='' && $l_name!='' ? '<span><b>'.$t_name.'</b>'.$f_name.' '.$l_name.'</span>' : '';
					echo  isset($item[0]) && $item[0]!='' ? '<span><b>'.$t_email.' </b>'.$item[0].'</span>' : '';
					do_action( 'we_after_order_info', $item);
					echo '</div>';
				}
			}
		}
	}
	
	function show_order_ineach_metadata($item_id, $item, $order){
		$id = $item['product_id'];
		$metadata = get_post_meta($order->get_id(),'att_info-'.$id, true);
		if($metadata !=''){
			
			$t_atten = get_option('we_text_attende_')!='' ? get_option('we_text_attende_') : esc_html__('Attendees info','exthemes');
			$t_name = get_option('we_text_name_')!='' ? get_option('we_text_name_') : esc_html__('Name: ','exthemes');
			$t_email = get_option('we_text_email_')!='' ? get_option('we_text_email_') : esc_html__('Email: ','exthemes');
			
			$metadata = explode("][",$metadata);
			if(!empty($metadata)){
				$i=0;
				foreach($metadata as $item){
					$i++;
					$item = explode("||",$item);
					$f_name = isset($item[1]) && $item[1]!='' ? $item[1] : '';
					$l_name = isset($item[2]) && $item[2]!='' ? $item[2] : '';
					echo '<div class="we-user-info">'.$t_atten.' ('.$i.') ';
					echo  $f_name!='' && $l_name!='' ? '<span><b>'.$t_name.'</b>'.$f_name.' '.$l_name.'</span>' : '';
					echo  isset($item[0]) && $item[0]!='' ? '<span><b>'.$t_email.' </b>'.$item[0].'</span>' : '';
					do_action( 'we_after_order_info', $item);
					echo '</div>';
				}
			}
		}
	}

	
}
$WooEvent_Checkouthook = new WooEvent_Checkouthook();