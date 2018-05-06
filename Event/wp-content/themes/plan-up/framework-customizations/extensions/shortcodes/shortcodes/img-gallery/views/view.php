<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */


if( $atts['source']['img_source'] == 'flickr' ):
    $user_id = $atts['source']['flickr']['user_id'];
    $group_id = $atts['source']['flickr']['group_id'];
    $user_set_id = $atts['source']['flickr']['user_set_id'];
    $number = $atts['source']['flickr']['number'];
    ?>
    <div class="ht-online-gallery flickr">
        <?php if( $user_id != '' ): ?>
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($number); ?>&amp;display=lastest&amp;size=m&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr($user_id); ?>"></script>
        <?php endif; ?>
        <?php if( $user_set_id != '' ): ?>
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($number); ?>&amp;display=lastest&amp;size=m&amp;layout=x&amp;source=user_set&amp;set=<?php echo esc_attr($user_set_id); ?>"></script>
        <?php endif; ?>
        <?php if( $group_id != '' ): ?>
            <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($number); ?>&amp;display=lastest&amp;size=m&amp;layout=x&amp;source=group&amp;group=<?php echo esc_attr($user_set_id); ?>"></script>
        <?php endif; ?>
        <?php if( $atts['icon'] != '' ): ?>
            <div class="follow-link">
                <a href="<?php echo esc_url($atts['f_url']); ?>"><i class="<?php echo esc_attr($atts['icon']); ?>"></i> <?php echo esc_html($atts['f_link']); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <?php
endif;
if( $atts['source']['img_source'] == 'instagram' ):
    $user_id = $atts['source']['instagram']['user_id'];
    $client_id = $atts['source']['instagram']['client_id'];
    $access_token = $atts['source']['instagram']['access_token'];
    $number = $atts['source']['instagram']['number'];
    ?>
        <script>
            /*http://instafeedjs.com/*/
            jQuery(document).ready(function($) {
                var feed = new Instafeed({
                    get: 'user',
                    userId: <?php echo esc_js($user_id); ?>,
                    limit: <?php echo esc_js($number); ?>,
                    accessToken: '<?php echo esc_js($access_token); ?>',
                    clientId: '<?php echo esc_js($client_id); ?>',
                    template: '<a class="entry" target="_blank" href="{{link}}"><img src="{{image}}" /></a>',
                    resolution: 'low_resolution' //306x306
                });
                feed.run();
            });
        </script>
        <div class="ht-online-gallery instagram">
            <div id="instafeed"></div>
            <?php if( $atts['icon'] != '' ): ?>
                <div class="follow-link">
                    <a href="<?php echo esc_url($atts['f_url']); ?>"><i class="<?php echo esc_attr($atts['icon']); ?>"></i> <?php echo esc_html($atts['f_link']); ?></a>
                </div>
            <?php endif; ?>
        </div>
    <?php
endif;
?>