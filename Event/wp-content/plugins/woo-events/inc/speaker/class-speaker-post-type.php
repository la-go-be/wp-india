<?php
class WooEvent_Speaker {
	public function __construct()
    {
        add_action( 'init', array( &$this, 'ex_register_post_type' ) );
		add_filter( 'exc_mb_meta_boxes', array($this,'speaker_metadata') );
    }

	function ex_register_post_type(){
		$labels = array(
			'name'               => esc_html__('Speaker','exthemes'),
			'singular_name'      => esc_html__('Speaker','exthemes'),
			'add_new'            => esc_html__('Add New Speaker','exthemes'),
			'add_new_item'       => esc_html__('Add New Speaker','exthemes'),
			'edit_item'          => esc_html__('Edit Speaker','exthemes'),
			'new_item'           => esc_html__('New Speaker','exthemes'),
			'all_items'          => esc_html__('All Speakers','exthemes'),
			'view_item'          => esc_html__('View Speaker','exthemes'),
			'search_items'       => esc_html__('Search Speaker','exthemes'),
			'not_found'          => esc_html__('No Speaker found','exthemes'),
			'not_found_in_trash' => esc_html__('No Speaker found in Trash','exthemes'),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__('Speaker','exthemes')
		);
		$we_speaker_slug = get_option('we_speaker_slug');
		if($we_speaker_slug==''){
			$we_speaker_slug = 'speaker';
		}
		if ( $we_speaker_slug ){
			$rewrite =  array( 'slug' => untrailingslashit( $we_speaker_slug ), 'with_front' => false, 'feeds' => true );
		}else{
			$rewrite = false;
		}
		$args = array(  
			'labels' => $labels,  
			'menu_position' => 8, 
			'supports' => array('title','editor','thumbnail', 'excerpt','custom-fields'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon' =>  'dashicons-groups',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite' => $rewrite,
		);  
		register_post_type('ex-speaker',$args);  
	}
	function speaker_metadata(array $meta_boxes){
		// register speaker meta
		$group_fields = array(
			array( 'id' => 'we_custom_title',  'name' => esc_html__('Title', 'exthemes'), 'type' => 'text' ),
			array( 'id' => 'we_custom_content', 'name' => esc_html__('Content', 'exthemes'), 'type' => 'text', 'desc' => '', 'repeatable' => false),
		);
		foreach ( $group_fields as &$field ) {
			$field['id'] = str_replace( 'field', 'gfield', $field['id'] );
		}
	
		$meta_boxes[] = array(
			'title' => esc_html__('Custom Field', 'exthemes'),
			'pages' => 'ex-speaker',
			'fields' => array(
				array(
					'id' => 'we_custom_metadata',
					'name' => esc_html__('Custom Metadata', 'exthemes'),
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => $group_fields,
					'desc' => esc_html__('Custom metadata for this post', 'exthemes')
				)
			),
			'priority' => 'high'
		);	
		$speaker_settings = array(	
				array( 'id' => 'speaker_position', 'name' => esc_html__('Position:', 'exthemes'), 'type' => 'text','desc' => esc_html__('Position of speaker', 'exthemes') , 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'facebook', 'name' => esc_html__('Facebook:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'instagram', 'name' => esc_html__('Instagram:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'envelope', 'name' => esc_html__('Email:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter email contact of speaker', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'twitter', 'name' => esc_html__('Twitter:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'linkedin', 'name' => esc_html__('LinkedIn:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'tumblr', 'name' => esc_html__('Tumblr:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'google-plus', 'name' => esc_html__('Google Plus:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'pinterest', 'name' => esc_html__('Pinterest:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes') , 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'youtube', 'name' => esc_html__('YouTube:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'flickr', 'name' => esc_html__('Flickr:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes') , 'repeatable' => false, 'multiple' => false),	
				array( 'id' => 'github ', 'name' => esc_html__('GitHub:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes'), 'repeatable' => false, 'multiple' => false ),	
				array( 'id' => 'dribbble', 'name' => esc_html__('Dribbble:', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Enter link to speaker profile page', 'exthemes') , 'repeatable' => false, 'multiple' => false),
			);

		$meta_boxes[] = array(
			'title' => __('Speaker Info','exthemes'),
			'pages' => 'ex-speaker',
			'fields' => $speaker_settings,
			'priority' => 'high'
		);
		return $meta_boxes;
	}
	
}
$WooEvent_Speaker = new WooEvent_Speaker();