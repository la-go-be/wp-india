<?php
class WooEvent_Meta {
	public function __construct()
    {
		add_action( 'save_post', array($this,'recurrence_event') );
		add_action( 'init', array($this,'init'), 0);
    }
	function init(){
		// Variables
		add_filter( 'exc_mb_meta_boxes', array($this,'wooevent_metadata') );
	}
	//Recurrence event
	function recurrence_event( $post_id ) {
		if('product' != get_post_type() || !isset($_POST['we_recurrence'])) { return;}
		$recurrence = $_POST['we_recurrence'];
		
		$we_startdate = $_POST['we_startdate'];
		$we_enddate = $_POST['we_enddate'];
		$cv_sd = strtotime(str_replace("/","-",$we_startdate['exc_mb-field-0']['date']));
		if(isset($we_startdate['exc_mb-field-0']['date']) && $cv_sd!=''){
			$_POST['we_startdate']['exc_mb-field-0']['date'] = date("d/m/Y", $cv_sd);
		}
		$cv_sd = strtotime(str_replace("/","-",$we_enddate['exc_mb-field-0']['date']));
		if(isset($we_enddate['exc_mb-field-0']['date']) && $cv_sd !=''){
			$_POST['we_enddate']['exc_mb-field-0']['date'] = date("d/m/Y", $cv_sd);
		}
		
		
		global $product;
		$ex_recurr = get_post_meta($post_id,'recurren_ext', true );
		if(!isset($recurrence['exc_mb-field-0']) || $recurrence['exc_mb-field-0']==''){
			update_post_meta( $post_id, 'recurren_ext', '');
			return;
		}
		if ($recurrence['exc_mb-field-0']=='day' || $recurrence['exc_mb-field-0']=='week' || $recurrence['exc_mb-field-0']=='month') {
			
			$we_recurrence_end = $_POST['we_recurrence_end'];
			$ev_date = (strtotime($we_enddate['exc_mb-field-0']['date']) - strtotime($we_startdate['exc_mb-field-0']['date']));
			$c_number = $ev_date/86400;
			$date_ed =  (strtotime($we_recurrence_end['exc_mb-field-0'])- strtotime($we_startdate['exc_mb-field-0']['date']));
			if($recurrence['exc_mb-field-0']=='day'){
				if($ev_date!=0){
					$date_ed = floor($date_ed/($ev_date + 86400));
				}elseif($ev_date==0){$date_ed = $date_ed/86400;}//echo $date_ed;exit;
				$number_plus = $c_number + 1;
			}elseif($recurrence['exc_mb-field-0']=='week'){
				if($ev_date!=0){
					$num_w = $ev_date + 86400*7;
					$date_ed = round($date_ed/$num_w);
				}else{ $date_ed = round($date_ed/(86400*7));}
				$number_plus = 7;
			}elseif($recurrence['exc_mb-field-0']=='month'){
				if($ev_date!=0){
					$n_m = $ev_date + 86400*30;
					$date_ed = round($date_ed/$n_m);
				}else{ $date_ed = round($date_ed/(86400*30));}
				$number_plus = 30;
			}
			if($ex_recurr !=''){
				$ev_stc = get_post_meta($post_id,'we_startdate', true );
				$ev_edc = get_post_meta($post_id,'we_enddate', true );
				$ev_recurrence_end = get_post_meta($post_id,'we_recurrence_end', true );
				$ev_recurrence = get_post_meta($post_id,'we_recurrence', true );
				$cr_st = strtotime($we_startdate['exc_mb-field-0']['date'] .' '. $we_startdate['exc_mb-field-0']['time']);
				$cr_ed = strtotime($we_enddate['exc_mb-field-0']['date'] .' '. $we_enddate['exc_mb-field-0']['time']);
				$cr_rec = strtotime($we_recurrence_end['exc_mb-field-0']);
				$ctmcheck = 0;
				if($ev_stc !=$cr_st || $ev_edc!= $cr_ed || $ev_recurrence_end!= $cr_rec || $ev_recurrence!= $recurrence['exc_mb-field-0']){
					$ctmcheck = 1;
				}
				$args = array(
					'post_type' => 'product',
					'post_status' => 'publish',
					'post__not_in' => array( $post_id ),
					'posts_per_page' => -1,
					'order' => 'ASC',
					'meta_key' => 'recurren_ext',
					'orderby' => 'meta_value_num',
					'meta_query' => array(
						array(
							'key'     => 'recurren_ext',
							'value'   => $ex_recurr,
							'compare' => '=',
						),
					),
				);
				$ex_posts = get_posts( $args );
				foreach($ex_posts as $item){
					remove_action( 'save_post', array($this,'recurrence_event' ));
					$stdate = get_post_meta($item->ID,'we_startdate', true );
					$enddate = get_post_meta($item->ID,'we_enddate', true );
					if($ctmcheck==1){
						wp_delete_post($item->ID);
					}else{
						we_update_recurren($_POST,$item->ID,$post_id,$stdate);
						update_post_meta( $item->ID, 'we_startdate', $stdate);
						update_post_meta( $item->ID, 'we_enddate', $enddate);
					}
					remove_action( 'save_post', array($this,'recurrence_event' ));
				}
				if($ctmcheck!=1){
					return;
				}
			}
			
		
			if ( current_user_can( 'manage_options' ) ) {
				$p_status = 'publish';
			}else{
				$p_status = 'pending';
			}
			//global $sitepress;//echo $_POST['lang'];exit;
			//echo $_POST['icl_post_language'];exit;
			//$def_trid = $sitepress->get_element_trid($post_id);//echo $def_trid;exit;
			
			for($i = 1; $i <= $date_ed; $i++){
				$attr = array(
				  'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
				  'post_content'  => $_POST['post_content'],
				  'post_status'   => $p_status,
				  'post_author'   => get_current_user_id(),
				  'post_type'      => 'product',
				  'post_excerpt' => $_POST['excerpt'],
				);
				$number_dt = $i*$number_plus;
				if($recurrence['exc_mb-field-0']=='month'){
					$st_date = strtotime("+".$i." month", strtotime($we_startdate['exc_mb-field-0']['date']));
				}else{
					$st_date = strtotime("+".$number_dt." day", strtotime($we_startdate['exc_mb-field-0']['date']));
				}

				$en_date = strtotime("+".$c_number." day", $st_date);
				
				$diff_st = strtotime($we_startdate['exc_mb-field-0']['date'] .' '. $we_startdate['exc_mb-field-0']['time'])- strtotime($we_startdate['exc_mb-field-0']['date']);
				$st_date = $st_date + $diff_st;
				
				$diff_ed = strtotime($we_enddate['exc_mb-field-0']['date'] .' '. $we_enddate['exc_mb-field-0']['time'])- strtotime($we_enddate['exc_mb-field-0']['date']);
				$en_date = $en_date + $diff_ed;
				$br_cre = strtotime($we_recurrence_end['exc_mb-field-0']) + 86399;
				if($en_date > $br_cre){
					$en_date = strtotime($we_recurrence_end['exc_mb-field-0'])+ $diff_ed;
				}
				
				$attach_id = get_post_thumbnail_id($post_id);
				if($st_date > $br_cre){
					break;
				}else{	
					$attr['post_title'] = apply_filters( 'we_change_title_recurring', $attr['post_title'], $st_date );
					remove_action( 'save_post', array($this,'recurrence_event' ));
					if($we_ID = wp_insert_post( $attr, false )){
						if($attach_id!=''){
							set_post_thumbnail( $we_ID, $attach_id );
						}
						// update meta
						update_post_meta( $we_ID, 'we_startdate', $st_date);
						update_post_meta( $we_ID, 'we_enddate', $en_date);
						update_post_meta( $we_ID, 'recurren_ext', 'event_'.$post_id);
						update_post_meta( $post_id, 'recurren_ext', 'event_'.$post_id);
						update_post_meta( $we_ID, 'we_recurrence_end', '');
						update_post_meta( $we_ID, 'we_recurrence', '');
						woometa_update($_POST,$we_ID, $post_id);
					}
					//WPML support
					if (class_exists('SitePress')) {
						global $sitepress,$wpdb;
						$trid = $sitepress->get_element_trid( $post_id, 'post_product');
						$orig_id = $sitepress->get_original_element_id_by_trid( $trid );
						$orig_lang = $this->get_original_product_language( $post_id );
						$sitepress->set_element_language_details($we_ID, 'post_product', false, $orig_lang);
						//$sitepress->set_element_language_details($we_ID, 'post_product', $def_trid, $_POST['icl_post_language'],null, false);
						$wpdb->insert( 
							"{$wpdb->prefix}icl_translations", 
							array( 
								'element_type' => 'post_product',
								'element_id' => $we_ID,
								'language_code' => $_POST['icl_post_language'],
							), 
							array( 
								'%s',
								'%d', 
								'%s'
							) 
						);
					}
					add_action( 'save_post', array($this,'recurrence_event') );
				}
			}
		}else{
			return;
		}
	}
	// Get original product language
    function get_original_product_language( $product_id ){

        $cache_key = $product_id;
        $cache_group = 'original_product_language';

        $temp_language = wp_cache_get( $cache_key, $cache_group );
        if($temp_language) return $temp_language;

        global $wpdb;

        $language = $wpdb->get_var( $wpdb->prepare( "
                            SELECT t2.language_code FROM {$wpdb->prefix}icl_translations as t1
                            LEFT JOIN {$wpdb->prefix}icl_translations as t2 ON t1.trid = t2.trid
                            WHERE t1.element_id=%d AND t1.element_type=%s AND t2.source_language_code IS NULL", $product_id, 'post_'.get_post_type($product_id) ) );

        wp_cache_set( $cache_key, $language, $cache_group );

        return $language;
    }
	function wooevent_metadata(array $meta_boxes){
		// register aff store metadata		
		$time_settings = array(	
			array( 'id' => 'we_allday',  'name' => esc_html__('All Day', 'exthemes'), 'type' => 'checkbox' ),
			array( 'id' => 'we_startdate', 'name' => esc_html__('Start Date:', 'exthemes'), 'type' => 'datetime_unix','desc' => esc_html__('', 'exthemes') , 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_enddate', 'name' => esc_html__('End Date:', 'exthemes'), 'type' => 'datetime_unix' ,'desc' => esc_html__('', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_recurrence', 'name' => esc_html__('Recurrence', 'exthemes'), 'type' => 'select', 'options' => array( 'day' => esc_html__('Every Day', 'exthemes'),  'week' => esc_html__('Every Week', 'exthemes'),  'month' => esc_html__('Every Month', 'exthemes') ), 'allow_none' => true, 'sortable' => false, 'repeatable' => false ),
			array( 'id' => 'we_recurrence_end', 'name' => esc_html__('End Date of Recurrence:', 'exthemes'), 'type' => 'date_unix' ,'desc' => esc_html__('', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			
			array( 'id' => 'we_time_zone', 'name' => esc_html__('Timezone', 'exthemes'), 'type' => 'select', 
				'options' => array( 
					'def' => esc_html__('Default', 'exthemes'), 
					'-12' => esc_html__('UTC−12', 'exthemes'), 
					'-11.5' => esc_html__('UTC−11:30', 'exthemes'),
					'-11' => esc_html__('UTC−11', 'exthemes'),
					'-10.5' => esc_html__('UTC−10:30', 'exthemes'),
					'-10' => esc_html__('UTC−10', 'exthemes'),
					'-9.5' => esc_html__('UTC−9:30', 'exthemes'),
					'-9' => esc_html__('UTC−9', 'exthemes'),
					'-8.5' => esc_html__('UTC−8:30', 'exthemes'),
					'-8' => esc_html__('UTC−8', 'exthemes'),
					'-7.5' => esc_html__('UTC−7:30', 'exthemes'),
					'-7' => esc_html__('UTC−7', 'exthemes'),
					'-6.5' => esc_html__('UTC−6:30', 'exthemes'),
					'-6' => esc_html__('UTC−6', 'exthemes'),
					'-5.5' => esc_html__('UTC−5:30', 'exthemes'),
					'-5' => esc_html__('UTC−5', 'exthemes'),
					'-4.5' => esc_html__('UTC−4:30', 'exthemes'),
					'-4' => esc_html__('UTC−4', 'exthemes'),
					'-3.5' => esc_html__('UTC−3:30', 'exthemes'),
					'-3' => esc_html__('UTC−3', 'exthemes'),
					'-2.5' => esc_html__('UTC−2:30', 'exthemes'),
					'-2' => esc_html__('UTC−2', 'exthemes'),
					'-1.5' => esc_html__('UTC−1:30', 'exthemes'),
					'-1' => esc_html__('UTC−1', 'exthemes'),
					'-0.5' => esc_html__('UTC-0:30', 'exthemes'),
					'+0' => esc_html__('UTC+0', 'exthemes'),
					'0.5' => esc_html__('UTC+0:30', 'exthemes'),
					'1' => esc_html__('UTC+1', 'exthemes'),
					'1.5' => esc_html__('UTC+1:30', 'exthemes'),
					'2' => esc_html__('UTC+2', 'exthemes'),
					'2.5' => esc_html__('UTC+2:30', 'exthemes'),
					'3' => esc_html__('UTC+3', 'exthemes'),
					'3.5' => esc_html__('UTC+3:30', 'exthemes'),
					'4' => esc_html__('UTC+4', 'exthemes'),
					'4.5' => esc_html__('UTC+4:30', 'exthemes'),
					'5' => esc_html__('UTC+5', 'exthemes'),
					'5.30' => esc_html__('UTC+5:30', 'exthemes'),
					'5.45' => esc_html__('UTC+5:45', 'exthemes'),
					'6' => esc_html__('UTC+6', 'exthemes'),
					'6.5' => esc_html__('UTC+6:30', 'exthemes'),
					'7' => esc_html__('UTC+7', 'exthemes'),
					'7.5' => esc_html__('UTC+7:30', 'exthemes'),
					'8' => esc_html__('UTC+8', 'exthemes'),
					'8.30' => esc_html__('UTC+8:30', 'exthemes'),
					'8.45' => esc_html__('UTC+8:45', 'exthemes'),
					'9' => esc_html__('UTC+9', 'exthemes'),
					'9.5' => esc_html__('UTC+9:30', 'exthemes'),
					'10' => esc_html__('UTC+10', 'exthemes'),
					'10.30' => esc_html__('UTC+10:30', 'exthemes'),
					'11' => esc_html__('UTC+11', 'exthemes'),
					'11.5' => esc_html__('UTC+11:30', 'exthemes'),
					'12' => esc_html__('UTC+12', 'exthemes'),
					'12.45' => esc_html__('UTC+12:45', 'exthemes'),
					'13' => esc_html__('UTC+13', 'exthemes'),
					'13.45' => esc_html__('UTC+13:45', 'exthemes'),
					'14' => esc_html__('UTC+14', 'exthemes'),
				),
				'desc' => '' , 
				'repeatable' => false,
				'multiple' => false
			),
			
			array( 'id' => 'we_speakers', 'name' => esc_html__('Speakers', 'exthemes'),'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'ex-speaker' ),'allow_none' => true, 'desc' => esc_html__('Choose speaker for this event', 'exthemes'), 'repeatable' => false, 'multiple' => true ),	
		);
		if(get_option('we_speaker')=='yes'){
			unset($time_settings[5]);
		}
		$location_settings = array(		
			array( 'id' => 'we_default_venue', 'name' => esc_html__('Select venue saved', 'exthemes'),'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'we_venue' ),'allow_none' => true, 'desc' => esc_html__('Leave blank to use new venue', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			
			array( 'id' => 'we_adress', 'name' => esc_html__('Address', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Location Address of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_latitude_longitude', 'name' => esc_html__('Latitude and Longitude (optional)', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Physical address of your event location, if Event map shortcode cannot load your address, you need to fill Latitude and Longitude to fix it, you can find phisical address here: https://ctrlq.org/maps/address/. Enter Latitude and Longitude, separated by a comma. Ex for London: 42.9869502,-81.243177', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			
			array( 'id' => 'we_phone', 'name' => esc_html__('Phone', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Contact Number of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_email', 'name' => esc_html__('Email', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Email Contact of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_website', 'name' => esc_html__('Website', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Website URL of event', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			//array( 'id' => 'we_subscribe_url', 'name' => esc_html__('Subscribe url', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Link to a subscribe form. Only work if no price is set.', 'exthemes'), 'repeatable' => false, 'multiple' => false ),
			array( 'id' => 'we_schedu', 'name' => esc_html__('Schedule', 'exthemes'), 'type' => 'text' ,'desc' => esc_html__('Add Schedule for this event', 'exthemes'), 'repeatable' => true, 'multiple' => true ),
			array( 'id' => 'we_iconmap', 'name' => esc_html__('Map Icon', 'exthemes'), 'type' => 'image', 'repeatable' => false, 'show_size' => false ),
			array( 'id' => 'we_eventcolor', 'name' => esc_html__('Color', 'exthemes'), 'type' => 'colorpicker', 'repeatable' => false, 'multiple' => true ),
			
		);
		if(get_option('we_venue_off')=='yes'){
			unset($location_settings[0]);
		}
		$event_layout = array(	
			array( 'id' => 'we_layout', 'name' => esc_html__('Layout', 'exthemes'), 'type' => 'select', 'options' => array( '' => esc_html__('Default', 'exthemes'), 'layout-1' => esc_html__('Layout 1', 'exthemes'), 'layout-2' => esc_html__('Layout 2', 'exthemes'),'layout-3' => esc_html__('Layout 3', 'exthemes')),'desc' => esc_html__('Select "Default" to use settings in Event Options', 'exthemes') , 'repeatable' => false, 'multiple' => false),
			array( 'id' => 'we_sidebar', 'name' => esc_html__('Sidebar', 'exthemes'), 'type' => 'select', 'options' => array( '' => esc_html__('Default', 'exthemes'), 'right' => esc_html__('Right', 'exthemes'), 'left' => esc_html__('Left', 'exthemes'),'hide' => esc_html__('Hidden', 'exthemes')),'desc' => esc_html__('Select "Default" to use settings in Event Options', 'exthemes') , 'repeatable' => false, 'multiple' => false),
		);
		$event_purpose = array(	
			array( 'id' => 'we_layout_purpose', 'name' => '', 'type' => 'select', 'options' => array( 'woo' => esc_html__('WooCommere', 'exthemes'), 'event' => esc_html__('Event', 'exthemes')),'desc' => esc_html__('Select Layout Purpose for this product', 'exthemes') , 'repeatable' => false, 'multiple' => false)
		);
		
		$we_main_purpose = get_option('we_main_purpose');
		if($we_main_purpose!='woo'){
			$meta_boxes[] = array(
				'title' => __('Event Settings','exthemes'),
				'pages' => 'product',
				'fields' => $time_settings,
				'priority' => 'high'
			);
			$meta_boxes[] = array(
				'title' => __('Location Settings','exthemes'),
				'pages' => 'product',
				'fields' => $location_settings,
				'priority' => 'high'
			);
		}
		if($we_main_purpose=='custom' || $we_main_purpose=='meta'){
			if($we_main_purpose=='meta'){
				$event_purpose = array(	
					array( 'id' => 'we_layout_purpose', 'name' => '', 'type' => 'select', 'options' => array( 'def' => esc_html__('Default', 'exthemes'), 'woo' => esc_html__('WooCommere', 'exthemes'), 'event' => esc_html__('Event', 'exthemes')),'desc' => esc_html__('Select Default to use setting in plugin setting', 'exthemes') , 'repeatable' => false, 'multiple' => false)
				);
			}
			$meta_boxes[] = array(
				'title' => __('Layout Purpose','exthemes'),
				'context' => 'side',
				'pages' => 'product',
				'fields' => $event_purpose,
				'priority' => 'high'
			);
		}
		$event_layout = apply_filters( 'we_change_layout_meta', $event_layout );
		$meta_boxes[] = array(
			'title' => __('Layout Settings','exthemes'),
			'pages' => 'product',
			'fields' => $event_layout,
			'priority' => 'high'
		);
		$group_fields = array(
			array( 'id' => 'we_custom_title',  'name' => esc_html__('Title', 'exthemes'), 'type' => 'text' ),
			array( 'id' => 'we_custom_content', 'name' => esc_html__('Content', 'exthemes'), 'type' => 'text', 'desc' => '', 'repeatable' => false),
		);
		foreach ( $group_fields as &$field ) {
			$field['id'] = str_replace( 'field', 'gfield', $field['id'] );
		}
	
		$meta_boxes[] = array(
			'title' => esc_html__('Custom Field', 'exthemes'),
			'pages' => 'product',
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
		
		$group_sponsors = array(
			array( 'id' => 'we_sponsors_link',  'name' => esc_html__('Link', 'exthemes'), 'type' => 'text' ),
			array( 'id' => 'we_sponsors_logo', 'name' => esc_html__('Logo', 'exthemes'), 'type' => 'image', 'desc' => '', 'repeatable' => false, 'show_size' => false),
		);
		foreach ( $group_fields as &$field ) {
			$field['id'] = str_replace( 'field', 'gfield', $field['id'] );
		}
	
		$meta_boxes[] = array(
			'title' => esc_html__('Sponsors of Event', 'exthemes'),
			'pages' => 'product',
			'fields' => array(
				array(
					'id' => 'we_sponsors',
					'name' => esc_html__('Sponsor', 'exthemes'),
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => $group_sponsors,
					'desc' => esc_html__('Add Sponsor for this event', 'exthemes')
				)
			),
			'priority' => 'high'
		);
		
		return $meta_boxes;
	}
	function meta_date_picker(){
		wp_enqueue_script( 'jquery-ui-timepicker-addon', trailingslashit( WOO_EVENT_PATH ) . 'js/time-picker/jquery-ui-timepicker-addon.js', array( 'jquery') );
		wp_enqueue_style( 'jquery-ui-timepicker-addon-css', trailingslashit( WOO_EVENT_PATH ) . 'js/time-picker/jquery-ui-timepicker-addon.css');
	}
    function woo_event_meta_tab(){
        echo '<li class="wooevent_options_tab"><a href="#wooevent_options">'.esc_html__('Event Settings','exthemes').'</a></li>';
    }
	
	function woo_add_wooevent_fields() {
		global $woocommerce, $post;
		echo '
		<div id="wooevent_options" class="panel woocommerce_options_panel">
			<div class="options_group event-date">
				<p><strong>'.esc_html__( 'Event Info', 'exthemes' ).'</strong></p>';
				
				$we_startdate = get_post_meta( $post->ID, 'we_startdate', true ) ;
				$we_enddate = get_post_meta( $post->ID, 'we_enddate', true ) ;
				?>
                <p class="form-field we_startdate_field ">
                	<label for="we_startdate"><?php esc_html_e( 'Start Date', 'exthemes' )?></label>
                    <input type="text"  name="we_startdate" id="we_startdate" value="<?php echo  $we_enddate!='' ? gmdate("m/d/Y H:i", $we_startdate) : '';?>" placeholder="">
                </p>
                <p class="form-field we_enddate_field ">
                	<label for="we_enddate"><?php esc_html_e( 'End Date', 'exthemes' )?></label>
                    <input type="text"  name="we_enddate" id="we_enddate" value="<?php echo  $we_enddate!='' ? gmdate("m/d/Y H:i", $we_enddate) : '';?>" placeholder="">
                </p>
                <script>
					jQuery(document).ready(function(e) {
						jQuery('#we_startdate').datetimepicker();
						jQuery('#we_enddate').datetimepicker();
					});
	
				</script>
                <?php
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_speakers', 
						'label'       => esc_html__( 'Speakers', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Enter ID from Speakers', 'exthemes' ) 
					)
				);
				echo '
			</div>
			<div class="options_group event-date">
				<p><strong>'.esc_html__( 'Event Location', 'exthemes' ).'</strong></p>';
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_adress', 
						'label'       => esc_html__( 'Address', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Location Address of event', 'exthemes' ) 
					)
				);
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_phone', 
						'label'       => esc_html__( 'Phone', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Contact Number of event', 'exthemes' ) 
					)
				);
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_email', 
						'label'       => esc_html__( 'Email', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Email Contact of event', 'exthemes' ) 
					)
				);
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_website', 
						'label'       => esc_html__( 'Website', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Website URL of event', 'exthemes' ) 
					)
				);
				woocommerce_wp_text_input( 
					array( 
						'id'          => 'we_subscribe_url', 
						'label'       => esc_html__( 'Subscribe URL', 'exthemes' ), 
						'placeholder' => '',
						'desc_tip'    => 'true',
						'description' => esc_html__( 'Link to a subscribe form. Only work if no price is set.', 'exthemes' ) 
					)
				);
				echo '
			</div>
		</div>';
	}
}
$WooEvent_Meta = new WooEvent_Meta();

if( get_option('we_cat_ctcolor') == 'on' ){
	/* Category color */
	add_action( 'product_cat_add_form_fields', 'we_color_fields', 10 );
	add_action ( 'product_cat_edit_form_fields', 'we_color_fields');
	
	function we_color_fields( $tag ) {
		$t_id 					= isset($tag->term_id) ? $tag->term_id : '';
		$we_category_color 			= get_option( "we_category_color_$t_id")?get_option( "we_category_color_$t_id"):'';
		?>
		<tr class="form-field" style="">
			<th scope="row" valign="top">
				<label for="we-category-color"><?php esc_html_e('Color','exthemes'); ?></label>
			</th>
			<td>
				<input type="text" name="we-category-color" id="we-category-color" class="jscolor {required:false}" style="margin-bottom:15px;" value="<?php echo esc_attr($we_category_color) ?>" />
			</td>
		</tr>
		<?php
	}
	//save color fields
	add_action ( 'edited_product_cat', 'we_save_extra_color_fileds', 10, 2);
	add_action( 'created_product_cat', 'we_save_extra_color_fileds', 10, 2 );
	function we_save_extra_color_fileds( $term_id ) {
		if ( isset( $_POST[sanitize_key('we-category-color')] ) ) {
			$we_category_color = $_POST['we-category-color'];
			update_option( "we_category_color_$term_id", $we_category_color );
		}
	}
}
