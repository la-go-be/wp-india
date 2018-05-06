<?php
function parse_we_timeline_func($atts, $content){
	global $ID,$number_excerpt;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype =  isset($atts['posttype']) ? $atts['posttype'] :'product';
	$ids =  isset($atts['ids']) ? $atts['ids'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'';
	$order =  isset($atts['order']) ? $atts['order'] :'';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$cat =  isset($atts['cat']) ? $atts['cat'] :'';
	$tag =  isset($atts['tag']) ? $atts['tag'] :'';
	$number_excerpt =  isset($atts['number_excerpt'])&& $atts['number_excerpt']!='' ? $atts['number_excerpt'] : '20';
	$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
	$featured = isset($atts['featured']) ? $atts['featured'] : '';
	$args = woo_event_query($posttype, $count, $order, $orderby, $meta_key, $cat, $tag, $ids,$paged,$data_qr,$spe_day=false, $featured);
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){?>
		<div class="we-timeline-shortcode" id="timeline-<?php echo $ID;?>">
        	<ul>
			<?php 
            while($the_query->have_posts()){ $the_query->the_post();
				wooevent_template_plugin('timeline', true);
            }?>
            </ul>
        </div>
		<?php
	}else{
		$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
		echo '<p>'.$noftrsl.'</p>';
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_timeline', 'parse_we_timeline_func' );
add_action( 'after_setup_theme', 'we_reg_timeline_vc' );
function we_reg_timeline_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Timeline", "exthemes"),
	   "base" => "we_timeline",
	   "class" => "",
	   "icon" => "",
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
				esc_html__('Menu order', 'exthemes') => 'menu_order',
				esc_html__('Meta value', 'exthemes') => 'meta_value',
				esc_html__('Meta value num', 'exthemes') => 'meta_value_num',
				esc_html__('Post__in', 'exthemes') => 'post__in',
				esc_html__('Upcoming', 'exthemes') => 'upcoming',
				esc_html__('Past', 'exthemes') => 'past',
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
			"type" => "textfield",
			"heading" => esc_html__("Number of Excerpt", "exthemes"),
			"param_name" => "number_excerpt",
			"value" => "",
			"description" => esc_html__("Enter number", "exthemes"),
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