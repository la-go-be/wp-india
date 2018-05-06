<?php

/**
 * The Template for displaying wishlist.
 *
 * @version             1.0.0
 * @package           TInvWishlist\Template
 */


if ( ! defined( 'ABSPATH' ) ) {

	exit; // Exit if accessed directly.

}

global $redux_demo;

?>


    <div class="title-sec">


        <div class="close-icn"><a href="javascript: history.go(-1)"><img
                        src="<?php echo get_template_directory_uri(); ?>/images/close-black.svg" alt=""></a></div>


        <h2><?php echo $redux_demo['wish_text_en']; ?>.</h2>


        <span>

	<?php //echo YITH_WCWL()->count_products(); ?>

	<?php //echo sprintf ( _n( '%d item.', '%d items.', YITH_WCWL()->count_products() ), YITH_WCWL()->count_products() ); ?>

	</span>


		<?php $remove = $redux_demo['remove_text_en']; ?>

        <a class="button wish-rmv" href="#"><?php echo $remove; ?></a>


    </div>


    <div class="tinv-wishlist woocommerce tinv-wishlist-clear">


		<?php do_action( 'tinvwl_before_wishlist', $wishlist ); ?>

		<?php if ( function_exists( 'wc_print_notices' ) ) {
			wc_print_notices();
		} ?>

        <form action="<?php echo esc_url( tinv_url_wishlist() ); ?>" method="post" autocomplete="off">

			<?php do_action( 'tinvwl_before_wishlist_table', $wishlist ); ?>

            <div class="tinvwl-table-manage-list">


                <ul class="table-body slider-view" id="wishlist-products">

					<?php do_action( 'tinvwl_wishlist_contents_before' ); ?>



					<?php

					foreach ( $products as $wl_product ) {

						$product = apply_filters( 'tinvwl_wishlist_item', $wl_product['data'] );
						unset( $wl_product['data'] );

						if ( $wl_product['quantity'] > 0 && apply_filters( 'tinvwl_wishlist_item_visible', true, $wl_product, $product ) ) {

							$product_url = apply_filters( 'tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product );

							?>

                            <li class="<?php echo esc_attr( apply_filters( 'tinvwl_wishlist_item_class', 'wishlist_item', $wl_product, $product ) ); ?>">

								<?php if ( $wishlist_table['colm_checkbox'] ) { ?>

                                    <div class="product-cb" style="display:none;">

										<?php

										echo apply_filters( 'tinvwl_wishlist_item_cb', sprintf( // WPCS: xss ok.

											'<input type="checkbox" name="wishlist_pr[]" value="%d">', esc_attr( $wl_product['ID'] )

										), $wl_product, $product );

										?>

                                    </div>

								<?php } ?>

                                <div class="remove-icon">

                                    <button type="submit" name="tinvwl-remove"
                                            value="<?php echo esc_attr( $wl_product['ID'] ); ?>"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></button>

                                </div>

                                <div class="product-img">

									<?php

									$thumbnail = apply_filters( 'tinvwl_wishlist_item_thumbnail', $product->get_image( 'cat-page-img' ), $wl_product, $product );


									if ( ! $product->is_visible() ) {

										echo $thumbnail; // WPCS: xss ok.

									} else {

										printf( '<a href="%s">%s</a>', esc_url( $product_url ), $thumbnail ); // WPCS: xss ok.

									}

									?>



									<?php //if ( $wishlist_table_row['add_to_card'] ) { ?>

                                        <div class="product-action">

											<?php

											//if ( apply_filters( 'tinvwl_wishlist_item_action_add_to_card', $wishlist_table_row['add_to_card'], $wl_product, $product ) ) {

												?>

                                                <button class="button alt" name="tinvwl-add-to-cart"
                                                        value="<?php echo esc_attr( $wl_product['ID'] ); ?>"><i
                                                            class="fa fa-shopping-cart"></i><span
                                                            class="tinvwl-txt"><?php echo esc_html( apply_filters( 'tinvwl_wishlist_item_add_to_card', $wishlist_table_row['text_add_to_card'], $wl_product, $product ) ); ?></span>
                                                </button>

											<?php //} ?>

                                        </div>

									<?php //} ?>

                                </div>


                                <div class="top-sec">

                                    <h1 class="product-name">

										<?php

										if ( ! $product->is_visible() ) {

											echo apply_filters( 'tinvwl_wishlist_item_name', $product->get_title(), $wl_product, $product ) . '&nbsp;'; // WPCS: xss ok.

										} else {

											echo apply_filters( 'tinvwl_wishlist_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_url ), $product->get_title() ), $wl_product, $product ); // WPCS: xss ok.

										}

										?>

                                    </h1>

									<?php if ( $wishlist_table_row['colm_price'] ) { ?>

                                        <div class="product-price">

											<?php

											echo apply_filters( 'tinvwl_wishlist_item_price', $product->get_price_html(), $wl_product, $product ); // WPCS: xss ok.

											?>

                                        </div>

									<?php } ?>



									<?php

									//echo '<pre>',print_r($wl_product),'</pre>';

									$product_id = $wl_product['product_id']; ?>

                                    <strong>

										<?php

										$terms = get_the_terms( $product_id, 'product_cat' );

										foreach ( $terms as $term ) {

											$product_cat = $term->name;

										}

										echo $product_cat;

										?>

                                    </strong>


									<?php $highlight = get_post_meta( $product_id, 'product_highlight', true ); ?>

									<?php if ( $highlight != "" ) { ?>

                                        <strong><?php echo $highlight; ?></strong>

									<?php } ?>


                                </div>


								<?php $attributes_wish = apply_filters( 'tinvwl_wishlist_item_meta_data', tinv_wishlist_my_item_data( $product ), $wl_product, $product ); // WPCS: xss ok.?>

								<?php if ( $attributes_wish != "" ) { ?>

                                    <div class="middle-sec">

										<?php if ( $wishlist_table_row['colm_date'] ) { ?>

                                            <div class="product-date">

												<?php

												echo apply_filters( 'tinvwl_wishlist_item_date', sprintf( // WPCS: xss ok.

													'<time class="entry-date" datetime="%1$s">%2$s</time>', $wl_product['date'], mysql2date( get_option( 'date_format' ), $wl_product['date'] )

												), $wl_product, $product );

												?>

                                            </div>

										<?php } ?>

										<?php

										echo $attributes_wish;

										?>

                                    </div>

								<?php } ?>


                                <div class="bottom-sec">

									<?php if ( $wishlist_table_row['colm_stock'] ) { ?>


										<?php

//										$availability = $product->get_availability();
//
//
//										$availability_html = empty( $availability['availability'] ) ? '<p class="not-available">' . esc_html__( 'In stock', 'ti-woocommerce-wishlist' ) . '</p>' : '<p class="available">' . esc_html( $availability['availability'] ) . '</p>';
//
//
//										echo apply_filters( 'tinvwl_wishlist_item_status', $availability_html, $availability['availability'], $wl_product, $product ); // WPCS: xss ok.

										?>


									<?php } ?>


                                    <div class="share-sec share-icon">

									<span class="shar-btn">

									<i class="fa fa-share-alt" aria-hidden="true"></i>

									</span>
										<?php //echo $product->ID; ?>
										<?php //echo $product_id = $wl_product['product_id']; ?>
                                        <div class="social" style="display:none;">
                                            <span class='st_facebook_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                            <span class='st_twitter_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                            <span class='st_linkedin_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                            <span class='st_email_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                            <span class='st_plusone_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                            <span class='st_pinterest_large' st_title='<?php the_title(); ?>'
                                                  st_url='<?php echo get_permalink( $product_id ); ?>'></span>
                                        </div>

                                    </div>

                                </div>


                            </li>

							<?php

						}

					}

					?>

					<?php do_action( 'tinvwl_wishlist_contents_after' ); ?>

                </ul>


                <ul class="table-body grid-view">


					<?php do_action( 'tinvwl_wishlist_contents_before' ); ?>



					<?php

					foreach ( $products as $wl_product ) {

						$product = apply_filters( 'tinvwl_wishlist_item', $wl_product['data'] );

						unset( $wl_product['data'] );

						if ( $wl_product['quantity'] > 0 && apply_filters( 'tinvwl_wishlist_item_visible', true, $wl_product, $product ) ) {

							$product_url = apply_filters( 'tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product );

							?>

                            <li class="<?php echo esc_attr( apply_filters( 'tinvwl_wishlist_item_class', 'wishlist_item', $wl_product, $product ) ); ?>">

								<?php /*if ( $wishlist_table['colm_checkbox'] ) { ?>

								<td class="product-cb">

									<?php

									echo apply_filters( 'tinvwl_wishlist_item_cb', sprintf( // WPCS: xss ok.

										'<input type="checkbox" name="wishlist_pr[]" value="%d">', esc_attr( $wl_product['ID'] )

									), $wl_product, $product );

									?>

								</td>

							<?php }*/ ?>


                                <div class="product-img">

									<?php

									$thumbnail = apply_filters( 'tinvwl_wishlist_item_thumbnail', $product->get_image( 'cat-page-img' ), $wl_product, $product );


									if ( ! $product->is_visible() ) {

										echo $thumbnail; // WPCS: xss ok.

									} else {

										printf( '<a href="%s">%s</a>', esc_url( $product_url ), $thumbnail ); // WPCS: xss ok.

									}

									?>



									<?php if ( $wishlist_table_row['add_to_card'] ) { ?>

                                        <div class="product-action">

											<?php

											if ( apply_filters( 'tinvwl_wishlist_item_action_add_to_card', $wishlist_table_row['add_to_card'], $wl_product, $product ) ) {

												?>

                                                <button class="button alt" name="tinvwl-add-to-cart"
                                                        value="<?php echo esc_attr( $wl_product['ID'] ); ?>"><i
                                                            class="fa fa-shopping-cart"></i><span
                                                            class="tinvwl-txt"><?php echo esc_html( apply_filters( 'tinvwl_wishlist_item_add_to_card', $wishlist_table_row['text_add_to_card'], $wl_product, $product ) ); ?></span>
                                                </button>

											<?php } ?>

                                        </div>

									<?php } ?>

                                </div>


                                <div class="grid-product-right">

                                    <div class="remove-icon">

                                        <button type="submit" name="tinvwl-remove"
                                                value="<?php echo esc_attr( $wl_product['ID'] ); ?>"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i></button>

                                    </div>


                                    <div class="top-sec">

                                        <h1 class="product-name">

											<?php

											if ( ! $product->is_visible() ) {

												echo apply_filters( 'tinvwl_wishlist_item_name', $product->get_title(), $wl_product, $product ) . '&nbsp;'; // WPCS: xss ok.

											} else {

												echo apply_filters( 'tinvwl_wishlist_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_url ), $product->get_title() ), $wl_product, $product ); // WPCS: xss ok.

											}

											?>

                                        </h1>

										<?php if ( $wishlist_table_row['colm_price'] ) { ?>

                                            <div class="product-price">

												<?php

												echo apply_filters( 'tinvwl_wishlist_item_price', $product->get_price_html(), $wl_product, $product ); // WPCS: xss ok.

												?>

                                            </div>

										<?php } ?>



										<?php

										//echo '<pre>',print_r($wl_product),'</pre>';

										$product_id = $wl_product['product_id']; ?>

                                        <strong>

											<?php

											$terms = get_the_terms( $product_id, 'product_cat' );

											foreach ( $terms as $term ) {

												$product_cat = $term->name;

											}

											echo $product_cat;

											?>

                                        </strong>


										<?php $highlight = get_post_meta( $product_id, 'product_highlight', true ); ?>

										<?php if ( $highlight != "" ) { ?>

                                            <strong><?php echo $highlight; ?></strong>

										<?php } ?>


                                    </div>


									<?php $attributes_wish = apply_filters( 'tinvwl_wishlist_item_meta_data', tinv_wishlist_my_item_data( $product ), $wl_product, $product ); // WPCS: xss ok.?>

									<?php if ( $attributes_wish != "" ) { ?>

                                        <div class="middle-sec">

											<?php if ( $wishlist_table_row['colm_date'] ) { ?>

                                                <div class="product-date">

													<?php

													echo apply_filters( 'tinvwl_wishlist_item_date', sprintf( // WPCS: xss ok.

														'<time class="entry-date" datetime="%1$s">%2$s</time>', $wl_product['date'], mysql2date( get_option( 'date_format' ), $wl_product['date'] )

													), $wl_product, $product );

													?>

                                                </div>

											<?php } ?>

											<?php

											echo $attributes_wish;

											?>

                                        </div>

									<?php } ?>


                                    <div class="bottom-sec">

										<?php if ( $wishlist_table_row['colm_stock'] ) { ?>

											<?php
//
//											$availability = $product->get_availability();
//
//											$availability_html = empty( $availability['availability'] ) ? '<p class="not-available">' . esc_html__( 'In stock', 'ti-woocommerce-wishlist' ) . '</p>' : '<p class="available">' . esc_html( $availability['availability'] ) . '</p>';
//
//
//											echo apply_filters( 'tinvwl_wishlist_item_status', $availability_html, $availability['availability'], $wl_product, $product ); // WPCS: xss ok.

											?>


										<?php } ?>


                                        <div class="share-sec share-icon">

									<span class="shar-btn">

									<i class="fa fa-share-alt" aria-hidden="true"></i>

									</span>

                                            <div class="social" style="display:none;">

                                                <span class='st_facebook_large' st_title='<?php the_title(); ?>'
                                                      st_url='<?php the_permalink(); ?>'></span>

                                                <span class='st_twitter_large' st_title='<?php the_title(); ?>'
                                                      st_url='<?php the_permalink(); ?>'></span>

                                                <span class='st_linkedin_large' st_title='<?php the_title(); ?>'
                                                      st_url='<?php the_permalink(); ?>'></span>

                                                <span class='st_email_large' st_title='<?php the_title(); ?>'
                                                      st_url='<?php the_permalink(); ?>'></span>

                                                <span class='st_pinterest_large' st_title='<?php the_title(); ?>'
                                                      st_url='<?php the_permalink(); ?>'></span>


                                            </div>

                                        </div>

                                    </div>


                                </div>


                            </li>

							<?php

						}

					}

					?>

					<?php do_action( 'tinvwl_wishlist_contents_after' ); ?>


                </ul>


                <div class="foot">

                    <div>

						<?php do_action( 'tinvwl_after_wishlist_table', $wishlist ); ?>

						<?php wp_nonce_field( 'tinvwl_wishlist_owner', 'wishlist_nonce' ); ?>

                    </div>

                </div>

            </div>

        </form>

		<?php do_action( 'tinvwl_after_wishlist', $wishlist ); ?>

        <div class="tinv-lists-nav tinv-wishlist-clear">

			<?php do_action( 'tinvwl_pagenation_wishlist', $wishlist ); ?>

        </div>

    </div>


    <div class="wc-proceed-to-checkout">

        <div class="view-icons wish-icons">

            <a href="JavaScript:Void(0);" id="wish-s" class="active"><i class="fa fa-bars" aria-hidden="true"></i></a>

            <a href="JavaScript:Void(0);" id="wish-g"><i class="fa fa-film" aria-hidden="true"></i></a>

        </div>

        <a href="<?php echo site_url(); ?>/shop/" class="continue-shoping button alt wc-forward">


			<?php echo $redux_demo['continue_text_en']; ?>.


            <i class="fa fa-shopping-cart" aria-hidden="true"></i></a>

		<?php do_action( 'tinvwl_after_wishlist' ); ?>

    </div>


<?php


function tinv_wishlist_my_item_data( $product, $flat = false ) {


	$item_data = array();

	$variation_id = version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->variation_id : ( $product->is_type( 'variation' ) ? $product->get_id() : 0 );

	$variation_data = version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->variation_data : ( $product->is_type( 'variation' ) ? wc_get_product_variation_attributes( $product->get_id() ) : array() );

	if ( ! empty( $variation_id ) && is_array( $variation_data ) ) {

		foreach ( $variation_data as $name => $value ) {

			if ( '' === $value ) {

				continue;

			}


			$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );


			// If this is a term slug, get the term's nice name.

			if ( taxonomy_exists( $taxonomy ) ) {

				$term = get_term_by( 'slug', $value, $taxonomy ); // @codingStandardsIgnoreLine WordPress.VIP.RestrictedFunctions.get_term_by

				if ( ! is_wp_error( $term ) && $term && $term->name ) {

					$value = $term->name;

				}

				$label = wc_attribute_label( $taxonomy );


				// If this is a custom option slug, get the options name.

			} else {

				$value = apply_filters( 'woocommerce_variation_option_name', $value );

				$product_attributes = $product->get_attributes();


				if ( isset( $product_attributes[ str_replace( 'attribute_', '', $name ) ] ) ) {

					$label = wc_attribute_label( ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_attributes[ str_replace( 'attribute_', '', $name ) ]['name'] : str_replace( 'attribute_', '', $name ) ) );

				} else {

					$label = $name;

				}

			}

			$item_data[] = array(

				'key' => $label,

				'value' => $value,

			);

		}

	}


	// Filter item data to allow 3rd parties to add more to the array.

	$item_data = apply_filters( 'tinv_wishlist_my_item_data', $item_data, $product );


	// Format item data ready to display.

	foreach ( $item_data as $key => $data ) {

		// Set hidden to true to not display meta on cart.

		if ( ! empty( $data['hidden'] ) ) {

			unset( $item_data[ $key ] );

			continue;

		}

		$item_data[ $key ]['key'] = ! empty( $data['key'] ) ? $data['key'] : $data['name'];

		$item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];

		//echo "<a href='JavaScript:Void(0);' class='btn'>".$data['value'].' > </a><br>';

	}


	// Output flat or in list format.

	if ( 0 < count( $item_data ) ) {

		ob_start();

		if ( $flat ) {

			foreach ( $item_data as $data ) {

				echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['display'] ) . '<br>';

			}

		} else {

			//print_r($item_data);

			//echo $item_data['display'];

			echo '<div class="variation">';

			foreach ( $item_data as $data ) :

				echo '<a href="JavaScript:Void(0);" class="btn">' . wp_kses_post( $data['display'] ) . ' > </a>';

			endforeach;

			echo '</div>';

			//tinv_wishlist_template( 'ti-wishlist-item-data.php', array( 'item_data' => $item_data ) );

		}


		return ob_get_clean();

	}


	return '';

}


remove_action( 'tinvwl_after_wishlist', array( 'TInvWL_Public_Wishlist_Social', 'init' ) );	