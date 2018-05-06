<?php

/*
Plugin Name: Woo Tabbed Category Product Listing
Plugin URI: http://www.quantumcloud.com/blog/woocommerce-tabbed-category-wise-product-listing/
Description: WooCommerce addon to display Category based Product Listing in tab format on any page with a short code.
Author: QuantumCloud
Author URI: https://www.quantumcloud.com/
Version: 1.5.0
License: GPL2
*/


if (!defined('WPINC')) {
    die;
}

define('WOO_PRODUCT_TAB_VERSION', 2.2);

Class Woo_Tab_Product_Category_List
{

    private static $instance;

    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->init();
        }

    }


    public function init()
    {

        include_once 'class-qc-free-plugin-upgrade-notice.php';

        // Check if WooCommerce is active, and is required WooCommerce version.
        if (!class_exists('WooCommerce') || version_compare(get_option('woocommerce_db_version'), WOO_PRODUCT_TAB_VERSION, '<')) {
            add_action('admin_notices', array($this, 'woocommerce_inactive_notice'));
            return;
        }
    }


    /**
     * Display Notifications on specific criteria.
     *
     * @since    2.14
     */
    public static function woocommerce_inactive_notice()
    {
        if (current_user_can('activate_plugins')) :
            if (!class_exists('WooCommerce')) :
                deactivate_plugins(plugin_basename(__FILE__));
                //wp_die('You need to activate WooCommerce first.');
                ?>
                <style>
                    .updated {
                        display: none;
                    }
                </style>

                <div id="message" class="error">
                    <p>
                        <?php
                        printf(
                            __('%sWoo Tabbed Category Product Listing REQUIRES WooCommerce%s %sWooCommerce%s must be active for Woo Tabbed Category Product Listing to work. Please install & activate WooCommerce.', 'qcld_express_shop'),
                            '<strong>',
                            '</strong><br>',
                            '<a href="http://wordpress.org/extend/plugins/woocommerce/" target="_blank" >',
                            '</a>'
                        );
                        ?>
                    </p>
                </div>
                <?php
            elseif (version_compare(get_option('woocommerce_db_version'), WOO_PRODUCT_TAB_VERSION, '<')) :
                ?>
                <div id="message" class="error">
                    <p>
                        <?php
                        printf(
                            __('%sWoo Tabbed Category Product Listing is inactive%s This version of Woo Tabbed Category Product Listing requires WooCommerce %s or newer. For more information about our WooCommerce version support %sclick here%s.', 'qcld_express_shop'),
                            '<strong>',
                            '</strong><br>',
                            WOO_PRODUCT_TAB_VERSION
                        );
                        ?>
                    </p>
                    <div style="clear:both;"></div>
                </div>
                <?php
            endif;
        endif;
    }
}


if (!function_exists('init_woo_tab_cat_list')) {
    function init_woo_tab_cat_list()
    {

        global $woo_tab_cat_list;

        $woo_tab_cat_list = Woo_Tab_Product_Category_List::get_instance();
    }
}


add_action('plugins_loaded', 'init_woo_tab_cat_list');

/**
 * Register the shortcode
 */

add_shortcode('wtcpl-product-cat', 'wtcpl_load_products');


/**
 * Check first if WooCommerce is activated or not
 */

// Plugin Code Below

require_once(plugin_dir_path(__FILE__) . 'class-woo-tabbed-category-product-listing.php');

function woo_tabbed_category_start()
{
    $tabbed_category = new Woo_Tabbled_Categoty();
    $tabbed_category->initialize();
}

woo_tabbed_category_start();


/**
 * Loading the plugin specific javascript files.
 */

add_action('init', 'wtcpl_plugin_scripts');
add_action('init', 'wtcpl_scroll_to_scripts');
add_action('wp_enqueue_scripts', 'wtcpl_plugin_styles');


function wtcpl_plugin_scripts()
{
    wp_enqueue_script('wtcpl-product-cat-js', plugins_url('/js/wtcpl-scripts.js', __FILE__), array('jquery'));


}

function wtcpl_scroll_to_scripts()
{

    wp_enqueue_script('wtcpl-scroll-to-js', plugins_url('/js/jquery.scrollTo-1.4.3.1-min.js', __FILE__), array('jquery'));
}


/**
 * Loading the plugin specific stylesheet files.
 */

function wtcpl_plugin_styles()
{
    wp_register_style('wtcpl_plugin_style', plugin_dir_url(__FILE__) . 'css/wtcpl-styles.css');
    wp_enqueue_style('wtcpl_plugin_style');

}


/**
 * The wtcpl_load_products() body
 */

