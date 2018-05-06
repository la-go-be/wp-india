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
	<div class="wrap-flickr">
		<ul>
			<script type="text/javascript"
			        src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo esc_html($number); ?>&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo esc_html($flickr_id); ?>"></script>
		</ul>
	</div>
<?php echo html_entity_decode($after_widget); ?>