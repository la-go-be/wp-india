<?php if (!defined('FW')) die( 'Forbidden' );
$datetime = $atts['datetime'];
$day_text = $atts['day_text'];
$hour_text = $atts['hour_text'];
$min_text = $atts['min_text'];
$sec_text = $atts['sec_text'];
$color = $atts['color'];
?>
<?php if( isset($atts['style']) && $atts['style'] == 'circle' ): ?>
    <div class="time-countdown-wrapper circle">
        <div class="countdown-group">
            <div style="color: <?php echo esc_attr($color); ?>" class="ht-countdown-hook" data-date="<?php echo esc_attr($datetime); ?>" data-day-text="<?php echo esc_attr($day_text); ?>" data-hour-text="<?php echo esc_attr($hour_text); ?>" data-min-text="<?php echo esc_attr($min_text); ?>" data-sec-text="<?php echo esc_attr($sec_text); ?>">

            </div>

        </div>
        <!-- /countdown-group -->
    </div>
<?php elseif( isset($atts['style']) && $atts['style'] == 'square' ): ?>
    <div class="time-countdown-wrapper square">
        <div class="countdown-group">
            <div style="color: <?php echo esc_attr($color); ?>" class="ht-countdown-hook" data-date="<?php echo esc_attr($datetime); ?>" data-day-text="<?php echo esc_attr($day_text); ?>" data-hour-text="<?php echo esc_attr($hour_text); ?>" data-min-text="<?php echo esc_attr($min_text); ?>" data-sec-text="<?php echo esc_attr($sec_text); ?>">

            </div>

        </div>
        <!-- /countdown-group -->
    </div>
<?php elseif( isset($atts['style']) && $atts['style'] == 'basic' ): ?>
<div class="time-countdown-wrapper">
    <div class="countdown-group">
        <div style="color: <?php echo esc_attr($color); ?>" class="ht-countdown-hook" data-date="<?php echo esc_attr($datetime); ?>" data-day-text="<?php echo esc_attr($day_text); ?>" data-hour-text="<?php echo esc_attr($hour_text); ?>" data-min-text="<?php echo esc_attr($min_text); ?>" data-sec-text="<?php echo esc_attr($sec_text); ?>"></div>

    </div>
    <!-- /countdown-group -->
</div>
<?php else: ?>
<div class="coundown-group">
    <div class="pane-left">
        <div class="desc">
            <?php echo html_entity_decode($atts['desc']); ?>
        </div>
        <div class="time-countdown-wrapper">
            <div class="countdown-group">
                <div class="ht-countdown-hook" data-date="<?php echo esc_attr($datetime); ?>" data-day-text="<?php echo esc_attr($day_text); ?>" data-hour-text="<?php echo esc_attr($hour_text); ?>" data-min-text="<?php echo esc_attr($min_text); ?>" data-sec-text="<?php echo esc_attr($sec_text); ?>"></div>

            </div>
            <!-- /countdown-group -->
        </div>
        <a href="<?php echo esc_url($atts['btn_url']); ?>" class="btn btn-circle secondary"><?php echo esc_html($atts['btn_label']); ?></a>
    </div>
    <div class="pane-right">
        <div class="video-wrapper">
            <?php
                if( strlen($atts['video']) == 11 ){
                    echo '<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'.esc_attr($atts['video']).'"></iframe>
						</div>';
                }
                if( strlen($atts['video']) == 9 ){
                    echo '<div class="embed-responsive embed-responsive-16by9" ">
							<iframe class="embed-responsive-item" src="//player.vimeo.com/video/'.esc_attr($atts['video']).'?color=ffffff" width="500" height="450"></iframe>
						</div>';
                }
            ?>
        </div>
        <div class="video-desc">
            <?php echo html_entity_decode($atts['video_desc']); ?>
        </div>
    </div>
</div>
<?php endif; ?>
<script>
    jQuery(document).ready(function(JQuery){
        jQuery('.ht-countdown-hook').each(function() {
            var $thisCountDown = jQuery(this);
            var dayText = ($thisCountDown.data('day-text') == undefined) ? 'days' : $thisCountDown.data('day-text');
            var hourText = ($thisCountDown.data('hour-text') == undefined) ? 'hours' : $thisCountDown.data('hour-text');
            var minText = ($thisCountDown.data('min-text') == undefined) ? 'minutes' : $thisCountDown.data('min-text');
            var secText = ($thisCountDown.data('sec-text') == undefined) ? 'secconds' : $thisCountDown.data('sec-text');
            if( secText == '' ){
                $thisCountDown.countdown({
                    date: jQuery(this).data('date'),
                    refresh: 1000*60,
                    render: function(data) {
                        jQuery(this.el).html(
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(((data.years > 0) ? data.years * 365 : data.days) , 2) + "</span><span class='indicator'>" + dayText + " </span></span>"+
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.hours, 2) + " </span><span class='indicator'> " + hourText + "</span></span>"+
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.min, 2) + " </span><span class='indicator'>" + minText + "</span></span>");
                    }
                });
            }else{
                $thisCountDown.countdown({
                date: jQuery(this).data('date'),
                refresh: 1000,
                render: function(data) {
                    jQuery(this.el).html(
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(((data.years > 0) ? data.years * 365 : data.days) , 2) + "</span><span class='indicator'>" + dayText + " </span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.hours, 2) + " </span><span class='indicator'> " + hourText + "</span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.min, 2) + " </span><span class='indicator'>" + minText + "</span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.sec, 2) + " </span><span class='indicator'>" + secText + "</span></span>");
                }
            });
            }
        })
    });
</script>
