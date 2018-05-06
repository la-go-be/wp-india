<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

if( isset($atts['tables']) && !empty($atts['tables']) ):
    echo '<div class="tables-group">';
    $tables = $atts['tables'];
    foreach ((array)$tables as $k => $v) {
        if( $v['typical'] == true ){
            $high = 'highlighted';
        }else{
            $high = '';
        }
    ?>
        <div class="table-entry <?php echo esc_attr($high); ?>">
            <div class="table-icon-wrapper">
                <i class="<?php echo esc_attr($v['icon']); ?> icon"></i>
            </div>
            <div class="table-name-wrapper">
                <a href="<?php echo esc_url($v['url']); ?>" class="table-name"><?php echo esc_html($v['name']); ?></a>
            </div>
            <div class="table-value-wrapper">
                <sub><?php echo esc_html(mauris_currency_symbol($v['currency'])); ?></sub>
                <p class="table-value"><?php echo esc_html($v['value']); ?></p>
                <small><?php echo esc_html($v['quantity']); ?></small>
            </div>
            <div class="table-desc-wrapper">
                <?php echo wpautop($v['desc'], true ); ?>
            </div>
        </div>
    <?php
    }
    echo '</div>';
endif;
?>
