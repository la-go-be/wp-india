<?php
function parse_we_grid_func($atts, $content){
	global $columns,$number_excerpt,$show_time,$orderby,$img_size;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype =  isset($atts['posttype']) ? $atts['posttype'] :'product';
	$ids =  isset($atts['ids']) ? $atts['ids'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'';
	$order =  isset($atts['order']) ? $atts['order'] :'';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$cat =  isset($atts['cat']) ? $atts['cat'] :'';
	$tag =  isset($atts['tag']) ? $atts['tag'] :'';
	$style =  isset($atts['style']) ? $atts['style'] :'';
	$number_excerpt =  isset($atts['number_excerpt'])&& $atts['number_excerpt']!='' ? $atts['number_excerpt'] : '10';
	$columns =  isset($atts['columns']) && $atts['columns']!='' ? $atts['columns'] :'3';
	$img_size =  isset($atts['img_size']) ? $atts['img_size'] :'wethumb_460x307';
	$show_time =  isset($atts['show_time']) ? $atts['show_time'] :'';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
	if($posts_per_page =="" || $posts_per_page > $count){$posts_per_page = $count; $paged ='';}
	$featured = isset($atts['featured']) ? $atts['featured'] : '';
	$args = woo_event_query($posttype, $posts_per_page, $order, $orderby, $meta_key, $cat, $tag, $ids,$paged,$data_qr=false,$spe_day=false, $featured);
	
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){?>
		<div class="we-grid-shortcode <?php echo 'we-grid-column-'.esc_attr($columns).' gr-'.$style; if($orderby=='has_submited'){ echo ' submit-list';}?>" id="grid-<?php echo $ID;?>">
        	<div class="ct-grid">
                <div class="grid-container">
                <div class="grid-row">
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
                    if(function_exists('wp_pagenavi')) {
                        $the_query->max_num_pages = $num_pg;
                    }
                    $i++;
                    if(($num_pg == $paged) && $num_pg!='1'){
                        if($i > $it_ep){ break;}
                    }
                    if($style=='classic'){
                        wooevent_template_plugin('grid-classic', true);
                    }else{
                        wooevent_template_plugin('grid', true);
                    }
                    if($i%$columns==0){?>
                        </div>
                        <div class="grid-row">
                        <?php
                    }
                }?>
                </div>
                </div>
                <div class="clear"></div>
            </div>
            <?php
			if(function_exists('wp_pagenavi')) {
				?>
                <div class="we-pagenavi">
					<?php
                    wp_pagenavi(array( 'query' => $the_query));
                    ?>
                </div>
                <?php
			}else{
				if($posts_per_page<$count){
					$loadtrsl = get_option('we_text_loadm')!='' ? get_option('we_text_loadm') : esc_html__('Load more','exthemes');
					echo '
						<div class="ex-loadmore">
							<input type="hidden"  name="id_grid" value="grid-'.$ID.'">
							<input type="hidden"  name="num_page" value="'.$num_pg.'">
							<input type="hidden"  name="num_page_uu" value="1">
							<input type="hidden"  name="current_page" value="1">
							<input type="hidden"  name="ajax_url" value="'.esc_url(admin_url( 'admin-ajax.php' )).'">
							<input type="hidden"  name="param_query" value="'.esc_html(str_replace('\/', '/', json_encode($args))).'">
							<input type="hidden" id="param_shortcode" name="param_shortcode" value="'.esc_html(str_replace('\/', '/', json_encode($atts))).'">
							<a  href="javascript:void(0)" class="loadmore-grid" data-id="grid-'.$ID.'">
								<span class="load-text">'.$loadtrsl.'</span><span></span>&nbsp;<span></span>&nbsp;<span></span>
							</a>';
					echo'</div>';
				}
			}?>
        </div>
		<?php
	}else{
		$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
		if(($orderby=='has_signed_up' || $orderby=='has_submited') && !is_user_logged_in()){
			$noftrsl = get_option('we_text_protect_ct')!='' ? get_option('we_text_protect_ct') : esc_html__('Please Login to See','exthemes');
			echo '<h2>'.$noftrsl.'</h2>';
		}else{
			echo '<p>'.$noftrsl.'</p>';
		}
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_grid', 'parse_we_grid_func' );
add_action( 'after_setup_theme', 'we_reg_grid_vc' );
function we_reg_grid_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Grid", "exthemes"),
	   "base" => "we_grid",
	   "class" => "",
	   "icon" => "icon-grid",
	   "controls" => "full",
	   "category" => esc_html__('WooEvents','exthemes'),
	   "params" => array(
		   array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Style", 'exthemes'),
			 "param_name" => "style",
			 "value" => array(
			 	esc_html__('Modern', 'exthemes') => '',
				esc_html__('Classic', 'exthemes') => 'classic',
				
			 ),
			 "description" => ''
		  ),
		   array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Columns", 'exthemes'),
			 "param_name" => "columns",
			 "value" => array(
			 	esc_html__('', 'exthemes') => '',
				esc_html__('1 columns', 'exthemes') => '1',
				esc_html__('2 columns', 'exthemes') => '2',
				esc_html__('3 columns', 'exthemes') => '3',
				esc_html__('4 columns', 'exthemes') => '4',
				esc_html__('5 columns', 'exthemes') => '5',
			 ),
			 "description" => ''
		  ),	
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
				esc_html__('Has signed up', 'exthemes') => 'has_signed_up',
				esc_html__('Has Submited', 'exthemes') => 'has_submited',
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
			 "heading" => esc_html__("Show time", 'exthemes'),
			 "param_name" => "show_time",
			 "value" => array(
			 	esc_html__('No', 'exthemes') => '',
				esc_html__('Yes', 'exthemes') => '1',
			 ),
			 "description" => ''
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