<?php if (!defined('FW')) die('Forbidden');

// find the uri to the shortcode folder
$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/event-countdown');
wp_enqueue_script(
    'fw-shortcode-jquery-countdown',
    $uri . '/static/js/jquery.countdown.min.js'
);

