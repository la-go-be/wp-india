<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

if ( ! function_exists( '_action_theme_setup' ) ) :
	function _action_theme_setup() {

		load_theme_textdomain( 'plan-up', get_template_directory() . '/languages' );

		add_editor_style( get_template_directory_uri().'/css/tinymce.css' );
		add_editor_style( plan_up_theme_font_url() );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'eventbrite' );
		add_theme_support( 'social-links', array(
		    'facebook', 'twitter', 'linkedin', 'google_plus', 'tumblr',
		) );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 800, 300, array('center', 'center'), true );

		update_option( 'thumbnail_size_h', 150 );
		update_option( 'thumbnail_size_w', 150 );
		update_option( 'medium_size_h', 580 );
		update_option( 'medium_size_w', 1024 );
		update_option( 'large_size_h', 0 );
		update_option( 'large_size_w', 0 );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );

		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'audio',
			'quote',
			'gallery',
		) );

		add_filter( 'use_default_gallery_style', '__return_false' );
	}
	add_action( 'init', '_action_theme_setup' );
endif;

function _action_theme_customize_preview_js() {
	wp_enqueue_script(
		'fw-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		'1.0',
		true
	);
}
add_action( 'customize_preview_init', '_action_theme_customize_preview_js' );

/**
 * Register widget areas.
 * @internal
 */
function _action_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Widget Area', 'plan-up' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'plan-up' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}

add_action( 'widgets_init', '_action_theme_widgets_init' );

if ( defined( 'FW' ) ):
	/**
	 * Display current submitted FW_Form errors
	 * @return array
	 */
	if ( ! function_exists( '_action_theme_display_form_errors' ) ):
		function _action_theme_display_form_errors() {
			$form = FW_Form::get_submitted();

			if ( ! $form || $form->is_valid() ) {
				return;
			}

			wp_enqueue_script(
				'fw-theme-show-form-errors',
				get_template_directory_uri() . '/js/form-errors.js',
				array( 'jquery' ),
				'1.0',
				true
			);

			wp_localize_script( 'fw-theme-show-form-errors', '_localized_form_errors', array(
				'errors'  => $form->get_errors(),
				'form_id' => $form->get_id()
			) );
		}
	endif;
	add_action('wp_enqueue_scripts', '_action_theme_display_form_errors');
endif;


/**
 * @param FW_Ext_Backups_Demo[] $demos
 * @return FW_Ext_Backups_Demo[]
 */
function _filter_theme_fw_ext_backups_demos($demos) {
    $demos_array = array(
        'planup' => array(
            'title' => esc_html__('Plan Up', 'plan-up'),
            'screenshot' => get_template_directory_uri().'/screenshot.png',
            'preview_link' => 'http://haintheme.com/item-switcher/?item=planup_wordpress',
        ),
    );

    $download_url = 'http://haintheme.com/ht-demos/';

    foreach ($demos_array as $id => $data) {
        $demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
            'url' => $download_url,
            'file_id' => $id,
        ));
        $demo->set_title($data['title']);
        $demo->set_screenshot($data['screenshot']);
        $demo->set_preview_link($data['preview_link']);

        $demos[ $demo->get_id() ] = $demo;

        unset($demo);
    }

    return $demos;
}
add_filter('fw:ext:backups-demo:demos', '_filter_theme_fw_ext_backups_demos');