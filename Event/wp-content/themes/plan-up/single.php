<?php
/**
 * The Template for displaying all single posts
 */

get_header(); ?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" >

		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
					if ( comments_open() || get_comments_number() ):
						comments_template();
					else:
						echo '<div class="post-comment"><h3>'.apply_filters( 'ht_comment_off_label', esc_html__('Comments are closed', 'plan-up') ).'</h3></div>';
					endif;
				endwhile;
			else:
				get_template_part( 'content', 'none' );
			endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
