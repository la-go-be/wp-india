<?php if (!defined('FW')) die( 'Forbidden' );
/**
 * @var $atts
 */
?>
<div class="fw-heading <?php echo !empty($atts['centered']) ? 'fw-heading-center' : ''; ?>">
    <?php if (!empty($atts['subtitle_2'])): ?>
        <div style="color: <?php echo esc_attr($atts['color']); ?>" class="fw-special-subtitle_2"><?php echo esc_html($atts['subtitle_2']); ?></div>
    <?php endif; ?>
	<?php $heading = "<h3 style='color: ".esc_attr($atts['color']).";' class='fw-special-title'>{$atts['title']}</h3>"; ?>
	<?php echo html_entity_decode($heading); ?>
	<?php if (!empty($atts['subtitle'])): ?>
		<div style="color: <?php echo esc_attr($atts['color']); ?>" class="fw-special-subtitle"><?php echo esc_html($atts['subtitle']); ?></div>
	<?php endif; ?>
</div>