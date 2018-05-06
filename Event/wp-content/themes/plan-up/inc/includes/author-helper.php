<?php
function mauris_new_contactmethods( $contactmethods ) {
    //$curauth->twitter;
    $contactmethods['twitter'] = esc_html__('Twitter', 'plan-up');
    $contactmethods['facebook'] = esc_html__('Facebook', 'plan-up');
    $contactmethods['linkedin'] = esc_html__('Linkin', 'plan-up');
    $contactmethods['google-plus'] = esc_html__('Google Plus', 'plan-up');
    $contactmethods['contact-email'] = esc_html__('Contact Email', 'plan-up');
    return $contactmethods;
}
add_filter('user_contactmethods','mauris_new_contactmethods',10,1);
/**
Author block
 */
function fw_author_block(){
    $au_ID = get_the_author_meta( 'ID' );
    ob_start();
?>
    <div class="post-author">
        <div class="au-avatar">
            <?php echo get_avatar($au_ID, 100 ); ?>
        </div>
        <div class="au-info">
            <h4 class="au-name"><?php the_author_posts_link(); ?></h4>
            <p class="au-bio">
                <?php echo get_the_author_meta('description', $au_ID); ?>
            </p>
            <div class="au-social">
                <?php
                    echo (get_the_author_meta('facebook', $au_ID) != '') ? '<a class="fa fa-facebook" href="'.get_the_author_meta('facebook', $au_ID).'" title=""></a>' : '';
                    echo (get_the_author_meta('twitter', $au_ID) != '') ? '<a class="fa fa-twitter" href="'.get_the_author_meta('twitter', $au_ID).'" title=""></a>' : '';
                    echo (get_the_author_meta('google-plus', $au_ID) != '') ? '<a class="fa fa-google-plus" href="'.get_the_author_meta('google-plus', $au_ID).'" title=""></a>' : '';
                    echo (get_the_author_meta('linkedin', $au_ID) != '') ? '<a class="fa fa-linkedin" href="'.get_the_author_meta('linkedin', $au_ID).'" title=""></a>' : '';
                    echo (get_the_author_meta('contact-email', $au_ID) != '') ? '<a class="fa fa-envelope" href="mailto:'.get_the_author_meta('contact-email', $au_ID).'" title=""></a>' : '';
                ?>
            </div>
        </div>
    </div>
<?php
    $output = ob_get_clean();
    echo html_entity_decode($output);
}
?>