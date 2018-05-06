<?php

/**
 * Created by PhpStorm.
 * User: mabbacc
 * Date: 2016. 8. 8.
 * Time: 오후 3:51
 */
class Treepay_Gateway extends WC_Payment_Gateway
{

    public function __construct()
    {
        try {

            $this->id = 'treepay';
            $this->has_fields = true;
            $this->method_title = __('TreePay', 'woo-treepay');
            $this->init_form_fields();

            $this->init_settings();

            $this->enabled = $this->get_option('treepay_enabled') === "yes" ? true : false;
            $this->title = $this->get_option('treepay_title');
            $this->description = $this->get_option('treepay_description');
            $this->testmode = $this->get_option('treepay_testmode') === "yes" ? true : false;

            $this->formtype = "mod"; // $this->get_option('treepay_payment_formtype');

            $this->vendor_name = get_bloginfo('name');

            $this->debug = $this->get_option('treepay_debug_log') === "yes" ? true : false;
            $this->home_URL = is_ssl() ? home_url('/', 'https') : home_url('/');
            $this->return_URL = add_query_arg('wc-api', 'Treepay_Gateway', $this->home_URL);
            $this->cancel_URL = add_query_arg('wc-api', 'Treepay_Gateway', add_query_arg('cancel_ec_trans', 'true', $this->home_URL));


            if ($this->testmode) {
                $this->is_mode = 'TEST';
                $this->tp_server = "https://paytest.treepay.co.th";
                $this->site_cd = ($this->get_option('treepay_test_sitecd')) ? trim($this->get_option('treepay_test_sitecd')) : '';
                $this->site_key = ($this->get_option('treepay_test_sitekey')) ? trim($this->get_option('treepay_test_sitekey')) : '';
            } else {
                $this->is_mode = 'LIVE';
                $this->tp_server = "https://pay.treepay.co.th";
                $this->site_cd = ($this->get_option('treepay_live_sitecd')) ? trim($this->get_option('treepay_live_sitecd')) : '';
                $this->site_key = ($this->get_option('treepay_live_sitekey')) ? trim($this->get_option('treepay_live_sitekey')) : '';
            }

            // Hooks
            add_action('admin_notices', array($this, 'treepay_checks_field')); //checks for availability of the plugin

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_receipt_treepay', array($this, 'treepay_receipt_page'));
            add_action('woocommerce_api_treepay_gateway', array($this, 'treepay_relay_response'));


            add_action('wp_enqueue_scripts', array($this, 'treepay_scripts'));

        } catch (Exception $ex) {
            wc_add_notice('<strong>' . __('Payment error', 'woo-treepay') . '</strong>: ' . $ex->getMessage(), 'error');
            return;
        }
    }

    public function init_form_fields()
    {
        return $this->form_fields = treepay_setting_field();
    }

    public function is_available()
    {
        error_log("is_available()a");
        if ($this->enabled) {
            if (!in_array(get_woocommerce_currency(), apply_filters('woocommerce_treepay_allowed_currencies', array('THB', 'USD', 'CAD')))) {
                error_log("is_available()z - false1");
                return false;
            }
            error_log("is_available()z - true3");
            return true;
        } else {
            error_log("is_available()z - false4");
            return false;
        }
    }

    public function admin_options()
    {
        ?>
        <h3>Treepay</h3>
        <p>Treepay works by adding credit card fields on the checkout and then sending the details to Treepay for
            verification.</p>

        <table class="form-table">
            <?php
            //if user's currency is USD
            if (!in_array(get_woocommerce_currency(), array('THB', 'USD', 'CAD'))) {
                ?>
                <div class="inline error"><p>
                        <strong><?php _e('Gateway Disabled', 'woo-treepay'); ?></strong>: <?php _e('Treepay does not support your store currency.', 'woo-treepay'); ?>
                    </p></div>
                <?php
                return;
            } else {
                $this->generate_settings_html();
            }
            ?>
        </table><!--/.form-table-->
        <script type="text/javascript">
            jQuery('.treepay_color').wpColorPicker();
            jQuery('#woocommerce_pal_advanced_premium_testmode').change(function () {
                var sandbox = jQuery('#woocommerce_pal_advanced_premium_sandbox_merchant, #woocommerce_pal_advanced_premium_sandbox_password, #woocommerce_pal_advanced_premium_sandbox_user, #woocommerce_pal_advanced_premium_sandbox_partner').closest('tr'),
                    production = jQuery('#woocommerce_pal_advanced_premium_live_merchant, #woocommerce_pal_advanced_premium_live_password, #woocommerce_pal_advanced_premium_live_user, #woocommerce_pal_advanced_premium_live_partner').closest('tr');
                if (jQuery(this).is(':checked')) {
                    sandbox.show();
                    production.hide();
                } else {
                    sandbox.hide();
                    production.show();
                }
            }).change();

        </script>
        <?php
    }

