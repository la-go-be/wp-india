<?php
if ( ! is_active_sidebar( 'hoot-sub-footer' ) )
	return;
?>
<div <?php hybridextend_attr( 'sub-footer', '', 'grid-stretch inline_nav enforce-typo' ); ?>>
	<div class="grid">
		<div class="grid-span-12">
			<?php dynamic_sidebar( 'hoot-sub-footer' ); ?>
		</div>
	</div>
</div>