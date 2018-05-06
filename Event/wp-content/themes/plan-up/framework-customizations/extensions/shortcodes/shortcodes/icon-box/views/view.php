<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
/**
 * @var array $atts
 */
?>
<?php
/*
 * `.fw-iconbox` supports 3 styles:
 * `fw-iconbox-1`, `fw-iconbox-2` and `fw-iconbox-3`
 */
if( $atts['style'] == 'fw-iconbox-1' ):
?>
<div class="clearfix <?php echo esc_attr($atts['style']); ?> textblock-shortcode icon-box">
	<div class="fw-iconbox-aside">
		<?php if( $atts['title'] != '' ): ?>
	        <h3 class="text-heading"><i class="<?php echo esc_attr($atts['icon']); ?>" style="color: <?php echo esc_attr($atts['color']); ?>;"></i><br><br><?php echo esc_html($atts['title']); ?></h3>
	    <?php endif; ?>
		<div class="fw-iconbox-text">
			<p><?php echo html_entity_decode($atts['content']); ?></p>
		</div>
		<?php if( $atts['link'] != '' ): ?>
		    <div class="text-link">
		        <a <?php echo esc_attr($atts['target']); ?> href="<?php echo esc_url($atts['url']); ?>"><?php echo esc_html($atts['link']); ?></a>
		    </div>
		<?php endif; ?>
	</div>
</div>
<?php else: ?>
<div class="textblock-shortcode icon-box">
    <?php if( $atts['title'] != '' ): ?>
        <h3 class="text-heading" style="color: <?php echo esc_attr($atts['color']); ?>;"><?php echo html_entity_decode('<i class="'.$atts['icon'].' inline"></i>')." <span>"; echo esc_html($atts['title']); ?></span></h3>
    <?php endif; ?>
    <?php echo do_shortcode( $atts['content'] ); ?>
    <?php if( $atts['link'] != '' ): ?>
        <div class="text-link">
            <a <?php echo esc_attr($atts['target']); ?> href="<?php echo esc_url($atts['url']); ?>"><?php echo esc_html($atts['link']); ?></a>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>