<?php if (!defined('FW')) die('Forbidden');

$shortcodes_extension = fw_ext('shortcodes');

wp_enqueue_script(
    'fw-shortcode-img-galler',
    fw_get_template_customizations_directory_uri().'/extensions/shortcodes/shortcodes/img-gallery/static/js/script.js',
    array('jquery'),
    false,
    true
);