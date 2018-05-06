<?php
function parse_we_speaker_func($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype ='ex-speaker';
	$ids =  isset($atts['ids']) ? $atts['ids'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'3';
	$order =  isset($atts['order']) ? $atts['order'] :'';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$cat =  isset($atts['cat']) ? $atts['cat'] :'';
	$tag =  isset($atts['tag']) ? $atts['tag'] :'';
	
	$autoplay =  isset($atts['autoplay']) ? $atts['autoplay'] :'';
	global $img_size,$show_meta;
	$img_size =  isset($atts['img_size']) ? $atts['img_size'] :'wethumb_460x307';
	$show_meta =  isset($atts['show_meta']) ? $atts['show_meta'] :'';
	$grid_autoplay ='off' ;
	$args = woo_event_query($posttype, $count, $order, $orderby, $meta_key, $cat, $tag, $ids,'');
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){?>
		<div class="we-carousel we-spekers-sc we-grid-shortcode we-grid-column-1" id="grid-<?php echo $ID;?>">
        	<div class="grid-container">
                <div class="is-carousel" id="post-corousel-<?php echo $ID; ?>" data-items="<?php echo esc_attr($posts_per_page); ?>" <?php if($autoplay=='on'){?> data-autoplay=1 <?php }?> data-navigation=1 data-pagination=1>
                    <?php 
                    $i=0;
                    $it = $the_query->found_posts;
                    if($it < $count || $count=='-1'){ $count = $it;}
                    if($count  > $posts_per_page){
                        $num_pg = ceil($count/$posts_per_page);
                        $it_ep  = $count%$posts_per_page;
                    }else{
                        $num_pg = 1;
                    }
                    while($the_query->have_posts()){ $the_query->the_post();
                        ?>
                        <div class="grid-row">
                        <?php
                        include we_get_plugin_url().'shortcode/content/content-speakersc.php';
                        ?>
                        </div>
                        <?php
                    }?>            
                </div>
            </div>
            <div class="clear"></div>
        </div>
		<?php
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_speakers', 'parse_we_speaker_func' );
add_action( 'after_setup_theme', 'we_reg_we_speakers_vc' );
function we_reg_we_speakers_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Speakers", "exthemes"),
	   "base" => "we_speakers",
	   "class" => "",
	   "icon" => "icon-speaker",
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
			"heading" => esc_html__("Posts per page", "exthemes"),
			"param_name" => "posts_per_page",
			"value" => "",
			"description" => esc_html__("Number items per page", 'exthemes'),
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
			 "heading" => esc_html__("Autoplay", 'exthemes'),
			 "param_name" => "autoplay",
			 "value" => array(
				esc_html__('Off', 'exthemes') => 'off',
				esc_html__('On', 'exthemes') => 'on',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show metadata", 'exthemes'),
			 "param_name" => "show_meta",
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