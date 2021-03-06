<?php

$customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array();
$show_author_block = isset($customizer['c_single_author']) ? $customizer['c_single_author'] : true;
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
			the_category(' '); ?>
		</div>
		<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
			endif;
		?>
		<?php fw_thumbnail_url(get_the_ID(),'post-thumbnail',''); ?>
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
				if(post_password_required()){
					the_content();
				}else{
					the_excerpt();
				}
				echo '<a class="readmore" href="'.esc_url(get_the_permalink()).'">'.apply_filters( 'ht_readmore_label', esc_html__('CONTINUE READING', 'plan-up') ).'</a>';
			}
		?>
	</div><!-- .entry-content -->
	<?php
		/*Display meta of comment, datetime, author, social
		inc/includes/post-helper
		*/
		mauris_post_meta_block();
		if( is_singular() && $show_author_block ){
			/*Display author information
			inc/includes/author-helper
			*/
			fw_author_block( get_the_author_meta('ID') );
		}
	?>
</article><!-- #post-## -->
