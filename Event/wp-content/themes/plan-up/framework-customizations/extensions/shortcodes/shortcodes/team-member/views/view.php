<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

if ( empty( $atts['image'] ) ) {
	$image = fw_get_framework_directory_uri('/static/img/no-image.png');
} else {
	$image = $atts['image']['url'];
}

$name = $atts['name'];
$position = $atts['job'];
$social = $atts['desc'];
$desc = $atts['desc_2'];
$url = $atts['url'];

if( isset($atts['speaker']) && !empty($atts['speaker']) ){
	$speakers = $atts['speaker'];
	if( isset($speakers[0]) && $speakers[0] != '' ){
		$speaker_id = $speakers[0];
		$speaker = get_post( $speaker_id );
		$name = fw_get_db_post_option($speaker_id,'name',$speaker->post_title);
		$position = fw_get_db_post_option($speaker_id,'position','');
		$social = fw_get_db_post_option($speaker_id,'social','');
		$desc = wpautop( $speaker->post_content, true );
		$url = '#';
		$image = wp_get_attachment_image_src( get_post_thumbnail_id($speaker_id), 'full');
		$image = $image[0];
	}
}

?>
<?php if( isset($atts['style']) && $atts['style'] == '0' ): ?>
<div class="fw-team style-normal">
	<div class="fw-team-image"><img src="<?php echo esc_attr($image); ?>" alt="<?php echo esc_attr($atts['name']); ?>"/></div>
	<div class="fw-team-inner">
		<div class="fw-team-name">
			<h4><a href="#" class="team-url heading"><?php echo esc_html($name); ?></a></h4>
			<span><?php echo esc_html($position); ?></span>
		</div>
		<div class="fw-team-text">
			<p><?php echo html_entity_decode($social); ?></p>
		</div>
		<div class="fw-team-desc">
			<?php
			if( isset($desc) && $desc != '' ):
				echo html_entity_decode($desc);
			endif; ?>
		</div>
	</div>
</div>
<?php else: ?>
	<div class="fw-team style-theme">
		<div class="fw-team-image"><img src="<?php echo esc_attr($image); ?>" alt="<?php echo esc_attr($name); ?>"/></div>
		<div class="fw-team-inner">
			<div class="fw-team-name">
				<h4><?php echo esc_html($name); ?></h4>
				<span class="team-position"><?php echo esc_html($position); ?></span>
				<p class="team-desc"><?php echo html_entity_decode($social); ?></p>
			</div>
			<div class="fw-team-desc">
				<?php
				if( isset($desc) && $desc != '' ):
					echo html_entity_decode($desc);
				endif; ?>
			</div>
		</div>
		<a href="<?php echo esc_url($url); ?>" class="team-url"><i class="ion-ios-plus-empty"></i></a>
	</div>
<?php endif; ?>