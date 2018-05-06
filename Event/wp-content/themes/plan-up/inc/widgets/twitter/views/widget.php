<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

/**
 * @var $number
 * @var $before_widget
 * @var $after_widget
 * @var $title
 * @var $tweets
 */

echo html_entity_decode($before_widget);
echo html_entity_decode($title);
?>
	<div class="wrap-twitter feed">
		<div class="tweet-navigation">
			<?php
				$i = 0;
				foreach ( $tweets as $tweet ) {
					if( $i == 0 ){
						echo '<a href="'.esc_attr($tweet->id_str).'" class="current" title="tweet"></a>';
					}else{
						echo '<a href="'.esc_attr($tweet->id_str).'" title="tweet"></a>';
					}
					$i++;
				}
			?>
		</div>
		<div class="tweets">
			<?php
				foreach ( $tweets as $tweet ) {
					$tuser = $tweet->user;
					$id = $tweet->id_str;
					$text = $tweet->text;
					?>
					<div class="tweet-entry entry<?php echo esc_attr($id); ?>">
						<div class="tw-head">
							<div class="tw-user">
								<img src="<?php echo esc_url($tuser->profile_image_url); ?>" alt="profile image">
								<h3 class="tw-name"><?php echo esc_html($tuser->screen_name); ?></h3>
								<p class="tw-desc"><?php echo esc_html($tuser->description); ?></p>
							</div>
							<!-- /user -->
							<div class="tw-follow">
								<a target="_blank" href="https://twitter.com/intent/user?screen_name=<?php echo esc_html($tuser->screen_name); ?>"><i class="fa fa-twitter"></i><?php esc_html_e('Follow', 'plan-up'); ?></a>
							</div>
						</div>
						<!-- /head -->
						<div class="tw-body">
							<?php
								$matches_t = array();
								$matches_l = array();
								preg_match('/(http[s]?:\/\/)?([^\/\s]+\/)(.*)/', $text, $matches_l);
								preg_match('/(?=@)(.*?)(?= )/', $text, $matches_t);
								if( !empty($matches_l) )
									$text = str_replace($matches_l[0], '<a href="'.$matches_l[0].'">'.$matches_l[0].'</a>', $text);
								if( !empty($matches_t) )
									$text = str_replace($matches_t[0], '<a href="http://twitter.com/'.$matches_t[0].'">'.$matches_t[0].'</a>', $text);
							?>
							<?php echo html_entity_decode($text); ?>
						</div>
						<!-- /body -->
						<div class="tw-footer">
							<a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to=<?php echo esc_attr($id); ?>" title="Reply"><i class="fa fa-reply"></i></a>
							<a target="_blank" href="https://twitter.com/intent/retweet?tweet_id=<?php echo esc_attr($id); ?>" title="Retweet"><i class="fa fa-retweet"></i></a>
							<a target="_blank" href="https://twitter.com/intent/favorite?tweet_id=<?php echo esc_attr($id); ?>" title="Favorite"><i class="fa fa-star"></i> <?php echo esc_html($tweet->favorite_count); ?></a>
						</div>
						<!-- /footer -->
					</div>
			<?php
				}
			?>
		</div>
	</div>
<?php echo html_entity_decode($after_widget); ?>