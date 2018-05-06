<?php
/*
Plugin Name: WooEvents
Plugin URI: http://www.exthemes.net
Description: Wordpress Calendar and Event Booking
Version: 2.7
Package: Ex 2.0
Author: ExThemes
Author URI: http://exthemes.net/
License: Commercial
*/

define( 'WOO_EVENT_PATH', plugin_dir_url( __FILE__ ) );

// Make sure we don't expose any info if called directly
if ( !defined('WOO_EVENT_PATH') ){
	die('-1');
}
if(!function_exists('we_get_plugin_url')){
	function we_get_plugin_url(){
		return plugin_dir_path(__FILE__);
	}
}
if(!function_exists('we_check_woo_exists')){
	function we_check_woo_exists() {
		$class = 'notice notice-error';
		$message = esc_html__( 'WooCommerce is Required to WooEvents plugin work, please install or activate WooCommerce plugin', 'exthemes' );
	
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message ); 
	}
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if (!is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		add_action( 'admin_notices', 'we_check_woo_exists' );
		return;
	}
	function we_mapapi_notice() {
		$we_api_map = get_option('we_api_map');
		if($we_api_map == ''){?>
			<div class="notice notice-warning is-dismissible">
				<p><?php esc_html_e( 'Google Maps APIs now requires API key, To make event map work, You need to create API key here: https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key and add it into WooEvents > Map Settings > API Key', 'exthemes' ); ?></p>
			</div>
			<?php
		}
	}
	add_action( 'admin_notices', 'we_mapapi_notice' );
}
class ExWooEvent{ //
	public $template_url;
	public $plugin_path;
	public function __construct()
    {
		$this->includes();
		if(is_admin()){
			$this->register_plugin_settings();
		}
		add_action( 'after_setup_theme', array(&$this, 'ex_calthumb_register') );
		add_action( 'admin_enqueue_scripts', array($this, 'wooevent_admin_css') );
		add_action( 'wp_enqueue_scripts', array($this, 'frontend_scripts') );
		add_filter( 'template_include', array( $this, 'we_template_loader' ),999 );
		add_action('wp_enqueue_scripts', array($this, 'frontend_style'),99 );
		add_action('wp_head',array( $this, 'we_custom_css'),100);
		add_action('plugins_loaded',array( $this, 'we_plugin_load_textdomain'));
		add_action( 'wp_footer', array( $this,'enqueue_customjs'),99 );
    }
	function we_plugin_load_textdomain() {
		$textdomain = 'exthemes';
		$locale = '';
		if ( empty( $locale ) ) {
			if ( is_textdomain_loaded( $textdomain ) ) {
				return true;
			} else {
				return load_plugin_textdomain( $textdomain, false, plugin_basename( dirname( __FILE__ ) ) . '/language' );
			}
		} else {
			return load_textdomain( $textdomain, plugin_basename( dirname( __FILE__ ) ) . '/' . $textdomain . '-' . $locale . '.mo' );
		}
	}
	function we_custom_css(){
		echo '<style type="text/css">';
			$we_main_purpose = get_option('we_main_purpose');
			if($we_main_purpose!='meta'){
				require we_get_plugin_url(). '/css/custom.css.php';
			}else{
				require we_get_plugin_url(). '/css/custom-meta-only.css.php';
			}
		echo '</style>';
	}

