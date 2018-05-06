<?php if (!defined('FW')) die( 'Forbidden' ); ?>
<?php
$color_class = !empty($atts['color']) ? "fw-btn-{$atts['color']}" : '';
if( isset($atts['style']) && $atts['style'] != 'circle' ):
?>
<div class="ht-btn-wrapper">
    <a href="<?php echo esc_attr($atts['link']) ?>" target="<?php echo esc_attr($atts['target']) ?>" class="fw-btn fw-btn-1 <?php echo esc_attr($color_class); ?>">
        <span><?php echo esc_html($atts['label']); ?></span>
    </a>
</div>
<?php else: ?>
    <div class="btn-circle-wrapper" style="text-align: <?php echo esc_attr($atts['align']); ?>">
        <a href="<?php echo esc_attr($atts['link']) ?>" class="btn btn-circle <?php echo esc_attr($atts['color']); ?>"><?php echo esc_html($atts['label']); ?></a>
    </div>
<?php endif; ?>