<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$color = '';
if ( ! empty( $atts['color'] ) ) {
	$color = 'color:' . ($atts['color']) . ';';
}

$bg_color = '';
$color_class = 'has-color';
if ( ! empty( $atts['background_color'] ) ) {
	$bg_color = 'background-color:' . ($atts['background_color']) . ';';
	$color_class = '';
}

$bg_image = '';
if ( ! empty( $atts['background_image'] ) && ! empty( $atts['background_image']['data']['icon'] ) ) {
	$image_id = esc_attr($atts['background_image']['custom']);
	$image_src = wp_get_attachment_image_src($image_id, 'full');
	$bg_image = 'background-image:url(' . esc_url($image_src[0]) . ');';
}

$padding = '';
if ( $atts['padding_top']  != '' ) {
	$padding .= 'padding-top:' . esc_attr($atts['padding_top']) . 'px;';
}
if ( $atts['padding_bottom'] != '' ) {
	$padding .= 'padding-bottom:' . esc_attr($atts['padding_bottom']) . 'px;';
}

$margin = '';
if ( $atts['margin_top'] != '' ) {
	$margin .= 'margin-top:' . ($atts['margin_top']) . 'px;';
}
if ( $atts['margin_bottom'] != '' ) {
	$margin .= 'margin-bottom:' . ($atts['margin_bottom']) . 'px;';
}

$bg_video_data_attr    = '';
$section_extra_classes = '';
if ( ! empty( $atts['video'] ) ) {
	$filetype           = wp_check_filetype( $atts['video'] );
	$filetypes          = array( 'mp4' => 'mp4', 'ogv' => 'ogg', 'webm' => 'webm', 'jpg' => 'poster' );
	$filetype           = array_key_exists( (string) $filetype['ext'], $filetypes ) ? $filetypes[ $filetype['ext'] ] : 'video';
	$bg_video_data_attr = 'data-wallpaper-options="' . fw_htmlspecialchars( json_encode( array( 'source' => array( $filetype => $atts['video'] ) ) ) ) . '"';
	$section_extra_classes .= ' background-video';
}

$has_parallax = '';
$parallax_attrs = '';
$parallax_offset = '';
if ( $atts['parallax_toggle'] == 'is-parallax' ) {
	$parallax_attrs = 'data-top-bottom="transform: translateY(' . ($atts['parallax_distance']) . 'px);" data-bottom-top="transform: translateY(0px);"';
	$has_parallax = 'has-parallax';
}

$section_style   = 'style=' . ( $color . $bg_color . $padding . $margin );
if( $color . $bg_color . $padding . $margin == '' ){
	$section_style = '';
}
$container_class = '';
$container_class .= ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) ? 'fw-container-fluid ' : 'fw-container ';
$container_class .= ( isset( $atts['no_padding'] ) && $atts['no_padding'] ) ? 'no-gutter' : '';
if( $atts['section_id'] != '' ){
	$section_id = 'id ='.$atts['section_id'];
}else{
	$section_id = '';
}
?>
<section <?php echo esc_attr($section_id); ?> class="fw-main-row <?php echo esc_attr($has_parallax) ?> <?php echo esc_attr($section_extra_classes) ?>" <?php echo esc_attr($section_style); ?> <?php echo $bg_video_data_attr; ?>>
	<div class="fw-main-row-bg" style="<?php echo ($bg_image) ?> <?php echo esc_attr($parallax_offset) ?>" <?php echo html_entity_decode($parallax_attrs); ?>></div>
	<div class="fw-main-row-overlay <?php echo esc_attr($color_class); ?>" <?php echo ($bg_color) ? 'style="' . $bg_color . '"' : '' ?>></div>
	<div style="<?php echo esc_attr($color); ?>" class="<?php echo esc_attr($container_class); ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>
</section>

<?php if( $atts['section_id'] == 'speakers' ): ?>
<div class="speakers-popup-wrapper">
	<div class="speakers-popup">
		<a href="javascript:void(0);" class="fa fa-times speakers-popup-close"></a>
		<div class="speakers-popup-content"></div>
	</div>
</div>
<script>
	jQuery(document).ready(function($) {
		var content = '';
		$('.fw-team').each(function(index, el) {
			content += '<div class="entry">'+$(this).html()+'</div>';
		});
		$('.speakers-popup-content').html(content);
		$('.fw-team .team-url').each(function(index, el) {
			$(this).click(function(event) {
				event.preventDefault();
				event.stopPropagation();
				$('.speakers-popup-wrapper').fadeIn();
				$('.speakers-popup-content').removeData("flexslider");
				$('.speakers-popup-content').flexslider({
				    selector        :   ".entry",
				    animation		: 	"fade",
				    slideshow       :   false, // Boolean: Animate slider automatically
				    startAt			: 	index,
				    easing          :   "easeInOutExpo", // Easing
				    controlNav      :   false, // Pagination
				    directionNav    :   true, // Next, prev
				    prevText        :   '<i class ="ion-ios-arrow-thin-left"></i>',
				    nextText        :   '<i class ="ion-ios-arrow-thin-right"></i>',
				});
			});
		});
		$(document).on('click',function(){
			$(".speakers-popup-wrapper").fadeOut("slow");
		});
		$(".speakers-popup-content").click(function(event){
			event.stopPropagation();
		});
	});
</script>
<?php endif; ?>