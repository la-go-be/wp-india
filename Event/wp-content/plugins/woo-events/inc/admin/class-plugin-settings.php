<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class WooEvent_Settings {
    private $dir;
	private $file;
	private $assets_dir;
	private $assets_url;
	private $settings_base;
	private $settings;
	public function __construct( $file ) {
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
		$this->settings_base = '';
		// Initialise settings
		add_action( 'admin_init', array( $this, 'init' ) );
		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );
		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );
		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_settings_link' ) );
	}
	/**
	 * Initialise settings
	 * @return void
	 */
	public function init() {
		$this->settings = $this->settings_fields();
	}
	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {
		$page = add_menu_page( esc_html__( 'WooEvents Settings', 'exthemes' ) , esc_html__( 'WooEvents', 'exthemes' ) , 'manage_options' , 'wooevents' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}
	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets() {
		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    // We're including the WP media scripts here because they're needed for the image upload field
    // If you're not including an image upload then you can leave this function call out
    wp_enqueue_media();
    wp_register_script( 'wpt-admin-js', $this->assets_url . 'js/settings.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'wpt-admin-js' );
	}
	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=wooevents">' . esc_html__( 'WooEvents Settings', 'exthemes' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}
	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {
		$settings['general'] = array(
			'title'					=> esc_html__( 'General', 'exthemes' ),
			'description'			=> esc_html__( '', 'exthemes' ),
			'fields'				=> array(
				array(
					'id' 			=> 'we_main_purpose',
					'label'			=> esc_html__( 'Main Purpose', 'exthemes' ),
					'description'	=> esc_html__( 'Select "Custom" to use main layout as woocommerce but you can choose product as event in each product, Select "Only use metadata" to use your theme style and you can choose product as event in each product', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'event' => esc_html__( 'Events', 'exthemes' ),
						'woo' => esc_html__( 'Styling for WooCommerce', 'exthemes' ),
						'custom' => esc_html__( 'Custom', 'exthemes' ),
						'meta' => esc_html__( 'Only use metadata', 'exthemes' )
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_main_color',
					'label'			=> esc_html__( 'Main color', 'exthemes' ),
					'description'	=> esc_html__( 'Choose main color of WooEvents', 'exthemes' ),
					'type'			=> 'color',
					'placeholder'			=> '',
					'default'		=> '#00BCD4'
				),
				array(
					'id' 			=> 'we_fontfamily',
					'label'			=> esc_html__( 'Main Font Family', 'exthemes' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Source Sans Pro" Google Font, enter Source Sans Pro', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_fontsize',
					'label'			=> esc_html__( 'Main Font Size', 'exthemes' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 13px', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_hfont',
					'label'			=> esc_html__( 'Heading Font Family', 'exthemes' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Source Sans Pro" Google Font, enter Ubuntu', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> '',
				),
				array(
					'id' 			=> 'we_hfontsize',
					'label'			=> esc_html__( 'Heading Font Size', 'exthemes' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 20px', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_metafont',
					'label'			=> esc_html__( 'Meta Font Family', 'exthemes' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Ubuntu" Google Font, enter Ubuntu', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> '',
				),
				array(
					'id' 			=> 'we_matafontsize',
					'label'			=> esc_html__( 'Meta Font Size', 'exthemes' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 12px', 'exthemes' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_sidebar',
					'label'			=> esc_html__( 'Sidebar', 'exthemes' ),
					'description'	=> esc_html__( 'Select hide to use sidebar of theme', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'right' => esc_html__( 'Right', 'exthemes' ),
						'left' => esc_html__( 'Left', 'exthemes' ),
						'hide' => esc_html__( 'Hide', 'exthemes' )
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_calendar_lg',
					'label'			=> esc_html__( 'Calendar Language', 'exthemes' ),
					'description'	=> esc_html__( 'Select language of Calendar', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'en' => esc_html__( 'en', 'exthemes' ),
						'ar-ma' => esc_html__( 'ar-ma', 'exthemes' ),
						'ar-sa' => esc_html__( 'ar-sa', 'exthemes' ),
						'ar-tn' => esc_html__( 'ar-tn', 'exthemes' ),
						'ar' => esc_html__( 'ar', 'exthemes' ),
						'bg' => esc_html__( 'bg', 'exthemes' ),
						'ca' => esc_html__( 'ca', 'exthemes' ),
						'cs' => esc_html__( 'cs', 'exthemes' ),
						'da' => esc_html__( 'da', 'exthemes' ),
						'de-at' => esc_html__( 'de-at', 'exthemes' ),
						'de' => esc_html__( 'de', 'exthemes' ),
						'el' => esc_html__( 'el', 'exthemes' ),
						'en-au' => esc_html__( 'en-au', 'exthemes' ),
						'en-ca' => esc_html__( 'en-ca', 'exthemes' ),
						'en-gb' => esc_html__( 'en-gb', 'exthemes' ),
						'en-ie' => esc_html__( 'en-ie', 'exthemes' ),
						'en-nz' => esc_html__( 'en-nz', 'exthemes' ),
						'es' => esc_html__( 'es', 'exthemes' ),
						'fa' => esc_html__( 'fa', 'exthemes' ),
						'fi' => esc_html__( 'fi', 'exthemes' ),
						'fr-ca' => esc_html__( 'fr-ca', 'exthemes' ),
						'fr-ch' => esc_html__( 'fr-ch', 'exthemes' ),
						'fr' => esc_html__( 'fr', 'exthemes' ),
						'he' => esc_html__( 'he', 'exthemes' ),
						'hi' => esc_html__( 'hi', 'exthemes' ),
						'hr' => esc_html__( 'hr', 'exthemes' ),
						'hu' => esc_html__( 'hu', 'exthemes' ),
						'id' => esc_html__( 'id', 'exthemes' ),
						'is' => esc_html__( 'is', 'exthemes' ),
						'it' => esc_html__( 'it', 'exthemes' ),
						'ja' => esc_html__( 'ja', 'exthemes' ),
						'ko' => esc_html__( 'ko', 'exthemes' ),
						'lt' => esc_html__( 'lt', 'exthemes' ),
						'lv' => esc_html__( 'lv', 'exthemes' ),
						'nb' => esc_html__( 'nb', 'exthemes' ),
						'nl' => esc_html__( 'nl', 'exthemes' ),
						'pl' => esc_html__( 'pl', 'exthemes' ),
						'pt-br' => esc_html__( 'pt-br', 'exthemes' ),
						'pt' => esc_html__( 'pt', 'exthemes' ),
						'ro' => esc_html__( 'ro', 'exthemes' ),
						'ru' => esc_html__( 'ru', 'exthemes' ),
						'sk' => esc_html__( 'sk', 'exthemes' ),
						'sl' => esc_html__( 'sl', 'exthemes' ),
						'sr-cyrl' => esc_html__( 'sr-cyrl', 'exthemes' ),
						'sr' => esc_html__( 'sr', 'exthemes' ),
						'sv' => esc_html__( 'sv', 'exthemes' ),
						'th' => esc_html__( 'th', 'exthemes' ),
						'tr' => esc_html__( 'tr', 'exthemes' ),
						'uk' => esc_html__( 'uk', 'exthemes' ),
						'vi' => esc_html__( 'vi', 'exthemes' ),
						'zh-cn' => esc_html__( 'zh-cn', 'exthemes' ),
						'zh-tw' => esc_html__( 'zh-tw', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_speaker_slug',
					'label'			=> esc_html__( 'Speaker Slug' , 'exthemes' ),
					'description'	=> esc_html__( 'Remember to save the permalink settings again in Settings > Permalinks', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__('', 'exthemes' )
				),
				/*array(
					'id' 			=> 'we_speaker_venue',
					'label'			=> esc_html__( 'Speaker &amp; Venue field' , 'exthemes' ),
					'description'	=> esc_html__( 'Select Ajax search or list view for this metadata' ),
					'type'			=> 'select',
					'options'		=> array( 
						'ajax' => esc_html__( 'Ajax type and search', 'exthemes' ),
						'list' => esc_html__( 'List view', 'exthemes' ),
						),
					'default'		=> '',
					'placeholder'	=> esc_html__('', 'exthemes' )
				),*/
				array(
					'id' 			=> 'we_shop_view',
					'label'			=> esc_html__( 'Listing default view', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'month' => esc_html__( 'Calendar Month', 'exthemes' ),
						'list' => esc_html__( 'List', 'exthemes' ),
						'map' => esc_html__( 'Map', 'exthemes' ),
						'week' => esc_html__( 'Agenda Week', 'exthemes' ),
						'day' => esc_html__( 'Agenda Day', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_firstday',
					'label'			=> esc_html__( 'The day that each week begins', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'1' => esc_html__('Monday', 'exthemes'),
						'2' => esc_html__('Tuesday', 'exthemes'),
						'3' => esc_html__('Wednesday', 'exthemes'),
						'4' => esc_html__('Thursday', 'exthemes'),
						'5' => esc_html__('Friday', 'exthemes'),
						'6' => esc_html__('Saturday', 'exthemes'),
						'7' => esc_html__('Sunday', 'exthemes'),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_listing_order',
					'label'			=> esc_html__( 'Listing default order', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'upcoming' => esc_html__( 'Upcoming', 'exthemes' ),
						'ontoup' => esc_html__( 'Ongoing and Upcoming', 'exthemes' ),
						'all' => esc_html__( 'Default order', 'exthemes' ),
						'def' => esc_html__( 'Default order bar of Woocommerce', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_enable_cart',
					'label'			=> esc_html__( 'Enable redirect to Checkout page', 'exthemes' ),
					'description'	=> esc_html__( 'Redirect to the Checkout page after successful addition', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'on' => esc_html__( 'Off', 'exthemes' ),
						'off' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_auto_color',
					'label'			=> esc_html__( 'Auto change color when low stock', 'exthemes' ),
					'description'	=> esc_html__( 'This feature allow user can see product has color Red when out of stock or Yellow when the seats are between the limit and 0 in listing page', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'off' => esc_html__( 'Off', 'exthemes' ),
						'on' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_cat_ctcolor',
					'label'			=> esc_html__( 'Enable custom color for category', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'off' => esc_html__( 'Off', 'exthemes' ),
						'on' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_stop_booking',
					'label'			=> esc_html__( 'Stop booking before event start', 'exthemes' ),
					'description'	=> esc_html__( 'This feature allow you can block all booking before X day before event start', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( 'Enter number', 'exthemes' )
				),
				array(
					'id' 			=> 'we_speaker',
					'label'			=> esc_html__( 'Disable speaker feature', 'exthemes' ),
					'description'	=> esc_html__( 'Disable speaker feature if you dont use it', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_venue_off',
					'label'			=> esc_html__( 'Disable Default Venue feature', 'exthemes' ),
					'description'	=> esc_html__( 'Disable Default Venue if you dont use it', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_multi_attendees',
					'label'			=> esc_html__( 'Enable multiple attendees info', 'exthemes' ),
					'description'	=> esc_html__( 'Show field for enter name & email for each ticket', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
					),
					'default'		=> ''
				),
			)
		);
		$settings['map_settings'] = array(
			'title'					=> esc_html__( 'Map Settings', 'exthemes' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'we_api_map',
					'label'			=> esc_html__( 'API Key' , 'exthemes' ),
					'description'	=> esc_html__( 'Google Maps APIs now requires a key, you can check how to create api key here: https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_smap',
					'label'			=> esc_html__( 'Map Icon' , 'exthemes' ),
					'description'	=> esc_html__( 'Select icon default of Map', 'exthemes' ),
					'type'			=> 'image',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_zoom_map',
					'label'			=> esc_html__( 'Map Zoom' , 'exthemes' ),
					'description'	=> esc_html__( 'Enter number, default: 1', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_map_style',
					'label'			=> esc_html__( 'Paste custom code style of map' , 'exthemes' ),
					'description'	=> esc_html__( 'Choose custom code style of map here: https://snazzymaps.com/explore?sort=popular', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
			)
		);
		$layout = array( 'layout-1' => esc_html__( 'Layout 1', 'exthemes' ), 'layout-2' => esc_html__( 'Layout 2', 'exthemes' ), 'layout-3' => esc_html__( 'Layout 3', 'exthemes' ));
		$layout = apply_filters( 'we_change_def_layout_meta', $layout );
		$settings['single_event'] = array(
			'title'					=> esc_html__( 'Single event', 'exthemes' ),
			'description'			=> esc_html__( '', 'exthemes' ),
			'fields'				=> array(
				array(
					'id' 			=> 'we_slayout',
					'label'			=> esc_html__( 'Layout', 'exthemes' ),
					'description'	=> esc_html__( 'Select default layout of single event', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> $layout,
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_ssocial',
					'label'			=> esc_html__( 'Show Social Share', 'exthemes' ),
					'description'	=> esc_html__( 'Show/hide Social Share section', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Show', 'exthemes' ),
						'off' => esc_html__( 'Hide', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_srelated',
					'label'			=> esc_html__( 'Show related', 'exthemes' ),
					'description'	=> esc_html__( 'Show/hide Related Event section', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Show', 'exthemes' ),
						'off' => esc_html__( 'Hide', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_related_count',
					'label'			=> esc_html__( 'Number of related' , 'exthemes' ),
					'description'	=> esc_html__( 'Enter number, default 3', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_sevent_navi',
					'label'			=> esc_html__( 'Show Event Navigation', 'exthemes' ),
					'description'	=> esc_html__( 'Show/hide Event Navigation section', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Show', 'exthemes' ),
						'off' => esc_html__( 'Hide', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_single_map',
					'label'			=> esc_html__( 'Default Map Style', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_click_remove',
					'label'			=> esc_html__( 'Remove click on button', 'exthemes' ),
					'description'	=> esc_html__('Remove click event on qty button when your theme has already added this event', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_enable_review',
					'label'			=> esc_html__( 'Enable Review for Event', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'off' => esc_html__( 'Off', 'exthemes' ),
						'on' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_enable_sginfo',
					'label'			=> esc_html__( 'User already Signed up info', 'exthemes' ),
					'description'	=> esc_html__( 'Enable show info if user  has signed up event', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'off' => esc_html__( 'Off', 'exthemes' ),
						'on' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
				
			)
		);
		$settings['search-page'] = array(
			'title'					=> esc_html__( 'Search bar', 'exthemes' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'we_search_enable',
					'label'			=> esc_html__( 'Enable search bar', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Enable', 'exthemes' ),
						'disable' => esc_html__( 'Disable', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_search_style',
					'label'			=> esc_html__( 'Search Style', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Default', 'exthemes' ),
						'sc' => esc_html__( 'Shortcode', 'exthemes' ),
						),
					'default'		=> ''
				),			
				array(
					'id' 			=> 'we_search_result',
					'label'			=> esc_html__( 'Show search result in', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Listing', 'exthemes' ),
						'map' => esc_html__( 'Map', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_search_ajax',
					'label'			=> esc_html__( 'Ajax search', 'exthemes' ),
					'description'	=> esc_html__( 'Only work with Listing result and default style', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'exthemes' ),
						'yes' => esc_html__( 'Yes', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_scat_include',
					'label'			=> esc_html__( 'Category include' , 'exthemes' ),
					'description'	=> esc_html__( 'List of cat ID (or slug), separated by a comma, leave blank to show all category in dropdown', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_stag_include',
					'label'			=> esc_html__( 'Tags include' , 'exthemes' ),
					'description'	=> esc_html__( 'List of Tag ID (or slug), separated by a comma, leave blank to show all Tags ', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_syear_include',
					'label'			=> esc_html__( 'Event Years filter include' , 'exthemes' ),
					'description'	=> esc_html__( 'List of year, separated by a comma, ex:2016,2017. Leave blank to show 5 year nearest', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_loca_include',
					'label'			=> esc_html__( 'Event location filter include ( only work with shrortcode style)' , 'exthemes' ),
					'description'	=> esc_html__( 'List of location, separated by a comma, ex:16,17. Leave blank to show all, enter hide to hide this field', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
			)
		);
		$settings['custom-css'] = array(
			'title'					=> esc_html__( 'Custom css', 'exthemes' ),
			'description'			=> esc_html__( '', 'exthemes' ),
			'fields'				=> array(
				array(
					'id' 			=> 'we_custom_css',
					'label'			=> esc_html__( 'Paste your CSS code' , 'exthemes' ),
					'description'	=> esc_html__( 'Add custom CSS code to the plugin without modifying files', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_custom_code',
					'label'			=> esc_html__( 'Paste your js code' , 'exthemes' ),
					'description'	=> esc_html__( 'Add custom js code to the plugin without modifying files', 'exthemes' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);
		$settings['email-reminder'] = array(
			'title'					=> esc_html__( 'Email reminder', 'exthemes' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'we_email_reminder',
					'label'			=> esc_html__( 'Email reminder', 'exthemes' ),
					'description'	=> esc_html__( 'Select off to disable this feature', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'On', 'exthemes' ),
						'off' => esc_html__( 'Off', 'exthemes' ),
						),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_email_delay',
					'label'			=> esc_html__( 'Time for sending the email notification before Event start', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( 'Enter number', 'exthemes' )
				),
				array(
					'id' 			=> 'we_email_timeformat',
					'label'			=> esc_html__( 'Type', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => '',
						'1' => esc_html__( 'seconds', 'exthemes' ),
						'60' => esc_html__( 'minutes', 'exthemes' ),
						'3600' => esc_html__( 'hours', 'exthemes' ),
						'86400' => esc_html__( 'days', 'exthemes' ),
						'604800' => esc_html__( 'weeks', 'exthemes' ),
						'18144000' => esc_html__( 'months', 'exthemes' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_email_content',
					'label'			=> esc_html__( 'Content of Email', 'exthemes' ),
					'description'	=> 'You can use [eventitle] for event title and [eventdate] for date of event and [eventlink] for link of event',
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);
		$settings['submit-event'] = array(
			'title'					=> esc_html__( 'Submit Event', 'exthemes' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'we_sm_cat',
					'label'			=> esc_html__( 'Exclude Category checkbox', 'exthemes' ),
					'description'	=> '',
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( 'Enter list id of category, ex: 23,66,1', 'exthemes' )
				),
				array(
					'id' 			=> 'we_sm_notify',
					'label'			=> esc_html__( 'Email Notification', 'exthemes' ),
					'description'	=> esc_html__( 'Send notification email to user when email is published', 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'0' => esc_html__( 'Off', 'exthemes' ),
						'1' => esc_html__( 'On', 'exthemes' ),
						),
					'default'		=> ''
				),
			)
		);
		$settings['js_css_settings'] = array(
			'title'					=> esc_html__( 'Js & Css file', 'exthemes' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'we_fontawesome',
					'label'			=> esc_html__( 'Turn off Font Awesome', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading plugin's Font Awesome. Check if your theme has already loaded this library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_boostrap_css',
					'label'			=> esc_html__( 'Turn off Bootstrap Css file', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading plugin's Bootstrap library. Check if your theme has already loaded this library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_googlemap_js',
					'label'			=> esc_html__( 'Turn off Google Map Api Js file', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading plugin's Google Map Api Js file. Check if your theme has already loaded this library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_googlefont_js',
					'label'			=> esc_html__( 'Turn off Google Font', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading Google Font", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_owl_js',
					'label'			=> esc_html__( 'Turn off Owl Carousel library', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading Owl Carousel library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_jscolor_js',
					'label'			=> esc_html__( 'Turn off Jscolor js', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading Jscolor js. Check if your theme has already loaded this library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_qtip_js',
					'label'			=> esc_html__( 'Turn off Qtip js', 'exthemes' ),
					'description'	=> esc_html__( "Turn off loading Qtip js. Check if your theme has already loaded this library", 'exthemes' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'we_plugin_style',
					'label'			=> esc_html__( 'Plugin Style', 'exthemes' ),
					'description'	=> esc_html__( "Select Off to disable load plugin style", 'exthemes' ),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Default', 'exthemes' ),
						//'basic' => esc_html__( 'Basic', 'exthemes' ),
						'off' => esc_html__( 'Off', 'exthemes' ),
					),
					'default'		=> ''
				),
			)
		);
		$settings['static-text'] = array(
			'title'					=> esc_html__( 'Front end Static Text', 'exthemes' ),
			'description'			=> esc_html__( '', 'exthemes' ),
			'fields'				=> array(
				array(
					'id' 			=> 'we_text_speaker',
					'label'			=> esc_html__( 'Speaker' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_join_ev',
					'label'			=> esc_html__( 'Join this Event' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_join_now',
					'label'			=> esc_html__( 'Join Now' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_related',
					'label'			=> esc_html__( 'Related Events' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_event_pass',
					'label'			=> esc_html__( 'This event has passed' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_add_to_cart',
					'label'			=> esc_html__( 'Add To Cart' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_details',
					'label'			=> esc_html__( 'Details' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evdetails',
					'label'			=> esc_html__( 'Event Details' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_viewdetails',
					'label'			=> esc_html__( 'View Details' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_ical',
					'label'			=> esc_html__( '+ Ical Import' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_ggcal',
					'label'			=> esc_html__( '+ Google calendar' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_from',
					'label'			=> esc_html__( 'From' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_stdate',
					'label'			=> esc_html__( 'Start Date' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_edate',
					'label'			=> esc_html__( 'End Date' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_allday',
					'label'			=> esc_html__( 'All day' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_previous',
					'label'			=> esc_html__( 'Previous' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_previousev',
					'label'			=> esc_html__( 'Previous Event' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_next',
					'label'			=> esc_html__( 'Next' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_nextev',
					'label'			=> esc_html__( 'Next Event' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_search',
					'label'			=> esc_html__( 'Search' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_all',
					'label'			=> esc_html__( 'All' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_viewas',
					'label'			=> esc_html__( 'View as' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_month',
					'label'			=> esc_html__( 'Month' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_week',
					'label'			=> esc_html__( 'Week' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_day',
					'label'			=> esc_html__( 'Day' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_map',
					'label'			=> esc_html__( 'Map' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_list',
					'label'			=> esc_html__( 'List' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_select',
					'label'			=> esc_html__( 'Select' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_unl_tic',
					'label'			=> esc_html__( 'Unlimited tickets' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_unl_pie',
					'label'			=> esc_html__( 'Unlimited pieces' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_qty_av',
					'label'			=> esc_html__( 'Qty Available' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_pie_av',
					'label'			=> esc_html__( 'Pieces Available' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_no_tk',
					'label'			=> esc_html__( 'There are no ticket available at this time.' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_no_pie',
					'label'			=> esc_html__( 'There are no pieces available at this time.' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_no_resu',
					'label'			=> esc_html__( 'Nothing matched your search terms. Please try again with some different keywords.' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_no_evf',
					'label'			=> esc_html__( 'No Events Found' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_hours',
					'label'			=> esc_html__( 'Hours' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_min',
					'label'			=> esc_html__( 'min' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_sec',
					'label'			=> esc_html__( 'sec' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_loadm',
					'label'			=> esc_html__( 'Load more' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_name',
					'label'			=> esc_html__( 'Name' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_price',
					'label'			=> esc_html__( 'Price' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_status',
					'label'			=> esc_html__( 'Status' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_loca',
					'label'			=> esc_html__( 'Location' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_date',
					'label'			=> esc_html__( 'Date' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_buytk',
					'label'			=> esc_html__( 'BUY TICKET -' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_start',
					'label'			=> esc_html__( 'Start' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_end',
					'label'			=> esc_html__( 'End' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_addres',
					'label'			=> esc_html__( 'Address' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_vmap',
					'label'			=> esc_html__( 'View Map' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_phone',
					'label'			=> esc_html__( 'Phone' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_email',
					'label'			=> esc_html__( 'Email' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_web',
					'label'			=> esc_html__( 'Website' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_hassold',
					'label'			=> esc_html__( 'Has sold' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_schedule',
					'label'			=> esc_html__( 'Schedule' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_speaker',
					'label'			=> esc_html__( 'Speaker' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evname',
					'label'			=> esc_html__( 'Event Name' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evdate',
					'label'			=> esc_html__( 'Event Date' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evlocati',
					'label'			=> esc_html__( 'Event Location' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				// 2.2
				array(
					'id' 			=> 'we_text_evcat',
					'label'			=> esc_html__( 'Category' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evtag',
					'label'			=> esc_html__( 'Tags' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evyears',
					'label'			=> esc_html__( 'Years' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_evfilter',
					'label'			=> esc_html__( 'Filter' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_usersg',
					'label'			=> esc_html__( 'You already signed up this event' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_speaker_of',
					'label'			=> esc_html__( 'Speaker of Events' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_protect_ct',
					'label'			=> esc_html__( 'Please login to see' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_protect_ct',
					'label'			=> esc_html__( 'Please login to see' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_sl_op',
					'label'			=> esc_html__( 'Select options' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_spon',
					'label'			=> esc_html__( 'Sponsors' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_stopb',
					'label'			=> esc_html__( 'Tickets not available' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_pending',
					'label'			=> esc_html__( '[pending]' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_trash',
					'label'			=> esc_html__( '[trash]' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
				
				array(
					'id' 			=> 'we_text_upc',
					'label'			=> esc_html__( 'Upcoming Events' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_defa',
					'label'			=> esc_html__( 'Default' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_ong',
					'label'			=> esc_html__( 'Ongoing Events' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_pas',
					'label'			=> esc_html__( 'Past Events' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
				array(
					'id' 			=> 'we_text_name_',
					'label'			=> esc_html__( 'Name:' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
				array(
					'id' 			=> 'we_text_fname_',
					'label'			=> esc_html__( 'First Name:' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_lname_',
					'label'			=> esc_html__( 'Last Name:' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
				array(
					'id' 			=> 'we_text_email_',
					'label'			=> esc_html__( 'Email:' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				array(
					'id' 			=> 'we_text_attende_',
					'label'			=> esc_html__( 'Attendees info' , 'exthemes' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'exthemes' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'exthemes' )
				),
				
			)
		);
		$we_main_purpose = we_global_main_purpose();
		if($we_main_purpose=='meta'){
			unset ($settings['general']['fields'][8],$settings['general']['fields'][11],$settings['general']['fields'][12],$settings['general']['fields'][14]);
			unset ($settings['search-page'],$settings['single_event']);
			$settings['single_event'] = array(
				'title'					=> esc_html__( 'Single event', 'exthemes' ),
				'description'			=> esc_html__( '', 'exthemes' ),
				'fields'				=> array(
					array(
						'id' 			=> 'we_slayout_purpose',
						'label'			=> esc_html__( 'Default Layout Purpose', 'exthemes' ),
						'description'	=> esc_html__( 'Select default layout of single event', 'exthemes' ),
						'type'			=> 'select',
						'options'		=> array( 
							'woo' => esc_html__( 'WooCommere', 'exthemes' ),
							'event' => esc_html__( 'Event', 'exthemes' ),
						),
						'default'		=> ''
					),
					array(
						'id' 			=> 'we_ssocial',
						'label'			=> esc_html__( 'Show Social Share', 'exthemes' ),
						'description'	=> esc_html__( 'Show/hide Social Share section', 'exthemes' ),
						'type'			=> 'select',
						'options'		=> array( 
							'' => esc_html__( 'Show', 'exthemes' ),
							'off' => esc_html__( 'Hide', 'exthemes' ),
						),
						'default'		=> ''
					),
					array(
						'id' 			=> 'we_single_map',
						'label'			=> esc_html__( 'Default Map Style', 'exthemes' ),
						'description'	=> '',
						'type'			=> 'select',
						'options'		=> array( 
							'' => esc_html__( 'No', 'exthemes' ),
							'yes' => esc_html__( 'Yes', 'exthemes' ),
						),
						'default'		=> ''
					),
					
				)
			);
		}
		$settings = apply_filters( 'wooevents_fields', $settings );
		return $settings;
	}
	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings() {
		if( is_array( $this->settings ) ) {
			foreach( $this->settings as $section => $data ) {
				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'wooevents' );
				foreach( $data['fields'] as $field ) {
					// Validation callback for field
					$validation = '';
					if( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}
					// Register field
					$option_name = $this->settings_base . $field['id'];
					register_setting( 'wooevents', $option_name, $validation );
					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'wooevents', $section, array( 'field' => $field ) );
				}
			}
		}
	}
	public function settings_section( $section ) {
		$html = '<p class="'.$section['id'].'"> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}
	/**
	 * Generate HTML for displaying fields
	 * @param  array $args Field data
	 * @return void
	 */
	public function display_field( $args ) {
		$field = $args['field'];
		$html = '';
		$option_name = $this->settings_base . $field['id'];
		$option = get_option( $option_name );
		$data = '';
		if( isset( $field['default'] ) ) {
			$data = $field['default'];
			if( $option ) {
				$data = $option;
			}
		}
		switch( $field['type'] ) {
			case 'text':
			case 'password':
			case 'number':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
			break;
			case 'text_secret':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
			break;
			case 'textarea':
				$html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>'. "\n";
			break;
			case 'checkbox':
				$checked = '';
				if( $option && 'on' == $option ){
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
			break;
			case 'checkbox_multi':
				foreach( $field['options'] as $k => $v ) {
					$checked = false;
					if( in_array( $k, $data ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;
			case 'radio':
				foreach( $field['options'] as $k => $v ) {
					$checked = false;
					if( $k == $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;
			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
			break;
			case 'select_multi':
				$html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( in_array( $k, $data ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
				}
				$html .= '</select> ';
			break;
			case 'image':
				$image_thumb = '';
				if( $data ) {
					$image_thumb = wp_get_attachment_thumb_url( $data );
				}
				$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
				$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . esc_html__( 'Upload an image' , 'exthemes' ) . '" data-uploader_button_text="' . esc_html__( 'Use image' , 'exthemes' ) . '" class="image_upload_button button" value="'. esc_html__( 'Upload new image' , 'exthemes' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="'. esc_html__( 'Remove image' , 'exthemes' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
			break;
			case 'color':
				?><div class="color-picker" style="position:relative;">
			        <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
			        <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
			    </div>
			    <?php
			break;
		}
		switch( $field['type'] ) {
			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $field['description'] . '</span>';
			break;
			default:
				$html .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
			break;
		}
		echo $html;
	}
	/**
	 * Validate individual settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function validate_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}
	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page() {
		// Build page HTML
		$html = '<div class="wrap" id="wooevents">' . "\n";
			$html .= '<h2>' . esc_html__( 'WooEvents Settings' , 'exthemes' ) . '</h2>' . "\n";
			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
				// Setup navigation
				$html .= '<ul id="settings-sections" class="subsubsub hide-if-no-js">' . "\n";
					//$html .= '<li><a class="tab all current" href="#standard">' . esc_html__( 'All' , 'exthemes' ) . '</a></li>' . "\n";
					foreach( $this->settings as $section => $data ) {
						$html .= '<li><a class="tab" href="#' . $section . '">' . $data['title'] . '</a> <span>|</span></li>' . "\n";
					}
				$html .= '</ul>' . "\n";
				$html .= '<div class="clear"></div>' . "\n";
				// Get settings fields
				ob_start();
				settings_fields( 'wooevents' );
				do_settings_sections( 'wooevents' );
				$html .= ob_get_clean();
				$html .= '<p class="submit">' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( esc_html__( 'Save Settings' , 'exthemes' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";
		echo $html;
	}
}