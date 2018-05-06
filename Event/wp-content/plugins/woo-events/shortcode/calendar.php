<?php
function parse_we_calendar_func($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$use_shortcode =  isset($atts['use_shortcode']) ? $atts['use_shortcode'] :'1'; 
	$view =  isset($atts['view']) ? $atts['view'] :'month';
	$defaultDate =  isset($atts['defaultdate']) && $atts['defaultdate']!='' ? $atts['defaultdate'] : date('Y-m-d');
	$firstDay =  isset($atts['firstday']) && $atts['firstday']!='' ? $atts['firstday'] : '1';
	$class =  isset($atts['class']) ? $atts['class'] :''; 
	$style =  isset($atts['style']) ? $atts['style'] :''; 
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$show_search =  isset($atts['show_search']) ? $atts['show_search'] :'';
	$calendar_language =  isset($atts['calendar_language']) ? $atts['calendar_language'] :'';
	$show_bt =  isset($atts['show_bt']) ? $atts['show_bt'] :'';
	if($style =='modern'){ $class .=" widget-style";}
	wp_enqueue_script( 'moment', WOO_EVENT_PATH.'/js/fullcalendar/lib/moment.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'we-fullcalendar', WOO_EVENT_PATH.'/js/fullcalendar/fullcalendar.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'we-fullcalendar-language', WOO_EVENT_PATH.'/js/fullcalendar/lang-all.js', array( 'jquery' ) );
	if(get_option('we_qtip_js')!='on'){
		wp_enqueue_script( 'we-jquery-qtip',  WOO_EVENT_PATH.'/js/fullcalendar/lib/qtip/jquery.qtip.min.js' , array( 'jquery' ) );
	}
	ob_start();
	?>
    <div class="we-calendar <?php echo esc_attr($style);?>-style" data-id ="<?php echo esc_attr($ID);?>" id="<?php echo esc_attr($ID);?>">
        <div class="we-loading">
            <div class="wpex-spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
        <?php 
		$we_shop_view = get_option('we_shop_view');
		$we_search_enable = get_option('we_search_enable');
		
		if(is_shop() && $we_search_enable!='disable' && $show_search=='1'){ echo wooevent_search_view_bar($ID);}
		$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
		echo '<div class="alert alert-warning calendar-info hidden"><i class="fa fa-exclamation-triangle"></i>'.$noftrsl.'</div>';
		
		if((isset($_GET['view']) && $_GET['view']=='list' && $show_search=='1') || is_search()&& $show_search=='1' || is_shop()&& $show_search=='1' && $we_shop_view=='list' && !isset($_GET['view']) ){
		}elseif((isset($_GET['view']) && $_GET['view']=='map' ) || $we_shop_view=='map' ){
			echo do_shortcode('[we_map type="upcoming"]');
		}elseif(is_shop() || $use_shortcode=='1' || $show_search!='1'){
			if(is_shop() && $show_search=='1'){
				if(isset($_GET['view'])){ 
					$cal_view = esc_attr($_GET['view']);
				}elseif($we_shop_view!=''){ 
					$cal_view = $we_shop_view;
				}else{ 
					$cal_view = 'month';
				}?>
            	<input type="hidden"  name="calendar_view" value="<?php echo esc_attr($cal_view);?>">
            <?php }else{?>
            	<input type="hidden"  name="calendar_view" value="<?php if($view!=''){ echo esc_attr($view);}else{ echo 'month';}?>">
            <?php }
			$language_crr = esc_attr(get_option('we_calendar_lg'));
			if($calendar_language != ''){
				$language_crr = $calendar_language;
			}
			if($calendar_language = 'wpml'){ 
				if(isset($_GET['language']) && ($_GET['language'] != '')){
					$language_crr = $_GET['language'];
				}else if(isset($_GET['lang']) && ($_GET['lang'] != '')){
					$language_crr = $_GET['lang'];
				}
			}
			?>
            
            <input type="hidden"  name="calendar_language" value="<?php echo $language_crr;?>">
            <input type="hidden"  name="calendar_defaultDate" value="<?php echo esc_attr($defaultDate);?>">
            <input type="hidden"  name="calendar_firstDay" value="<?php echo esc_attr($firstDay);?>">
            <input type="hidden"  name="calendar_orderby" value="<?php echo esc_attr($orderby);?>">
            <input type="hidden"  name="calendar_cat" value="<?php echo esc_attr($cat);?>">
            <input type="hidden"  name="show_bt" value="<?php echo esc_attr($show_bt);?>">
            <div id="calendar" class="<?php echo esc_attr($class);?>"></div>
        <?php }?>
        <input type="hidden"  name="ajax_url" value="<?php echo esc_url(admin_url( 'admin-ajax.php' ));?>">
        <?php
		if($style=='modern'){
			$day_event = '';
			echo '<div class="wt-eventday">'.$day_event.'</div>';
		}
		?>
    </div>
    <?php
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_calendar', 'parse_we_calendar_func' );
add_action( 'after_setup_theme', 'we_reg_calendar_vc' );
function we_reg_calendar_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Calendar", "exthemes"),
	   "base" => "we_calendar",
	   "class" => "",
	   "icon" => "icon-calendar",
	   "controls" => "full",
	   "category" => esc_html__('WooEvents','exthemes'),
	   "params" => array(
	   	  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("View", 'exthemes'),
			 "param_name" => "view",
			 "value" => array(
			 	esc_html__('Month', 'exthemes') => '',
				esc_html__('Basic Week', 'exthemes') => 'basicWeek',
				esc_html__('Agenda Week', 'exthemes') => 'agendaWeek',
				esc_html__('Basic Day', 'exthemes') => 'basicDay',
				esc_html__('Agenda Day ', 'exthemes') => 'agendaDay ',
			 ),
			 "description" => ''
		  ),
		  array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Calendar Month Style", 'exthemes'),
			 "param_name" => "style",
			 "value" => array(
				esc_html__('Classic', 'exthemes') => '',
				esc_html__('Modern', 'exthemes') => 'modern',
			 ),
			 'dependency' 	=> array(
				'element' => 'view',
				'value'   => array(''),
			 ),
			 "description" => ''
		  ),
		  /*array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show button", 'exthemes'),
			 "param_name" => "show_bt",
			 "value" => array(
				esc_html__('No', 'exthemes') => '',
				esc_html__('Add to cart', 'exthemes') => 'addtocart',
				esc_html__('View Details', 'exthemes') => 'details',
			 ),
			 'dependency' 	=> array(
				'element' => 'style',
				'value'   => array(''),
			 ),
			 "description" => ''
		  ),*/
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Default date", "exthemes"),
			"param_name" => "defaultdate",
			"value" => "",
			"description" => esc_html__("The initial date displayed when the calendar first loads. Ex:2016-05-19", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "dropdown",
			"heading" => esc_html__("First date", "exthemes"),
			"param_name" => "firstday",
			"value" => array(
				esc_html__('Monday', 'exthemes') => '1',
				esc_html__('Tuesday', 'exthemes') => '2',
				esc_html__('Wednesday', 'exthemes') => '3',
				esc_html__('Thursday,', 'exthemes') => '4',
				esc_html__('Friday', 'exthemes') => '5',
				esc_html__('Saturday', 'exthemes') => '6',
				esc_html__('Sunday', 'exthemes') => '7',
			 ),
			"description" => esc_html__("The day that each week begins.", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Category", "exthemes"),
			"param_name" => "cat",
			"value" => "",
			"description" => esc_html__("List of cat ID (or slug), separated by a comma", "exthemes"),
		  ),
		  array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Order by", 'exthemes'),
			 "param_name" => "orderby",
			 "value" => array(
				esc_html__('Default', 'exthemes') => '',
				esc_html__('Upcoming', 'exthemes') => 'upcoming',
				esc_html__('Past', 'exthemes') => 'past',
			 ),
			 "description" => ''
		  ),
		  array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Calendar language", 'exthemes'),
			 "param_name" => "calendar_language",
			 "value" => array(
				esc_html__('Default', 'exthemes') => '',
				esc_html__( 'ar-ma', 'exthemes' ) => 'ar-ma',
				esc_html__( 'ar-sa', 'exthemes' ) => 'ar-sa',
				esc_html__( 'ar-tn', 'exthemes' ) => 'ar-tn',
				esc_html__( 'ar', 'exthemes' ) => 'ar',
				esc_html__( 'bg', 'exthemes' ) => 'bg',
				esc_html__( 'ca', 'exthemes' ) => 'ca',
				esc_html__( 'cs', 'exthemes' ) => 'cs',
				esc_html__( 'da', 'exthemes' ) => 'da',
				esc_html__( 'de-at', 'exthemes' ) => 'de-at',
				esc_html__( 'de', 'exthemes' ) => 'de',
				esc_html__( 'el', 'exthemes' ) => 'el',
				esc_html__( 'en-au', 'exthemes' ) => 'en-au',
				esc_html__( 'en-ca', 'exthemes' ) => 'en-ca',
				esc_html__( 'en-gb', 'exthemes' ) => 'en-gb',
				esc_html__( 'en-ie', 'exthemes' ) => 'en-ie',
				esc_html__( 'en-nz', 'exthemes' ) => 'en-nz',
				esc_html__( 'es', 'exthemes' ) => 'es',
				esc_html__( 'fa', 'exthemes' ) => 'fa',
				esc_html__( 'fi', 'exthemes' ) => 'fi',
				esc_html__( 'fr-ca', 'exthemes' ) => 'fr-ca',
				esc_html__( 'fr-ch', 'exthemes' ) => 'fr-ch',
				esc_html__( 'fr', 'exthemes' ) => 'fr',
				esc_html__( 'he', 'exthemes' ) => 'he',
				esc_html__( 'hi', 'exthemes' ) => 'hi',
				esc_html__( 'hr', 'exthemes' ) => 'hr',
				esc_html__( 'hu', 'exthemes' ) => 'hu',
				esc_html__( 'id', 'exthemes' ) => 'id',
				esc_html__( 'is', 'exthemes' ) => 'is',
				esc_html__( 'it', 'exthemes' ) => 'it',
				esc_html__( 'ja', 'exthemes' ) => 'ja',
				esc_html__( 'ko', 'exthemes' ) => 'ko',
				esc_html__( 'lt', 'exthemes' ) => 'lt',
				esc_html__( 'lv', 'exthemes' ) => 'lv',
				esc_html__( 'nb', 'exthemes' ) => 'nb',
				esc_html__( 'nl', 'exthemes' ) => 'nl',
				esc_html__( 'pl', 'exthemes' ) => 'pl',
				esc_html__( 'pt-br', 'exthemes' ) => 'pt-br',
				esc_html__( 'pt', 'exthemes' ) => 'pt',
				esc_html__( 'ro', 'exthemes' ) => 'ro',
				esc_html__( 'ru', 'exthemes' ) => 'ru',
				esc_html__( 'sk', 'exthemes' ) => 'sk',
				esc_html__( 'sl', 'exthemes' ) => 'sl',
				esc_html__( 'sr-cyrl', 'exthemes' ) => 'sr-cyrl',
				esc_html__( 'sr', 'exthemes' ) => 'sr',
				esc_html__( 'sv', 'exthemes' ) => 'sv',
				esc_html__( 'th', 'exthemes' ) => 'th',
				esc_html__( 'tr', 'exthemes' ) => 'tr',
				esc_html__( 'uk', 'exthemes' ) => 'uk',
				esc_html__( 'vi', 'exthemes' ) => 'vi',
				esc_html__( 'zh-cn', 'exthemes' ) => 'zh-cn',
				esc_html__( 'zh-tw', 'exthemes' ) => 'zh-tw',
				esc_html__( 'wpml', 'exthemes' ) => 'wpml',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Class", "exthemes"),
			"param_name" => "class",
			"value" => "",
			"description" => esc_html__("Enter class for custom css", 'exthemes'),
		  ),
	   )
	));
	}
}