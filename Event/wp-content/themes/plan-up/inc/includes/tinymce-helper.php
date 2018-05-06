<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
// Enable font size & font family selects in the editor
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
    function wpex_mce_buttons( $buttons ) {
        array_unshift( $buttons, 'fontselect' ); // Add Font Select
        array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

function mauris_change_mce_options( $init ) {
    $default_colours = '
        "000000", "Black",
        "993300", "Burnt orange",
        "333300", "Dark olive",
        "003300", "Dark green",
        "003366", "Dark azure",
        "000080", "Navy Blue",
        "333399", "Indigo",
        "333333", "Very dark gray",
        "800000", "Maroon",
        "FF6600", "Orange",
        "808000", "Olive",
        "008000", "Green",
        "008080", "Teal",
        "0000FF", "Blue",
        "666699", "Grayish blue",
        "808080", "Gray",
        "FF0000", "Red",
        "F30c74", "Pink",
        "FF9900", "Amber",
        "99CC00", "Yellow green",
        "339966", "Sea green",
        "33CCCC", "Turquoise",
        "3366FF", "Royal blue",
        "800080", "Purple",
        "999999", "Medium gray",
        "FF00FF", "Magenta",
        "FFCC00", "Gold",
        "FFFF00", "Yellow",
        "00FF00", "Lime",
        "00FFFF", "Aqua",
        "00CCFF", "Sky blue",
        "993366", "Brown",
        "C0C0C0", "Silver",
        "FF99CC", "Pink",
        "FFCC99", "Peach",
        "FFFF99", "Light yellow",
        "CCFFCC", "Pale green",
        "CCFFFF", "Pale cyan",
        "99CCFF", "Light sky blue",
        "CC99FF", "Plum",
        "FFFFFF", "White"
        ';
    $custom_colours = '
        "727272", "Theme dark-grey",
        "040404", "Theme dark",
        "e7b740", "Theme Yellow",
        "b50d0d", "Theme Red",
        "f30c74", "Theme Pink",
        "00a859", "Color 6 Name",
        "00aae7", "Color 7 Name",
        "282828", "Color 8 Name"
        ';
    $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';
    $init['textcolor_rows'] = 6; // expand colour grid to 6 rows
    return $init;
}
add_filter('tiny_mce_before_init', 'mauris_change_mce_options');

// Add custom Fonts to the Fonts list
if ( ! function_exists( 'mauris_mce_google_fonts_array' ) ) {
    function mauris_mce_google_fonts_array( $initArray ) {
        $initArray['font_formats'] = 'Roboto=Roboto;Droid Serif=Droid Serif;Roboto Condensed = Roboto Condensed;Gotham Extra=Gotham Extra Light;Lato=Lato;Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Aeron=Aeron Light; Aeron Medium=Aeron Medium;Aeron Bold=Aeron Bold;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats';
            return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'mauris_mce_google_fonts_array' );

// Customize mce editor font sizes
if ( ! function_exists( 'mauris_mce_text_sizes' ) ) {
    function mauris_mce_text_sizes( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 18px 20px 21px 24px 28px 30px 32px 36px 40px 48px 50px 60px 68px 70px 80px 100px 120px";
        return $initArray;
    }
}
add_filter( 'tiny_mce_before_init', 'mauris_mce_text_sizes' );

/* Filter Tiny MCE Default Settings */
add_filter( 'tiny_mce_before_init', 'mauris_switch_tinymce_p_br' );

/**
 * Switch Default Behaviour in TinyMCE to use "<br>"
 * On Enter instead of "<p>"
 *
 * @link https://shellcreeper.com/?p=1041
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/tiny_mce_before_init
 * @link http://www.tinymce.com/wiki.php/Configuration:forced_root_block
 */
function mauris_switch_tinymce_p_br( $settings ) {
    $settings['forced_root_block'] = FALSE;
    return $settings;
}