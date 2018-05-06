<?php
function parse_we_countdown_func($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$single = isset($atts['single']) ? $atts['single'] : '0';
	$style = isset($atts['style']) ? $atts['style'] : '';
	$posttype = 'product';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$show_title = isset($atts['show_title']) ? $atts['show_title'] : true;
	$featured = isset($atts['featured']) ? $atts['featured'] : '';
	$args = woo_event_query($posttype, $count, $order, $orderby, $meta_key, $cat, $tag, $ids, $page=false, $data_qr=false,$spe_day=false, $featured);
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){
		wp_enqueue_script( 'moment', WOO_EVENT_PATH.'/js/fullcalendar/lib/moment.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'we-jquery.countdown', WOO_EVENT_PATH.'/js/jquery.countdown/jquery.countdown.js', array( 'jquery' ) );
		?>
    	<div class="we-countdonw <?php if($single!='1'){?>list-countdown<?php } echo ' style-'.$style;?>">
        	<input type="hidden"  name="cd-days" value="<?php echo get_option('we_text_day')!='' ? get_option('we_text_day') : esc_html__('days','exthemes');?>">
            <input type="hidden"  name="cd-hr" value="<?php echo get_option('we_text_hours')!='' ? get_option('we_text_hours') : esc_html__('hours','exthemes');?>">
            <input type="hidden"  name="cd-min" value="<?php echo get_option('we_text_min')!='' ? get_option('we_text_min') : esc_html__('min','exthemes');?>">
            <input type="hidden"  name="cd-sec" value="<?php echo get_option('we_text_sec')!='' ? get_option('we_text_sec') : esc_html__('sec','exthemes');?>">
        	<div class="row">
				<?php while($the_query->have_posts()){ $the_query->the_post(); 
					$we_eventcolor ='';
					$we_eventcolor = we_event_custom_color(get_the_ID());
					if($we_eventcolor==''){$we_eventcolor = we_autochange_color();}
					$bg_style ='';
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
					if($style=='modern'){
						$bg_style = 'style="background-image:url('.esc_url($image_src[0]).');"';
					}
					?>
					<div class="col-md-12">
					<div class="we-evcount" <?php echo $bg_style;?>>
						<?php
						if($style=='modern'){
							echo '<div class="bg-gra">';
						}
						if($show_title!=false){?>
						<span class="cd-title"><a href="<?php the_permalink();?>"><?php echo get_the_title();?></a></span>
						<?php }
						if($we_eventcolor!="" && $style!='modern'){?>
							<style type="text/css" scoped>
								.we-countdonw.list-countdown #countdown-<?php echo get_the_ID();?> .cd-number { background-color:<?php echo $we_eventcolor; ?>}
							</style>
							<?php
						}
						$we_time_zone = get_post_meta(get_the_ID(),'we_time_zone',true);
						?>
						<span class="we-coundown-item" id="countdown-<?php echo get_the_ID();?>" data-date="<?php echo date_i18n('Y-m-d H:i', get_post_meta( get_the_ID(), 'we_startdate', true ))?>" data-timezone="<?php echo esc_attr($we_time_zone);?>"></span>
                        <?php 
						if($style=='modern'){
							echo '</div>';
						}
						?>
					</div>
					</div>
                <?php }?>
            </div>
        </div>
        <?php
	}elseif($single!='1'){
		$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
		echo '<div class="alert alert-success">'.$noftrsl.'</div>';
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_countdown', 'parse_we_countdown_func' );
add_action( 'after_setup_theme', 'we_reg_countdown_vc' );
function we_reg_countdown_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - CountDown", "exthemes"),
	   "base" => "we_countdown",
	   "class" => "",
	   "icon" => "icon-countdown",
	   "controls" => "full",
	   "category" => esc_html__('WooEvents','exthemes'),
	   "params" => array(
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("IDs", "exthemes"),
			"param_name" => "ids",
			"value" => "",
			"description" => esc_html__("Specify post IDs to retrieve", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Style", 'exthemes'),
			 "param_name" => "style",
			 "value" => array(
			 	esc_html__('Classic', 'exthemes') => 'classic',
				esc_html__('Modern', 'exthemes') => 'modern',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Count", "exthemes"),
			"param_name" => "count",
			"value" => "",
			"description" => esc_html__("Number of posts", 'exthemes'),
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
			"type" => "textfield",
			"heading" => esc_html__("Tags", "exthemes"),
			"param_name" => "tag",
			"value" => "",
			"description" => esc_html__("List of tags, separated by a comma", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Order", 'exthemes'),
			 "param_name" => "order",
			 "value" => array(
			 	esc_html__('DESC', 'exthemes') => 'DESC',
				esc_html__('ASC', 'exthemes') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Order by", 'exthemes'),
			 "param_name" => "orderby",
			 "value" => array(
			 	esc_html__('Date', 'exthemes') => 'date',
				esc_html__('ID', 'exthemes') => 'ID',
				esc_html__('Author', 'exthemes') => 'author',
			 	esc_html__('Title', 'exthemes') => 'title',
				esc_html__('Name', 'exthemes') => 'name',
				esc_html__('Modified', 'exthemes') => 'modified',
			 	esc_html__('Parent', 'exthemes') => 'parent',
				esc_html__('Random', 'exthemes') => 'rand',
				esc_html__('Comment count', 'exthemes') => 'comment_count',
				esc_html__('Menu order', 'exthemes') => 'menu_order',
				esc_html__('Meta value', 'exthemes') => 'meta_value',
				esc_html__('Meta value num', 'exthemes') => 'meta_value_num',
				esc_html__('Post__in', 'exthemes') => 'post__in',
				esc_html__('Upcoming', 'exthemes') => 'upcoming',
				esc_html__('Day', 'exthemes') => 'day',
				esc_html__('Week', 'exthemes') => 'week',
				esc_html__('Month', 'exthemes') => 'month',
				esc_html__('Year', 'exthemes') => 'year',
				esc_html__('None', 'exthemes') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Meta key", "exthemes"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => esc_html__("Enter meta key to query", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show only Featured event", 'exthemes'),
			 "param_name" => "featured",
			 "value" => array(
			 	esc_html__('No', 'exthemes') => '',
				esc_html__('Yes', 'exthemes') => '1',
			 ),
			 "description" => ''
		  ),
	   )
	));
	}
}