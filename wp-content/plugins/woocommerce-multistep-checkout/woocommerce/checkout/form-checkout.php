<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
?>
<div class="container-coupon-login-form"></div>
<div class="wmc-loading-img"></div>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div id="wizard"><!---Start of jQuery Wizard -->
        <?php do_action('woocommerce_multistep_checkout_before', $checkout); ?>
        <?php if (sizeof($checkout->checkout_fields) > 0) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>

            <?php if (WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping() || get_option('wmc_merge_billing_shipping_tabs') == 'true') : ?>
                <h1 class="title-billing-shipping"><?php echo get_option('wmc_billing_shipping_label') ? __(get_option('wmc_billing_shipping_label'), 'woocommerce-multistep-checkout') : __('Billing &amp; Shipping', 'woocommerce-multistep-checkout') ?></h1>
            <?php else: ?>
                <h1><?php echo get_option('wmc_billing_label') ? __(get_option('wmc_billing_label'), 'woocommerce-multistep-checkout') : __('Billing', 'woocommerce-multistep-checkout') ?></h1>
            <?php endif; ?>

            <?php
            /**
             * If Combine Billing and Shipping Steps **
             */
            if (get_option('wmc_merge_billing_shipping_tabs') == 'true') {?>                
                <div class="billing-tab-contents">
                    <?php
                    do_action('woocommerce_checkout_billing');
                    do_action('woocommerce_checkout_shipping');
                    do_action('woocommerce_checkout_after_customer_details');
                    ?>
                </div>
            <?php } else { ?>

                <div class="billing-tab-contents">
                    <?php
                    do_action('woocommerce_checkout_billing');

                    //If cart don't needs shipping
                    if (!WC()->cart->needs_shipping_address()) :
                        do_action('woocommerce_checkout_after_customer_details');
                        do_action('woocommerce_before_order_notes', $checkout);

                        if (apply_filters('woocommerce_enable_order_notes_field', get_option('woocommerce_enable_order_comments', 'yes') === 'yes')) :

                            if (!WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only()) :
                                ?>

                                <h3><?php _e('Additional Information', 'woocommerce'); ?></h3>

                            <?php endif; ?>

                            <?php foreach ($checkout->checkout_fields['order'] as $key => $field) : ?>

                                <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>

                            <?php endforeach; ?>

                        <?php endif; ?>
                        <?php do_action('woocommerce_after_order_notes', $checkout); ?>
                    <?php endif; ?>
                </div>

                <?php if (!WC()->cart->ship_to_billing_address_only() && WC()->cart->needs_shipping()) : ?>

                    <?php do_action('woocommerce_multistep_checkout_before_shipping', $checkout); ?>

                    <h1 class="title-shipping"><?php echo get_option('wmc_shipping_label') ? __(get_option('wmc_shipping_label'), 'woocommerce-multistep-checkout') : __('Shipping', 'woocommerce-multistep-checkout') ?></h1>
                    <div class="shipping-tab-contents">
                        <?php do_action('woocommerce_checkout_shipping'); ?>

                        <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                    </div>
                    <?php do_action('woocommerce_multistep_checkout_after_shipping', $checkout); ?>
                <?php endif; ?>
            <?php } ?>
        <?php endif; ?>

        <?php do_action('woocommerce_multistep_checkout_before_order_info', $checkout); ?>  


        <?php if (get_option('wmc_merge_order_payment_tabs') != "true"): ?>
            <h1 class="title-order-info"><?php echo get_option('wmc_orderinfo_label') ? __(get_option('wmc_orderinfo_label'), 'woocommerce-multistep-checkout') : __('Order Information', 'woocommerce-multistep-checkout'); ?></h1>
            <div class="shipping-tab">
                <?php do_action('woocommerce_multistep_checkout_before_order_contents', $checkout); ?>
            </div>
        <?php endif ?>

        <?php do_action('woocommerce_multistep_checkout_after_order_info', $checkout); ?>
        <?php do_action('woocommerce_multistep_checkout_before_payment', $checkout); ?>

        <h1 class="title-payment"><?php echo get_option('wmc_paymentinfo_label') ? __(get_option('wmc_paymentinfo_label'), 'woocommerce-multistep-checkout') : __('Payment Info', 'woocommerce-multistep-checkout'); ?></h1>
        <div class="payment-tab-contents"> 
            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_before_order_review'); ?>
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>
        </div>


        <?php do_action('woocommerce_multistep_checkout_after', $checkout); ?>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>