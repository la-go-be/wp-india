<?php
/*
Plugin Name: WooCommerce Fly Cart
Description: WooCommerce interaction mini cart with many styles and effects.
Version: 1.2
Author: WPclever.net
Author URI: https://wpclever.net
Text Domain: woosmc
*/
if ( ! defined( 'ABSPATH' ) && ! class_exists( 'WooCommerce' ) ) {
	exit;
}
define( 'WOOSMC_URI', plugin_dir_url( __FILE__ ) );
define( 'WOOSMC_VERSION', '1.2' );
define( 'WOOSMC_PRO_URL', 'https://wpclever.net/downloads/woocommerce-fly-cart' );
define( 'WOOSMC_PRO_PRICE', '$19' );
include( 'inc/dashboard_widget.php' );
add_action( 'wp_footer', 'woosmc_wp_footer' );
add_action( 'wp_enqueue_scripts', 'woosmc_wp_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'woosmc_admin_enqueue_scripts' );
// Ajax get cart
add_action( 'wp_ajax_woosmc_get_cart', 'woosmc_get_cart' );
add_action( 'wp_ajax_nopriv_woosmc_get_cart', 'woosmc_get_cart' );
// Ajax update qty
add_action( 'wp_ajax_woosmc_update_qty', 'woosmc_update_qty' );
add_action( 'wp_ajax_nopriv_woosmc_update_qty', 'woosmc_update_qty' );
// Ajax remove item
add_action( 'wp_ajax_woosmc_remove_item', 'woosmc_remove_item' );
add_action( 'wp_ajax_nopriv_woosmc_remove_item', 'woosmc_remove_item' );
// Add settings page
add_action( 'admin_menu', 'woosmc_settings_page' );
// Add settings link
add_filter( 'plugin_action_links', 'woosmc_settings_link', 10, 2 );
function woosmc_wp_enqueue_scripts() {
	// perfect srollbar
	wp_enqueue_style( 'perfect-scrollbar', WOOSMC_URI . 'assets/perfect-scrollbar/css/perfect-scrollbar.min.css' );
	wp_enqueue_style( 'perfect-scrollbar-theme', WOOSMC_URI . 'assets/perfect-scrollbar/css/custom-theme.css' );
	wp_enqueue_script( 'perfect-scrollbar', WOOSMC_URI . 'assets/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js', array( 'jquery' ), WOOSMC_VERSION, true );
	// main
	wp_enqueue_style( 'woosmc-fonts', WOOSMC_URI . 'assets/css/fonts.css' );
	wp_enqueue_style( 'woosmc-frontend', WOOSMC_URI . 'assets/css/frontend.css' );
	wp_enqueue_script( 'woosmc-frontend', WOOSMC_URI . 'assets/js/frontend.js', array( 'jquery' ), WOOSMC_VERSION, true );
	wp_localize_script( 'woosmc-frontend', 'woosmcVars', array(
			'ajaxurl'             => admin_url( 'admin-ajax.php' ),
			'nonce'               => wp_create_nonce( 'woosmc-security' ),
			'auto_show'           => get_option( '_woosmc_auto_show_ajax', 'yes' ),
			'manual_show'         => get_option( '_woosmc_manual_show', '' ),
			'reload'              => get_option( '_woosmc_reload', 'no' ),
			'hide_count_empty'    => get_option( '_woosmc_count_hide_empty', 'no' ),
			'hide_count_checkout' => get_option( '_woosmc_count_hide_checkout', 'no' ),
		)
	);
}

function woosmc_admin_enqueue_scripts( $hook ) {
	wp_enqueue_style( 'woosmc-backend', WOOSMC_URI . 'assets/css/backend.css' );
	if ( $hook == 'woocommerce_page_woosmc' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'woosmc-fonts', WOOSMC_URI . 'assets/css/fonts.css' );
		wp_enqueue_script( 'woosmc-backend', WOOSMC_URI . 'assets/js/backend.js', array(
			'jquery',
			'wp-color-picker'
		) );
	}
}

function woosmc_settings_page() {
	add_submenu_page( 'woocommerce', esc_html__( 'WooCommerce Fly Cart', 'woosmc' ), esc_html__( 'Fly Cart', 'woosmc' ), 'manage_options', 'woosmc', 'woosmc_settings_page_content' );
}

