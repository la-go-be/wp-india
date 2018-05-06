<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'YITH_WooCommerce_Barcodes' ) ) {

	/**
	 *
	 * @class   YITH_Barcodes
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 */
	class YITH_WooCommerce_Barcodes {

		/**
		 * Single instance of the class
		 *
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * @var bool set if the barcode generation is enabled for orders
		 */
		public $enable_on_orders = true;

		/**
		 * @var bool create automatically on new order
		 *
		 */
		public $create_on_orders = false;

		/**
		 * @var bool set if the barcode generation is enabled for products
		 */
		public $enable_on_products = true;

		/**
		 * @var bool permit to enter a custom value for the product barcode
		 */
		public $manual_value_on_products = false;

		/**
		 * @var bool create automatically barcode for new products
		 */
		public $create_on_products = false;

		/**
		 * @var string default barcode protocol to be used for orders
		 */
		public $orders_protocol = '';

		/**
		 * @var bool set if the barcode should be shown on order page
		 */
		public $show_on_order_page = false;

		/**
		 * @var string default barcode protocol to be used for orders
		 */
		public $products_protocol = '';

		/**
		 * @var bool set if the barcode should be shown on single product page
		 */
		public $show_on_product_page = true;

		/**
		 * @var bool show the order barcode on email sent whem the order is set as completed
		 */
		public $show_on_email_completed = false;

		/**
		 * @var bool show the order barcode on email sent whem the order is set as completed
		 */
		public $show_on_email_all = false;

		/**
		 * @var array list if all actions that could be executed from the shortcode for orders
		 */
		public $custom_order_actions = array();

		/**
		 * @var array list if all actions that could be executed from the shortcode for products
		 */
		public $custom_product_actions = array();

		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * Initialize plugin and registers actions and filters to be used
		 *
		 * @since  1.0
		 * @author Lorenzo Giuffrida
		 */
		protected function __construct() {
			$this->init_settings();

			$this->set_admin_hooks();
			$this->set_frontend_hooks();
		}

		/**
		 * Initialize plugin settings
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function init_settings() {

			$this->enable_on_orders   = "yes" == get_option( 'ywbc_enable_on_orders', 'no' );
			$this->create_on_orders   = "yes" == get_option( 'ywbc_create_on_orders', 'no' );
			$this->orders_protocol    = get_option( 'ywbc_orders_protocol', 'EAN13' );
			$this->show_on_order_page = $this->enable_on_orders && ( "yes" == get_option( 'ywbc_show_on_order_page', 'no' ) );

			$this->enable_on_products       = "yes" == get_option( 'ywbc_enable_on_products', 'no' );
			$this->manual_value_on_products = "yes" == get_option( 'ywbc_product_manual_barcode', 'no' );

			$this->create_on_products   = "yes" == get_option( 'ywbc_create_on_products', 'no' );
			$this->products_protocol    = get_option( 'ywbc_products_protocol', 'EAN13' );
			$this->show_on_product_page = $this->enable_on_products && ( "yes" == get_option( 'ywbc_show_on_product_page', 'no' ) );

			$_show_on_emails               = get_option( 'ywbc_show_on_emails', 'no' );
			$this->show_on_email_completed = "completed" == $_show_on_emails;
			$this->show_on_email_all       = "all" == $_show_on_emails;

			$this->custom_order_actions = apply_filters( 'yith_ywbc_sc_custom_order_action', array(
				'search'         => __( 'Search', 'yith-woocommerce-barcodes' ),
				'complete_order' => __( 'Complete order', 'yith-woocommerce-barcodes' ),
			) );

			$this->custom_product_actions = apply_filters( 'yith_ywbc_sc_custom_order_action', array(
				'search'           => __( 'Search', 'yith-woocommerce-barcodes' ),
				'stock_add_one'    => __( 'Add one', 'yith-woocommerce-barcodes' ),
				'stock_remove_one' => __( 'Remove one', 'yith-woocommerce-barcodes' ),
			) );

			/** Load external library, if needed */
			$load_qr_code = ( 'QRcode' == $this->orders_protocol ) || ( 'QRcode' == $this->products_protocol );
			$load_barcode = ( 'QRcode' != $this->orders_protocol ) || ( 'QRcode' != $this->products_protocol );

			if ( $load_qr_code ) {
				require_once( YITH_YWBC_INCLUDES_DIR . '/vendor/phpqrcode.php' );
			}
			if ( $load_barcode ) {
				require_once( YITH_YWBC_INCLUDES_DIR . '/vendor/php-barcode.php' );
			}
		}

		/**
		 * Initialize all hooks used by the plugin affecting the back-end behaviour
		 */
		public function set_admin_hooks() {
			/**
			 * Enqueue scripts and styles for admin pages
			 */
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_files' ) );

			/**
			 * Create the barcode for orders when they are created
			 */
			add_action( 'woocommerce_checkout_order_processed', array(
				$this,
				'on_new_order'
			) );

			/**
			 * Create the barcode for products when they are created
			 */
			add_action( 'transition_post_status', array(
				$this,
				'on_new_product'
			), 10, 3 );

			/**
			 * Add the search by barcode value on back-end product list
			 */
			add_filter( 'posts_join', array(
				$this,
				'query_barcode_join'
			), 10, 2 );

			/**
			 * Add the search by barcode value on back-end product list
			 */
			add_filter( 'posts_where', array(
				$this,
				'query_barcode_where'
			), 10, 2 );

			/**
			 * Add the barcode fields for the order search
			 */
			add_filter( 'woocommerce_shop_order_search_fields', array(
				$this,
				'search_by_order_fields'
			), 10, 2 );

			/**
			 * Manage a request from product bulk actions
			 */
			add_action( 'load-edit.php', array(
				$this,
				'generate_bulk_action'
			) );

			/**
			 * Show the order barcode on emails
			 */
			if ( $this->show_on_email_all || $this->show_on_email_completed ) {
				add_action( 'woocommerce_email_footer', array( $this, 'show_on_emails' ) );
			}

			/**
			 * Add a metabox showing the barcode for the order
			 */
			add_action( 'add_meta_boxes', array( $this, 'add_barcode_metabox' ) );

			/**
			 * Manage a request for generating the barcode for an object
			 */
			add_action( "admin_action_generate_barcode", array(
				$this,
				'admin_action_generate_barcode'
			) );

			/**
			 * Manage request from the form generated by the shortcode
			 */
			add_action( 'wp_ajax_barcode_actions', array( $this, 'manage_barcode_actions' ) );

			/**
			 * Manage a search barcode value for products from the form generated by the shortcode
			 */
			add_filter( 'yith_barcode_action_product_search', array(
				$this,
				'yith_barcode_action_product_search'
			), 10, 2 );

			/**
			 * Manage a search barcode value for products from the form generated by the shortcode
			 */
			add_filter( 'yith_barcode_action_shop_order_complete_order', array(
				$this,
				'yith_barcode_action_shop_order_complete_order'
			), 10, 2 );

			/**
			 * Manage a search barcode value for products from the form generated by the shortcode
			 */
			add_filter( 'yith_barcode_action_shop_order_search', array(
				$this,
				'yith_barcode_action_shop_order_search'
			), 10, 2 );

			/**
			 * If a manual value is entered on the product barcode fields, use it as the current barcode value
			 */
			add_action( 'save_post_product', array( $this, 'save_manual_barcode' ), 10, 3 );
			add_action( 'wp_ajax_apply_barcode_to_products', array( $this, 'apply_barcode_to_products' ) );
			
		
		}

		public function manage_barcode_actions() {

			if ( ! isset( $_POST["type"] ) || ! isset( $_POST["text"] ) || ! isset( $_POST["value"] ) ) {
				return;
			}
			$text   = sanitize_text_field( $_POST["text"] );
			$action = sanitize_text_field( $_POST["value"] );
			$type   = sanitize_text_field( $_POST["type"] );

			$result = array(
				'code'  => - 1,
				'value' => __( 'The selected action could not be performed', 'yith-woocommerce-barcodes' ),
			);

			if ( ( ( 'product' == $type ) && isset( $this->custom_product_actions[ $action ] ) ) ||
			     ( ( 'shop_order' == $type ) && isset( $this->custom_order_actions[ $action ] ) )
			) {
				$result = apply_filters( 'yith_barcode_action_' . $type . '_' . $action, $result, $text );
			}
			wp_send_json( $result );
		}

		/**
		 * If a manual value is entered on the product barcode fields, use it as the current barcode value
		 */
		public function save_manual_barcode( $post_ID, $post, $update ) {
			if ( isset( $_POST['ywbc-manual-value'] ) && ! empty( $_POST['ywbc-manual-value'] ) ) {
				//  save the custom value
				$barcode = YITH_Barcode::get( $post_ID );
				$barcode->generate( $this->products_protocol, $_POST['ywbc-manual-value'] );
				$barcode->save();
			}

		}

		/**
		 * Perform a search for a barcode value on specific object type
		 *
		 * @param string $text
		 * @param string $type
		 *
		 * @return array
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function barcode_action_search( $text, $type = 'shop_order' ) {
			global $wpdb;

			$args = array(
				'posts_per_page' => - 1,
				'post_type'      => $type,
				'post_status'    => 'any',
				'meta_query'     => array(
					array(
						'key'     => YITH_YWBC_META_KEY_BARCODE_DISPLAY_VALUE,
						'value'   => $text,
						'compare' => 'LIKE',
					)
				)
			);

			return get_posts( $args );
			/*
						$query = $wpdb->prepare( "SELECT " . $columns . " 	
							FROM {$wpdb->posts} p LEFT JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
							 WHERE pm.meta_key = %s and pm.meta_value like '%%%s%%' and post_type = %s",
							YITH_YWBC_META_KEY_BARCODE_DISPLAY_VALUE,
							$text,
							$type );
			
						return $wpdb->get_results( $query, OBJECT );
			*/
		}

		/**
		 * Manage a search for barcode value on products
		 *
		 * @param array  $result the result for the current action
		 * @param string $text   the text entered by the user
		 *
		 *
		 * @return string
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function yith_barcode_action_product_search( $result, $text ) {
			$items = $this->barcode_action_search(
				$text,
				'product'
			);

			ob_start();
			wc_get_template( 'shortcode/ywbc-search-products.php',
				array(
					'posts' => $items,
				),
				YITH_YWBC_TEMPLATES_DIR,
				YITH_YWBC_TEMPLATES_DIR
			);

			$content = ob_get_clean();

			$result['code']  = 1;
			$result['value'] = $content;

			return $result;
		}

		/**
		 * Manage a search for barcode value on orders
		 *
		 * @param array  $result the result for the current action
		 * @param string $text   the text entered by the user
		 *
		 *
		 * @return string
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function yith_barcode_action_shop_order_complete_order( $result, $text ) {
			$items = $this->barcode_action_search(
				$text,
				'shop_order'
			);

			foreach ( $items as $post ) {
				$order = wc_get_order( $post );
				if ( $order ) {
					$order->update_status( 'wc-completed', __( 'Order status set by YITH WooCommerce Barcodes', 'yith-woocommerce-barcodes' ) );
				}
			}

			ob_start();
			wc_get_template( 'shortcode/ywbc-complete-orders.php',
				array(
					'posts' => $items,
				),
				YITH_YWBC_TEMPLATES_DIR,
				YITH_YWBC_TEMPLATES_DIR
			);

			$content = ob_get_clean();


			$result['code']  = 1;
			$result['value'] = $content;

			return $result;
		}

		/**
		 * Manage a search for barcode value on orders
		 *
		 * @param array  $result the result for the current action
		 * @param string $text   the text entered by the user
		 *
		 *
		 * @return string
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function yith_barcode_action_shop_order_search( $result, $text ) {
			$items = $this->barcode_action_search(
				$text,
				'shop_order'
			);

			ob_start();
			wc_get_template( 'shortcode/ywbc-search-orders.php',
				array(
					'posts' => $items,
				),
				YITH_YWBC_TEMPLATES_DIR,
				YITH_YWBC_TEMPLATES_DIR
			);

			$content = ob_get_clean();


			$result['code']  = 1;
			$result['value'] = $content;

			return $result;
		}

		/**
		 * Initialize all hooks used by the plugin affecting the front-end behaviour
		 */
		public function set_frontend_hooks() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_files' ) );

			add_action( 'woocommerce_order_details_after_order_table', array(
				$this,
				'show_barcode_on_view_order_page'
			) );

			/**
			 * Show the barcode on front-end product page
			 */
			add_action( 'woocommerce_single_product_summary', array(
				$this,
				'show_barcode_on_single_product_page'
			), 25 );

			/**
			 * Add a shortcode for rendering a barcode
			 */
			add_shortcode( "yith_render_barcode", array( $this, "sc_render_barcode" ) );

			/**
			 * Add a shortcode for searching for a order barcode value
			 */
			add_shortcode( "yith_order_barcode", array( $this, "yith_order_barcode" ) );

			/**
			 * Add a shortcode for searching for a product barcode value
			 */
			add_shortcode( "yith_product_barcode", array( $this, "yith_product_barcode" ) );

		}

		/**
		 * Enqueue scripts and styles for the back-end
		 *
		 * @param string $hook
		 *
		 */
		public function enqueue_backend_files( $hook ) {
			//$this->backend->enqueue_resources( $hook );
			$screen_id = get_current_screen()->id;

			if ( 'edit-product' == $screen_id ) {
				wp_register_script( "ywbc-bulk-actions",
					YITH_YWBC_SCRIPTS_URL . yit_load_js_file( 'ywbc-bulk-actions.js' ),
					array(
						'jquery',
					),
					YITH_YWBC_VERSION,
					true );

				wp_localize_script( 'ywbc-bulk-actions', 'ywbc_bk_data', array(
					'action_options' => '<option value="ywbc-generate">' . __( 'Generate barcode', 'yith-woocommerce-barcodes' ) . '</option>',
				) );

				wp_enqueue_script( "ywbc-bulk-actions" );
			}

			if( ( isset( $_GET['page'] ) && 'yith_woocommerce_barcodes_panel' == $_GET['page'] ) && ( isset( $_GET['tab'] )  && 'tool' == $_GET['tab'] ) ){

				 wp_register_script( 'ywbc-ajax-apply-barcode', YITH_YWBC_SCRIPTS_URL.yit_load_js_file('ywbc-ajax-apply-barcode.js'), array('jquery','jquery-ui-progressbar'), YITH_YWBC_VERSION, true );

				$ywbc_params = array(
					'ajax_url' => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
					'messages' => array(
						'complete_task' => __('Barcode applied successfully', 'yith-woocommerce-barcode' ),
						'error_task' => __('It is not possible to complete the task', 'yith-woocommerce-barcode')
					)
				);

				wp_localize_script('ywbc-ajax-apply-barcode', 'ywbc_params', $ywbc_params );
				wp_enqueue_script('ywbc-ajax-apply-barcode');

			}

			/**
			 * Add styles
			 */
			wp_enqueue_style( 'ywbc-style', YITH_YWBC_ASSETS_URL . '/css/ywbc-style.css', array(), YITH_YWBC_VERSION );
		}

		/**
		 * Enqueue scripts and styles for the front-end
		 *
		 */
		public function enqueue_frontend_files() {
			//  register and enqueue ajax calls related script file
			wp_register_script( "ywbc-frontend",
				YITH_YWBC_SCRIPTS_URL . yit_load_js_file( 'ywbc-frontend.js' ),
				array(
					'jquery',
				),
				YITH_YWBC_VERSION,
				true );

			wp_localize_script( 'ywbc-frontend', 'ywbc_data', array(
				'loader'   => apply_filters( 'yith_barcodes_loader', YITH_YWBC_ASSETS_URL . '/images/loading.gif' ),
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			) );

			wp_enqueue_script( "ywbc-frontend" );

			wp_enqueue_style( 'ywbc-style', YITH_YWBC_ASSETS_URL . '/css/ywbc-style.css', array(), YITH_YWBC_VERSION );
		}

		/**
		 * Create barcode for new orders if needed
		 *
		 * @param int $order_id
		 */
		public function on_new_order( $order_id ) {

			//  Check if barcode are enabled for orders
			if ( ! $this->enable_on_orders ) {
				return;
			}

			//  Check if barcode should be create automatically
			if ( ! $this->create_on_orders ) {
				return;
			}

			$this->create_order_barcode( $order_id );
		}

		/**
		 * Create the barcode values for the order
		 *
		 * @param int    $order_id
		 * @param string $protocol
		 * @param string $value
		 */
		public function create_order_barcode( $order_id, $protocol = '', $value = '' ) {
			$protocol  = $protocol ? $protocol : $this->orders_protocol;
			$the_value = $value ? $value : $order_id;
			$the_value = apply_filters( 'yith_barcode_new_order_value', $the_value, $order_id, $protocol, $value );

			$this->generate_barcode_image( $order_id, $protocol, $the_value );
		}

		/**
		 * Generate a new barcode instance
		 *
		 * @param $barcode_id
		 * @param $protocol
		 * @param $value
		 *
		 * @return YITH_Barcode
		 */
		public function generate_barcode_image( $barcode_id, $protocol, $value ) {
			$barcode = new YITH_Barcode( $barcode_id );
			$res     = $barcode->generate( $protocol, $value );

			//todo save with creating a file
			$barcode->save();

			return $barcode;

			/*$image_filename = sprintf( "%s_%s.gif", $barcode->get_protocol(), $barcode->get_display_value() );
			$image_path     = YITH_YWBC_UPLOAD_DIR . "/" . $image_filename;

			if ( imagegif( $res['img'], $image_path ) ) {
				imagedestroy( $res['img'] );
			}

			$barcode->save( $image_filename );*/
		}

		/**
		 * Create barcode for new products if needed
		 *
		 * @param string  $new_status
		 * @param string  $old_status
		 * @param WP_Post $post
		 */
		public function on_new_product( $new_status, $old_status, $post ) {

			//  Check if barcode are enabled for products
			if ( ! $this->enable_on_products ) {
				return;
			}

			//  Check if barcode should be create automatically
			if ( ! $this->create_on_products ) {
				return;
			}

			//  Work only on published posts
			if ( 'new' !== $old_status ) {
				return;
			}

			$this->create_product_barcode( $post->ID );
		}

		/**
		 * Create the barcode values for the order
		 *
		 * @param int    $product_id
		 * @param string $protocol
		 * @param string $value
		 */
		public function create_product_barcode( $product_id, $protocol = '', $value = '' ) {

			$protocol  = $protocol ? $protocol : $this->products_protocol;
			$the_value = $value ? $value : $product_id;
			$the_value = apply_filters( 'yith_barcode_new_product_value', $the_value, $product_id, $protocol, $value );

			return $this->generate_barcode_image( $product_id, $protocol, $the_value );
		}

		/**
		 * Manage a request from product bulk actions
		 */
		public function generate_bulk_action() {

			global $typenow;
			$post_type = $typenow;
			$sendback  = admin_url( "edit.php?post_type=$post_type" );

			// 1. get the action
			$wp_list_table = _get_list_table( 'WP_Posts_List_Table' );
			$action        = $wp_list_table->current_action();

			if ( $action == 'ywbc-generate' ) {
				$post_ids = $_GET['post'];
				check_admin_referer( 'bulk-posts' );

				foreach ( $post_ids as $post_id ) {
					$this->create_product_barcode( $post_id );
				}

				// build the redirect url
				//$sendback = add_query_arg( array( 'done' => $done, 'ids' => join( ',', $post_ids ) ), $sendback );

				wp_redirect( $sendback );

				exit();
			}

			// 4. Redirect client

		}

		/**
		 * Set the join part of the query used for filtering products
		 *
		 * @param string   $join
		 * @param WP_Query $par2
		 *
		 * @return string
		 */
		public function query_barcode_join( $join, $par2 ) {

			//  check for necessary arguments
			if ( ! isset( $par2 ) || ! isset( $par2->query["post_type"] ) ) {
				return $join;
			}

			//  Do something only for products and orders
			if ( "product" != $par2->query["post_type"] ) {
				return $join;
			}

			global $wpdb;

			if ( isset( $_GET["s"] ) ) {

				$join .= sprintf( " LEFT JOIN {$wpdb->postmeta} ps_meta ON {$wpdb->posts}.ID = ps_meta.post_id " );
			}

			return $join;
		}

		public function search_by_order_fields( $fields ) {
			$fields[] = YITH_YWBC_META_KEY_BARCODE_DISPLAY_VALUE;

			return $fields;
		}

		/**
		 * Set the where part of the query used for filtering products
		 *
		 * @param string   $where
		 * @param WP_Query $par2
		 *
		 * @return string
		 */
		public function query_barcode_where( $where, $par2 ) {

			//  check for necessary arguments
			if ( ! isset( $par2 ) || ! isset( $par2->query["post_type"] ) ) {
				return $where;
			}

			//  Do something only for products and orders
			if ( "product" != $par2->query["post_type"] ) {
				return $where;
			}

			global $wpdb;
			$post_type = $par2->query["post_type"];

			if ( isset( $_GET["s"] ) ) {

				$where .= sprintf( " or ('%s' = {$wpdb->posts}.post_type and ps_meta.meta_key = '%s' and ps_meta.meta_value like '%%%s%%') ",
					$post_type,
					YITH_YWBC_META_KEY_BARCODE_DISPLAY_VALUE,
					$_GET["s"] );
			}

			return $where;
		}

		/**
		 * show the order barcode on emails
		 *
		 * @param WC_Email $email
		 */
		public function show_on_emails( $email ) {
			//  Check if the barcode should be shown...
			if ( ! $this->show_on_email_completed && ! $this->show_on_email_all ) {
				return;
			}

			if ( ! isset( $email ) ) {
				return;
			}

			//  Only for email related to an order...
			if ( ! $email->object instanceof WC_Order ) {
				return;
			}

			//  Check if only on completed order should be shown the barcode and
			//  this is not the case
			if ( $this->show_on_email_completed && ( 'customer_completed_order' != $email->id ) ) {
				return;
			}

			//  Display the barcode...

			$order = $email->object;
			ob_start();

			include( YITH_YWBC_ASSETS_DIR . '/css/ywbc-main.css' );
			$css = ob_get_clean();

			$this->show_barcode( $order->id, true, $css );
		}

		/**
		 * Build an <img> tag with the barcode image rendered from the base64 format
		 *
		 * @param YITH_Barcode $barcode
		 *
		 * @return string
		 */
		public function render_barcode( $barcode, $show_value = false ) {
			// Format the image SRC:  data:{mime};base64,{data};
			$src = 'data:image/gif;base64,' . $barcode->image;
			$src = '<img class="ywbc-barcode-image" src="' . $src . '">';

			if ( $show_value ) {
				$src .= '<span class="ywbc-barcode-display-value">' . $barcode->get_display_value() . '</span>';
			}

			// Echo out a sample image
			return $src;
		}

		/**
		 * Show the barcode text and graphic
		 *
		 * @param int|YITH_Barcode $obj             The object id or specific YITH_Barcode instance
		 * @param bool             $hide_if_missing Set if the result should be shown even if no barcode exists for the product
		 * @param string           $inline_css      CSS style to be used(needs Emogrifer)
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		private function show_barcode( $obj, $hide_if_missing = false, $inline_css = '' ) {
			$barcode = is_numeric( $obj ) ? new YITH_Barcode( $obj ) : $obj;
			if ( ! $barcode instanceof YITH_Barcode ) {
				return;
			}

			ob_start();
			?>
			<div id="ywbc_barcode_value">
				<?php

				if ( $barcode->exists() ) : ?>

					<?php if ( $barcode->image ) {
						echo $this->render_barcode( $barcode, true );
					}
					?>
				<?php elseif ( ! $hide_if_missing ): ?>
					<span
						class="ywbc-no-barcode-value"><?php _e( "No barcode is available for this element.", 'yith-woocommerce-barcodes' ); ?></span>
				<?php endif; ?>
			</div>
			<?php
			$content = ob_get_clean();

			if ( $inline_css ) {
				try {
					$emogrifier = new Emogrifier( $content, $inline_css );
					$content    = $emogrifier->emogrify();
				} catch ( Exception $e ) {
					$logger = new WC_Logger();
					$logger->add( 'emogrifier', $e->getMessage() );
					error_log( '$e->getMessage() : ' . print_r( $e->getMessage(), true ) );

				}
			}
			echo $content;
		}

		/**
		 * Show the order metabox
		 */
		function add_barcode_metabox() {
			if ( $this->enable_on_orders ) {
				//  Add metabox on order page
				add_meta_box( 'ywbc_barcode',
					__( 'YITH Barcodes', 'yith-woocommerce-barcodes' ), array(
						$this,
						'display_barcode_metabox',
					), 'shop_order', 'side', 'high' );
			}

			if ( $this->enable_on_products ) {
				//  Add metabox on order page
				add_meta_box( 'ywbc_barcode',
					__( 'YITH Barcodes', 'yith-woocommerce-barcodes' ), array(
						$this,
						'display_barcode_metabox',
					), 'product', 'side', 'high' );
			}
		}

		/**
		 * Display the barcode metabox
		 *
		 * @param WP_Post $post
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function display_barcode_metabox( $post ) {

			if ( ( "shop_order" == $post->post_type ) ||
			     ( "product" == $post->post_type )
			) {
				$this->show_barcode( $post->ID );
				$this->show_generate_barcode_button( $post->post_type, $post->ID );
				$this->show_manual_barcode_generation( $post );
			}
		}

		/**
		 * Show the fields for entering custom product barcode value
		 *
		 * @param $post
		 */
		public function show_manual_barcode_generation( $post ) {
			if ( "product" != $post->post_type ) {
				return;
			}

			if ( ! $this->manual_value_on_products ) {
				return;
			}

			?>
			<div class="ywbc-manual-barcode">
				<label for="ywbc-manual-value"><?php _e( 'Enter a value', 'yith-woocommerce-barcodes' ); ?></label>
				<input type="text" name="ywbc-manual-value" id="ywbc-manual-value">
			</div>
			<?php
		}

		/**
		 * Show a button that let the admin to generate a new barcode for the order
		 *
		 * @param string $type the type of object for which the action generate is intended for
		 * @param int    $obj_id
		 */
		public function show_generate_barcode_button( $type = 'shop_order', $obj_id ) {
			?>
			<div class="ywbc-generate-barcode">
				<a id="ywbc-generate"
				   href="<?php echo admin_url( "admin.php?action=generate_barcode&type=" . $type . "&id=" . $obj_id ); ?>"><?php _e( 'Create automatically', 'yith-woocommerce-barcodes' ); ?></a>
			</div>
			<?php

		}

		/**
		 * Generate the order barcode for a specific order id
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function admin_action_generate_barcode() {
			$obj_id = $_GET["id"];
			$type   = $_GET["type"];

			if ( 'shop_order' == $type ) {
				$this->create_order_barcode( $obj_id );
			} elseif ( 'product' == $type ) {
				$this->create_product_barcode( $obj_id );
			}

			wp_redirect( esc_url_raw( admin_url( 'post.php?post=' . $obj_id ) . '&action=edit' ) );
		}

		/**
		 * Show the order barcode on order page
		 *
		 * @param WC_Order $order the order being shown
		 *
		 * @author Lorenzo Giuffrida
		 * @since  1.0.0
		 */
		public function show_barcode_on_view_order_page( $order ) {
			if ( ! $this->show_on_order_page ) {
				return;
			}

			$this->show_barcode( $order->id, true );
		}

		/**
		 * Show the barcode on the product page
		 */
		public function show_barcode_on_single_product_page() {
			if ( ! $this->show_on_product_page ) {
				return;
			}

			global $product;
			$this->show_barcode( $product->id, true );
		}

		/**
		 * Manage the shortcode 'yith_render_barcode' for rendering a barcode by object id or with specific value
		 *
		 *
		 * @param array $atts the shortcode attributes
		 */
		public function sc_render_barcode( $atts ) {
			$fields = shortcode_atts( array(
				'id'            => 0,
				'hide_if_empty' => 1,
				'value'         => '',
				'protocol'      => 'EAN8',
			), $atts );

			//  if id>0 show the barcode for a specific object
			if ( $fields['id'] ) {
				$this->show_barcode( $fields['id'], $fields['hide_if_empty'] );
			} elseif ( $fields['value'] ) {

				//  Show barcode with specific value and protocol
				$barcode = new YITH_Barcode();
				$barcode->generate( $fields['protocol'], $fields['value'] );
				$this->show_barcode( $barcode, $fields['hide_if_empty'] );

			}
		}

		/**
		 * Manage the shortcode 'yith_order_barcode'
		 *
		 * @param array $atts the shortcode attributes
		 *
		 * @return string
		 */
		public function yith_order_barcode( $atts ) {

			$fields = shortcode_atts(
				array(
					'search_type' => 'shop_order',
					'capability'  => 'manage_woocommerce',
					'style'       => 'buttons',
					'actions'     => 'search, complete_order',
				),
				$atts );

			ob_start();
			wc_get_template( 'shortcode/ywbc-barcode-actions.php',
				array(
					'fields'               => $fields,
					'custom_order_actions' => $this->custom_order_actions,
				),
				YITH_YWBC_TEMPLATES_DIR,
				YITH_YWBC_TEMPLATES_DIR
			);
			$content = ob_get_clean();

			return $content;
		}

		/**
		 * Manage the shortcode 'yith_product_barcode'
		 *
		 * @param array $atts the shortcode attributes
		 *
		 * @return string
		 */
		public function yith_product_barcode( $atts ) {

			$fields = shortcode_atts(
				array(
					'search_type' => 'product',
					'capability'  => 'manage_woocommerce',
					'style'       => 'buttons',
					'actions'     => 'search',
				),
				$atts );

			ob_start();
			wc_get_template( 'shortcode/ywbc-barcode-actions.php',
				array(
					'fields'               => $fields,
					'custom_order_actions' => $this->custom_product_actions,
				),
				YITH_YWBC_TEMPLATES_DIR,
				YITH_YWBC_TEMPLATES_DIR
			);

			$content = ob_get_clean();

			return $content;
		}

		/**
		 * apply barcode to product
		 * @since 1.0.2
		 */
		public function apply_barcode_to_products(){

			$item_id = isset( $_POST['ywbc_item_id'] ) ? $_POST['ywbc_item_id'] : false ;
			$result = 'error_on_create_barcode';
			if( $item_id ){
				/**
				 * @var YITH_Barcode $barcode
				 */
				$barcode =$this->create_product_barcode( $item_id );

				if( $barcode->object_id  ){

					$result = 'barcode_created';
				}
			}
			wp_send_json( array('result' => $result ) );
		}

		
	}
}