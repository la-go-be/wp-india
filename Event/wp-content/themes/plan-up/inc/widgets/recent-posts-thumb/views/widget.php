<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 * @var string $title
 * @var string $number
 */

echo html_entity_decode($before_widget);
echo html_entity_decode($title);
$query = new WP_Query('post_type=post&post_status=publish&ignore_sticky_posts=true&posts_per_page='.$number);
if( $query->have_posts() ):
    while($query->have_posts()): $query->the_post();
?>
    <a class="recent-post-entry" href="<?php the_permalink(); ?>">
        <?php fw_thumbnail_url(get_the_title(),'thumbnail',''); ?>
        <div>
            <h4 class="post-title"><?php the_title(); ?></h4>
        </div>
    </a>
<?php
    endwhile;
endif;
wp_reset_postdata();
echo html_entity_decode($after_widget);