	function we_template_loader($template){
		$find = array('single-speaker.php');
		$file = '';			
		if(is_singular('ex-speaker')){
			$file = 'speaker/single-speaker.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
			if ( $file ) {
				$template = locate_template( $find );
				
				if ( ! $template ) $template = $this->plugin_path() . '/templates/speaker/single-speaker.php';
			}
		}elseif(is_post_type_archive( 'ex-speaker' )){
			$file = 'speaker/speaker-listing.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
			if ( $file ) {
				$template = locate_template( $find );
				
				if ( ! $template ) $template = $this->plugin_path() . '/templates/speaker/speaker-listing.php';
			}
		}
		$we_main_purpose = get_option('we_main_purpose');
		if($we_main_purpose!='meta'){
			if(is_post_type_archive( 'product' ) || is_tax('product_cat') || is_tax('product_tag') ){
				$file = 'archive-product.php';
				$find[] = $file;
				$find[] = $this->template_url . $file;
				
				if ( $file ) {
					$template = locate_template( $find );
					
					if ( ! $template ){
						$file = 'woo-events/archive-product.php';
						$find[] = $file;
						$find[] = $this->template_url . $file;
						$template = locate_template( $find );
						if ( ! $template ){
							$template = $this->plugin_path() . '/templates/archive-product.php';
						}
					}
				}
				
			}
			if(is_singular('product')){
				$file = 'single-product.php';
				$find[] = $file;
				$find[] = $this->template_url . $file;
				
				if ( $file ) {
					$template = locate_template( $find );
					
					if ( ! $template ){
						$file = 'woo-events/single-product.php';
						$find[] = $file;
						$find[] = $this->template_url . $file;
						$template = locate_template( $find );
						if ( ! $template ){
							$template = $this->plugin_path() . '/templates/single-product.php';
						}
					}
				}
			}
		}
		return $template;		
	}
	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;
		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	function register_plugin_settings(){
		global $settings;
		$settings = new WooEvent_Settings(__FILE__);
		return $settings;
	}
	//thumbnails register
	function ex_calthumb_register(){
		add_image_size('thumb_150x160',150,160, true);
		add_image_size('thumb_150x140',150,140, true);
		add_image_size('wethumb_300x300',300,300, true);
		add_image_size('wethumb_460x307',460,307, true);
		add_image_size('wethumb_85x85',85,85, true);
	}
	//inculde
	function includes(){
		if(is_admin()){
			require_once  we_get_plugin_url().'inc/admin/class-plugin-settings.php';
			include_once we_get_plugin_url().'inc/admin/functions.php';
			if(!function_exists('exc_mb_init')){
				if(!class_exists('EXC_MB_Meta_Box')){
					include_once we_get_plugin_url().'inc/admin/Meta-Boxes/custom-meta-boxes.php';
				}
			}
			include we_get_plugin_url(). 'inc/admin/class-event-meta.php';
		}
		if(get_option('we_speaker')!='yes'){
			require_once we_get_plugin_url().'inc/speaker/class-speaker-post-type.php';
		}
		if(get_option('we_venue_off')!='yes'){
			require_once we_get_plugin_url().'inc/admin/class-venue-post-type.php';
		}
		// Reminder email class
		if(get_option('we_email_reminder')!='off'){
			require_once we_get_plugin_url().'inc/class-email-reminder.php';
		}
		$we_main_purpose = get_option('we_main_purpose');
		if($we_main_purpose!='meta'){
			require_once we_get_plugin_url().'inc/class-woo-event.php';
		}else{
			require_once we_get_plugin_url().'inc/class-meta-event-only.php';
		}
		if(get_option('we_multi_attendees')=='yes'){
			require_once we_get_plugin_url().'inc/class-checkout-hook.php';
		}
		include_once we_get_plugin_url().'inc/functions.php';
		include we_get_plugin_url().'shortcode/map.php';
		include we_get_plugin_url().'shortcode/count-down.php';
		include we_get_plugin_url().'shortcode/calendar.php';
		include we_get_plugin_url().'shortcode/event-table.php';
		include we_get_plugin_url().'shortcode/event-grid.php';
		include we_get_plugin_url().'shortcode/event-carousel.php';
		include we_get_plugin_url().'shortcode/timeline.php';
		include we_get_plugin_url().'shortcode/speaker-sc.php';
		include we_get_plugin_url().'shortcode/event-search.php';
		//widget
		include we_get_plugin_url().'widgets/events-search.php';
		include we_get_plugin_url().'widgets/latest-events.php';
	}
	/*
	 * Load js and css
	 */
	function wooevent_admin_css(){
		$js_params = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		wp_localize_script( 'jquery', 'woo_events', $js_params  );
		// CSS for button styling
		wp_enqueue_style("wooevent_admin_style", WOO_EVENT_PATH . '/assets/css/style.css');
		wp_enqueue_script( 'we-color-picker', WOO_EVENT_PATH. 'js/jscolor.min.js', array('jquery'), '2.0' );
		$we_api_map = get_option('we_api_map');
		if($we_api_map!=''){
		wp_enqueue_script( 'wooevent-auto-map', '//maps.googleapis.com/maps/api/js?key='.$we_api_map.'&libraries=places');
		}
		wp_enqueue_script( 'wooevent-admin-js', WOO_EVENT_PATH . 'assets/js/admin.js', array( 'jquery' ) );
	}
	function frontend_scripts(){
		$we_fontawesome = get_option('we_fontawesome');
		if($we_fontawesome!='on'){
			wp_enqueue_style('we-font-awesome', WOO_EVENT_PATH.'css/font-awesome/css/font-awesome.min.css');
		}
		$we_boostrap_css = get_option('we_boostrap_css');
		if($we_boostrap_css!='on'){
			wp_enqueue_style('we-bootstrap-min', WOO_EVENT_PATH.'js/bootstrap/bootstrap.min.css');
		}
		$main_font_default='Source Sans Pro';
		$meta_font_default='Ubuntu';
		$g_fonts = array($main_font_default, $meta_font_default);
		$we_fontfamily = get_option('we_fontfamily');
		if($we_fontfamily!=''){
			$we_fontfamily = we_get_google_font_name($we_fontfamily);
			array_push($g_fonts, $we_fontfamily);
		}
		$we_hfont = get_option('we_hfont');
		if($we_hfont!=''){
			$we_hfont = we_get_google_font_name($we_hfont);
			array_push($g_fonts, $we_hfont);
		}
		$we_metafont = get_option('we_metafont');
		if($we_metafont!=''){
			$we_metafont = we_get_google_font_name($we_metafont);
			array_push($g_fonts, $we_metafont);
		}
		$we_googlefont_js = get_option('we_googlefont_js');
		if($we_googlefont_js!='on'){
			wp_enqueue_style( 'wooevent-google-fonts', we_get_google_fonts_url($g_fonts), array(), '1.0.0' );
		}
		wp_enqueue_style('fullcalendar', WOO_EVENT_PATH.'js/fullcalendar/fullcalendar.min.css');
		wp_enqueue_style('qtip-css', WOO_EVENT_PATH.'js/fullcalendar/lib/qtip/jquery.qtip.min.css');
		if(get_option('we_owl_js')!='on'){
			wp_enqueue_style( 'owl-carousel', WOO_EVENT_PATH .'js/owl-carousel/owl.carousel.css');
			wp_enqueue_script( 'we-owl-carousel', WOO_EVENT_PATH. 'js/owl-carousel/owl.carousel.min.js', array('jquery'), '2.0', true );
		}

		wp_enqueue_script( 'woo-event',plugins_url('/js/plugin-script.js', __FILE__) , array( 'jquery' ) );
	}
	function frontend_style(){
		$we_main_purpose = get_option('we_main_purpose');
		$we_plugin_style = get_option('we_plugin_style');
		if($we_plugin_style!='off'){
			$we_main_purpose = get_option('we_main_purpose');
			if($we_main_purpose!='meta'){
				wp_enqueue_style('woo-event-css', WOO_EVENT_PATH.'css/style.css');
			}else{
				wp_enqueue_style('woo-event-css', WOO_EVENT_PATH.'css/meta-style.css');
			}
		}
		if($we_main_purpose=='woo' || $we_main_purpose=='custom'){
			wp_enqueue_style('we-woo-style', WOO_EVENT_PATH.'css/woo-style.css');
		}
	}
	function enqueue_customjs() {
		$we_custom_code = get_option('we_custom_code');
		if($we_custom_code!=''){
			echo '<script>'.$we_custom_code.'</script>';
		}
	}
}
$ExWooEvent = new ExWooEvent();