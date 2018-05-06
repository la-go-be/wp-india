<?php if (!defined('FW')) die( 'Forbidden' );
$datetime = $atts['datetime'];
$day_text = $atts['day_text'];
$hour_text = $atts['hour_text'];
$min_text = $atts['min_text'];
$sec_text = $atts['sec_text'];
$color = $atts['color'];
$direction = isset($atts['direction']) ? $atts['direction'] : 'vertical';


if ( isset($atts['slide']) && !empty($atts['slide']) ): ?>
    <div class="header-has-slide">

<?php
    $slide_ID = $atts['slide']['0'];

    $galleries = fw_get_db_post_option($slide_ID);
    $galleries = $galleries['custom-slides'];
    $slide_ID = uniqid()."slide";
    ?>
        <div id="flexslider-<?php echo esc_attr($slide_ID); ?>" class="flexslider basic header-slider <?php echo isset($atts['direction']) ? $atts['direction'].'-direction' : 'vertical-direction'; ?>" data-sync="#syn-<?php echo esc_attr($slide_ID); ?>" data-auto="true" data-effect="slide" data-navi="true" data-pager="true" data-slide-speed="9000" data-animation-speed="1000" data-direction="<?php echo esc_html($direction); ?>">
            <div class="container text-center slides-ajax-loading">
                <br><br><br><br><br>
                <img src="<?php echo get_template_directory_uri()."/images/ajax-loader.gif"; ?>">
                <br><br><br><br>
            </div>
            <ul class="slides" style="display: none;">
            <?php
                foreach ((array)$galleries as $gallery) {
                    $img = $gallery['multimedia']['image']['src'];
                    $extra = $gallery['extra-options'];
                    $g_url = wp_get_attachment_image_src( $img['attachment_id'], 'slider', false ); ?>
                    <li style="background: url(<?php echo esc_url($g_url['0']); ?>) center center /cover;" class="slide-entry">
                        <div class="container">
                            <div class="fw-row">
                                <div class="fw-col-md-7 fw-col-sm-9">
                                    <div class="slider-caption">
                                        <p class="slide-desc"><?php echo html_entity_decode($gallery['desc']); ?></p>
                                        <h2 class="slide-title"><?php echo html_entity_decode($gallery['title']); ?></h2>
                                        <p class="slide-desc2"><?php echo html_entity_decode($gallery['extra-options']['subtitle']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="fw-row">
                                <div class="fw-col-sm-12">
                                    <?php if( isset($atts['share_links']) && !empty($atts['share_links']) ):
                                    ?>
                                        <p class="slide-share">
                                            <img src="<?php echo esc_url(get_template_directory_uri()."/images/arrow-slide.png"); ?>" alt="Share">
                                            <span><?php echo esc_html($atts['share_label']."&nbsp;&nbsp;&nbsp;"); ?>
                                                <?php foreach ((array)$atts['share_links'] as $k => $v) {
                                                    ?>
                                                        <a href="<?php echo esc_url($v); ?>"></a>
                                                    <?php
                                                } ?>
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php
                }
            ?>
            </ul>
        </div>
    </div>
    <!-- /countdown-wrapper -->
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
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(((data.years > 0) ? data.years * 365 : data.days) , 3) + "</span><br><span class='indicator'>" + dayText + " </span></span>"+
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.hours, 2) + " </span><br><span class='indicator'> " + hourText + "</span></span>"+
                            "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.min, 2) + " </span><br><span class='indicator'>" + minText + "</span></span>");
                    }
                });
            }else{
                $thisCountDown.countdown({
                date: jQuery(this).data('date'),
                refresh: 1000,
                render: function(data) {
                    jQuery(this.el).html(
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(((data.years > 0) ? data.years * 365 : data.days) , 3) + "</span><br><span class='indicator'>" + dayText + " </span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.hours, 2) + " </span><br><span class='indicator'> " + hourText + "</span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.min, 2) + " </span><br><span class='indicator'>" + minText + "</span></span>"+
                        "<span class='ht_countdown_section'><span class='value'>" + this.leadingZeros(data.sec, 2) + " </span><br><span class='indicator'>" + secText + "</span></span>");
                }
            });
            }
        })
    });
</script>