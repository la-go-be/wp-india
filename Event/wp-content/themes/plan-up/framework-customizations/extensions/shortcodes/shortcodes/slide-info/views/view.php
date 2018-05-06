<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

$entries = $atts['info'];


?>
<div class="ht-carousel slide-info" data-loop="true" data-auto="true" data-navi="true" data-pager="false" data-animation-speed="1000" data-slide-speed="5000" data-items="[1,2,2,3,3]">
    <div class="container text-center slides-ajax-loading">
        <br><br><br>
        <img src="<?php echo get_template_directory_uri()."/images/ajax-loader.gif"; ?>">
        <br><br><br>
    </div>
    <ul class="slides" style="display: none;">
        <?php foreach ((array)$entries as $key => $value) {
    ?>
            <li>
                <div class="slider-inner fw-block-info">
                    <div class="info-text">
                        <?php echo html_entity_decode($value['content']); ?>
                    </div>
                </div>
            </li>
    <?php
        } ?>
    </ul>
</div>