    public function payment_fields()
    {
        $this->treepay_log_write('pg-method:', 'payment_fields()a [' . $this->formtype . ']');


        if ($this->formtype == "mod") {
            // Modal
            if ($this->testmode) {
                echo "<p>Pay width your credit card via TreePay. TEST MODE ENABLED. In test mode, you can use the card number 4000000000000002 with any CVC and a valid expiration date or check the document “Testing TreePay” for more card numbers.</p>";
            } else {
                if ($this->description)
                    echo wpautop(wptexturize($this->description));

            }

	        require_once(plugin_dir_path(__FILE__) . 'templates/treepay-paymethod-form.php');
        } else {

            // Embedded Box
            if (is_user_logged_in()) {
                $viewData["user_logged_in"] = true;
            } else {
                $viewData["user_logged_in"] = false;
            }

            $this->cert_url = add_query_arg('wc-api', 'Treepay_Gateway', $this->home_URL);// '';// '_cert_url(empty)';
            $this->pay_type = "PACA";
            $this->order_no = $this->site_cd . date('YmdHis');
            $this->trade_mony = WC()->cart->total * 100;
            $this->tp_langFlag = "en";

            require_once(plugin_dir_path(__FILE__) . 'templates/treepay-payment-form.php');

        }
        $this->treepay_log_write('pg-method:', 'payment_fields()z');

    }


    public function process_refund($order_id, $amount = null, $reason = '')
    {
        $this->treepay_log_write('pg-method:', 'process_refund()a');

        $this->treepay_log_write('pg-method:', 'process_refund()z');
        return true;
    }


    public function process_payment($order_id)
    {
        $this->treepay_log_write('pg-method:', 'process_payment(' . $order_id . ')a');

        try {
            $order = new WC_Order($order_id);

            if ($this->formtype == "mod") {
                $this->treepay_log_write('pg-method:', 'process_payment()z');

                return array(
                    'result' => 'success',
                    'redirect' => add_query_arg('treepay_paymethod', $_REQUEST['treepay_paymethod'], $order->get_checkout_payment_url(true))
                );
            } else {
            
                 try {

                     $result = $this->_processOttApprove($order, $_POST);

                     if ($result) {

                         $order->payment_complete($result);
                         $order->add_order_note("Payment with TreepayOTT successful");

                         WC()->cart->empty_cart();

                         return array(
                             'result' => 'success',
                             'redirect' => $order->get_checkout_order_received_url()
                         );

                     } else {
                         throw new Exception("Please select a card or enter new payment information.");
                     }
                 } catch (Exception $e) {
                     $error_message = $e->getMessage();
                     wc_add_notice(__('Payment error: ', 'treepay') . $error_message, 'error');
                    $order->add_order_note('Payment with Treepay(OTT) error: ' . $error_message);
                    return array(
                        'result' => 'fail',
                        'redirect' => ''
                    );
                }
            }


            $this->treepay_log_write('pg-method:', 'process_payment()z');
        } catch (Exception $e) {
            wc_add_notice(__('Error:', 'woo-treepay') . ' "' . $e->getMessage() . '"', 'error');
            $this->treepay_log_write($text = null, 'Error Occurred while processing the order ' . $order_id);
        }
    }


    public function treepay_include_tax_or_discount($length_error, $order)
    {
        try {

            $item_names = array();
            if (sizeof($order->get_items()) > 0) {

                $this->post_data['FREIGHTAMT'] = number_format($order->get_total_shipping() + $order->get_shipping_tax(), 2, '.', '');

                if ($length_error <= 1) {
                    foreach ($order->get_items() as $item)
                        if ($item['qty'])
                            $item_names[] = $item['name'] . ' x ' . $item['qty'];
                } else {
                    $item_names[] = "All selected items, refer to Woocommerce order details";
                }
                $items_string = sprintf(__('Order %s', 'woo-treepay'), $order->get_order_number()) . " - " . implode(', ', $item_names);
                $items_names_string = treepay_item_name($items_string);
                $items_desc_string = treepay_item_desc($items_string);
                $this->post_data['L_NAME0[' . strlen($items_names_string) . ']'] = $items_names_string;
                $this->post_data['L_DESC0[' . strlen($items_desc_string) . ']'] = $items_desc_string;
                $this->post_data['L_QTY0'] = 1;
                $this->post_data['L_COST0'] = number_format($order->get_total() - round($order->get_total_shipping() + $order->get_shipping_tax(), 2), 2, '.', '');

                $this->post_data['ITEMAMT'] = $this->post_data['L_COST0'] * $this->post_data['L_QTY0'];
            }
            return TRUE;
        } catch (Exception $e) {

        }
    }

