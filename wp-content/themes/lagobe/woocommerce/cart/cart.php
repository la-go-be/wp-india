<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.3
 */



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $redux_demo;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<div class="title-sec">

			<div class="close-icn"><a href="javascript: history.go(-1)"><img src="<?php echo get_template_directory_uri();?>/images/cross-out.svg" alt=""></a></div>
			
			<h2><?php echo $redux_demo['cart_text_en']; ?>.</h2>
			
	<?php $items = $redux_demo['item_text_en']; ?>
	
	
	<?php $remove = $redux_demo['remove_text_en']; ?>
	
	
	<span>
	
	<?php echo sprintf ( _n( '%d item.', '%d '.$items.'.', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?>
	</span>
<a class="button" href="<?php //echo $woocommerce->cart->get_cart_url(); ?>?empty-cart"><?php echo $remove;  ?></a>
</div>

<div class="categories">
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>
	<ul id="cart-products" class="shop_table shop_table_responsive cart woocommerce-cart-form__contents grid-view">
	<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
	?>
	<li>
		<div class="remove-icon">
			<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
					'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-trash-o" aria-hidden="true"></i></a>',
					esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
					__( 'Remove this item', 'woocommerce' ),
					esc_attr( $product_id ),
					esc_attr( $_product->get_sku() )
					), $cart_item_key );
			?>
		</div>
		<div class="product-img">
			<?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('cat-page-img'), $cart_item, $cart_item_key );
					
					
					if ( ! $product_permalink ) {
					echo $thumbnail;
					} else {
					printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
					}
			?>
		</div> 
		
		
		<div class="grid-product-right">
		<div class="top-sec wrap-div">
			<h1 data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>"><?php
								if ( ! $product_permalink ) {
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
								} else {
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
								}

								// Meta data
								//echo WC()->cart->get_item_data( $cart_item );

								// Backorder notification
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
								}
							?></h1>
			<div data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></div>				
			<strong><?php 
			$terms = get_the_terms( $product_id, 'product_cat' );
				foreach ($terms as $term) {
			    $product_cat = $term->name;
				}
			echo $product_cat ;
			?></strong>
			<?php $highlight = get_post_meta( $product_id, 'product_highlight', true ); ?>	
			<?php if($highlight != ""){ ?>
			<strong><?php echo $highlight; ?></strong>						
			<?php } ?>
		</div>  
		
		<div class="middle-sec wrap-div">
			<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
				<span><?php esc_attr_e( 'Quantity', 'woocommerce' ); ?></span>
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '1',
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</div>
			<div class="product_varient">
			<?php 
			foreach($cart_item['variation'] as $attribute_val ){
                    // comparing attribute parameter value with current attribute value
                    if($attribute_val != ""){
					echo '<a href="#" class="btn">'.$attribute_val.' > </a>';
                	}
				}
			?>
			</div>
            
		</div>	
		
		<div class="bottom-sec wrap-div">
			<?php 
			if ( $_product->is_in_stock() ) { ?>
			<p class="available"><?php echo $redux_demo['woo_avai_txt_en']; ?></p>
			<?php } else { ?>
			<p class="not-available"><?php echo $redux_demo['woo_notavai_txt_en']; ?></p>
			<?php } ?>
			
			<div class="share-sec share-icon">
									<span class="shar-btn">
									<i class="fa fa-share-alt" aria-hidden="true"></i>
									</span>
<div class="social" style="display:none;">
	<span class='st_facebook_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
	<span class='st_twitter_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
	<span class='st_linkedin_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
	<span class='st_email_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
	<span class='st_plusone_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
	<span class='st_pinterest_large' st_title='<?php the_title(); ?>' st_url='<?php echo get_permalink( $product_id); ?>'></span>
</div>
								</div>
			
		</div>
		
		</div>
		
	</li>
	<?php }	} ?>
	<?php do_action( 'woocommerce_cart_contents' ); ?>
	</ul>
	
	
<!---------------------------------------------------Grid View Cart Page ----------------------------------------------------------------------------------->
	
	
<!---------------------------------------------------End Grid View Cart Page ----------------------------------------------------------------------------------->	
	
	<div class="cart-right">
		<div class="right-top">
			<img src="<?php echo get_template_directory_uri(); ?>/images/cart-icon.png" alt="cart-icon"/>
			<h2><?php echo $redux_demo['woo_safe_shop_txt_en']; ?></h2>
			<p><?php echo $redux_demo['pci_text_en']; ?></p>
		</div>
		
		<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code"><?php _e( 'Apply Promo Code', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter Code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>" />
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
		<?php } ?>
		
		<div class="cart-collaterals">
			<?php do_action( 'woocommerce_cart_collaterals' ); ?>
		</div>
	</div>
	<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>	
</div>
		
		





<?php do_action( 'woocommerce_after_cart' ); ?>

<div class="wc-proceed-to-checkout">
	<div class="view-icons cart-icons">
		<a href="JavaScript:Void(0);" id="cart-s"><i class="fa fa-bars" aria-hidden="true"></i></a>
		<a href="JavaScript:Void(0);" id="cart-g" class="active"><i class="fa fa-film" aria-hidden="true"></i></a>
	</div>
	
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
</div>
<?php do_action( 'woocommerce_after_cart_totals' ); ?>

