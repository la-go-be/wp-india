<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

$tl = $atts['timeline2'];
?>
<?php if(!empty($tl)){ ?>
    <div class="tl2">
        <div class="tl2-nav">
            <?php foreach($tl as $key => $value){ ?>
                <a <?php if($key==0){ echo 'class="tl2-nav-current"'; } ?> href="#tl2-<?php echo esc_attr($key); ?>"><?php echo esc_html($value['tl_date']); ?></a>
            <?php } ?>
        </div>
        <div class="tl2-tabs">
            <?php foreach($tl as $keys => $values) { ?>
                <div class="tl2-content<?php if($keys==0){ echo ' tl2-content-current'; } ?>" id="tl2-<?php echo esc_attr($keys); ?>">
                    <?php foreach($values['tl_box'] as $ks => $vs) { ?>
                        <div class="tl-content-item">
                            <div class="tl-content-header">
                                <span class="tl-header-time"><?php echo esc_html($vs['tl_time']); ?></span>
                                <span class="tl-header-place"><?php echo esc_html($vs['tl_place']); ?></span>
                            </div>
                            <div class="tl-content-body">
                                <?php echo wp_kses($vs['tl_content'], array(
                                    'h3' => array(),
                                    'a' => array('href' => array()),
                                    'span' => array(),
                                    'p' => array()
                                )); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>