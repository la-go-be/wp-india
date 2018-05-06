<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
?>
<div class="ht-accordion">
    <div class="accordion">
    	<?php foreach ( $atts['tabs'] as $tab ) : ?>
            <div class="accordion-title"><p><?php echo html_entity_decode($tab['tab_title']); ?></p><a href="#" class="ion-arrow-down-b"></a></div>
            <div class="accordion-content">
                <?php echo do_shortcode( $tab['tab_content'] ); ?>
            </div>
    	<?php endforeach; ?>
    </div>
</div>