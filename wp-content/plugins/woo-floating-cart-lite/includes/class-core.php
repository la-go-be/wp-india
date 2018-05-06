<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://xplodedthemes.com
 * @since      1.0.0
 *
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Floating_Cart
 * @subpackage Woo_Floating_Cart/includes
 * @author     XplodedThemes <helpdesk@xplodedthemes.com>
 */
class Woo_Floating_Cart {

	/**
	 * The single instance of Woo_Floating_Cart.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Var that holds the plugin name.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    Plugin Name
	 */
	protected $plugin_name;
	

	/**
	 * Var that holds the plugin slug.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_slug    The string used to uniquely identify this plugin
	 */
	protected $plugin_slug;


	/**
	 * Plugin main file path.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_file   Plugin main file path
	 */
	protected $plugin_file;
	
	/**
	 * License class object
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $license = null;
					
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Floating_Cart_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($file, $version = '1.0.0') {

		// Load plugin environment variables
		
		$this->plugin_name = 'Woo Floating Cart';
		$this->plugin_slug = 'woo-floating-cart';
		$this->plugin_version = $version;
		$this->plugin_file = $file;

		$this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '-min';
		
		$this->loader = $this->load_dependencies();
	
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->loader->run();
		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Floating_Cart_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Floating_Cart_i18n. Defines internationalization functionality.
	 * - Woo_Floating_Cart_Admin. Defines all hooks for the admin area.
	 * - Woo_Floating_Cart_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once $this->plugin_path() . 'includes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $this->plugin_path() . 'includes/class-i18n.php';

		/**
		 * The class responsible for checking for migrations
		 */
		require_once $this->plugin_path() . 'includes/class-migration.php';
					
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once $this->plugin_path() . 'admin/class-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once $this->plugin_path() . 'public/class-public.php';

		return new Woo_Floating_Cart_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Floating_Cart_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Floating_Cart_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		if(is_admin()) {

			// Check for migrations
			new Woo_Floating_Cart_Migration($this);
		
		}

		$this->plugin_admin = new Woo_Floating_Cart_Admin( $this );
		
        $this->loader->add_action( 'admin_body_class', $this->plugin_admin, 'admin_body_class', 1);
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $this->plugin_admin, 'settings_menu', 1);
		$this->loader->add_action( 'admin_notices', $this->plugin_admin, 'woocommerce_missing_notice', 1 );
		$this->loader->add_action( 'plugins_loaded', $this->plugin_admin, 'check_upgraded');
		$this->loader->add_action( 'admin_init', $this->plugin_admin, 'activation_redirect' );
		$this->loader->add_action( 'admin_init', $this->plugin_admin, 'upgrade_success' );
		$this->loader->add_action( 'admin_init', $this->plugin_admin, 'write_changelog' );
		$this->loader->add_filter( 'plugin_action_links_' . plugin_basename( $this->plugin_file() ), $this->plugin_admin, 'action_link', 99);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->plugin_public = new Woo_Floating_Cart_Public( $this );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_action( 'wp_ajax_woofc_update_cart', $this->plugin_public, 'ajax_update_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_woofc_update_cart', $this->plugin_public, 'ajax_update_cart' );

		$this->loader->add_action( 'woocommerce_add_to_cart', $this->plugin_public, 'add_to_cart', 1, 6 );
		$this->loader->add_filter( 'woocommerce_add_to_cart_fragments', $this->plugin_public, 'add_to_cart_fragments', 1, 1 );

		$this->loader->add_filter( 'woocommerce_remove_cart_item', $this->plugin_public, 'remove_cart_item', 1, 2 );
		$this->loader->add_filter( 'woocommerce_cart_item_restored', $this->plugin_public, 'cart_item_restored', 1, 2 );
		
		$this->loader->add_action( 'wp_footer', $this->plugin_public, 'render' );
	}

	/**
	 * The name of the plugin
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function plugin_name() {
		
		return $this->plugin_name;
	}
	
	/**
	 * The ID of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function plugin_slug($section = '') {
		
		return $this->plugin_slug.(!empty($section) ? '-'.$section : '');
	}

	/**
	 * The plugin file
	 *
	 * @since     1.0.0
	 * @return    string    The plugin file.
	 */
	public function plugin_file() {
		
		return $this->plugin_file;
	}

	/**
	 * The plugin directory
	 *
	 * @since     1.0.0
	 * @return    string    The plugin directory.
	 */
	public function plugin_dir() {
		
		return dirname( $this->plugin_file );
	}
	
	/**
	 * The plugin path
	 *
	 * @since     1.0.0
	 * @return    string    The plugin path.
	 */
	public function plugin_path($dir = null, $file = null) {
		
		$path = plugin_dir_path( $this->plugin_file );
		
		if(!empty($dir)) {
			$path .= $dir."/";
		}
		
		if(!empty($file)) {
			$path .= $file;
		}
		
		return $path;
	}

	/**
	 * The plugin URL
	 *
	 * @since     1.0.0
	 * @return    string    The plugin url.
	 */
	public function plugin_url($dir = null, $file = null) {
		
		$url = plugin_dir_url( $this->plugin_file );
		
		if(!empty($dir)) {
			$url .= $dir."/";
		}
		
		if(!empty($file)) {
			$url .= $file;
		}

		return $url;
	}


	public function plugin_admin_url($section = '', $params = array()) {
		
		$url = admin_url('admin.php?page='.$this->plugin_slug($section));

		if(!empty($params)) {
			$url = add_query_arg( $params, $url );
		}
		
		return $url;
	}
	
	/**
	 * The plugin theme templates path
	 *
	 * @since     1.0.0
	 * @return    string    The plugin theme templates path.
	 */
	 
	public function template_path() {
		
	    return apply_filters( 'woo_floating_cart_template_path', 'woo-floating-cart/' );
	}
	
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Floating_Cart_Loader    Orchestrates the hooks of the plugin.
	 */
	public function plugin_loader() {
		
		return $this->loader;
	}

	/**
	 * The reference to the class that manages the frontend side of the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Floating_Cart_Public    Frontend side of the plugin.
	 */
	public function frontend() {
		
		return $this->plugin_public;
	}
	
	/**
	 * The reference to the class that manages the backend side of the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Floating_Cart_Admin    Backend side of the plugin.
	 */
	public function backend() {
		
		return $this->plugin_admin;
	}
		
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function plugin_version() {
		
		return $this->plugin_version;
	}


	/**
	 * Main Woo_Floating_Cart Instance
	 *
	 * Ensures only one instance of Woo_Floating_Cart is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Woo_Floating_Cart()
	 * @return Main Woo_Floating_Cart instance
	 */
	public static function instance ( $file, $version = '1.0.0' ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->plugin_version() );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->plugin_version() );
	} // End __wakeup()
}
