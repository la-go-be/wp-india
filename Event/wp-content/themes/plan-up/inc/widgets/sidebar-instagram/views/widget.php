<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * @var $number
 * @var $before_widget
 * @var $after_widget
 * @var $title
 * @var $user_id
 * @var $access_token
 * @var $client_id
 */

echo html_entity_decode($before_widget);
echo html_entity_decode($title);
?>
<div class="widget-content">
	<div class="row">
		<script>
			jQuery(document).ready(function($) {
				var feed = new Instafeed({
			        get: 'user',
					userId: <?php echo esc_html($user_id); ?>,
					limit: <?php echo esc_html($number); ?>,
					accessToken: '<?php echo esc_js($access_token); ?>',
			        clientId: '<?php echo esc_js($client_id); ?>',
			        template: '<a class="entry" target="_blank" href="{{link}}"><img src="{{image}}" /></a>'
			    });
			    feed.run();
			});
		</script>
		<div id="instafeed"></div>
	</div>
</div>
<?php echo html_entity_decode($after_widget); ?>