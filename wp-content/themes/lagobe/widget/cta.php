<?php
$top_class = hoot_widget_border_class( $border, 0, 'topborder-');
$bottom_class = hoot_widget_border_class( $border, 1, 'bottomborder-');

$table_class = ( $style == 'style1' ) ? '' : 'table';
$table_cell_class = ( $style == 'style1' ) ? '' : 'table-cell-mid';
$cta_button_class = ( $style == 'style1' ) ? '' : 'button button-medium border-box';
$highglight_class = ( $style == 'style3' ) ? 'highlight-typo' : '';
?>

<div class="cta-widget-wrap <?php echo $highglight_class . ' ' . sanitize_html_class( 'cta-' . $style ) . ' ' . sanitize_html_class( $top_class ); ?>">
	<div class="cta-widget-box <?php echo sanitize_html_class( $bottom_class ); ?>">
		<div class="cta-widget <?php echo  $table_class; ?>">
			<?php if ( !empty( $headline ) || !empty( $description ) ) { ?>
				<div class="cta-text <?php echo $table_cell_class; ?>">
					<?php if ( !empty( $headline ) ) { ?>
						<h3 class="cta-headine"><?php echo do_shortcode( esc_html( $headline ) ); ?></h3>
					<?php } ?>
					<?php if ( !empty( $description ) ) { ?>
						<div class="cta-description"><?php echo do_shortcode( wp_kses_post( wpautop( $description ) ) ); ?></div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php if ( !empty( $url ) ) { ?>
				<div class="cta-action <?php echo $table_cell_class; ?>">
					<a href="<?php echo esc_url( $url ); ?>" <?php hybridextend_attr( 'cta-widget-button', 'widget', $cta_button_class ); ?>><?php echo esc_html( $button_text ); ?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>