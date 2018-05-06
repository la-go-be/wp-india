<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header">
		<?php
			the_title( '<h1 class="entry-title">', '</h1>' );
		?>
		<?php fw_thumbnail_url(get_the_ID(),'post-thumbnail',''); ?>
	</header>
	<!-- /post-header -->
	<div class="entry-content">
		<?php
			the_content();
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'plan-up' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php
		/*Display meta of comment, datetime, author, social
		inc/includes/post-helper
		*/
		mauris_post_meta_block();
		if( is_singular() ){
			/*Display author information
			inc/includes/author-helper
			*/
			fw_author_block( get_the_author_meta('ID') );
		}
	?>
</article><!-- #post-## -->
