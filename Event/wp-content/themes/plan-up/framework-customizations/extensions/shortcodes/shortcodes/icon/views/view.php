<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */
?>
<?php if( isset($atts['url']) && $atts['url'] != '' ): ?>
    <span class="fw-icon">
        <a href="<?php echo esc_url($atts['url']); ?>">
            <i class="<?php echo esc_attr($atts['icon']); ?>"></i>
            <?php if (!empty($atts['title'])): ?>
                <br/>
                <span class="list-title"><?php echo esc_html($atts['title']); ?></span>
            <?php endif; ?>
        </a>
    </span>
<?php else: ?>
    <span class="fw-icon">
        <i class="<?php echo esc_attr($atts['icon']); ?>"></i>
        <?php if (!empty($atts['title'])): ?>
            <br/>
            <span class="list-title"><?php echo esc_html($atts['title']); ?></span>
        <?php endif; ?>
    </span>
<?php endif; ?>