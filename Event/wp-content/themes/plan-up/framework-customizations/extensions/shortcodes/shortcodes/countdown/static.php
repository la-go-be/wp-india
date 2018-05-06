<?php if (!defined('FW')) die('Forbidden');

// find the uri to the shortcode folder
$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/countdown');
// wp_enqueue_style(
//     'fw-shortcode-demo-shortcode',
//     $uri . '/static/css/styles.css'
// );
wp_enqueue_script(
    'fw-shortcode-jquery-time-countdown',
    $uri . '/static/js/jquery.countdown.min.js'
);