    public function treepay_no_include_tax_or_discount($length_error, $order)
    {
        try {

            $this->post_data['TAXAMT'] = $order->get_total_tax();
            $this->post_data['ITEMAMT'] = 0;
            $item_loop = 0;
            if (sizeof($order->get_items()) > 0) {
                foreach ($order->get_items() as $item) {
                    if ($item['qty']) {
                        $product = $order->get_product_from_item($item);
                        $item_name = $item['name'];

                        $item_meta = new WC_order_item_meta($item['item_meta']);
                        if ($length_error == 0 && $meta = $item_meta->display(true, true)) {
                            $item_name .= ' (' . $meta . ')';
                            $item_name = treepay_item_name($item_name);
                        }

                        $this->post_data['L_NAME' . $item_loop . '[' . strlen($item_name) . ']'] = $item_name;

                        if ($product->get_sku())
                            $this->post_data['L_SKU' . $item_loop] = $product->get_sku();

                        $this->post_data['L_QTY' . $item_loop] = $item['qty'];
                        $this->post_data['L_COST' . $item_loop] = $order->get_item_total($item, false, false);
                        $this->post_data['L_TAXAMT' . $item_loop] = $order->get_item_tax($item, false);
                        $this->post_data['ITEMAMT'] += $order->get_line_total($item, false, false);

                        $item_loop++;
                    }
                }
            }

            return TRUE;
        } catch (Exception $e) {

        }
    }

    public function treepay_checks_field()
    {
    }

    public function treepay_is_valid_currency()
    {
        return in_array(get_woocommerce_currency(), apply_filters('woocommerce_pal_advanced_supported_currencies', array('THB', 'USD', 'CAD')));
    }

    public function treepay_redirect_to($redirect_url)
    {

        @ob_clean();
        header('HTTP/1.1 200 OK');
        echo "<script>window.parent.location.href='" . $redirect_url . "';</script>";
        exit;
    }

    public function treepay_log_write($text = null, $message)
    {
        if ($this->debug) {
            if (!isset($this->log) || empty($this->log)) {
                $this->log = new WC_Logger();
            }

            if (is_array($message) && count($message) > 0) {
                $message = $this->treepay_personal_detail_square($message);
            }
            $this->log->add('treepay', $text . ' ' . print_r($message, true));
        }
    }

    public function treepay_personal_detail_square($message)
    {

        foreach ($message as $key => $value) {
            if ($key == "USER" || $key == "VENDOR" || $key == "PARTNER" || $key == "PWD[" . strlen($this->paypal_password) . "]" || $key == "ACCT" || $key == "PROCCVV2" || $key == "ACCT" || $key == "EXPDATE" || $key == "CVV2") {
                $str_length = strlen($value);
                $ponter_data = "";
                for ($i = 0; $i <= $str_length; $i++) {
                    $ponter_data .= '*';
                }
                $message[$key] = $ponter_data;
            }
        }

        return $message;
    }

    public function treepay_receipt_page($order_id)
    {

        $this->treepay_log_write('pg-method:', 'treepay_receipt_page()a');


        echo '<p>' . __('Thank you for your order, please click the button below to pay with Treepay.', 'woo-treepay') . '</p>';

        if ($this->formtype == "mod") {
            echo $this->generate_treepay_form($order_id);
        } else {
            // WHAT!!!!
            $this->treepay_log_write('pg-method:', 'DO SOMETHING!!!!!');
        }

        $this->treepay_log_write('pg-method:', 'treepay_receipt_page()z');
    }

