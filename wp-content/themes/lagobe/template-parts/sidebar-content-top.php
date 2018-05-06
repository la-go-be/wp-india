<?php
// Dispay Sidebar if sidebar has widgets
if ( is_active_sidebar( 'hoot-content-top' ) ) :

	?>
	<div <?php hybridextend_attr( 'content-top', '', 'grid-stretch inline_nav highlight-typo' ); ?>>
		<div class="grid">
			<div class="grid-span-12">
				<?php

				// Template modification Hook
				do_action( 'hoot_template_sidebar_start', 'content-top' );

				?>
				<aside <?php hybridextend_attr( 'sidebar', 'content-top' ); ?>>
					<?php dynamic_sidebar( 'hoot-content-top' ); ?>
				</aside>
				<?php

				// Template modification Hook
				do_action( 'hoot_template_sidebar_end', 'content-top' );

				?>
			</div>
		</div>
	</div>
	<?php

endif;