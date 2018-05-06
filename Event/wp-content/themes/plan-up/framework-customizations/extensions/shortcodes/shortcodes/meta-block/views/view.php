<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

?>
<div class="ht-meta-block">
    <ul>
        <?php foreach ((array)$atts['meta_block'] as $key => $value) {
    ?>
            <li>
                <i class="<?php echo esc_attr($value['icon']); ?>"></i>
                <p><?php echo esc_html($value['title']); ?><br><span><?php echo esc_html($value['sub-title']); ?></span></p>
            </li>
    <?php
        } ?>
    </ul>
</div>
