<?php if (!defined('FW')) die('Forbidden'); ?>

<?php if (isset($data['slides'])):
$galleries = $data['slides']; ?>
<div id="flexslider-<?php the_ID(); ?>" class="flexslider basic" data-sync="#syn-<?php the_ID(); ?>" data-auto="true" data-effect="fade" data-navi="true" data-pager="false" data-slide-speed="7000" data-animation-speed="1000">
	<ul class="slides">
	<?php
		foreach ($galleries as $gallery) {
			$g_url = wp_get_attachment_image_src( $gallery['attachment_id'], 'slider', false ); ?>
			<li style="background-image: url(<?php echo esc_url($g_url['0']); ?>); height: 550px;">
				<div class="container">
					<div class="fw-row">
						<div class="fw-col-md-12">
							<div class="slider-caption">
								<p class="slide-title"><?php echo html_entity_decode($gallery['title']); ?></p>
								<p class="slide-desc"><?php echo html_entity_decode($gallery['desc']); ?></p>
								<p class="slide-desc2"><?php echo html_entity_decode($gallery['extra']['subtitle']); ?></p>
							</div>
						</div>
					</div>
				</div>
			</li>
		<?php
		}
	?>
	</ul>
</div>
<?php endif; ?>