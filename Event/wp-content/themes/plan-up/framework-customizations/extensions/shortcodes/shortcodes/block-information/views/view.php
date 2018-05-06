<?php if (!defined('FW')) die('Forbidden');

/**
 * @var $atts The shortcode attributes
 */

$content = $atts['content'];
$title = $atts['title'];

?>
<div class="fw-block-info">
<h3 class="info-heading"><?php echo html_entity_decode('<i class="'.$atts['icon'].'"></i>')." "; echo esc_html($title); ?></h3>
<div class="info-text"><?php echo html_entity_decode($content); ?></div>
</div>
