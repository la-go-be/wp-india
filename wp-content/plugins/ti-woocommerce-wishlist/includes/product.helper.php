<?php
/**
 * Product function class
 *
 * @since             1.5.0
 * @package           TInvWishlist\Products
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Product function class
 */
class TInvWL_Product {

	/**
	 * Table name
	 *
	 * @var string
	 */
	private $table;
	/**
	 * Plugin name
	 *
	 * @var string
	 */
	private $_n;
	/**
	 * Wishlist object
	 *
	 * @var array
	 */
	public $wishlist;
	/**
	 * User id
	 *
	 * @var integer
	 */
	public $user;

	/**
	 * Constructor
	 *
	 * @global wpdb $wpdb
	 * @param array  $wishlist Object wishlist.
	 * @param string $plugin_name Plugin name.
	 */
	function __construct( $wishlist = array(), $plugin_name = TINVWL_PREFIX ) {
		global $wpdb;

		$this->wishlist	 = (array) $wishlist;
		$this->_n		 = $plugin_name;
		$this->table	 = sprintf( '%s%s_%s', $wpdb->prefix, $this->_n, 'items' );
		$this->user		 = $this->wishlist_author();
		if ( empty( $this->user ) ) {
			$user = wp_get_current_user();
			if ( $user->exists() ) {
				$this->user = $user->ID;
			}
		}
	}

	/**
	 * Get wishlist id
	 *
	 * @return int
	 */
	function wishlist_id() {
		if ( is_array( $this->wishlist ) && array_key_exists( 'ID', $this->wishlist ) ) {
			return $this->wishlist['ID'];
		}
		return 0;
	}

	/**
	 * Get author wishlist
	 *
	 * @return int
	 */
	function wishlist_author() {
		if ( is_array( $this->wishlist ) && array_key_exists( 'author', $this->wishlist ) ) {
			return $this->wishlist['author'];
		}
		return 0;
	}

	/**
	 * Add\Update product
	 *
	 * @param array $data Object product.
	 * @param array $meta Object meta form data.
	 * @return boolean
	 */
	function add_product( $data = array(), $meta = array() ) {
		$_data = filter_var_array( $data, array(
			'product_id'	 => FILTER_VALIDATE_INT,
			'variation_id'	 => FILTER_VALIDATE_INT,
			'wishlist_id'	 => FILTER_VALIDATE_INT,
			'quantity'		 => FILTER_VALIDATE_INT,
		) );
		if ( empty( $_data['quantity'] ) ) {
			$_data['quantity'] = 1;
		}
		if ( empty( $_data['wishlist_id'] ) ) {
			$_data['wishlist_id'] = $this->wishlist_id();
		}
		$product_data = $this->check_product( $_data['product_id'], $_data['variation_id'], $_data['wishlist_id'], $meta );
		if ( false === $product_data ) {
			return false;
		}
		if ( $product_data ) {
			$data['quantity'] = $product_data['quantity'] + $_data['quantity'];
			return $this->update( $data, $meta );
		} else {
			return $this->add( $data, $meta );
		}
	}

