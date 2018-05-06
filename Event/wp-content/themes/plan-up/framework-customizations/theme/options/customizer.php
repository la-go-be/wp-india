<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$favicon = array();
if ( ! function_exists( 'wp_site_icon' ) ) {
    $favicon['label'] = 'Favicon';
    $favicon['type'] = 'upload';
} else {
    $favicon['label'] = false;
    $favicon['type'] = 'hidden';
}

$options = array(
    fw()->theme->get_options( 'customizer/c_header' ),
    fw()->theme->get_options( 'customizer/c_banner' ),
    fw()->theme->get_options( 'customizer/c_blog' ),
    fw()->theme->get_options( 'customizer/c_footer' ),
    fw()->theme->get_options( 'customizer/c_typo' ),
    fw()->theme->get_options( 'customizer/c_other' ),
);
?>