<h1>Login</h1>
<div class="my-custom-step">
<?php if(is_user_logged_in()) { ?>
<h1>My Account.</h1>
<?php } else { ?>
<h1>Guest.</h1><span>Sign Up</span>
<?php } ?>
<?php global $current_user;
      get_currentuserinfo();
?>
<div class="alert result-message"></div>
<div class="vb-registration-form">
<?php
	 woocommerce_form_field('billing_email_n', array(
	 'type' => 'email',
	 'required' => true,
	 'id' => 'billing_email_n',
	 'class' => array('form-group'),
	 'label' => __(''),
	 'placeholder' => __('Email'),
	 ), $checkout->get_value('billing_email_n'));
?>
<?php if(!is_user_logged_in()) { ?>          
<?php
	 woocommerce_form_field('account_password', array(
	 'type' => 'password',
	 'required' => true,
	 'class' => array('form-group'),
	 'id' => 'account_password',
	 'label' => __(''),
	 'placeholder' => __('Choose Password'),
	 ), $checkout->get_value('account_password'));
?>
<?php } ?>
<?php
	 woocommerce_form_field('billing_first_name_n', array(
	 'type' => 'text',
	 'required' => true,
	 'class' => array('form-group'),
	 'id' => 'billing_first_name_n',
	 'label' => __(''),
	 'placeholder' => __('First Name'),
	 ), $checkout->get_value('billing_first_name_n'));
?>
<?php
	 woocommerce_form_field('billing_last_name_n', array(
	 'type' => 'text',
	 'required' => true,
	 'class' => array('form-group'),
	 'id' => 'billing_last_name_n',
	 'label' => __(''),
	 'placeholder' => __('Last Name'),
	 ), $checkout->get_value('billing_last_name_n'));
?>
<?php
	woocommerce_form_field( 'gender', array(
	'type'          => 'select',
	'required' => true,
	'class'         => array('form-group'),
	'placeholder'   => __('Select Gender'),
	'options'       => array(
	'' => __('Select Gender', 'woocommerce' ), 
	'male' => __('Male', 'woocommerce' ),
	'female' => __('Female', 'woocommerce' ),
	'other' => __('Other', 'woocommerce' )
	),
	
	), $checkout->get_value( 'billing_myfield16' ));
?>
<?php
	woocommerce_form_field( 'user_date', array(
	'type'          => 'text',
	'required' => true,
	'id' => 'usr-dob',
	'class'         => array('form-group'),
	'placeholder'   => __('dd/mm/yyyy'),
	), $checkout->get_value( 'user_date' ));
?>
<?php
	woocommerce_form_field( 'mailpoet_checkout_subscription[]', array(
	'type'          => 'checkbox',
	'required' => false,
	'label'         => '<div class="slider round"></div><span class="mail-span">Receive Exclusive LAGOBE offers & updates.</span>',
	'id' => 'mailpoet_checkout_subscription',
	'class'         => array('form-group'),
	), $checkout->get_value( 'mailpoet_checkout_subscription[]' ));
?>