	/**
	 * Add product
	 *
	 * @global wpdb $wpdb
	 * @param array $data Object product.
	 * @param array $meta Object meta form data.
	 * @return boolean
	 */
	function add( $data = array(), $meta = array() ) {
		$default = array(
			'author'		 => $this->user,
			'date'			 => date( 'Y-m-d H:i:s' ),
			'in_stock'		 => false,
			'price'			 => 0,
			'product_id'	 => 0,
			'quantity'		 => 1,
			'variation_id'	 => 0,
			'wishlist_id'	 => $this->wishlist_id(),
		);
		$data	 = filter_var_array( $data, apply_filters( 'tinvwl_wishlist_product_add_field', array(
			'author'		 => FILTER_VALIDATE_INT,
			'product_id'	 => FILTER_VALIDATE_INT,
			'quantity'		 => FILTER_VALIDATE_INT,
			'variation_id'	 => FILTER_VALIDATE_INT,
			'wishlist_id'	 => FILTER_VALIDATE_INT,
		) ) );
		$data	 = array_filter( $data );

		$data = tinv_array_merge( $default, $data );

		if ( empty( $data['wishlist_id'] ) || empty( $data['product_id'] ) ) {
			return false;
		}

		$product_data = $this->product_data( $data['product_id'], $data['variation_id'] );

		if ( $data['quantity'] <= 0 || ! $product_data ) {
			return false;
		}

		if ( $product_data->is_sold_individually() ) {
			$data['quantity'] = 1;
		}

		$data = apply_filters( 'tinvwl_wishlist_product_add', $data );
		$data['product_id']		 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) );
		$data['variation_id']	 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) );
		$data['in_stock']		 = $product_data->is_in_stock();
		$data['price']			 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->price : $product_data->get_price() );
		$data['formdata']		 = $this->prepare_save_meta( $meta, $data['product_id'], $data['variation_id'] );

		global $wpdb;
		if ( $wpdb->insert( $this->table, $data ) ) { // @codingStandardsIgnoreLine WordPress.VIP.DirectDatabaseQuery.DirectQuery
			$id = $wpdb->insert_id;
			return $id;
		}
		return false;
	}

	/**
	 * Get products by wishlist
	 *
	 * @param array $data Request.
	 * @return array
	 */
	function get_wishlist( $data = array() ) {
		if ( ! array_key_exists( 'wishlist_id', $data ) ) {
			$data['wishlist_id'] = $this->wishlist_id();
		}
		if ( empty( $data['wishlist_id'] ) ) {
			return array();
		}

		return $this->get( $data );
	}

	/**
	 * Check existing product
	 *
	 * @param integer $product_id Product id.
	 * @param integer $variation_id Product variaton id.
	 * @param integer $wishlist_id If exist wishlist object, you can put 0.
	 * @param array   $meta Object meta form data.
	 * @return mixed
	 */
	function check_product( $product_id, $variation_id = 0, $wishlist_id = 0, $meta = array() ) {
		$product_id		 = absint( $product_id );
		$variation_id	 = absint( $variation_id );
		$wishlist_id	 = absint( $wishlist_id );

		if ( empty( $wishlist_id ) ) {
			$wishlist_id = $this->wishlist_id();
		}
		if ( empty( $wishlist_id ) || empty( $product_id ) ) {
			return false;
		}

		$product_data = $this->product_data( $product_id, $variation_id );

		if ( ! $product_data ) {
			return false;
		}

		$product_id		 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) );
		$variation_id	 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) );

		$products = $this->get( array(
			'product_id'	 => $product_id,
			'variation_id'	 => $variation_id,
			'wishlist_id'	 => $wishlist_id,
			'formdata'		 => $this->prepare_save_meta( $meta, $product_id, $variation_id ),
			'count'			 => 1,
			'external'		 => false,
		) );

		return array_shift( $products );
	}

	/**
	 * Get products
	 *
	 * @global wpdb $wpdb
	 * @param array $data Request.
	 * @return array
	 */
	function get( $data = array() ) {
		global $wpdb;

		$default = array(
			'count'		 => 10,
			'field'		 => null,
			'offset'	 => 0,
			'order'		 => 'ASC',
			'order_by'	 => 'in_stock',
			'external'	 => true,
			'sql'		 => '',
		);

		foreach ( $default as $_k => $_v ) {
			if ( array_key_exists( $_k, $data ) ) {
				$default[ $_k ] = $data[ $_k ];
				unset( $data[ $_k ] );
			}
		}

		$default['offset'] = absint( $default['offset'] );
		$default['count']	 = absint( $default['count'] );
		if ( is_array( $default['field'] ) ) {
			$default['field'] = '`' . implode( '`,`', $default['field'] ) . '`';
		} elseif ( is_string( $default['field'] ) ) {
			$default['field']	 = array( 'ID', $default['field'] );
			$default['field']	 = '`' . implode( '`,`', $default['field'] ) . '`';
		} else {
			$default['field'] = '*';
		}
		$sql = "SELECT {$default[ 'field' ]} FROM `{$this->table}`";

		$where = '1';
		if ( ! empty( $data ) && is_array( $data ) ) {
			if ( array_key_exists( 'meta', $data ) ) {
				$product_id = $variation_id = 0;
				if ( array_key_exists( 'product_id', $data ) ) {
					$product_id = $data['product_id'];
				}
				if ( array_key_exists( 'variation_id', $data ) ) {
					$variation_id = $data['variation_id'];
				}
				$data['formdata'] = trim( $wpdb->prepare( '%s', $this->prepare_save_meta( $data['meta'], $product_id, $variation_id ) ), "'" );
				unset( $data['meta'] );
			}
			foreach ( $data as $f => $v ) {
				$s = is_array( $v ) ? ' IN ' : '=';
				if ( is_array( $v ) ) {
					$v	 = "'" . implode( "','", $v ) . "'";
					$v	 = "($v)";
				} else {
					$v = "'$v'";
				}
				$data[ $f ] = sprintf( '`%s`%s%s', $f, $s, $v );
			}
			$where = implode( ' AND ', $data );
			$sql .= ' WHERE ' . $where;
		}

		$sql .= sprintf( ' ORDER BY `%s` %s LIMIT %d,%d;', $default['order_by'], $default['order'], $default['offset'], $default['count'] );
		if ( ! empty( $default['sql'] ) ) {
			$replacer		 = $replace		 = array();
			$replace[0]	 = '{table}';
			$replacer[0]	 = $this->table;
			$replace[1]	 = '{where}';
			$replacer[1]	 = $where;

			foreach ( $default as $key => $value ) {
				$i = count( $replace );

				$replace[ $i ]	 = '{' . $key . '}';
				$replacer[ $i ]	 = $value;
			}

			$sql = str_replace( $replace, $replacer, $default['sql'] );
		}
		$products = $wpdb->get_results( $sql, ARRAY_A ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.

		if ( empty( $products ) ) {
			return array();
		}

		foreach ( $products as $k => $product ) {
			if ( empty( $default['sql'] ) ) {
				$product = filter_var_array( $product, array(
					'ID'			 => FILTER_VALIDATE_INT,
					'wishlist_id'	 => FILTER_VALIDATE_INT,
					'product_id'	 => FILTER_VALIDATE_INT,
					'variation_id'	 => FILTER_VALIDATE_INT,
					'author'		 => FILTER_VALIDATE_INT,
					'date'			 => FILTER_DEFAULT,
					'formdata'		 => FILTER_DEFAULT,
					'quantity'		 => FILTER_VALIDATE_INT,
					'price'			 => FILTER_SANITIZE_NUMBER_FLOAT,
					'in_stock'		 => FILTER_VALIDATE_BOOLEAN,
				) );
				if ( ! tinv_get_option( 'general', 'quantity_func' ) ) {
					$product['quantity'] = 1;
				}
			}
			if ( $default['external'] ) {
				$product_data = $this->product_data( $product['variation_id'], $product['product_id'] );
				if ( $product_data ) {
					$product['product_id']		 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) );
					$product['variation_id']	 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) );
				} else {
					unset( $products[ $k ] );
					continue;
				}
				$product['data'] = $product_data;
			}
			$product['meta'] = array();
			if ( array_key_exists( 'formdata', $product ) ) {
				$meta = $product['formdata'];
				unset( $product['formdata'] );

				$product['meta'] = $this->prepare_retrun_meta( $meta, $product['product_id'], $product['variation_id'], $product['quantity'] );
			}
			$products[ $k ] = apply_filters( 'tinvwl_wishlist_product_get', $product );
		}
		return $products;
	}

	/**
	 * Get product info
	 *
	 * @param integer $product_id Product id.
	 * @param integer $variation_id Product variation id.
	 * @return mixed
	 */
	function product_data( $product_id, $variation_id = 0 ) {
		$product_id		 = absint( $product_id );
		$variation_id	 = absint( $variation_id );

		if ( 'product_variation' == get_post_type( $product_id ) ) { // WPCS: loose comparison ok.
			$variation_id	 = $product_id;
			$product_id		 = wp_get_post_parent_id( $variation_id );
		}

		$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );

		if ( ! $product_data || 'trash' === ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->post->post_status : get_post( $product_data->get_id() )->post_status ) ) {
			return null;
		}

		$product_data->variation_id = absint( ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) ) );
		return $product_data;
	}

	/**
	 * Update product
	 *
	 * @global wpdb $wpdb
	 * @param array $data Object product.
	 * @param array $meta Object meta form data.
	 * @return boolean
	 */
	function update( $data = array(), $meta = array() ) {
		if ( empty( $meta ) && array_key_exists( 'meta', $data ) && ! empty( $data['meta'] ) ) {
			$meta = $data['meta'];
		}

		$data	 = filter_var_array( $data, apply_filters( 'tinvwl_wishlist_product_update_field', array(
			'product_id'	 => FILTER_VALIDATE_INT,
			'quantity'		 => FILTER_VALIDATE_INT,
			'variation_id'	 => FILTER_VALIDATE_INT,
			'wishlist_id'	 => FILTER_VALIDATE_INT,
			'author'		 => FILTER_VALIDATE_INT,
		) ) );
		$data	 = array_filter( $data );

		if ( ! array_key_exists( 'wishlist_id', $data ) ) {
			$data['wishlist_id'] = $this->wishlist_id();
		}
		if ( ! array_key_exists( 'variation_id', $data ) ) {
			$data['variation_id'] = 0;
		}

		if ( empty( $data['wishlist_id'] ) || empty( $data['product_id'] ) ) {
			return false;
		}
		$product_data = $this->product_data( $data['product_id'], $data['variation_id'] );
		if ( ! $product_data ) {
			return false;
		}

		if ( $product_data->is_sold_individually() ) {
			$data['quantity'] = 1;
		}

		$data = apply_filters( 'tinvwl_wishlist_product_update', $data );
		$data['product_id']		 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) );
		$data['variation_id']	 = ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) );
		$data['in_stock']		 = $product_data->is_in_stock();
		$data['price']			 = version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->price : $product_data->get_price();

		global $wpdb;
		return false !== $wpdb->update( $this->table, $data, array(
			'product_id'	 => $data['product_id'],
			'variation_id'	 => $data['variation_id'],
			'wishlist_id'	 => $data['wishlist_id'],
			'formdata'		 => $this->prepare_save_meta( $meta, $data['product_id'], $data['variation_id'] ),
		) ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.
	}

	/**
	 * Remove product from wishlist
	 *
	 * @global wpdb $wpdb
	 * @param integer $wishlist_id If exist wishlist object, you can put 0.
	 * @param integer $product_id Product id.
	 * @param integer $variation_id Product variation id.
	 * @param array   $meta Object meta form data.
	 * @return boolean
	 */
	function remove_product_from_wl( $wishlist_id = 0, $product_id = 0, $variation_id = 0, $meta = array() ) {
		global $wpdb;
		if ( empty( $wishlist_id ) ) {
			$wishlist_id = $this->wishlist_id();
		}
		if ( empty( $wishlist_id ) ) {
			return false;
		}
		if ( empty( $product_id ) ) {
			return false !== $wpdb->delete( $this->table, array( 'wishlist_id' => $wishlist_id ) ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.
		}
		$product_data = $this->product_data( $product_id, $variation_id );
		if ( ! $product_data ) {
			return false;
		}
		$data	 = array(
			'wishlist_id'	 => $wishlist_id,
			'product_id'	 => ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) ),
			'variation_id'	 => ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) ),
		);
		$data['formdata'] = $this->prepare_save_meta( $meta, $data['product_id'], $data['variation_id'] );
		$result	 = false !== $wpdb->delete( $this->table, $data ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.
		if ( $result ) {
			do_action( 'tinvwl_wishlist_product_removed_from_wishlist', $wishlist_id, ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->id : ( $product_data->is_type( 'variation' ) ? $product_data->get_parent_id() : $product_data->get_id() ) ), ( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product_data->variation_id : ( $product_data->is_type( 'variation' ) ? $product_data->get_id() : 0 ) ) );
		}
		return $result;
	}

	/**
	 * Remove product
	 *
	 * @global wpdb $wpdb
	 * @param integer $product_id Product id.
	 * @return boolean
	 */
	function remove_product( $product_id = 0 ) {
		if ( empty( $product_id ) ) {
			return false;
		}

		global $wpdb;
		$result = false !== $wpdb->delete( $this->table, array( 'product_id' => $product_id ) ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.
		if ( $result ) {
			do_action( 'tinvwl_wishlist_product_removed_by_product', $product_id );
		}
		return $result;
	}

	/**
	 * Remove product by ID
	 *
	 * @global wpdb $wpdb
	 * @param integer $id Product id.
	 * @return boolean
	 */
	function remove( $id = 0 ) {
		if ( empty( $id ) ) {
			return false;
		}

		global $wpdb;
		$result = false !== $wpdb->delete( $this->table, array( 'ID' => $id ) ); // WPCS: db call ok; no-cache ok; unprepared SQL ok.
		if ( $result ) {
			do_action( 'tinvwl_wishlist_product_removed_by_id', $id );
		}
		return $result;
	}

	/**
	 * Prepare to save meta in database
	 *
	 * @param array  $meta Meta array.
	 * @param ineger $product_id Woocommerce product ID.
	 * @param ineger $variation_id Woocommerce product variation ID.
	 * @return string
	 */
	function prepare_save_meta( $meta = array(), $product_id = 0, $variation_id = 0 ) {
		if ( ! is_array( $meta ) ) {
			$meta = array();
		}
		$meta = apply_filters( 'tinvwl_product_prepare_meta', $meta, $product_id, $variation_id );
		if ( ! empty( $variation_id ) ) {
			$product_data	 = $this->product_data( $product_id, $variation_id );
			if ( is_object( $product_data ) ) {
				$attributes		 = array_keys( (array) $product_data->get_variation_attributes() );
				foreach ( $attributes as $attribute ) {
					if ( array_key_exists( $attribute, $meta ) ) {
						unset( $meta[ $attribute ] );
						continue;
					}
					$attribute = 'attribute_' . sanitize_title( $attribute );
					if ( array_key_exists( $attribute, $meta ) ) {
						unset( $meta[ $attribute ] );
					}
				}
			}
		}
		foreach ( array( 'add-to-cart', 'product_id', 'variation_id', 'quantity', 'undefined' ) as $field ) {
			if ( array_key_exists( $field, $meta ) ) {
				unset( $meta[ $field ] );
			}
		}
		$meta = array_filter( $meta );
		if ( empty( $meta ) ) {
			return '';
		}
		ksort( $meta );
		return json_encode( $meta );
	}

	/**
	 * Convert meta string to array
	 *
	 * @param string  $meta Meta array.
	 * @param integer $product_id Product ID.
	 * @param integer $variation_id Variation product ID.
	 * @param integer $quantity Quantity product.
	 * @return array
	 */
	function prepare_retrun_meta( $meta = '', $product_id = 0, $variation_id = 0, $quantity = 1 ) {
		if ( empty( $meta ) ) {
			return array();
		}
		$meta = @json_decode( $meta, true );
		if ( empty( $meta ) || ! is_array( $meta ) ) {
			return array();
		}
		if ( ! empty( $product_id ) ) {
			$meta['add-to-cart'] = $product_id;
			$meta['product_id'] = $product_id;
			$meta['quantity'] = $quantity;
			if ( ! empty( $variation_id ) ) {
				$meta['variation_id'] = $variation_id;
			}
		}
		return apply_filters( 'tinvwl_wishlist_product_unprepare_meta', $meta );
	}
}
