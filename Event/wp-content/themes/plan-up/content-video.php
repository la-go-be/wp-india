<?php
$youtube = function_exists('fw_get_db_post_option') ? fw_get_db_post_option( get_the_ID(), 'youtube', '' ) : '';
$vimeo = function_exists('fw_get_db_post_option') ? fw_get_db_post_option( get_the_ID(), 'vimeo', '' ) : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header">
		<?php
			if( is_sticky() ){
		?>
			<i class="fa fa-thumb-tack sticky-gim"></i>
		<?php
			}
		?>
		<div class="post-cates">
			<?php
			the_category(' ');
			?>
		</div>
		<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;
		?>
		<?php
			if( $vimeo == '' && $youtube == '' ):
				fw_thumbnail_url(get_the_ID(),'post-thumbnail','');
			else:
				if( $vimeo != '' ):
					echo '<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="//player.vimeo.com/video/'.esc_attr($vimeo).'?color=ffffff" width="500" height="281"></iframe>
						</div>';
				endif;
				if( $youtube != '' ):
					echo '<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.esc_attr($youtube).'"></iframe>
						</div>';
				endif;
			endif;
		?>
	</header>
	<!-- /post-header -->
	<div class="entry-content">
		<?php
			if( is_singular() ){
				the_content();
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'plan-up' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				the_tags( '<div class="post-tags">', '', '</div>' );
			}else{
				the_excerpt();
				echo '<a class="readmore" href="'.esc_url(get_the_permalink()).'">'.apply_filters( 'ht_readmore_label', esc_html__('CONTINUE READING', 'plan-up') ).'</a>';
			}
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
