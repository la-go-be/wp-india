<?php
//  if a capability is entered, check if the current user can
if ( $fields['capability'] && ! current_user_can( $fields['capability'] ) ) {
	return;
}

$actions = array_map( 'trim', explode( ",", $fields['actions'] ) );
if ( ! $actions ) {
	return;
}
?>
<div class="yith-barcode-actions">
	<form name="yith-barcodes-form" method="post">
		<input type="text" name="yith-barcode-value" value="" placeholder="<?php _e( 'Enter the barcode here', 'yith-woocommerce-barcodes' ); ?>">
		<input type="hidden" name="yith-type" value="<?php echo $fields['search_type']; ?>" placeholder="<?php _e( 'Enter the barcode here', 'yith-woocommerce-barcodes' ); ?>">
		<div class="yith-barcode-buttons">
			<?php foreach ( $actions as $action_id ): ?>
				<?php if ( isset( $custom_order_actions[ $action_id ] ) ) : ?>
					<button name="ywbc-action" class="<?php echo $action_id; ?>" data-action="<?php echo $action_id; ?>"><?php echo $custom_order_actions[ $action_id ]; ?></button>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</form>
</div>