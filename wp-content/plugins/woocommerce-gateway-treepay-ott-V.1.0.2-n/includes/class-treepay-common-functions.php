<?php
/**
 * Created by PhpStorm.
 * User: mabbacc
 * Date: 2016. 8. 8.
 * Time: 오후 3:42
 */

function treepayott_setting_field() {

    return array(
        'treepay_enabled' => array(
            'title' => __('Enable/Disable', 'woo-treepay-ott'),
            'label' => __('Enable Treepay', 'woo-treepay-ott'),
            'type' => 'checkbox',
            'description' => '',
            'default' => 'no'
        ),
        'treepay_title' => array(
            'title' => __('Title', 'woo-treepay-ott'),
            'type' => 'text',
            'description' => __('This controls the title which the user sees during checkout.', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => __('Credit Card(Treepay OTT)', 'woo-treepay-ott')
        ),
        'treepay_description' => array(
            'title' => __('Description', 'woo-treepay-ott'),
            'type' => 'textarea',
            'description' => __('This controls the description which the user sees during checkout.', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => __("Pay with your credit card via treepay.", 'woo-treepay-ott')
        ),
        'treepay_testmode' => array(
            'title' => __('Test Mode', 'woo-treepay-ott'),
            'type' => 'checkbox',
            'default' => 'yes',
            'description' => __('Place the payment gateway in test mode using test API keys.', 'woo-treepay-ott'),
            'desc_tip' => true,
            'label' => __('Enable Test Mode', 'woo-treepay-ott')
        ),

        'treepay_test_sitecd' => array(
            'title' => __('Test Site Code', 'woo-treepay-ott'),
            'type' => 'text',
            'description' => __('Get your Test Site code from your Treepay account', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => ''
        ),
        'treepay_test_sitekey' => array(
            'title' => __('Test Secure Key', 'woo-treepay-ott'),
            'type' => 'text',
            'description' => __('Get your Test Secure key from your Treepay account', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => ''
        ),

        'treepay_live_sitecd' => array(
            'title' => __('Live Site Code', 'woo-treepay-ott'),
            'type' => 'text',
            'description' => __('Get your live Site code from your Treepay account', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => ''
        ),
        'treepay_live_sitekey' => array(
            'title' => __('Live Secure Key', 'woo-treepay-ott'),
            'type' => 'text',
            'description' => __('Get your live Secure key from your Treepay account', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => ''
        ),
        'treepay_debug_log' => array(
            'title' => __('Debug Log', 'woo-treepay-ott'),
            'type' => 'checkbox',
            'description' => __('Enable Log Treepay', 'woo-treepay-ott'),
            'desc_tip' => true,
            'default' => 'no',
            'label' => __('Enable logging <code>/wp-content/uploads/wc-logs/</code>', 'woo-treepay-ott')
        )
    );
}

function treepayott_get_user_ip() {

    return (isset($_SERVER['HTTP_X_FORWARD_FOR']) && !empty($_SERVER['HTTP_X_FORWARD_FOR'])) ? $_SERVER['HTTP_X_FORWARD_FOR'] : $_SERVER['REMOTE_ADDR'];
}

function treepayott_item_name($item_name) {

    if (strlen($item_name) > 36) {
        $item_name = substr($item_name, 0, 33) . '...';
    }
    return html_entity_decode($item_name, ENT_NOQUOTES, 'UTF-8');
}

function treepayott_item_desc($item_desc) {

    if (strlen($item_desc) > 127) {
        $item_desc = substr($item_desc, 0, 124) . '...';
    }
    return html_entity_decode($item_desc, ENT_NOQUOTES, 'UTF-8');
}

function treepayott_request_string($treepay_args) {

    if (!is_array($treepay_args) && count($treepay_args) == 0) {
        return false;
    }
    $postData = "";
    foreach ($treepay_args as $key => $val) {
        $postData .='&' . $key . '=' . $val;
    }
    return trim($postData, '&');
}
