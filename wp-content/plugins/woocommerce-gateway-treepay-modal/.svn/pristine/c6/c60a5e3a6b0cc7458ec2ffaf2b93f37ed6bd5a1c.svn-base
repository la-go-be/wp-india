<?php
/**
 * Created by PhpStorm.
 * User: mabbacc
 * Date: 2016. 8. 8.
 * Time: 오후 3:42
 */

function treepay_setting_field() {

    return array(
        'treepay_enabled' => array(
            'title' => __('Enable/Disable', 'woo-treepay'),
            'label' => __('Enable Treepay', 'woo-treepay'),
            'type' => 'checkbox',
            'description' => '',
            'default' => 'no'
        ),
        'treepay_title' => array(
            'title' => __('Title', 'woo-treepay'),
            'type' => 'text',
            'description' => __('This controls the title which the user sees during checkout.', 'woo-treepay'),
            'desc_tip' => true,
            'default' => __('Credit Card(Treepay)', 'woo-treepay')
        ),
        'treepay_description' => array(
            'title' => __('Description', 'woo-treepay'),
            'type' => 'textarea',
            'description' => __('This controls the description which the user sees during checkout.', 'woo-treepay'),
            'desc_tip' => true,
            'default' => __("Pay with your credit card via treepay.", 'woo-treepay')
        ),
        'treepay_testmode' => array(
            'title' => __('Test Mode', 'woo-treepay'),
            'type' => 'checkbox',
            'default' => 'yes',
            'description' => __('Place the payment gateway in test mode using test API keys.', 'woo-treepay'),
            'desc_tip' => true,
            'label' => __('Enable Test Mode', 'woo-treepay')
        ),

        'treepay_test_sitecd' => array(
            'title' => __('Test Site Code', 'woo-treepay'),
            'type' => 'text',
            'description' => __('Get your Test Site code from your Treepay account', 'woo-treepay'),
            'desc_tip' => true,
            'default' => ''
        ),
        'treepay_test_sitekey' => array(
            'title' => __('Test Secure Key', 'woo-treepay'),
            'type' => 'text',
            'description' => __('Get your Test Secure key from your Treepay account', 'woo-treepay'),
            'desc_tip' => true,
            'default' => ''
        ),

        'treepay_live_sitecd' => array(
            'title' => __('Live Site Code', 'woo-treepay'),
            'type' => 'text',
            'description' => __('Get your live Site code from your Treepay account', 'woo-treepay'),
            'desc_tip' => true,
            'default' => ''
        ),
        'treepay_live_sitekey' => array(
            'title' => __('Live Secure Key', 'woo-treepay'),
            'type' => 'text',
            'description' => __('Get your live Secure key from your Treepay account', 'woo-treepay'),
            'desc_tip' => true,
            'default' => ''
        ),

        'treepay_pc_paymethods_card' => array(
	        'title' => __('Pay method', 'woo-treepay'),
	        'type' => 'checkbox',
	        'label' => __("Credit Card", "woo-treepay"),
	        'default'   => 'yes',
        ),
        'treepay_pc_paymethods_ibnk' => array(
	        'type' => 'checkbox',
	        'label' => __("Internet Banking", "woo-treepay"),
	        'default'   => 'no',
        ),
        'treepay_pc_paymethods_inst' => array(
	        'type' => 'checkbox',
	        'label' => __("Installment", "woo-treepay"),
	        'default'   => 'no',
        ),

        'treepay_debug_log' => array(
            'title' => __('Debug Log', 'woo-treepay'),
            'type' => 'checkbox',
            'description' => __('Enable Log Treepay', 'woo-treepay'),
            'desc_tip' => true,
            'default' => 'no',
            'label' => __('Enable logging <code>/wp-content/uploads/wc-logs/</code>', 'woo-treepay')
        )
    );
}

function treepay_get_user_ip() {

    return (isset($_SERVER['HTTP_X_FORWARD_FOR']) && !empty($_SERVER['HTTP_X_FORWARD_FOR'])) ? $_SERVER['HTTP_X_FORWARD_FOR'] : $_SERVER['REMOTE_ADDR'];
}

function treepay_item_name($item_name) {

    if (strlen($item_name) > 36) {
        $item_name = substr($item_name, 0, 33) . '...';
    }
    return html_entity_decode($item_name, ENT_NOQUOTES, 'UTF-8');
}

function treepay_item_desc($item_desc) {

    if (strlen($item_desc) > 127) {
        $item_desc = substr($item_desc, 0, 124) . '...';
    }
    return html_entity_decode($item_desc, ENT_NOQUOTES, 'UTF-8');
}

function treepay_request_string($treepay_args) {

    if (!is_array($treepay_args) && count($treepay_args) == 0) {
        return false;
    }
    $postData = "";
    foreach ($treepay_args as $key => $val) {
        $postData .='&' . $key . '=' . $val;
    }
    return trim($postData, '&');
}
