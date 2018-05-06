<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var $map_data_attr
 * @var $atts
 * @var $content
 * @var $tag
 */
$map_zoom           = fw_akg('map_zoom',$atts);
$map_style           = fw_akg('map_style',$atts);
$map_data_attr['data-map-zoom'] = $map_zoom;
$map_data_attr['data-map-style'] = $map_style;
?>
<div class="entry-map">
    <div class="fw-map" <?php echo fw_attr_to_html($map_data_attr); ?>>
    	<div class="fw-map-canvas"></div>
    </div>
</div>