<?php
/*add_action('woocommerce_checkout_update_order_meta', 'custom_checkout_field_update_order_meta');
add_action( 'woocommerce_thankyou', 'custom_checkout_field_update_order_meta');

function custom_checkout_field_update_order_meta( $order_id ) {

  $order = new WC_Order($order_id);
  //get the user email from the order
  $order_email = $_POST['billing_email'];
  // check if there are any users with the billing email as user or email
  $email = email_exists( $order_email );  
  $user = username_exists( $order_email );
  	// if the UID is null, then it's a guest checkout
 	// if( $user == false && $email == false ){
    // random password with 12 chars
    // create new user with email as username & newly created pw
	print_r($order);
    $user_id = wp_create_user( $order_email, $random_password, $order_email );
	
	
    if ($_POST['billing_address_1']) update_user_meta( $user_id, 'billing_address_1', esc_attr($_POST['billing_address_1']));
    if ($_POST['billing_first_name_n']) update_user_meta( $user_id, 'first_name', esc_attr($_POST['billing_first_name_n']));
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'last_name', esc_attr($_POST['billing_last_name_n']));
	
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'billing_first_name', esc_attr($_POST['billing_last_name_n']));
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'billing_last_name', esc_attr($_POST['billing_last_name_n']));
	
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'billing_last_name', esc_attr($_POST['billing_last_name_n']));
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'billing_last_name', esc_attr($_POST['billing_last_name_n']));
	if ($_POST['billing_last_name_n']) update_user_meta( $user_id, 'billing_last_name', esc_attr($_POST['billing_last_name_n']));
	
	if ($_POST['account_password']) update_user_meta( $user_id, 'pass1', esc_attr($_POST['billing_last_name_n']));
	if ($_POST['account_password']) update_user_meta( $user_id, 'pass1-text', esc_attr($_POST['billing_last_name_n']));
	
	if ($_POST['billing_address_1']) update_user_meta( $user_id, 'billing_address_1', esc_attr($_POST['billing_address_1']));
	if ($_POST['billing_address_2']) update_user_meta( $user_id, 'billing_address_2', esc_attr($_POST['billing_address_2']));
	if ($_POST['billing_postcode']) update_user_meta( $user_id, 'billing_postcode', esc_attr($_POST['billing_postcode']));
	if ($_POST['billing_city']) update_user_meta( $user_id, 'billing_city', esc_attr($_POST['billing_city']) );
    if ($_POST['billing_company']) update_user_meta( $user_id, 'billing_company', esc_attr($_POST['billing_company']) );
    if ($_POST['billing_country']) update_user_meta( $user_id, 'billing_country', esc_attr($_POST['billing_country']) );
    if ($_POST['billing_phone']) update_user_meta( $user_id, 'billing_phone', esc_attr($_POST['billing_phone']) );
    if ($_POST['billing_state']) update_user_meta( $user_id, 'billing_state', esc_attr($_POST['billing_state']) );
	
	if ($_POST['shipping_address_1']) update_user_meta( $user_id, 'shipping_address_1', esc_attr($_POST['shipping_address_1']));
	if ($_POST['shipping_address_2']) update_user_meta( $user_id, 'shipping_address_2', esc_attr($_POST['shipping_address_2']));
	if ($_POST['shipping_postcode']) update_user_meta( $user_id, 'shipping_postcode', esc_attr($_POST['shipping_postcode']));
	if ($_POST['shipping_city']) update_user_meta( $user_id, 'shipping_city', esc_attr($_POST['shipping_city']) );
    if ($_POST['shipping_company']) update_user_meta( $user_id, 'shipping_company', esc_attr($_POST['shipping_company']) );
    if ($_POST['shipping_country']) update_user_meta( $user_id, 'shipping_country', esc_attr($_POST['shipping_country']) );
    if ($_POST['shipping_phone']) update_user_meta( $user_id, 'shipping_phone', esc_attr($_POST['shipping_phone']) );
    if ($_POST['shipping_state']) update_user_meta( $user_id, 'shipping_state', esc_attr($_POST['shipping_state']) );
	
	
	if ($_POST['gender']) update_user_meta( $user_id, 'gender', esc_attr($_POST['gender']));
	if ($_POST['user_date']) update_user_meta( $user_id, 'user_date', esc_attr($_POST['user_date']));
}*/


add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {

	
    if ( ! empty( $_POST['gender'] ) ) {
        update_post_meta( $order_id, 'gender', sanitize_text_field( $_POST['gender'] ) );
    }
	if ( ! empty( $_POST['user_date'] ) ) {
        update_post_meta( $order_id, 'user_date', sanitize_text_field( $_POST['user_date'] ) );
    }
	if ( ! empty( $_POST['account_password'] ) ) {
        update_post_meta( $order_id, 'pass1-text', sanitize_text_field( $_POST['account_password'] ) );
    }
	
	
}
?>





<?php wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true ); ?>
</div>

</div>
