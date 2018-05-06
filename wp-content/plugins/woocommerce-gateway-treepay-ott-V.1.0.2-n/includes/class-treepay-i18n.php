<?php
/**
 * Created by PhpStorm.
 * User: mabbacc
 * Date: 2016. 8. 8.
 * Time: 오후 3:39
 */

class TreepayOTT_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'woo-treepay-ott',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }



}
