<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */
$tw_user = $atts['tw_user'];
$tw_number = $atts['tw_number'];
if ( function_exists( 'fw_ext_social_twitter_get_connection' ) && function_exists( 'curl_exec' ) ) {
$tweets = get_site_transient( 'scratch_tweets_' . $tw_user . '_' . $tw_number );
if ( empty( $tweets ) ) {
    /* @var $connection TwitterOAuth */
    $connection = fw_ext_social_twitter_get_connection();
    $tweets     = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $tw_user . "&count=" . $tw_number );
    set_site_transient( 'scratch_tweets_' . $tw_user . '_' . $tw_number, $tweets, 12 * HOUR_IN_SECONDS );
}

?>
<div class="fw-block-tweet fw-block-info">
<div class="wrap-twitter feed">
    <div class="tweet-navigation">
        <?php
            $i = 0;
            foreach ( $tweets as $tweet ) {
                if( $i == 0 ){
                    echo '<a href="'.esc_attr($tweet->id_str).'" class="current" title="tweet"></a>';
                }else{
                    echo '<a href="'.esc_attr($tweet->id_str).'" title="tweet"></a>';
                }
                $i++;
            }
        ?>
    </div>
    <div class="tweets">
        <?php
            foreach ( $tweets as $tweet ) {
                $tuser = $tweet->user;
                $id = $tweet->id_str;
                $text = $tweet->text;
                ?>
                <div class="tweet-entry entry<?php echo esc_attr($id); ?>">
                    <div class="tw-head">
                        <div class="tw-user">
                            <img src="<?php echo esc_url($tuser->profile_image_url); ?>" alt="profile image">
                            <h3 class="tw-name"><?php echo esc_html($tuser->screen_name); ?></h3>
                            <p class="tw-desc"><?php echo esc_html($tuser->description); ?></p>
                        </div>
                        <!-- /user -->
                        <div class="tw-follow">
                            <a target="_blank" href="https://twitter.com/intent/user?screen_name=<?php echo esc_html($tuser->screen_name); ?>"><i class="fa fa-twitter"></i><?php _e('Follow', 'plan-up'); ?></a>
                        </div>
                    </div>
                    <!-- /head -->
                    <div class="tw-body">

                        <?php echo html_entity_decode($text); ?>
                    </div>
                    <!-- /body -->
                    <div class="tw-footer">
                        <a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_attr($id); ?>" title="Reply"><i class="fa fa-reply"></i></a>
                        <a target="_blank" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_attr($id); ?>" title="Retweet"><i class="fa fa-retweet"></i></a>
                        <a target="_blank" href="https://twitter.com/intent/favorite?tweet_id=<?php echo esc_attr($id); ?>" title="Favorite"><i class="fa fa-star"></i> <?php echo esc_html($tweet->favorite_count); ?></a>
                    </div>
                    <!-- /footer -->
                </div>
        <?php
            }
        ?>
    </div>
</div>
</div>
<?php
}
?>