function wtcpl_load_products()
{

    if (!is_admin()) {

        $product_number = get_option('product_number');
        $column_number = get_option('column_number');
        ?>

        <div class="wtcpl_container">
            <div id="nav-holder">
                <div class="wtcpl_category_nav" id="wtcpl_tabs">
                    <?php
                    $args = array(
                        'number' => '',
                        'orderby' => '',
                        'order' => '',
                        'hide_empty' => '',
                        'include' => ''
                    );

                    $product_categories = get_terms('product_cat', $args); ?>
                    <ul>
                        <?php
                        $i = 0;
                        foreach ($product_categories as $cat) {
                            ?>
                            <li>
                                <a id="<?php echo $cat->slug; ?>"
                                   class="product-<?php echo $cat->slug; ?><?php if ($i == 0) {
                                       echo " active";
                                   } ?>"
                                   data-name="<?php echo $cat->name; ?>"
                                   href="#"><?php echo substr($cat->name, 0, get_option('max_char_per_cat')); ?></a>
                            </li>
                            <?php
                            $i++;
                        }
                        ?>
                    </ul>
                    <!--   <div class="clear"></div>-->
                </div>
            </div>
            <div class="product_content" id="wtcpl_tabs_container">


                <?php
                $i = 0;
                foreach ($product_categories as $cat) {
                    ?>
                    <div class="each_cat<?php if ($i == 0) {
                        echo " active";
                    } ?>" id="product-<?php echo $cat->slug; ?>">
                        <?php
                        echo do_shortcode('[product_category category="' . $cat->name . '" per_page=' . $product_number . ' columns=' . $column_number . ' orderby="title" order="' . get_option('order_product_by') . '"]');
                        ?></div>
                    <?php $i++;
                } ?>

            </div>
        </div>

        <?php
    }
}


function plugin_settings_page()
{
    ?>
    <div class="wrap">

        <a style="text-decoration: none;" target="_blank"
           href="https://www.quantumcloud.com/products/woo-tabbed-category-product-listing/"><h3
                    style="font-weight: bold; color: #22A7F0;">Upgrade to pro</h3></a>
        <h1>Woo Tabbed Category Product Listing Settings</h1>
        <div class="updated notice">
            <p>Use the shortcode [wtcpl-product-cat] inside any WordPress post or page to show category wise
                WooCommerce product listing in tabbed format.</p>
        </div>

        <form method="post" action="options.php">
            <?php
            settings_fields("section");
            do_settings_sections("theme-options");
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


function woo_product_tag_sub_menu()
{
    add_submenu_page('woocommerce', 'Woo Tabbed', 'Woo Tabbed', 'manage_options', 'woo-tab', 'plugin_settings_page');
}

add_action('admin_menu', 'woo_product_tag_sub_menu', 99);


function display_product_number()
{
    ?>


    <input type="text" name="product_number" id="product_number" value="<?php echo get_option('product_number'); ?>"/>
    <?php
}

function max_character_count_per_category_name()
{
    ?>

    <p class="qc-opt-dcs-font">You can truncate category name by limiting number of letter to display </p>
    <input type="number" name="max_char_per_cat" value="<?php echo get_option('max_char_per_cat'); ?>">
    <?php
}

function custom_global_css()
{
    ?>

    <p class="qc-opt-dcs-font">You can paste or write your custom css here.</p>
    <textarea name="custom_global_css"
              class="form-control custom-global-css"
              cols="132"
              rows="20"><?php echo get_option('custom_global_css'); ?></textarea>
    <?php
}


function display_column_number()
{
    ?>
    <input type="text" name="column_number" id="product_number" value="<?php echo get_option('column_number'); ?>"/>
    <?php
}

function order_product_by_title()
{
    ?>

    <ul class="radio-list">
        <li><input type="radio"
                   name="order_product_by" <?php echo(get_option('order_product_by') == 'ASC' ? 'checked' : ''); ?>
                   value="ASC"> Ascending


        </li>
        <li><input type="radio"
                   name="order_product_by" <?php echo(get_option('order_product_by') == 'DESC' ? 'checked' : ''); ?>
                   value="DESC"> Descending


        </li>


    </ul>

    <?php
}


function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");

    add_settings_field("product_number", "Product In Each Category: ", "display_product_number", "theme-options", "section");
    add_settings_field("column_number", "Number Of Column: ", "display_column_number", "theme-options", "section");
    add_settings_field("order_product_by", "Order Product Title By: ", "order_product_by_title", "theme-options", "section");
    add_settings_field("max_char_per_cat", "Number Of Letter Allowed Per Category Name: ", "max_character_count_per_category_name", "theme-options", "section");
    add_settings_field("custom_global_css", "Custom Global CSS: ", "custom_global_css", "theme-options", "section");


    register_setting("section", "product_number");
    register_setting("section", "column_number");
    register_setting("section", "custom_global_css");
    register_setting("section", "max_char_per_cat");
    register_setting("section", "order_product_by");


}

add_action("admin_init", "display_theme_panel_fields");


add_action('wp_footer', 'woo_tab_load_footer_html');


// Override Global Stylesheet from admin settings.

function woo_tab_load_footer_html()
{
    ?>
    <style>
        <?php if(get_option('custom_global_css')!=''){echo get_option('custom_global_css');}?>
    </style>
<?php }


register_activation_hook(__FILE__, 'woo_tab_demo_content');
function woo_tab_demo_content()
{

    update_option('product_number', 20);
    update_option('max_char_per_cat', 20);
    update_option('column_number', 4);
    update_option('order_product_by', 'ASC');


}
























