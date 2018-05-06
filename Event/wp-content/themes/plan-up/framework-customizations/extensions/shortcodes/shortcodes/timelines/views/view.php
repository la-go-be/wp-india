<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

// $content = $atts['content'];
$timelines = $atts['timelines'];
?>
<div class="timelines-container">
    <div class="timelines-navigation">
        <?php
            foreach ((array)$timelines as $key => $value) {
                if( $key == 0 ){
                    echo '<a class="active" href="#period-'.$key.'">'.esc_html($value['tm_date']).'</a>';
                }else{
                    echo '<a href="#period-'.$key.'">'.esc_html($value['tm_date']).'</a>';
                }
             }
        ?>
    </div>
    <?php
        $j = 1;
        foreach ((array)$timelines as $key => $value) {
    ?>
        <ul class="timeline" id="period-<?php echo esc_attr($key); ?>">
            <?php
                $i = 0;
                foreach ((array)$value['tm-entries'] as $k => $v) {
                    $i++;
                    if( $i%2 != 0 ){
                        $iv = '';
                    }else{
                        $iv = 'class="timeline-inverted"';
                    }
            ?>
                    <li <?php echo html_entity_decode($iv); ?>>
                        <div class="timeline-badge"></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-date"><?php  echo esc_html($v['time']); ?></h4>
                                <h4 class="timeline-place"><?php  echo esc_html($v['place']); ?></h4>
                            </div>
                            <div class="timeline-body">
                                <?php echo html_entity_decode($v['content']) ?>
                            </div>
                        </div>
                    </li>
            <?php
                }
                if( $j < count($timelines) ){
            ?>
                    <li>
                        <div class="timeline-badge warning">
                            <a  href="<?php echo '#period-'.$j; ?>"><i class="ion-ios-plus-empty"></i></a>
                        </div>
                    </li>
            <?php
                }
            ?>
        </ul>
    <?php
            $j++;
        }
    ?>
</div>