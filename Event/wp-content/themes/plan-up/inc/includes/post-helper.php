<?php
/**
Return the html of the post thumbnail
 */
function fw_thumbnail_url( $post_id = null, $size, $classes ){
    if( has_post_thumbnail() ){
        $img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $size );
        echo '<div class="post-thumbnail"><img class="'.esc_attr($classes).'" src="'.esc_url($img["0"]).'" alt="'.esc_attr( get_the_title() ).'"></div>';
    }
}

/**
Change the length of excerpt
*/
function fw_excerpt_length($length) {
    return 75;
}
add_filter('excerpt_length', 'fw_excerpt_length');


// Custom more tag excerpt
//
function mauris_new_excerpt_more( $more ) {
    return ' ...';
}
add_filter('excerpt_more', 'mauris_new_excerpt_more');

/**
Return the content of share action for content.php
 */
function fw_sharePost( $postID ){
    if( function_exists('sharing_display')){//Integrate with jetback social
        echo strip_tags(sharing_display(), '<a>');
    }else{
        $customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');
        $network_set = array( 'facebook','twitter','googleplus','linkedin','email','digg','pinterest','stumble','reddit' );
        $network = isset($customizer['c_social_icon']) ? $customizer['c_social_icon'] : array('facebook' => true, 'twitter' => true, 'googleplus' => true);
        if( !empty($network) ){
            $a = '';
            foreach ( $network as $key => $value ) {
                switch ($key) {
                    case 'facebook':
                        $a .= '<a target="_blank" href="http://www.facebook.com/sharer.php?u='.get_permalink().'&amp;t='.get_the_title().'" class="fa fa-facebook" title="Share on Facebook"></a>';
                        break;
                    case 'twitter':
                        $a .= '<a target="_blank" href="http://twitter.com/home/?status='.get_the_title().' - '.get_permalink().'" class="fa fa-twitter" title="Tweet this!"></a>';
                        break;
                    case 'googleplus':
                        $a .= '<a target="_blank" class="fa fa-google-plus" href="https://plus.google.com/share?url='.get_permalink().'" onclick="javascript:window.open(this.href,
                            \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"></a>';
                        break;
                    case 'linkedin':
                        $a .= ' <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;title='.get_the_title().'&amp;url='.get_permalink().'" class="fa fa-linkedin" title="Share on LinkedIn"></a>';
                        break;
                    case 'email':
                        $a .= '<a target="_blank" class="fa fa-envelope" href="mailto:?Subject='.get_the_title().'&Body='.get_permalink().'"></a>';
                        break;
                    case 'digg':
                        $a .= '<a href="http://digg.com/submit?url='.get_permalink().'&amp;title='.get_the_title().'" class="fa fa-digg" title="Digg this!"></a>';
                        break;
                    case 'pinterest':
                        $a .= '<a target="_blank" class="fa fa-pinterest" href="http://pinterest.com/pin/create/button/?url='.get_permalink().'&media='.wp_get_attachment_url( get_post_thumbnail_id($postID) ).'"></a>';
                        break;
                    case 'stumble':
                        $a .= '<a href="http://www.stumbleupon.com/submit?url='.get_permalink().'&amp;title='.get_the_title().'" class="fa fa-stumbleupon" title="Stumble it"></a>';
                        break;
                    case 'reddit':
                        $a .= '<a href="http://www.reddit.com/submit?url='.get_permalink().'&amp;title='.get_the_title().'" class="fa fa-reddit" title="Vote on Reddit"></a>';
                        break;
                    case 'delicious':
                        $a .= '<a href="http://del.icio.us/post?url='.get_permalink().'&amp;title='.get_the_title().'" title="Bookmark on del.icio.us"></a>';
                    default:
                        break;
                }
            }
            echo html_entity_decode($a);
        }
    }
}

/**
Add meta tag
 */
add_action( 'wp_head', 'fw_add_metaTag' );
function fw_add_metaTag(){
    if( is_singular() && !function_exists('sharing_display') ){//Integrate with jetback social
        global $wp_query;
        $post_id = $wp_query->get_queried_object_id();
        $post7 = get_post( $post_id );

        if( $post7 != null && !is_front_page() ){
            $metaTag = '';
            $metaTag .= '<meta property="og:title" content="'.$post7->post_title.'" />';
            $metaTag .= '<meta property="og:url" content="'.get_permalink( $post_id ).'" />';
            $metaTag .= "<meta property='og:description' content='".wp_trim_words( $post7->post_content, 80, '...' )."' />";
             $metaTag .= '<meta property="og:site_name" content="'.get_bloginfo('name').'" />';
             $metaTag .= '<meta property="og:image" content="'.wp_get_attachment_url( get_post_thumbnail_id($post_id) ).'" />';
            echo html_entity_decode($metaTag);
        }
    }
}

