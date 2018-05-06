<?php

get_header(); ?>
<div class="container">
<div id="primary" class="content-area">
	<main id="main" class="site-main" >
	<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', 'page' );
            if ( comments_open() || get_comments_number() ):
                comments_template();
           
            endif;
		endwhile;
	?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>