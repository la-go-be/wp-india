<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * @var $number
 * @var $before_widget
 * @var $after_widget
 * @var $title
 * @var $flickr_id
 */

echo html_entity_decode($before_widget);
echo html_entity_decode($title);
?>
<div class="widget-content">
	<div class="row">
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_attr($number); ?>&amp;display=lastest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_attr($flickr_id); ?>"></script>
	</div>
</div>
<?php echo html_entity_decode($after_widget); ?>