    public function generate_treepay_form($order_id)
    {
        $order = new WC_Order($order_id);

        $basket = array();


        if (sizeof($order->get_items()) > 0) {
            foreach ($order->get_items() as $item) {
                if ($item['qty']) {

                    $basket[] = $this->_getCleanStrForTreepay($item['name']) . ' x ' . $item['qty'];
                }
            }
        }


        $orderid = $order_id;

        $params['pay_type']         = $_REQUEST['treepay_paymethod']; // 'PACA'; // PACA(3D 인증 / 원클릭) or PARC(자동결제)
        $params['order_no']         = $orderid;
        $params['trade_mony']       = $order->get_total() * 100;
        $params['site_cd']          = $this->site_cd;

        $current_user = wp_get_current_user();
        if ( $current_user instanceof WP_User ) {
            $params['user_id'] = wp_get_current_user()->user_login;
        } else {
            $params['user_id'] = 'guest';
        }
        if ( $params['user_id'] == '') { $params['user_id'] = 'guest'; }
        $params['cert_url']         = add_query_arg('wc-api', 'Treepay_Gateway', $this->home_URL);// '';// '_cert_url(empty)';
        $params['good_name']        = implode(',', $basket);
        $params['currency']         = '764'; // get_woocommerce_currency(); //TODO:currency 부분 수정해야함
        $params['order_addr']       = $this->_getCleanStrForTreepay($order->billing_address_1 . '-' . $order->billing_address_2);
        $params['order_first_name'] = $this->_getCleanStrForTreepay($order->billing_first_name);
        $params['order_last_name']  = $this->_getCleanStrForTreepay($order->billing_last_name);
        $params['order_city']       = $this->_getCleanStrForTreepay($order->billing_city);
        $params['order_country']    = $this->_getCleanStrForTreepay($order->billing_country);
        $params['order_email']      = $order->billing_email;
        $params['order_tel']        = $order->billing_phone;
        $params['order_post_code']  = $order->billing_postcode;
        $params['recv_addr']        = $this->_getCleanStrForTreepay($order->shipping_address_1 . '-' . $order->shipping_address_2);
        $params['recv_first_name']  = $this->_getCleanStrForTreepay($order->shipping_first_name);
        $params['recv_last_name']   = $this->_getCleanStrForTreepay($order->shipping_last_name);
        $params['recv_city']        = $order->shipping_city;
        $params['recv_country']     = $order->shipping_country;
        $params['recv_tel']         = $order->billing_phone; // $order->shipping_phone; // there is no such attribute
        $params['recv_email']       = ''; // $order->shipping_email; // Not exist;
        $params['recv_post_code']   = $order->shipping_postcode;
        $params['tp_langFlag']      = 'en'; //TODO:Language 설정
        $params['ret_url']          = add_query_arg('order_id', $order_id, $this->return_URL);
        $params['cancel_url']       = $this->cancel_URL;
        $params['bill_end_ymd']     = '';
        $params['bill_frequency']   = '';


        $params['hash_data'] = $this->makeHash(
            $params['pay_type'] .
            $params['order_no'] .
            $params['trade_mony'] .
            $params['site_cd'] .
            $this->site_key .
            $params['user_id']
        );

        $treepay_arg_array = array();

        foreach ($params as $key => $value) {
            $treepay_arg_array[] = '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
        }


        wp_register_script('treepay_fnc', plugin_dir_url(__FILE__) . '../lib/js/fnc.js', array(), null, false);
        wp_enqueue_script('treepay_fnc');


        return '<form name="' . 'treepay_payment_form' . '">
					' . implode('', $treepay_arg_array) . '
					<input class="button" id="submit_treepay_payment_form" value="' . __('Pay via Treepay', 'woo-treepay') . '" onclick="jsf__pay_v3d(document.treepay_payment_form)" /> 
				</form>';

    }

