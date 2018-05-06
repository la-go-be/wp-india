<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * @var string $before_widget
 * @var string $after_widget
 * @var string $banner_url
 * @var string $des_url
 */

echo html_entity_decode($before_widget);
?>
<div class="banner-ad">
    <a href="<?php echo esc_url($des_url); ?>" target="_blank">
        <span class="overlay"></span>
        <img src="<?php echo esc_url($banner_url); ?>" alt="">
    </a>
</div>
<?php
echo html_entity_decode($after_widget);