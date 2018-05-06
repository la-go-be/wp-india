<?php if (!defined('FW')) die('Forbidden');

$class = fw_ext_builder_get_item_width('page-builder', $atts['width'] . '/frontend_class');
$style = '';
$has_bg_class = '';
if( isset($atts['bg_color']) || isset($atts['color']) ){
    if( $atts['color'] != '' ){
        $style = 'style="background-color: '.$atts['bg_color'].'; color: '.$atts['color'].';"';
    }
    if( $atts['bg_color'] != '' ){
        $style = 'style="background-color: '.$atts['bg_color'].'; color: '.$atts['color'].'; padding: 40px 25px 30px;"';
        $has_bg_class = 'has_bg';
    }
}
?>
<div class="<?php echo esc_attr($class); ?> <?php echo esc_attr($has_bg_class); ?>" <?php echo ($style); ?>>
	<?php echo do_shortcode($content); ?>
</div>