    public function treepay_relay_response()
    {

        $this->treepay_log_write('pg-method:', 'treepay_relay_response()a');
        //define a variable to indicate whether it is a silent post or return

        if (isset($_REQUEST['silent']) && $_REQUEST['silent'] == 'true')
            $silent_post = true;
        else
            $silent_post = false;


        if ($silent_post === true)
            $this->treepay_log_write('Silent Relay Response Triggered: ', print_r($_REQUEST, true));
        else
            $this->treepay_log_write('Relay Response Triggered: ', print_r($_REQUEST, true));

        if (!isset($_REQUEST['order_id'])) {
            $this->treepay_log_write('pg-method:', '\torder_id is empty!');
            if ($silent_post === false) {
                wc_add_notice(__('Payment error: ', 'treepay') . "[" . $_REQUEST['res_cd'] . "]: " . $_REQUEST['res_msg'], 'error');

                global $woocommerce;
                $checkout_url = $woocommerce->cart->get_checkout_url();
                wp_redirect($checkout_url);
            }
            exit;
        }


        if (!isset($_REQUEST['res_cd'])) {
            if ($silent_post === false)
                wp_redirect(home_url('/'));
            exit;
        }

        $order_id = $_REQUEST['order_id'];
        $order = new WC_Order($order_id);

        $status = isset($order->status) ? $order->status : $order->get_status();
        if ($status == 'processing' || $status == 'completed') {
            $this->treepay_log_write('Redirecting to Thank You Page for order ', $order->get_order_number());
            if ($silent_post === false)
                $this->treepay_log_write($this->get_return_url($order));
        }


        if ($_REQUEST['res_cd'] == "0000") {
            // 결제 성공
            $this->treepay_success_handler($order, $order_id, $silent_post, $_REQUEST['res_msg']);

        } else if ($_REQUEST['res_cd'] != "0000") {
            // 결제 실패
            if (isset($_REQUEST['cancel_ec_trans']) && $_REQUEST['cancel_ec_trans'] == 'true') {
                // 결제 취소
                $this->treepay_cancel_handler($order, $order_id);
            } else {
                // 결제 오류
                $this->treepay_error_handler($order, $order_id, $silent_post);
            }


        }


        $this->treepay_log_write('pg-method:', 'treepay_relay_response()z');
    }

    public function treepay_success_handler($order, $order_id, $silent_post, $res_msg)
    {

        $order->add_order_note(sprintf(__('Treepay payment completed (Order: %s). Transaction number/ID: %s.', 'woo-treepay'), $order->get_order_number(), $_REQUEST['tno']));


        if ($res_msg == 'success') {
            $order->payment_complete($_REQUEST['tno']);
            WC()->cart->empty_cart();
            $order->add_order_note(sprintf(__('Payment completed for the  (Order: %s)', 'woo-treepay'), $order->get_order_number()));
            $this->treepay_log_write('Payment completed for the   ', '(Order: ' . $order->get_order_number() . ')');
            if ($silent_post === false) {
                $this->treepay_redirect_to($this->get_return_url($order));
            }
        }
    }

    public function treepay_error_handler($order, $order_id, $silent_post)
    {

        wc_clear_notices();
        wc_add_notice(__('Error:', 'woo-treepay') . ' "' . urldecode($_REQUEST['res_msg']) . '"', 'error');

        $order->add_order_note(sprintf(__('Treepay payment failed (Order: %s). ERROR CODE: %s.', 'woo-treepay'), $order->get_order_number(), $_REQUEST['res_cd'] . $_REQUEST['res_msg']));
        if ($silent_post === false) {
            // $this->treepay_redirect_to($order->get_checkout_payment_url(false));
            global $woocommerce;
            $checkout_url = $woocommerce->cart->get_checkout_url();
            wp_redirect($checkout_url);
        }
    }

    public function treepay_cancel_handler($order, $order_id)
    {
        wp_redirect($order->get_cancel_order_url());
        exit;
    }

    public function treepay_decline_handler($order, $order_id, $silent_post)
    {


        $order->update_status('failed', __('Payment failed via Treepay because of.', 'woo-treepay') . '&nbsp;' . $_REQUEST['res_msg']);
        $this->treepay_log_write('Status has been changed to failed for order ', $response->get_order_number());
        $this->treepay_log_write('Error Occurred while processing ', $response->get_order_number() . ' : ' . urldecode($_REQUEST['res_cd']) . ', status:' . $_REQUEST['res_msg']);
        $this->treepay_error_handler($order, $order_id, $silent_post);
    }



    /**
     * Register all javascripts
     */
    public function treepay_scripts()
    {
        if (!is_checkout() || !$this->is_available()) {
            return;
        }

        if ($this->formtype == "mod") {
            $script_url = $this->tp_server . "/js/plugin.tp";
        } else {
            $script_url = $this->tp_server . "/js/plugin_api.tp";
        }
        wp_enqueue_script('treepay-js', $script_url, array('jquery'), '1.0.0', true);

        wp_enqueue_script('treepay-payment-form-handler', plugin_dir_url(__FILE__) . '../lib/js/tp-payment-form-handler.js', array(), null, false);
    }

    private function makeHash($strIn)
    {
        error_log("makeHash(" . $strIn . ")a");

        $returnString = bin2hex(hash("sha256", $strIn, true));

        error_log("makeHash(" . $returnString . ")z");
        return $returnString;


    }

