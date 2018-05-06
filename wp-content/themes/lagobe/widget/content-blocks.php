<?php
// Return if no boxes to show
if ( empty( $boxes ) || !is_array( $boxes ) )
	return;

// Get border classes
$top_class = hoot_widget_border_class( $border, 0, 'topborder-');
$bottom_class = hoot_widget_border_class( $border, 1, 'bottomborder-');

// Get total columns and set column counter
$columns = ( intval( $columns ) >= 1 && intval( $columns ) <= 5 ) ? intval( $columns ) : 3;
$column = 1;

// Set clearfix to avoid error if there are no boxes
$clearfix = 1;

// Set user defined style for content boxes
$userstyle = $style;

// Create a custom WP Query
$page_ids = array();
foreach ( $boxes as $key => $box ) {
	$box['page'] = ( isset( $box['page'] ) ) ? intval( $box['page'] ) : '';
	if ( !empty( $box['page'] ) )
		$page_ids[] = $box['page'];
}
if ( empty( $page_ids ) )
	return; // If $page_ids is empty, custom query below will return all posts
$content_blocks_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => $page_ids, 'posts_per_page' => -1, 'orderby' => 'post__in' ) );

// Temporarily remove read more links from excerpts
hoot_remove_readmore_link();

// Template modification Hook
do_action( 'hoot_content_blocks_wrap' );
?>

<div class="content-blocks-widget-wrap <?php echo sanitize_html_class( $top_class ); ?>">
	<div class="content-blocks-widget-box <?php echo sanitize_html_class( $bottom_class ); ?>">
		<div class="content-blocks-widget">

			<?php
			/* Display Title */
			if ( $title )
				echo wp_kses_post( apply_filters( 'hoot_content_blocks_title', $before_title . $title . $after_title, $title, $before_title, $after_title ) );

			// Template modification Hook
			do_action( 'hoot_content_blocks_start' );
			?>

			<div class="flush-columns">
				<?php
				foreach ( $boxes as $key => $box ) :
					if ( !empty( $box['page'] ) ) :

						global $post;
						$altPage = ( function_exists('pll_get_post') ) ? pll_get_post($box['page']) : $box['page'];

						foreach( $content_blocks_query->posts as $post ) :
							if ( $box['page'] == $post->ID || $altPage == $post->ID ) :

								// Init
								setup_postdata( $post );
								$visual = $visualtype = '';
								$box['icon_style'] = ( isset( $box['icon_style'] ) ) ? $box['icon_style'] : 'none';

								// Refresh user style (to add future op of diff styles for each block)
								$style = $userstyle;
								// Style-3 exceptions: doesnt work great with icons of 'None' style, or with images or with no visual at all. So revert to Style-2 for this scenario.
								if ( $style == 'style3' ) {
									if ( !empty( $box['icon'] ) ) {
										if ( $box['icon_style'] == 'none' ) $style = 'style2';
									} else $style = 'style2';
								}

								// Set image or icon
								if ( !empty( $box['icon'] ) ) {
									$visualtype = 'icon';
									$visual = '<i class="fa ' . sanitize_html_class( $box['icon'] ) . '"></i>';
								} elseif ( has_post_thumbnail() ) {
									$visualtype = 'image';
									if ( $style == 'style4' ) {
										switch ( $columns ) {
											case 1: $img_size = 2; break;
											case 2: $img_size = 4; break;
											default: $img_size = 5;
										}
									} else {
										$img_size = $columns;
									}
									$img_size = hoot_thumbnail_size( 'column-1-' . $img_size );
									$img_size = apply_filters( 'content_block_img', $img_size );
									$visual = 1;
								}

								// Set Block Class (if no visual for style 2/3, then dont highlight)
								$block_class = ( !empty( $visual ) && ( $style == 'style2' || $style == 'style3' ) ) ? 'highlight-typo' : 'no-highlight';

								// Set URL
								if ( !empty( $box['excerpt'] ) && empty( $box['url'] ) ) {
									$linktag = '<a href="' . get_permalink() . '" ' . hybridextend_get_attr( 'content-block-link', 'permalink' ) . '>';
									$linktagend = '</a>';
								} elseif ( !empty( $box['url'] ) ) {
									$linktag = '<a href="' . esc_url( $box['url'] ) . '" ' . hybridextend_get_attr( 'content-block-link', 'custom' ) . '>';
									$linktagend = '</a>';
								} else {
									$linktag = $linktagend = '';
								}

								// Start Block Display
								if ( $column == 1 ) echo '<div class="content-block-row">';
								?>

								<div class="content-block-column <?php echo 'column-1-' . $columns; ?> <?php echo sanitize_html_class( 'content-block-' . $style ); ?>">
									<div class="content-block <?php echo $block_class; ?>">

										<?php if ( $visualtype == 'image' ) : ?>
											<div class="content-block-visual content-block-image">
												<?php echo $linktag;
												hoot_post_thumbnail( 'content-block-img', $img_size );
												echo $linktagend; ?>
											</div>
										<?php elseif ( $visualtype == 'icon' ) : ?>
											<?php
											$contrast_class = ( 'none' == $box['icon_style'] || 'style4' == $style ) ? '' : ' accent-typo';
											$contrast_class = ( 'style3' == $style ) ? ' enforce-typo ' : $contrast_class;
											?>
											<div class="content-block-visual content-block-icon <?php echo 'icon-style-' . esc_attr( $box['icon_style'] ); echo $contrast_class; ?>">
												<?php echo $linktag . $visual . $linktagend; ?>
											</div>
										<?php endif; ?>

										<div class="content-block-content<?php
											if ( $visualtype == 'image' ) echo ' content-block-content-hasimage';
											elseif ( $visualtype == 'icon' ) echo ' content-block-content-hasicon';
											else echo ' no-visual';
											?>">
											<h4 class="content-block-title"><?php echo $linktag;
												the_title();
												echo $linktagend; ?></h4>
											<div class="content-block-text"><?php
												if ( empty( $box['excerpt'] ) )
													the_content();
												else
													the_excerpt();
												?></div>
											<?php if ( $linktag ) : ?>
												<?php
												$linktext = ( !empty( $box['link'] ) ) ? $box['link'] : hoot_get_mod('read_more');
												$linktext = ( empty( $linktext ) ) ? sprintf( __( 'Read More %s', 'creattica' ), '&rarr;' ) : $linktext;
												echo '<p class="more-link">' . $linktag . esc_html( $linktext ) . $linktagend . '</p>';
												?>
											<?php endif; ?>
										</div>

									</div>
								</div><?php

								if ( $column == $columns ) {
									echo '</div>';
									$column = $clearfix = 1;
								} else {
									$clearfix = false;
									$column++;
								}

								break;
							endif;
						endforeach;

						wp_reset_postdata();

					endif;
				endforeach;

				if ( !$clearfix ) echo '</div>';
				?>
			</div>

			<?php
			// Template modification Hook
			do_action( 'hoot_content_blocks_end' );
			?>

		</div>
	</div>
</div>

<?php
// Reinstate read more links to excerpts
hoot_reinstate_readmore_link();