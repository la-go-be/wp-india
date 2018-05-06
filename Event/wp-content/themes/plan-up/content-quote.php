<?php
$quote = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'quote', '') : '';
$au = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'author', '') : '';
$pos = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'position', '') : '';
if( $quote != '' ) :
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content quote">
		<p class="quote"><?php echo esc_html($quote); ?></p>
		<h4 class="quote-au"><?php echo esc_html($au); ?></h4>
		<p class="au-pos"><?php echo esc_html($pos); ?></p>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
<?php
else:
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
		<?php
			fw_thumbnail_url(get_the_ID(),'post-thumbnail','');
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
		mauris_post_meta_block();
		if( is_singular() ){
			fw_author_block( get_the_author_meta('ID') );
		}
	?>
</article><!-- #post-## -->
<?php
endif;
?>