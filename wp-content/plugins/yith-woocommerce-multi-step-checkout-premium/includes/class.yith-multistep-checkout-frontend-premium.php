<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'YITH_WCMS_VERSION' ) ) {
    exit( 'Direct access forbidden.' );
}

/**
 *
 *
 * @class      YITH_Multistep_Checkout_Frontend_Premium
 * @package    Yithemes
 * @since      Version 1.0.0
 * @author     Andrea Grillo <andrea.grillo@yithemes.com>
 *
 */

if ( ! class_exists( 'YITH_Multistep_Checkout_Frontend_Premium' ) ) {
    /**
     * Class YITH_Multistep_Checkout_Frontend_Premium
     *
     * @author Andrea Grillo <andrea.grillo@yithemes.com>
     */
    class YITH_Multistep_Checkout_Frontend_Premium extends YITH_Multistep_Checkout_Frontend {

        /**
         * Construct
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         */
        public function __construct() {
            /* === Timeline Customizzation === */
            add_filter( 'yith_wcms_timeline_labels', array( $this, 'timeline_labels' ) );
            add_filter( 'yith_wcms_timeline_display', array( $this, 'timeline_display' ) );
            add_action( 'wp_head', array( $this, 'timeline_style' ) );

            /* === Order Received Customizzation === */
            add_filter( 'body_class', array( $this, 'body_class' ) );
            add_action( 'wp_head', array( $this, 'thankyou_style' ) );

            /* === Checkout Customizzation === */
            add_filter( 'wc_get_template', array( $this, 'get_template' ), 10, 5 );
            add_filter( 'the_title', array( $this, 'remove_endpoint_title' ), 30 );

            /* === Enqueue Scripts === */
            add_filter( 'yith_wcms_main_script', array( $this, 'premium_script' ) );
            add_action( 'yith_wcms_enqueue_scripts', array( $this, 'premium_enqueue_scripts' ) );

            /* WooCommerce Multiple Shipping Support */
            if( class_exists('WC_Ship_Multiple') ){
                global $wcms;
                if( $wcms ){
                    remove_action( 'woocommerce_before_checkout_form', array( $wcms->checkout, 'before_checkout_form' ) );
                    add_action( 'woocommerce_checkout_shipping', array( $wcms->checkout, 'before_checkout_form' ) );
                }
            }

            parent::__construct();
        }

        /**
         * Change Timeline and Button Label
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         */
        public function timeline_labels( $labels ) {
            return array(
                'login'      => get_option( 'yith_wcms_timeline_options_login' ),
                'skip_login' => get_option( 'yith_wcms_timeline_options_skip_login' ),
                'billing'    => get_option( 'yith_wcms_timeline_options_billing' ),
                'shipping'   => get_option( 'yith_wcms_timeline_options_shipping' ),
                'order'      => get_option( 'yith_wcms_timeline_options_order' ),
                'payment'    => get_option( 'yith_wcms_timeline_options_payment' ),
                'next'       => get_option( 'yith_wcms_timeline_options_next' ),
                'prev'       => get_option( 'yith_wcms_timeline_options_prev' ),
            );
        }

        /**
         * Change Timeline display
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         */
        public function timeline_display( $display ) {
            return get_option( 'yith_wcms_timeline_display', 'horizontal' );
        }

        /**
         * Add a body class(es)
         *
         * @param $classes The classes array
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return array
         */
        public function body_class( $classes ) {
            if ( ( is_order_received_page() || is_view_order_page() || is_page( 'my-account' ) ) && 'plugin' == get_option( 'yith_wcms_thankyou_style' ) ) {
                $classes[] = 'yith-wcms-pro-myaccount';
            }
            return $classes;
        }

        /**
         * Add a body class(es)
         *
         * @param $located
         * @param $template_name
         * @param $args
         * @param $template_path
         * @param $default_path
         *
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @since    1.0
         * @return array
         */
        public function get_template( $located, $template_name, $args, $template_path, $default_path ) {
            if ( 'plugin' == get_option( 'yith_wcms_thankyou_style' ) && 'checkout/thankyou.php' == $template_name ) {
                $located = YITH_WCMS_WC_TEMPLATE_PATH . 'checkout/thankyou.php';
            }
            return $located;
        }

        /**
         * Add a body class(es)
         *
         * @param $title The page title
         *
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @since    1.0
         * @return   array
         */
        public function remove_endpoint_title( $title ) {
            return 'plugin' == get_option( 'yith_wcms_thankyou_style' ) && 'order-received' == WC()->query->get_current_endpoint() && $title == WC()->query->get_endpoint_title( 'order-received' ) ? __return_empty_string() : $title;
        }

        /**
         * Add thankyou style
         *
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @since    1.0
         * @return   array
         */
        public function thankyou_style(){
            $is_enable_customizzation  = ( is_order_received_page() || is_view_order_page() || is_page( 'my-account' ) ) && 'plugin' == get_option( 'yith_wcms_thankyou_style' );
            if( ! $is_enable_customizzation ){
                return false;
            }

            ob_start();
            yith_wcms_get_template( 'thankyou-style.php', array(), 'style' );
            echo ob_get_clean();
        }

        /**
         * Add timeline style
         *
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @since    1.0
         * @return   array
         */
        public function timeline_style(){
            $timeline_template = get_option( 'yith_wcms_timeline_template' );
            if( ! is_checkout() || 'text' == $timeline_template ){
                return false;
            }

            ob_start();
            yith_wcms_get_template( "timeline-{$timeline_template}.php", array(), 'style' );
            echo ob_get_clean();
        }


        /**
         * Enqueue Scripts
         *
         * Register and enqueue scripts for Frontend
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since 1.0
         * @return void
         */
        public function premium_enqueue_scripts() {
            /* === Style === */
            wp_register_style( 'yith-wcms-checkout-responsive', YITH_WCMS_ASSETS_URL . 'css/responsive.css', array( 'yith-wcms-checkout' ), YITH_WCMS_VERSION );

            /* === Localize Script === */
            $dom = apply_filters( 'yith_wcms_frontend_dom_object', array(
                    'login'                     => '#checkout_login',
                    'billing'                   => '#customer_billing_details',
                    'shipping'                  => '#customer_shipping_details',
                    'order'                     => '#order_info',
                    'payment'                   => '#order_checkout_payment',
                    'form_actions'              => '#form_actions',
                    'coupon'                    => '#checkout_coupon',
                    'checkout_timeline'         => '#checkout_timeline',
                    'checkout_form'             => 'form.woocommerce-checkout',
                    'active_timeline'           => '.timeline.active',
                    'button_next'               => '.button.next',
                    'button_prev'               => '.button.prev',
                    'shipping_check'            => '#ship-to-different-address-checkbox',
                    'create_account'            => '#createaccount',
                    'create_account_wrapper'    => '.create-account',
                    'wc_invalid_required'       => '.woocommerce-invalid-required-field',
                    'timeline_id_prefix'        => '#timeline-',
                    'required_fields_check'     => '.input-text, select',
                    'select2_fields'            => array( 'billing_country', 'shipping_country', 'billing_state', 'shipping_state' ),
                )
            );

            $to_localize = array(
                'dom'                             => $dom,
                'live_fields_validation'          => get_option( 'yith_wcms_enable_ajax_validator', 'no' ),
                'disabled_prev_button'            => get_option( 'yith_wcms_nav_disabled_prev_button', 'no' ),
                'wc_shipping_multiple'            => class_exists( 'WC_Ship_Multiple' ),
                'is_old_wc'                       => version_compare( WC()->version, '2.5', '<' ),
                'checkout_login_reminder_enabled' => 'yes' == get_option( 'woocommerce_enable_checkout_login_reminder', 'yes' ) ? true : false,
                'is_order_received_endpoint'      => is_wc_endpoint_url( 'order-received' ),
                'transition_duration'             => get_option( 'yith_wcms_timeline_fade_duration', 200 ),
                'skip_login_label'                => get_option( 'yith_wcms_timeline_options_skip_login', _x( 'Skip Login', 'Frontend: button label', 'yith-woocommerce-multi-step-checkout' ) ),
                'next_label'                      => get_option( 'yith_wcms_timeline_options_next' ),
                'use_cookie'                      => apply_filters( 'yith_wcms_use_cookie', true )  
            );

            wp_localize_script( 'yith-wcms-step', 'yith_wcms', $to_localize );

            if( is_checkout() ){
                if( apply_filters( 'yith_wcms_use_cookie', true ) ) {
                    wp_enqueue_script( 'jquery-cookie' );
                }
                wp_enqueue_style( 'yith-wcms-checkout-responsive' );
            }
        }

        /**
         * Premium Script File
         *
         * Register and enqueue scripts for Frontend
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         *
         * @param $js_file The premium js filename
         *
         * @return string The new filename
         */
        public function premium_script( $js_file ){
            return 'multistep-premium.js';
        }
    }
}