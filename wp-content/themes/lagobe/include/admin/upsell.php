<?php
/**
 * Upsell page
 *
 * @package    Hoot
 * @subpackage Creattica
 */

/** Determine whether to load upsell subpage **/
$premium_features_file = HYBRIDEXTEND_INC . 'admin/premium.php';
$hoot_load_upsell_subpage = apply_filters( 'hoot_load_upsell_subpage', file_exists( $premium_features_file ) );
if ( !$hoot_load_upsell_subpage )
	return;

/* Add the admin setup function to the 'admin_menu' hook. */
add_action( 'admin_menu', 'hoot_appearance_subpage' );

/**
 * Sets up the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_appearance_subpage() {

	add_theme_page(
		__( 'Creattica Premium', 'creattica' ),	// Page Title
		__( 'Premium Options', 'creattica' ),	// Menu Title
		'edit_theme_options',					// capability
		'creattica-premium',					// menu-slug
		'hoot_theme_appearance_subpage'			// function name
		);

	add_action( 'admin_enqueue_scripts', 'hoot_admin_enqueue_upsell_styles' );

}

/**
 * Enqueue CSS
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_admin_enqueue_upsell_styles( $hook ) {
	if ( $hook == 'appearance_page_creattica-premium' )
		wp_enqueue_style( 'hoot-admin-upsell', HYBRIDEXTEND_INCURI . 'admin/css/upsell.css', array(),  HYBRIDEXTEND_VERSION );
}

/**
 * Display the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function hoot_theme_appearance_subpage() {
	/** Load Premium Features Data **/
	include_once( HYBRIDEXTEND_INC . 'admin/premium.php' );

	/** Display Premium Teasers **/
	$hoot_cta = ( empty( $hoot_cta ) ) ? '<a class="button button-primary button-buy-premium" href="http://wphoot.com/" target="_blank">' . __( 'Click here', 'creattica' ) . '</a>' : $hoot_cta;
	$hoot_cta_top = ( empty( $hoot_cta_top ) ) ? $hoot_cta : $hoot_cta_top;
	$hoot_intro = ( !empty( $hoot_intro ) && is_array( $hoot_intro ) ) ? $hoot_intro : array();
	$hoot_intro = wp_parse_args( $hoot_intro, array(
		'name' => __('Upgrade to Premium', 'creattica'),
		'desc' => '',
		) );
	?>
	<div id="hoot-upsell" class="wrap">
		<h1 class="centered"><?php echo $hoot_intro['name']; ?></h1>
		<p class="hoot-upsell-intro centered"><?php echo $hoot_intro['desc']; ?></p>
		<p class="hoot-upsell-cta centered"><?php echo $hoot_cta_top; ?></p>
		<?php if ( !empty( $hoot_cta_demo ) ) echo '<p class="hoot-upsell-demo centered">' . $hoot_cta_demo . '</p>'; ?>
		<?php if ( !empty( $hoot_options_premium ) && is_array( $hoot_options_premium ) ): ?>
			<div class="hoot-upsell-sub">
				<?php foreach ( $hoot_options_premium as $key => $feature ) : ?>
					<div class="section-premium-info">
						<?php if ( !empty( $feature['desc'] ) ) : ?>
							<div class="premium-info">
								<div class="premium-info-text">
									<?php if ( !empty( $feature['name'] ) ) : ?>
										<h4 class="heading"><?php echo $feature['name']; ?></h4>
									<?php endif; ?>
									<?php echo $feature['desc']; ?>
								</div>
								<?php if ( !empty( $feature['img'] ) ) : ?>
									<div class="premium-info-img">
										<img src="<?php echo esc_url( $feature['img'] ); ?>" />
									</div>
								<?php endif; ?>
								<div class="clear"></div>
							</div>
						<?php elseif ( !empty( $feature['name'] ) ) : ?>
							<h4 class="heading"><?php echo $feature['name']; ?></h4>
						<?php endif; ?>
						<?php if ( !empty( $feature['std'] ) ) echo $feature['std']; ?>
					</div>
				<?php endforeach; ?>
				<div class="section-premium-info hoot-upsell-cta centered"><?php echo $hoot_cta; ?></p>
			</div>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Reorder subpage in the appearance menu.
 *
 * @since 1.0
 */
function hoot_appearance_subpage_reorder() {
	global $submenu;
	$menu_slug = 'creattica-premium';
	$index = '';

	if ( !isset( $submenu['themes.php'] ) ) {
		// probably current user doesn't have this item in menu
		return;
	}

	foreach ( $submenu['themes.php'] as $key => $sm ) {
		if ( $sm[2] == $menu_slug ) {
			$index = $key;
			break;
		}
	}

	if ( ! empty( $index ) ) {
		//$item = $submenu['themes.php'][ $index ];
		//unset( $submenu['themes.php'][ $index ] );
		//array_splice( $submenu['themes.php'], 1, 0, array($item) );

		/* array_splice does not preserve numeric keys, so instead we do our own rearranging. */
		$smthemes = array();
		foreach ( $submenu['themes.php'] as $key => $sm ) {
			if ( $key != $index ) {
				$setkey = $key;
				for ( $i = $key; $i < 1000; $i++ ) { 
					if( !isset( $smthemes[$i] ) ) {
						$setkey = $i;
						break;
					}
				}
				$smthemes[ $setkey ] = $sm;
				if ( $sm[2] == 'themes.php' ) {
					$smthemes[ $setkey + 1 ] = $submenu['themes.php'][ $index ];
				}
			}
		}
		$submenu['themes.php'] = $smthemes;
	}

}
add_action( 'admin_menu', 'hoot_appearance_subpage_reorder', 9999 );