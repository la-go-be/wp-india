<?php

defined('ABSPATH') OR exit;

/**
 * @wordpress-plugin
 * Plugin Name:       WooCommerce TreePay Gateway
 * Plugin URI:        http://docs.treepay.co.th/
 * Description:       Take credit card payments on your store using TreePay
 * Version:           1.0.3
 * Author:            TreePay
 * Author URI:        http://docs.treepay.co.th/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-treepay
 * Domain Path:       /languages
 */


register_activation_hook(     __FILE__,   array("WooTreepay", "setActivation"));
register_deactivation_hook(   __FILE__,   array("WooTreepay", "setDeactivation"));

add_action('plugins_loaded', array('WooTreepay', 'init'), 0);

class WooTreepay
{

    protected static $instance;

    public function __construct()
    {

    }

    public static function init()
    {
        error_log("WooTreepay-init()a");



        require plugin_dir_path(__FILE__) . 'includes/class-treepay.php';

        $plugin = new Treepay();
        $plugin->run();




        error_log("WooTreepay-init()z");

        is_null(self::$instance) AND self::$instance = new self;
        return self::$instance;


    }




    public static function setActivation()
    {

        error_log("set_activation()a");

        require_once plugin_dir_path(__FILE__) . 'includes/class-treepay-activator.php';
        Treepay_Activator::activate();

        error_log("set_activation()z");
    }

    public static function setDeactivation()
    {

        error_log("set_deactivation()a");


        require_once plugin_dir_path(__FILE__) . 'includes/class-treepay-deactivator.php';
        Treepay_Deactivator::deactivate();

        error_log("set_deactivation()z");

    }


}

