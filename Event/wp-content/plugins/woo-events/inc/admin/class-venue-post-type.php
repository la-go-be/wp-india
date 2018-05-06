<?php
class WooEvent_Venue {
	public function __construct()
    {
        add_action( 'init', array( &$this, 'register_post_type' ) );
		add_filter( 'exc_mb_meta_boxes', array($this,'speaker_metadata') );
    }

	function register_post_type(){
		$labels = array(
			'name'               => esc_html__('Venue','exthemes'),
			'singular_name'      => esc_html__('Venue','exthemes'),
			'add_new'            => esc_html__('Add New Venue','exthemes'),
			'add_new_item'       => esc_html__('Add New Venue','exthemes'),
			'edit_item'          => esc_html__('Edit Venue','exthemes'),
			'new_item'           => esc_html__('New Venue','exthemes'),
			'all_items'          => esc_html__('Venues','exthemes'),
			'view_item'          => esc_html__('View Venue','exthemes'),
			'search_items'       => esc_html__('Search Venue','exthemes'),
			'not_found'          => esc_html__('No Venue found','exthemes'),
			'not_found_in_trash' => esc_html__('No Venue found in Trash','exthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__('Venues','exthemes')
		);
		
		$rewrite = false;
		$args = array(  
			'labels' => $labels,  
			'menu_position' => 8, 
			'supports' => array('title','custom-fields'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => 'edit.php?post_type=product',
			'menu_icon' =>  'dashicons-groups',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite' => $rewrite,
		);  
		register_post_type('we_venue',$args);  
	}
	function speaker_metadata(array $meta_boxes){
		// register meta
		$venue_settings = array(	
				array( 'id' => 'we_adress', 'name' => esc_html__('Address', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Location Address of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_latitude_longitude', 'name' => esc_html__('Latitude and Longitude (optional)', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Physical address of your event location, if Event map shortcode cannot load your address, you need to fill Latitude and Longitude to fix it, you can find phisical address here: https://ctrlq.org/maps/address/. Enter Latitude and Longitude, separated by a comma. Ex for London: 42.9869502,-81.243177', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			
			array( 'id' => 'we_phone', 'name' => esc_html__('Phone', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Contact Number of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_email', 'name' => esc_html__('Email', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Email Contact of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_website', 'name' => esc_html__('Website', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Website URL of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
		);

		$meta_boxes[] = array(
			'title' => __('Venue Info','exthemes'),
			'pages' => 'we_venue',
			'fields' => $venue_settings,
			'priority' => 'high'
		);
		return $meta_boxes;
	}
	
}
$WooEvent_Venue = new WooEvent_Venue();