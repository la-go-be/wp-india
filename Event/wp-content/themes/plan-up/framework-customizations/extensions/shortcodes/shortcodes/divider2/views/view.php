<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>
<?php
if( isset($atts['h_des']) && $atts['h_des'] != '' ): ?>
    <div class="fw-divider-space hidden-xs" style="padding-top: <?php echo (int) $atts['h_des']; ?>px;"></div>
<?php
endif;
if( isset($atts['h_mb']) && $atts['h_mb'] != '' ): ?>
    <div class="fw-divider-space visible-xs-block" style="padding-top: <?php echo (int) $atts['h_mb']; ?>px;"></div>
<?php
endif; ?>