function mauris_remove_jp_sharing() {
    if ( function_exists( 'sharing_display' ) ) {
        remove_filter( 'the_content', 'sharing_display', 19 );
        remove_filter( 'the_excerpt', 'sharing_display', 19 );
    }
}
add_action( 'loop_start', 'mauris_remove_jp_sharing' );

/**
Post meta block
 */
function mauris_post_meta_block(){
    if( get_post_type() == 'post' ) :
        $customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');
        $show_meta_pages = isset($customizer['c_post_show']) ? $customizer['c_post_show'] : array('bloglist' => true, 'single' => true);
        $metas = isset($customizer['c_post_meta']) ? $customizer['c_post_meta'] : array('datetime' => true, 'author' => true, 'comment' => true, 'social' => true);
        if( (is_singular() && isset($show_meta_pages['single'])) || (!is_singular() && isset($show_meta_pages['bloglist'])) ) :
            ob_start();
            ?>
            <footer class="entry-meta">
                <?php if( isset($metas['datetime']) ) : ?>
                <div class="meta meta-date">
                    <i class="ion-ios-calendar-outline"></i> <a href="<?php printf('%1s',get_month_link('','')); ?>" title="Month Archies"><?php printf('%1$s',get_the_date('M, dS, Y')) ?></a>
                </div>
                <?php endif; ?>
                <?php if( isset($metas['author']) ) : ?>
                <div class="meta meta-author">
                    <i class="ion-ios-compose-outline"></i> <?php the_author_posts_link(); ?>
                </div>
                <?php endif; ?>
                <?php if( isset($metas['comment']) ) : ?>
                <div class="meta meta-comment">
                    <?php
                        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
                            comments_popup_link( __('<i class="ion-ios-chatboxes-outline"></i> 0 comment', 'plan-up'), __('<i class="ion-ios-chatboxes-outline"></i> 1 comment', 'plan-up'), __('<i class="ion-ios-chatboxes-outline"></i> % comments', 'plan-up'), '', '' );
                        else:
                            echo '<i class="ion-ios-chatboxes-outline"></i> '.apply_filters( 'ht_comment_off', __('Comment off', 'plan-up') );
                        endif;
                    ?>
                </div>
                <?php endif; ?>
                <?php if( isset($metas['social']) ) : ?>
                <div class="meta meta-social">
                    <?php fw_sharePost(get_the_ID()); ?>
                </div>
                <?php endif; ?>
            </footer>
            <?php
            $output = ob_get_clean();
            echo html_entity_decode($output);
        endif;
    endif;
}

function fw_commentcb($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <<?php echo html_entity_decode($tag); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
        <div class="au-block">
            <div class="comment-author vcard">
            <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            </div>
            <?php if ( $comment->comment_approved == '0' ) : ?>
                <em class="comment-awaiting-moderation"><?php echo apply_filters( 'ht_comment_waiting_validate', __('Your comment is awaiting moderation.', 'plan-up') ); ?></em>
                <br />
            <?php endif; ?>
        </div>
        <div class="au-block-2">
            <div class="block-1">
                <div class="comment-meta commentmetadata">
                    <?php printf( __( '<cite style="display: block;" class="fn">%s</cite>', 'plan-up' ), get_comment_author_link() ); ?>
                    <a class="diff-time" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                        <?php
                            /* translators: 1: date, 2: time */
                            printf( __('%1$s', 'plan-up'), fw_time_ago() );
                        ?>
                    </a>
                    <?php
                        edit_comment_link( __('(Edit)', 'plan-up'), '  ', '' );
                    ?>
                </div>
                <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div>
            </div>
            <div class="block-2">
                <?php comment_text(); ?>
            </div>
        </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php
}

function fw_time_ago( $type = 'post' ) {
    $d = 'get_comment_time';

    return human_time_diff($d('U'), current_time('timestamp')) . " " . __('ago', 'plan-up');

}
?>