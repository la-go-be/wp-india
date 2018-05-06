<?php if (!defined('FW')) die('Forbidden');

$shortcodes_extension = fw_ext('slide-info');
wp_enqueue_script(
    'owl-carousel',
    fw_get_template_customizations_directory_uri().'/extensions/shortcodes/shortcodes/slide-info/static/js/owl.carousel.min.js',
    array( 'jquery' ),
    '1.0',
    true
);

wp_enqueue_script(
    'owl-carousel-theme',
    fw_get_template_customizations_directory_uri().'/extensions/shortcodes/shortcodes/slide-info/static/js/script.js',
    array( 'owl-carousel' ),
    '1.0',
    true
);
?>