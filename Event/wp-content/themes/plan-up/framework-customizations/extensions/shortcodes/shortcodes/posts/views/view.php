<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$query = new WP_Query(array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $atts['number'],
    'category__in' => (array)$atts['cate']
));
?>
<div class="posts-shortcode-wrapper">
    <?php
    if( $query->have_posts() ):
    	while($query->have_posts()): $query->the_post();
    ?>
        <div class="post-entry">
            <?php if( has_post_thumbnail() ): ?>
                <div class="entry-media">
                    <?php the_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <div class="entry-content">
                <h3 class="post-title"><?php the_title( '<a href='.get_permalink().'>', '</a>', true ); ?></h3>
                <small><?php echo get_the_date( 'd.m.Y' ); ?></small>
                <br><br>
                <p class="post-desc"><?php the_excerpt(); ?></p>
                <a class="read-more" href="<?php echo esc_url(get_permalink()); ?>"><?php echo html_entity_decode($atts['read_more']); ?></a>
            </div>
        </div>
    <?php
    	endwhile;
    endif;
    ?>
</div>
<?php
wp_reset_postdata();