function woosmc_settings_link( $links, $file ) {
	static $plugin;
	if ( ! isset( $plugin ) ) {
		$plugin = plugin_basename( __FILE__ );
	}
	if ( $plugin == $file ) {
		$settings_link = '<a href="admin.php?page=woosmc">' . esc_html__( 'Settings', 'woosmc' ) . '</a>';
		$links[]       = '<a href="' . esc_url( WOOSMC_PRO_URL ) . '">' . esc_html__( 'Premium Version', 'woosmc' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}

function woosmc_settings_page_content() {
	$plugin_data = get_plugin_data( __FILE__ );
	?>
	<div class="wrap" id="woosmc-settings-page">

		<h1>
			<?php echo $plugin_data['Name'] . ' ' . $plugin_data['Version']; ?>
		</h1>
		<p>
			<?php echo $plugin_data['Description']; ?>
		</p>

		<form method="post" action="options.php">
			<?php wp_nonce_field( 'update-options' ) ?>
			<h2>Main Cart</h2>
			<table class="form-table">
				<tr>
					<th scope="row">Show on AJAX add to cart</th>
					<td>
						<select name="_woosmc_auto_show_ajax">
							<option
								value="yes" <?php echo( get_option( '_woosmc_auto_show_ajax', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_auto_show_ajax', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">The mini cart will be show up immediately after whenever click to AJAX Add to cart buttons (AJAX enable)? See <a
								href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ); ?>"
								target="_blank">"Add to cart behaviour" setting</a></span>
					</td>
				</tr>
				<tr>
					<th scope="row">Show on normal add to cart</th>
					<td>
						<select name="_woosmc_auto_show_normal">
							<option
								value="yes" <?php echo( get_option( '_woosmc_auto_show_normal', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_auto_show_normal', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">The mini cart will be show up immediately after whenever click to normal Add to cart buttons (AJAX is not enable) or Add to cart button in single product page?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Manual show up button</th>
					<td>
						<input type="text" name="_woosmc_manual_show"
						       value="<?php echo get_option( '_woosmc_manual_show', '' ); ?>"
						       placeholder="button class or id" />
						<p class="description">The class or id of the button, when click to this button the mini cart
							will be show up.<br />Example <code>.mini-cart-btn</code> or <code>#mini-cart-btn</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">Position</th>
					<td>
						<select name="_woosmc_position">
							<option
								value="01" <?php echo( get_option( '_woosmc_position', '05' ) == '01' ? 'selected' : '' ); ?>>
								01 - Right
							</option>
							<option
								value="02" <?php echo( get_option( '_woosmc_position', '05' ) == '02' ? 'selected' : '' ); ?>>
								02 - Left
							</option>
							<option
								value="03" <?php echo( get_option( '_woosmc_position', '05' ) == '03' ? 'selected' : '' ); ?>>
								03 - Top
							</option>
							<option
								value="04" <?php echo( get_option( '_woosmc_position', '05' ) == '04' ? 'selected' : '' ); ?>>
								04 - Bottom
							</option>
							<option
								value="05" <?php echo( get_option( '_woosmc_position', '05' ) == '05' ? 'selected' : '' ); ?>>
								05 - Center
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Style</th>
					<td>
						<select name="_woosmc_style">
							<option
								value="01" <?php echo( get_option( '_woosmc_style', '01' ) == '01' ? 'selected' : '' ); ?>>
								01 - Color background
							</option>
							<option
								value="02" <?php echo( get_option( '_woosmc_style', '01' ) == '02' ? 'selected' : '' ); ?>>
								02 - White background
							</option>
							<option
								value="03" <?php echo( get_option( '_woosmc_style', '01' ) == '03' ? 'selected' : '' ); ?>>
								03 - Color background, no thumbnail
							</option>
							<option
								value="04" <?php echo( get_option( '_woosmc_style', '01' ) == '04' ? 'selected' : '' ); ?>>
								04 - White background, no thumbnail
							</option>
							<option
								value="05" <?php echo( get_option( '_woosmc_style', '01' ) == '05' ? 'selected' : '' ); ?>>
								05 - Background image
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Color</th>
					<td>
						<input type="text" name="_woosmc_color" id="_woosmc_color"
						       value="<?php echo get_option( '_woosmc_color', '#cc6055' ); ?>"
						       class="woosmc_color_picker" />
						<p class="description">Background & text color, default <code>#cc6055</code></p>
					</td>
				</tr>
				<tr>
					<th scope="row">Background image</th>
					<td>
						<?php wp_enqueue_media(); ?>
						<img id="woosmc_image_preview"
						     src="<?php echo( get_option( '_woosmc_bg_image', '' ) != '' ? wp_get_attachment_url( get_option( '_woosmc_bg_image', '' ) ) : '' ); ?>"
						     width="100" height="100"
						     style="max-height: 100px; width: 100px; border-radius: 4px;">
						<input id="woosmc_upload_image_button" type="button" class="button"
						       value="<?php _e( 'Upload image' ); ?>" />
						<input type="hidden" name="_woosmc_bg_image" id="woosmc_image_attachment_url"
						       value="<?php echo get_option( '_woosmc_bg_image', '' ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">The cart heading</th>
					<td>
						<input type="text" name="_woosmc_cart_heading"
						       value="<?php echo get_option( '_woosmc_cart_heading', esc_html__( 'Shopping Cart', 'woosmc' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">Show close button</th>
					<td>
						<select name="_woosmc_close">
							<option
								value="yes" <?php echo( get_option( '_woosmc_close', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_close', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">Show the close button on the mini-cart?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Show attributes</th>
					<td>
						<select name="_woosmc_attributes">
							<option
								value="yes" <?php echo( get_option( '_woosmc_attributes', 'no' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_attributes', 'no' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span
							class="description">Show attributes of variation product under product title on the list?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Show total price</th>
					<td>
						<select name="_woosmc_total">
							<option
								value="yes" <?php echo( get_option( '_woosmc_total', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_total', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Show action buttons</th>
					<td>
						<select name="_woosmc_buttons">
							<option
								value="01" <?php echo( get_option( '_woosmc_buttons', '01' ) == '01' ? 'selected' : '' ); ?>>
								Cart & Checkout
							</option>
							<option
								value="02" <?php echo( get_option( '_woosmc_buttons', '01' ) == '02' ? 'selected' : '' ); ?>>
								Cart only
							</option>
							<option
								value="03" <?php echo( get_option( '_woosmc_buttons', '01' ) == '03' ? 'selected' : '' ); ?>>
								Checkout only
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Show continue shopping</th>
					<td>
						<select name="_woosmc_continue">
							<option
								value="yes" <?php echo( get_option( '_woosmc_continue', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_continue', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">Show the continue shopping button at the end of mini-cart?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Reload the cart</th>
					<td>
						<select name="_woosmc_reload">
							<option
								value="yes" <?php echo( get_option( '_woosmc_reload', 'no' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_reload', 'no' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">The cart will be reloaded when opening the page? If you use the cache for your site, please turn on this option.</span>
					</td>
				</tr>
			</table>
			<h2>Cart Button</h2>
			<p>
				This feature just available on <?php echo '<a href="' . esc_url( WOOSMC_PRO_URL ) . '">' . esc_html__( 'Premium Version', 'woosmc' ) . '</a>'; ?>
			</p>
			<table class="form-table">
				<tr>
					<th scope="row">Show cart button</th>
					<td>
						<select name="_woosmc_count">
							<option
								value="yes" <?php echo( get_option( '_woosmc_count', 'yes' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_count', 'yes' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Cart button position</th>
					<td>
						<select name="_woosmc_count_position">
							<option
								value="top-left" <?php echo( get_option( '_woosmc_count_position', 'bottom-left' ) == 'top-left' ? 'selected' : '' ); ?>>
								Top Left
							</option>
							<option
								value="top-right" <?php echo( get_option( '_woosmc_count_position', 'bottom-left' ) == 'top-right' ? 'selected' : '' ); ?>>
								Top Right
							</option>
							<option
								value="bottom-left" <?php echo( get_option( '_woosmc_count_position', 'bottom-left' ) == 'bottom-left' ? 'selected' : '' ); ?>>
								Bottom Left
							</option>
							<option
								value="bottom-right" <?php echo( get_option( '_woosmc_count_position', 'bottom-left' ) == 'bottom-right' ? 'selected' : '' ); ?>>
								Bottom Right
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Cart button icon</th>
					<td>
						<select id="woosmc_count_icon" name="_woosmc_count_icon">
							<?php
							for ( $i = 1; $i <= 16; $i ++ ) {
								if ( get_option( '_woosmc_count_icon', 'woosmc-icon-cart7' ) == 'woosmc-icon-cart' . $i ) {
									echo '<option value="woosmc-icon-cart' . $i . '" selected>woosmc-icon-cart' . $i . '</option>';
								} else {
									echo '<option value="woosmc-icon-cart' . $i . '">woosmc-icon-cart' . $i . '</option>';
								}
							}
							?>
						</select>
						<span class="description"><span id="woosmc_count_icon_view"></span></span>
					</td>
				</tr>
				<tr>
					<th scope="row">Hide if empty</th>
					<td>
						<select name="_woosmc_count_hide_empty">
							<option
								value="yes" <?php echo( get_option( '_woosmc_count_hide_empty', 'no' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_count_hide_empty', 'no' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">Hide the cart button if the cart empty?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">Hide in Cart & Checkout</th>
					<td>
						<select name="_woosmc_count_hide_checkout">
							<option
								value="yes" <?php echo( get_option( '_woosmc_count_hide_checkout', 'no' ) == 'yes' ? 'selected' : '' ); ?>>
								Yes
							</option>
							<option
								value="no" <?php echo( get_option( '_woosmc_count_hide_checkout', 'no' ) == 'no' ? 'selected' : '' ); ?>>
								No
							</option>
						</select>
						<span class="description">Hide the cart button in the Cart & Checkout page?</span>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="submit" name="Submit" class="button button-primary"
						       value="Update Options" />
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options"
						       value="_woosmc_auto_show_ajax,_woosmc_auto_show_normal,_woosmc_manual_show,_woosmc_position,_woosmc_style,_woosmc_color,_woosmc_bg_image,_woosmc_cart_heading,_woosmc_close,_woosmc_attributes,_woosmc_total,_woosmc_buttons,_woosmc_continue,_woosmc_reload,_woosmc_count,_woosmc_count_position,_woosmc_count_icon,_woosmc_count_hide_empty,_woosmc_count_hide_checkout" />
					</th>
					<td>&nbsp;</td>
				</tr>
			</table>
		</form>
	</div>
	<?php
}

function woosmc_update_qty() {
	if ( ! isset( $_POST['security'] ) || ( ! wp_verify_nonce( $_POST['security'], 'woosmc-security' ) && ( $_POST['security'] != $_POST['nonce'] ) ) ) {
		die( '<div class="woosmc-error">' . esc_html__( 'Permissions check failed!', 'woosmc' ) . '</div>' );
	}
	if ( isset( $_POST['cart_item_key'] ) && isset( $_POST['cart_item_qty'] ) ) {
		WC()->cart->set_quantity( $_POST['cart_item_key'], intval( $_POST['cart_item_qty'] ) );
		$cart             = array();
		$cart['subtotal'] = WC()->cart->get_cart_subtotal();
		echo json_encode( $cart );
		die();
	}
}

function woosmc_remove_item() {
	if ( ! isset( $_POST['security'] ) || ( ! wp_verify_nonce( $_POST['security'], 'woosmc-security' ) && ( $_POST['security'] != $_POST['nonce'] ) ) ) {
		die( '<div class="woosmc-error">' . esc_html__( 'Permissions check failed!', 'woosmc' ) . '</div>' );
	}
	if ( isset( $_POST['cart_item_key'] ) ) {
		WC()->cart->remove_cart_item( $_POST['cart_item_key'] );
		$cart             = array();
		$cart['subtotal'] = WC()->cart->get_cart_subtotal();
		echo json_encode( $cart );
		die();
	}
}

function woosmc_get_cart() {
	if ( ! isset( $_POST['security'] ) || ( ! wp_verify_nonce( $_POST['security'], 'woosmc-security' ) && ( $_POST['security'] != $_POST['nonce'] ) ) ) {
		die( '<div class="woosmc-error">' . esc_html__( 'Permissions check failed!', 'woosmc' ) . '</div>' );
	}
	$cart          = array();
	$cart['html']  = woosmc_get_cart_items( esc_attr( get_option( '_woosmc_style', '01' ) ) );
	echo json_encode( $cart );
	die();
}

function woosmc_show_cart() {
	$cart_html = woosmc_get_cart_items( esc_attr( get_option( '_woosmc_style', '01' ) ) );

	return $cart_html;
}

function woosmc_get_cart_items( $style = '01' ) {
	$cart_html = '';
	$cart_html .= '<div class="woosmc-area-top"><span>' . get_option( '_woosmc_cart_heading', esc_html__( 'Shopping Cart', 'woosmc' ) ) . '</span>';
	if ( get_option( '_woosmc_close', 'yes' ) == 'yes' ) {
		$cart_html .= '<div class="woosmc-close"><i class="woosmc-icon-icon10"></i></div>';
	}
	$cart_html .= '</div>';
	$items = WC()->cart->get_cart();
	if ( sizeof( $items ) > 0 ) {
		$items = array_reverse( $items );
		$cart_html .= '<div class="woosmc-area-mid woosmc-items">';
		foreach ( $items as $cart_item_key => $cart_item ) {
			$_product          = $cart_item['data'];
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			if ( $_product->is_visible() ) {
				if ( $_product->is_sold_individually() ) {
					$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
				} else {
					$product_quantity = woocommerce_quantity_input( array(
						'input_name'  => "{$cart_item_key}",
						'input_value' => $cart_item['quantity'],
						'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
						'min_value'   => '0',
					), $_product, false );
				}
				if ( ( $style == '03' ) || ( $style == '04' ) ) {
					$cart_html .= '<div data-key="' . $cart_item_key . '" class="woosmc-item"><div class="woosmc-item-inner">';
					$cart_html .= '<div class="woosmc-item-qty"><div class="woosmc-item-qty-inner"><span class="woosmc-item-qty-plus">+</span>' . apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ) . '<span class="woosmc-item-qty-minus">-</span></div></div>';
					//$cart_html .= '<div class="woosmc-item-qty"><div class="woosmc-item-qty-inner"><span class="woosmc-item-qty-plus">+</span><input class="woosmc-item-qty-input" type="number" value="' . $cart_item['quantity'] . '" step="1" min="1" max="' . $_product->get_stock_quantity() . '" data-key="' . $cart_item_key . '"/><span class="woosmc-item-qty-minus">-</span></div></div>';
					$cart_html .= '<div class="woosmc-item-info">';
					$cart_html .= '<span class="woosmc-item-title">';
					if ( ! $product_permalink ) {
						$cart_html .= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						$cart_html .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
					}
					$cart_html .= '</span>';
					if ( ( get_option( '_woosmc_attributes', 'no' ) == 'yes' ) && $_product->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
						if ( count( $_product->get_variation_attributes() ) > 0 ) {
							$cart_html .= '<span class="woosmc-item-data">';
							foreach ( $_product->get_variation_attributes() as $key => $value ) {
								$cart_html .= '<span class="woosmc-item-data-attr">' . wc_attribute_label( str_replace( 'attribute_', '', $key ), $_product ) . ': ' . $value . '</span>';
							}
							$cart_html .= '</span>';
						}
					}
					$cart_html .= '</div>';
					$cart_html .= '<div class="woosmc-item-price">' . apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) . '</div>';
					$cart_html .= '<span class="woosmc-item-remove" data-key="' . $cart_item_key . '"></span></div></div>';
				} else {
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$cart_html .= '<div data-key="' . $cart_item_key . '" class="woosmc-item"><div class="woosmc-item-inner">';
					$cart_html .= '<div class="woosmc-item-thumb">';
					if ( ! $product_permalink ) {
						$cart_html .= $thumbnail;
					} else {
						$cart_html .= sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
					}
					$cart_html .= '</div>';
					$cart_html .= '<div class="woosmc-item-info">';
					$cart_html .= '<span class="woosmc-item-title">';
					if ( ! $product_permalink ) {
						$cart_html .= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						$cart_html .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
					}
					$cart_html .= '</span>';
					if ( ( get_option( '_woosmc_attributes', 'no' ) == 'yes' ) && $_product->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
						if ( count( $_product->get_variation_attributes() ) > 0 ) {
							$cart_html .= '<span class="woosmc-item-data">';
							foreach ( $_product->get_variation_attributes() as $key => $value ) {
								$cart_html .= '<span class="woosmc-item-data-attr">' . wc_attribute_label( str_replace( 'attribute_', '', $key ), $_product ) . ': ' . $value . '</span>';
							}
							$cart_html .= '</span>';
						}
					}
					$cart_html .= '<span class="woosmc-item-price">' . $_product->get_price_html() . '</span>';
					$cart_html .= '</div>';
					$cart_html .= '<div class="woosmc-item-qty"><div class="woosmc-item-qty-inner"><span class="woosmc-item-qty-plus">+</span>' . apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ) . '<span class="woosmc-item-qty-minus">-</span></div></div>';
					//$cart_html .= '<div class="woosmc-item-qty"><div class="woosmc-item-qty-inner"><span class="woosmc-item-qty-plus">+</span><input class="woosmc-item-qty-input" type="number" value="' . $cart_item['quantity'] . '" step="1" min="1" max="' . $_product->get_stock_quantity() . '" data-key="' . $cart_item_key . '"/><span class="woosmc-item-qty-minus">-</span></div></div>';
					$cart_html .= '<span class="woosmc-item-remove" data-key="' . $cart_item_key . '"></span></div></div>';
				}
			}
		}
		$cart_html .= '</div>';
		$cart_html .= '<div class="woosmc-area-bot">';
		if ( get_option( '_woosmc_total', 'yes' ) == 'yes' ) {
			$cart_html .= '<div class="woosmc-total"><div class="woosmc-total-inner"><div class="woosmc-total-left">' . esc_html__( 'Total', 'woosmc' ) . '</div><div id="woosmc-subtotal" class="woosmc-total-right">' . WC()->cart->get_cart_subtotal() . '</div></div></div>';
		}
		if ( get_option( '_woosmc_buttons', '01' ) == '01' ) {
			$cart_html .= '<div class="woosmc-action"><div class="woosmc-action-inner"><div class="woosmc-action-left"><a href="' . wc_get_cart_url() . '">' . esc_html__( 'Cart', 'woosmc' ) . '</a></div><div class="woosmc-action-right"><a href="' . wc_get_checkout_url() . '">' . esc_html__( 'Checkout', 'woosmc' ) . '</a></div></div></div>';
		} else {
			if ( get_option( '_woosmc_buttons', '01' ) == '02' ) {
				$cart_html .= '<div class="woosmc-action"><div class="woosmc-action-inner"><div class="woosmc-action-full"><a href="' . wc_get_cart_url() . '">' . esc_html__( 'Cart', 'woosmc' ) . '</a></div></div></div>';
			}
			if ( get_option( '_woosmc_buttons', '01' ) == '03' ) {
				$cart_html .= '<div class="woosmc-action"><div class="woosmc-action-inner"><div class="woosmc-action-full"><a href="' . wc_get_checkout_url() . '">' . esc_html__( 'Checkout', 'woosmc' ) . '</a></div></div></div>';
			}
		}
		if ( get_option( '_woosmc_continue', 'yes' ) == 'yes' ) {
			$cart_html .= '<div class="woosmc-continue"><span id="woosmc-continue">' . esc_html__( 'Continue Shopping', 'woosmc' ) . '</span></div>';
		}
		$cart_html .= '</div>';
	} else {
		$cart_html .= '<div class="woosmc-no-item">' . esc_html__( 'There are no products in the cart!', 'woosmc' ) . '</div>';
	}

	return $cart_html;
}

function woosmc_wp_footer() {
	?>
	<div id="woosmc-area"
	     class="woosmc-area woosmc-effect-<?php echo esc_attr( get_option( '_woosmc_position', '05' ) ); ?> woosmc-style-<?php echo esc_attr( get_option( '_woosmc_style', '01' ) ); ?>">
		<?php echo woosmc_show_cart(); ?>
	</div>
	<input type="hidden" id="woosmc-nonce" value="<?php echo wp_create_nonce( 'woosmc-security' ); ?>" />
	<div class="woosmc-overlay"></div>
	<style>
		.woosmc-area.woosmc-style-01, .woosmc-area.woosmc-style-03, .woosmc-area.woosmc-style-02 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a:hover, .woosmc-area.woosmc-style-04 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a:hover {
			background-color: <?php echo get_option( '_woosmc_color', '#cc6055' ); ?>;
		}

		.woosmc-area.woosmc-style-01 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a, .woosmc-area.woosmc-style-02 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a, .woosmc-area.woosmc-style-03 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a, .woosmc-area.woosmc-style-04 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a {
			outline: none;
			color: <?php echo get_option( '_woosmc_color', '#cc6055' ); ?>;
		}

		.woosmc-area.woosmc-style-02 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a, .woosmc-area.woosmc-style-04 .woosmc-area-bot .woosmc-action .woosmc-action-inner > div a {
			border-color: <?php echo get_option( '_woosmc_color', '#cc6055' ); ?>;
		}

		.woosmc-area.woosmc-style-05 {
			background-color: <?php echo get_option( '_woosmc_color', '#cc6055' ); ?>;
			background-image: url("<?php echo( get_option( '_woosmc_bg_image', '' ) != '' ? wp_get_attachment_url( get_option( '_woosmc_bg_image', '' ) ) : '' ); ?>");
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		}
	</style>
	<?php
	if ( ( get_option( '_woosmc_auto_show_normal', 'yes' ) == 'yes' ) && ( isset( $_POST['add-to-cart'] ) || ( isset( $_GET['add-to-cart'] ) ) ) ) {
		?>
		<script>
			jQuery(document).ready(function () {
				setTimeout(function () {
					woosmc_show_cart();
				}, 1000);
			});
		</script>
		<?php
	}
}