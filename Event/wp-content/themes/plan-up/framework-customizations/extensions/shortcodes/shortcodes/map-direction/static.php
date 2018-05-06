<?php if (!defined('FW')) die('Forbidden');

$shortcodes_extension = fw_get_template_customizations_directory_uri().'/extensions/shortcodes/shortcodes';

$language = substr( get_locale(), 0, 2 );
wp_enqueue_script(
    'google-maps-api-v3',
    'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDG3tO4-pHuSHLscmtP5meKtnfVUgaHnbM&language=' . $language,
    array(),
    false,
    false
);

wp_enqueue_script(
    'fw-shortcode-mapdirection-mapapasp',
    'http://www.google.com/jsapi',
    array(),
    false,
    false
);
