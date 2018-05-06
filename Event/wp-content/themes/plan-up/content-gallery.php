<?php

$galleries = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'gallery',array()) : array();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="post-header">
		<?php
			if( is_sticky() ){
		?>
			<i class="ion-flash sticky-gim"></i>
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
		<?php if( !empty($galleries) ): ?>
			<div id="flexslider-<?php the_ID(); ?>" class="flexslider sync" data-sync="#syn-<?php the_ID(); ?>" data-auto="true" data-effect="slide" data-navi="true" data-pager="false" data-slide-speed="7000" data-animation-speed="1000">
				<ul class="slides">
				<?php

					foreach ($galleries as $gallery) {
						if( is_singular() ){
							$g_url = wp_get_attachment_image_src( $gallery['attachment_id'], 'medium', false );
						}else{
							$g_url = wp_get_attachment_image_src( $gallery['attachment_id'], 'post-thumbnail', false );
						}
						echo '<li>';
						echo '<img src="'.esc_url($g_url['0']).'" alt=".'.esc_attr_e("recipe image cover").'>';
						echo '</li>';
					}
				?>
				</ul>
			</div>
			<?php if( is_singular() ): ?>
				<div id="syn-<?php the_ID(); ?>" class="flexslider-sync-carousel">
					<ul class="slides">
						<?php
							foreach ($galleries as $gallery) {
								if( is_singular() ){
									$g_url = wp_get_attachment_image_src( $gallery['attachment_id'], 'medium', false );
								}else{
									$g_url = wp_get_attachment_image_src( $gallery['attachment_id'], 'post-thumbnail', false );
								}
								echo '<li>';
								echo '<img src="'.esc_url($g_url['0']).'" alt=".'.esc_attr_e("recipe image cover").'>';
								echo '</li>';
							}
						?>
					</ul>
				</div>
			<?php endif; ?>
		<?php else:
			fw_thumbnail_url(get_the_ID(),'post-thumbnail','');
		endif; ?>
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