    private function _processOttApprove($order, $post)
    {
        $this->treepay_log_write('pg-method', '_processOttApprove()a');
        $item_loop = 0;

        $basket = array();

        if (sizeof($order->get_items()) > 0) {
            foreach ($order->get_items() as $item) {
                if ($item['qty']) {

                    $basket[] = $this->_getCleanStrForTreepay($item['name']) . ' x ' . $item['qty'];

                }
            }
        }


        $hash_data = $this->makeHash(
            $post['pay_type'] .
            $post['order_no'] .
            $post['trade_mony'] .
            $this->site_cd.
            $this->site_key .
            $post['treepay_ott']
        );

        $this->treepay_log_write('pg-method', 'getHash(' . $hash_data . ')');
        $postBody = array(
            "site_cd" => $this->site_cd,
            "tp_langFlag" => $post['tp_langFlag'],
            "currency" => '764', //TODO:currency 부분 수정해야함
            "pay_type" => $post['pay_type'],
            "ott" => $post['treepay_ott'],
            "hash_data" => $hash_data,

            "order_no" => $post['order_no'],
            "order_addr"        => $this->_getCleanStrForTreepay($order->billing_address_1 . '-' . $order->billing_address_2),
            "order_first_name"  => $this->_getCleanStrForTreepay($order->billing_first_name),
            "order_last_name"   => $this->_getCleanStrForTreepay($order->billing_last_name),
            "order_city"        => $this->_getCleanStrForTreepay($order->billing_city),
            "order_country"     => $this->_getCleanStrForTreepay($order->billing_country),
            "order_email"       => $order->billing_email,
            "order_tel"         => $order->billing_phone,
            "order_post_code"   => $order->billing_postcode,
            "recv_addr"         => $this->_getCleanStrForTreepay($order->shipping_address_1 . '-' . $order->shipping_address_2),
            "recv_first_name"   => $this->_getCleanStrForTreepay($order->shipping_first_name),
            "recv_last_name"    => $this->_getCleanStrForTreepay($order->shipping_last_name),
            "recv_city"         => $this->_getCleanStrForTreepay($order->shipping_city),
            "recv_country"      => $this->_getCleanStrForTreepay($order->shipping_country),
            "recv_tel"          => $order->billing_phone,
            "recv_email"        => '',
            "recv_post_code"    => $order->shipping_postcode,

            "good_name"         => implode(',', $basket),
            "trade_mony"        => $order->get_total() * 100
        );

        // $this->treepay_log_write('pg-method', 'postBody(' . print_r($postBody) . ')');

        $postBodyString = json_encode($postBody, JSON_UNESCAPED_UNICODE);

        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        $this->treepay_log_write('pg-method', 'tp_server  [' . $this->tp_server . "]");
        $this->treepay_log_write('pg-method', 'postBodyString  [' . $postBodyString . "]");

        $ch = curl_init($this->tp_server . '/api/ottApprove.api');
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBodyString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-type: application/json',
                'Content-length: ' . strlen($postBodyString))
        );
        $verbose = fopen('/tmp/curl-woocommerce', 'a');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $verbose);

        $result = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == "200") {
            // req/res success
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);
            $response = json_decode($body, true);

            curl_close($ch);

            $this->treepay_log_write('pg-method', 'response  [' . $response['res_cd'] . ":" . $response['res_msg'] . ']');
            if ($response['res_cd'] == "0000") {
                // SUCCESS!!!
                $order->add_order_note(sprintf(__('Treepay payment completed (Order: %s). Transaction number/ID: %s.', 'woo-treepay'), $order->get_order_number(), $response['tno']));
                return $response['tno'];

            } else {
                // FAIL!!!
                $this->treepay_log_write('pg-method', 'response  FAIL!!!');
                throw new Exception("Error [" . $response['res_cd'] . ":" . $response['res_msg'] ."]" );
            }
        } else {
            // error
            $this->treepay_log_write('pg-method', 'Connection Fail!!!');
            curl_close($ch);
            return false;
        }

    }


    protected function _getCleanStrForTreepay($strIn) {
        $vowels = array(',', '&',';','\n', '\\', '|', '\'', '\"');
        $_strOut = str_replace($vowels, ' ', $strIn);

        $strOut = str_replace("\r\n", ' ', $_strOut);
        return $strOut;
    }

}
