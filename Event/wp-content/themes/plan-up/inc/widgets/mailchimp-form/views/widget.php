<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 * @var string $title
 * @var string $mc_action
 * @var string $mc_btn_label
 * @var string $name_label
 * @var string $mail_label
 * @var string $desc
 */

echo html_entity_decode($before_widget);
echo html_entity_decode($title);
?>
<div class="desctiption">
    <?php echo html_entity_decode($desc); ?>
</div>
<form action="<?php echo esc_url($mc_action); ?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form">
    <input value="" placeholder="<?php echo esc_attr($name_label); ?>" name="FNAME" id="mce-FNAME" type="text">
    <input value="" placeholder="<?php echo esc_attr($mail_label); ?>" name="EMAIL" class="required email" id="mce-EMAIL" type="email">
    <button id="mc-embedded-subscribe" type="submit" name="subscribe" class="ht-btn"><?php echo esc_html($mc_btn_label); ?></button>
</form>
<?php
echo html_entity_decode($after_widget);