<?php

    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_demo";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    

    

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Man-Page Banner Option', 'redux-framework-demo' ),
        'id'               => 'banner-sec',
        'desc'             => __( 'These fields are Manage FrontPage Banner Section', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner', 'redux-framework-demo' ),
        'id'               => 'basic-banner',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'switch-on',
                'type'     => 'switch',
                'title'    => __( 'Switch On Banner', 'redux-framework-demo' ),
                'subtitle' => __( 'Check Yes if you want to Enabled banner on Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
            
            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-1', 'redux-framework-demo' ),
        'id'               => 'banner-1',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'banner-1-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-1 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'http://www.fashioncentral.pk/wp-content/uploads/2017/02/Mens_Fashion/mens_winter_fashion.jpg' ),
            ),
            array(
                'id'       => 'banner-1-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-1-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'banner-1-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'banner-1-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
			array(
                'id'       => 'banner-1-shortdesc',
                'type'     => 'media',
                'title'    => __( 'Banner Left Top Section', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner for left top section', 'redux-framework-demo' ),
            ),
			
			
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-2', 'redux-framework-demo' ),
        'id'               => 'banner-2',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'banner-2-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-2 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'https://ae01.alicdn.com/kf/HTB1enSXKFXXXXXQXpXXq6xXFXXXs/holiday-shorts-2013-summer-New-arrival-fashion-design-Men-Casual-Shorts-men-shorts-male-trousers-American.jpg' ),
            ),
            /*array(
                'id'       => 'banner-2-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),*/
			
			
			
			/*array(
				'id'    => 'inssdaafo_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			
			array(
                'id'       => 'banner-2-title_th',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-subtitle_th',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),*/
			
			array(
                'id'       => 'banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
        )
    ) );
	
	
	
	
	
	
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Woman-Page Banner Option', 'redux-framework-demo' ),
        'id'               => 'les-banner-sec',
        'desc'             => __( 'These fields are Manage Lesbian Page Banner Section', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner', 'redux-framework-demo' ),
        'id'               => 'les-basic-banner',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'les-switch-on',
                'type'     => 'switch',
                'title'    => __( 'Switch On Banner', 'redux-framework-demo' ),
                'subtitle' => __( 'Check Yes if you want to Enabled banner on Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
            
            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-1', 'redux-framework-demo' ),
        'id'               => 'les-banner-1',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'les-banner-1-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-1 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'http://www.fashioncentral.pk/wp-content/uploads/2017/02/Mens_Fashion/mens_winter_fashion.jpg' ),
            ),
            array(
                'id'       => 'les-banner-1-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-1-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'les-banner-1-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'les-banner-1-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
			
			array(
                'id'       => 'les-banner-1-shortdesc',
                'type'     => 'media',
                'title'    => __( 'Banner Left Top Section', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner for left top section', 'redux-framework-demo' ),
            ),
			
			
			
			
			
			/*array(
				'id'    => 'lesd_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'les-banner-1-title_th',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-1-subtitle_th',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-1-shortdesc_th',
                'type'     => 'textarea',
                'title'    => __( 'Short Description', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Short Description', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-1-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'les-banner-1-btn-url_th',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),*/
			
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-2 Bottom', 'redux-framework-demo' ),
        'id'               => 'les-banner-2',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'les-banner-2-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-2 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'https://ae01.alicdn.com/kf/HTB1enSXKFXXXXXQXpXXq6xXFXXXs/holiday-shorts-2013-summer-New-arrival-fashion-design-Men-Casual-Shorts-men-shorts-male-trousers-American.jpg' ),
            ),
            /*array(
                'id'       => 'les-banner-2-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'les-banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),*/
			
			
			/*array(
				'id'    => 'lesasd_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			 array(
                'id'       => 'les-banner-2-title_th',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-subtitle_th',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),*/
			
			array(
                'id'       => 'les-banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
        )
    ) );
	
	
	
	
	
	
	
	
	
	
	
	
	
	/***************************Combine page Redux Start**********************************************************/
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Combination-Page Banner Option', 'redux-framework-demo' ),
        'id'               => 'com-banner-sec',
        'desc'             => __( 'These fields are Manage Combanition Page Banner Section', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner', 'redux-framework-demo' ),
        'id'               => 'com-basic-banner',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'com-switch-on',
                'type'     => 'switch',
                'title'    => __( 'Switch On Banner', 'redux-framework-demo' ),
                'subtitle' => __( 'Check Yes if you want to Enabled banner on Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
            
            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-1', 'redux-framework-demo' ),
        'id'               => 'com-banner-1',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'com-banner-1-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-1 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'http://www.fashioncentral.pk/wp-content/uploads/2017/02/Mens_Fashion/mens_winter_fashion.jpg' ),
            ),
            array(
                'id'       => 'com-banner-1-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'com-banner-1-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'com-banner-1-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'com-banner-1-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
			array(
                'id'       => 'com-banner-1-shortdesc',
                'type'     => 'media',
                'title'    => __( 'Banner Left Top Section', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner for left top section', 'redux-framework-demo' ),
            ),
			
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner-2 Bottom', 'redux-framework-demo' ),
        'id'               => 'com-banner-2',
        'subsection'       => true,
        'customizer_width' => '500px',
        'fields'           => array(
            array(
                'id'       => 'com-banner-2-img',
                'type'     => 'media',
				'url'      => true,
				'compiler' => 'true',
                'title'    => __( 'Media File', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner-2 Media File', 'redux-framework-demo' ),
                'default'  => array( 'url' => 'https://ae01.alicdn.com/kf/HTB1enSXKFXXXXXQXpXXq6xXFXXXs/holiday-shorts-2013-summer-New-arrival-fashion-design-Men-Casual-Shorts-men-shorts-male-trousers-American.jpg' ),
            ),
            /*array(
                'id'       => 'les-banner-2-title',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-subtitle',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			
			array(
                'id'       => 'les-banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),*/
			
			
			/*array(
				'id'    => 'lesasd_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			 array(
                'id'       => 'les-banner-2-title_th',
                'type'     => 'text',
                'title'    => __( 'Title', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Title', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-subtitle_th',
                'type'     => 'text',
                'title'    => __( 'Subtitle', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Subtitle', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),
			array(
                'id'       => 'les-banner-2-btn-txt_th',
                'type'     => 'text',
                'title'    => __( 'Button Text', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button Text', 'redux-framework-demo' ),
            ),*/
			
			array(
                'id'       => 'com-banner-2-btn-url',
                'type'     => 'text',
                'title'    => __( 'Button URL', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Banner Button URL', 'redux-framework-demo' ),
				'validate' => 'url',
            ),
			
        )
    ) );
	
	
	
	
	
	
	
	
	
	
	
	
	/*****************************End Combine Redux****************************************************************/
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
    Redux::setSection( $opt_name, array(
        'icon'            => 'el el-list-alt',
        'title'           => __( 'Customizer Only', 'redux-framework-demo' ),
        'desc'            => __( '<p class="description">This Section should be visible only in Customizer</p>', 'redux-framework-demo' ),
        'customizer_only' => true,
        'fields'          => array(
            array(
                'id'              => 'opt-customizer-only',
                'type'            => 'select',
                'title'           => __( 'Customizer Only Option', 'redux-framework-demo' ),
                'subtitle'        => __( 'The subtitle is NOT visible in customizer', 'redux-framework-demo' ),
                'desc'            => __( 'The field desc is NOT visible in customizer.', 'redux-framework-demo' ),
                'customizer_only' => true,
                //Must provide key => value pairs for select options
                'options'         => array(
                    '1' => 'Opt 1',
                    '2' => 'Opt 2',
                    '3' => 'Opt 3'
                ),
                'default'         => '2'
            ),
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Landing Page', 'redux-framework-demo' ),
        'id'               => 'landing-sec',
        'desc'             => __( 'These fields are Manage Landing Page Sec', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-iphone-home'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Logo Section', 'redux-framework-demo' ),
        'id'               => 'landing-page',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'landing-media-logo',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Select Logo', 'redux-framework-demo' ),
                'subtitle' => __( 'Select Logo that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			array(
                'id'       => 'landing-media-title',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Add Title Logo', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Title Logo that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			array(
                'id'       => 'landing-media-subtitle',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Add Subtitle Logo', 'redux-framework-demo' ),
                'subtitle' => __( 'Add Subtitle logo that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			array(
                'id'       => 'enter-text-en',
			    'type'     => 'text', 
    			'url'      => true,
                'title'    => __( 'Add "Enter" text for Bottom', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
        )
    ) );
	
	
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Banner Section', 'redux-framework-demo' ),
        'id'               => 'landing-page-banner',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'landing-media-left',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Select Left Section Image', 'redux-framework-demo' ),
                'subtitle' => __( 'Select Image that appear on Landing Page Left Sec', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			array(
                'id'       => 'landing-media-right',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Select Right Section Image', 'redux-framework-demo' ),
                'subtitle' => __( 'Select Image that appear on Landing Page Right Sec', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
        )
    ) );
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Woocommerce Page', 'redux-framework-demo' ),
        'id'               => 'woocommerce-sec',
        'desc'             => __( 'These fields are Manage Woocommerce Page Sec', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-shopping-cart'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Shop Page', 'redux-framework-demo' ),
        'id'               => 'shop-page',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'shop-page-banner',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Upload Banner', 'redux-framework-demo' ),
                'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
        )
    ) );
	
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Header Section', 'redux-framework-demo' ),
        'id'               => 'header-sec',
        'desc'             => __( 'These fields are Manage header Section', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-stop'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Add Services', 'redux-framework-demo' ),
        'id'               => 'services',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'add-services',
			    'type' => 'multi_text',
    			'url'      => true,
                'title'    => __( 'Add Services', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			
			
			
			/*array(
				'id'    => 'lesasasd_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			array(
                'id'       => 'add-services_th',
			    'type' => 'multi_text',
    			'url'      => true,
                'title'    => __( 'Add Services', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),*/
        )
    ) );
	
	
	
	
	
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Woocommerce Page', 'redux-framework-demo' ),
        'id'               => 'woocommerce-sec',
        'desc'             => __( 'These fields are Manage Woocommerce Page Sec', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-shopping-cart'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Shop Page', 'redux-framework-demo' ),
        'id'               => 'shop-page',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'shop-page-banner',
			    'type'     => 'media', 
    			'url'      => true,
                'title'    => __( 'Upload Banner', 'redux-framework-demo' ),
                'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
        )
    ) );
	
	
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Theme Section', 'redux-framework-demo' ),
        'id'               => 'theme-sec',
        'desc'             => __( 'These fields are Manage Ttitle and Subtitle', 'redux-framework-demo' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-th-large'
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Section', 'redux-framework-demo' ),
        'id'               => 'home-sec-theme',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
			 array(
				'id'    => 'info_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage English Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
            array(
                'id'       => 'cat_sec_title_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Title', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_subtitle_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section SubTitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_btn_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_btn_url_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            
            ),
			array(
                'id'       => 'col_sec_title_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Title', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_subtitle_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section SubTitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_btn_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_btn_url_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_title_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Title', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_subtitle_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section SubTitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_btn_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_btn_url_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			/*****************************************************************/
			array(
                'id'       => 'ins_sec_title_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Instragram Section Title', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'ins_sec_id_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Instragram ID', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'ins_sec_aft_user_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'After user text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			/***********************************************************************/
			/*array(
				'id'    => 'info_success_th',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			array(
                'id'       => 'cat_sec_title_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_subtitle_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Sub-Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_btn_txt_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cat_sec_btn_url_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Category Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_title_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_subtitle_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Sub-Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_btn_txt_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'col_sec_btn_url_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Collection Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_title_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_subtitle_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Sub-Title (Th:)', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_btn_txt_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Button Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'sel_sec_btn_url_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Seller Section Button URL', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'ins_sec_title_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Instragram Section Title', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'ins_sec_id_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Instragram ID', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'ins_sec_aft_user_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'After user text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),*/
			/***********************************************************************/
        )
    )
);


Redux::setSection( $opt_name, array(
        'title'            => __( 'Header Section', 'redux-framework-demo' ),
        'id'               => 'head-sec-theme',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
			 array(
				'id'    => 'insdfo_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage English Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
            
			array(
                'id'       => 'wel_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add Welcome Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'shop_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add Above menu Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'shop_fillter_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Filter by" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'shop_short_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			 /*array(
				'id'    => 'insdasfo_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			array(
                'id'       => 'wel_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add Welcome Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'shop_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add Above menu Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),*/
			
			
			/***********************************************************************/
        )
    )
);



Redux::setSection( $opt_name, array(
        'title'            => __( 'Site Section', 'redux-framework-demo' ),
        'id'               => 'site-sec-theme',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
			 array(
				'id'    => 'insasdfo_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage English Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
            
			array(
                'id'       => 'all_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add All Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'hot_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "See hotest articles" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'art_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Articles" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'wish_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Wishlist" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cart_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Shoping cart" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'item_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Items" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'continue_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Continue Shopping" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'remove_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Remove All" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
                'id'       => 'related_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Related Products" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'related_text_sub_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Related Products" Subtitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'recently_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Recently View" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'recently_text_sub_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Recently View" Subtitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
                'id'       => 'recently_text_sub_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Recently View" Subtitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'cancel_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Cancel" Button', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'guest_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Guest" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'login_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Login" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'checkout_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Checkout" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'pci_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "PCI approved seal of security" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'quan_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Quantity" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
                'id'       => 'loginerror_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Login failed" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'loginerrorn_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Username or password are not correct" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'loginerrorw_text_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Please try again or register account" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			
			 array(
				'id'    => '404_search_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage 404 Page Text Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'page_not_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "PAGE NOT FOUND" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'page_link_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "The link you clicked may be broken or the page may have been removed." Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'page_link_visit_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "VISIT THE" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'page_link_home_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "HOMEPAGE" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			
			
			array(
				'id'    => 'newsletter_search_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Newsletter Text Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'news_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Newsletter" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'news_sign_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sign Up" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'news_email_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Enter your email" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'news_email_sign_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sign up" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
				'id'    => 'insdsdcshort_search_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Shorting Options Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'short_def_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Default sorting" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'short_pop_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by popularity" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'short_avg_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by average rating" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'short_new_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by newness" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'short_low_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by price: low to high" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'short_high_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Sort by price: high to low" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			
			
			
			
			
			
			array(
                'id'       => 'woo_avai_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Available" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'woo_notavai_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Not Available" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'woo_safe_shop_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Safe Shopping Gurantee" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			
			
			
			
			 array(
				'id'    => 'insdasasasfo_search_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Search Options Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'search_result_txt_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Search Results" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'search_result_no_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "No products found" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'search_result_may_en',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "You may Interested" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
				'id'    => 'insdasasasfo_col_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Pages URL "Man" Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
				'id'    => 'col_page_man_url',
			    'type' => 'text',
    			'url'      => true,
				'style' => 'normal',
				'title' => __('Collection Page', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			
			
			array(
				'id'    => 'insdwoman_col_en',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Pages URL "Woman" Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
				'id'    => 'col_page_woman_url',
			    'type' => 'text',
    			'url'      => true,
				'style' => 'normal',
				'title' => __('Collection Page', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			
			
			
			
			/**************************************************************************************************/
			/* array(
				'id'    => 'insdasasasfo_success_en',
				'type'  => 'info',
				'style' => 'success',
				'title' => __('You will Manage Thai Language Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			array(
                'id'       => 'all_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add All Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'hot_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "See hotest articles" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'art_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Articles" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'wish_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Wishlist" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			array(
                'id'       => 'cart_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Shoping cart" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'item_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Items" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'continue_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Continue Shopping" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'remove_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Remove All" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
                'id'       => 'related_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Related Products" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'related_text_sub_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Related Products" Subtitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
                'id'       => 'recently_text_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Recently View" Text', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'recently_text_sub_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Recently View" Subtitle', 'redux-framework-demo' ),
               // 'subtitle' => __( 'Select Banner that appear on Landing Page', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			
			array(
				'id'    => 'insdasasasfo_search_th',
				'type'  => 'info',
				'style' => 'normal',
				'title' => __('You will Manage Search Options Here!', 'redux-framework-demo'),
				'icon'  => 'el-icon-info-sign',
				//'desc'  => __( 'This is an info field with the success style applied, a header and an icon.', 'redux-framework-demo')
			),
			
			array(
                'id'       => 'search_result_txt_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "Search Results" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'search_result_no_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "No products found" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),
			
			array(
                'id'       => 'search_result_may_th',
			    'type' => 'text',
    			'url'      => true,
                'title'    => __( 'Add "You may Interested" Text', 'redux-framework-demo' ),
                'default'  => true,
            ),*/
			
			
			/***********************************************************************/
        )
    )
);


Redux::setSection( $opt_name, array(
        'title'     => __('Woo Section', 'bk_settings'),
        'fields'    => array(
            array(
                'id'       => 'safe_shop_en',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Safe Shopping" Title', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'safe_shop_sub_en',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Safe Shopping" SubTitle', 'redux-framework-demo' ),
                'default'  => false,
            ),
		 	
			array(
				'id'   => 'info_normal_cart_th',
				'type' => 'info',
				'desc' => __('You Will Manage Cart Page Section Here.', 'redux-framework-demo')
			),
			array(
                'id'       => 'safe_shop_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Safe Shopping" Title', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'safe_shop_sub_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Safe Shopping" SubTitle', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'apply_promo_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Apply Promo Code" Title', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'apply_promo_place_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Apply Promo Code" Placeholder', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'sub_tot_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Sub Total" Text', 'redux-framework-demo' ),
                'default'  => false,
            ),
			array(
                'id'       => 'ship_cart_th',
			    'type' => 'text',
    			'url'      => false,
                'title'    => __( 'Add "Sub Total" Text', 'redux-framework-demo' ),
                'default'  => false,
            ),
        )   
    )
);

	
	

    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'redux-framework-demo' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'redux-framework-demo' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

