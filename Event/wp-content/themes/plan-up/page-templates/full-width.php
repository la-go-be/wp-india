<?php
/**
 * Template Name: Full Width Page
 */

get_header(); ?>
<div id="main-content" class="main-content">
	<div id="primary" class="content-full">
		<div id="content" class="site-content" >
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					the_content();
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->
<?php
get_footer();
