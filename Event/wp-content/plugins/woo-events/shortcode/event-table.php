<?php
function parse_we_table_func($atts, $content){
	global $style,$show_time,$show_atc;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$posttype =  isset($atts['posttype']) ? $atts['posttype'] :'product';
	$ids =  isset($atts['ids']) ? $atts['ids'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'';
	$order =  isset($atts['order']) ? $atts['order'] :'';
	$show_atc =  isset($atts['show_atc']) ? $atts['show_atc'] :'';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$cat =  isset($atts['cat']) ? $atts['cat'] :'';
	$tag =  isset($atts['tag']) ? $atts['tag'] :'';
	$style =  isset($atts['style']) ? $atts['style'] :'';
	$data_qr =  isset($atts['data_qr']) ? $atts['data_qr'] :'';
	$show_time =  isset($atts['show_time']) ? $atts['show_time'] :'';
	$paged = get_query_var('paged')?get_query_var('paged'):(get_query_var('page')?get_query_var('page'):1);
	if($posts_per_page =="" || $posts_per_page > $count){$posts_per_page = $count; $paged ='';}
	$featured = isset($atts['featured']) ? $atts['featured'] : '';
	$args = woo_event_query($posttype, $posts_per_page, $order, $orderby, $meta_key, $cat, $tag, $ids,$paged,$data_qr,$spe_day=false, $featured);
	ob_start();
	$the_query = new WP_Query( $args );
	if($the_query->have_posts()){?>
		<div class="we-table-lisst <?php echo 'table-style-'.esc_attr($style); if($style=='3'){ echo ' table-style-2';}?>" id="table-<?php echo $ID;?>">
			<table class="we-table">
            	<?php if($style!='2' && $style!='3'){?>
                <thead class="thead-inverse">
                  <tr>
                    <th><?php echo get_option('we_text_stdate')!='' ? get_option('we_text_stdate') : esc_html__("Start Date", "exthemes");?></th>
                    <th>
						<?php echo get_option('we_text_name')!='' ? get_option('we_text_name') : esc_html__("Name", "exthemes");?>
                    	<span class="we-hidden-screen"><?php echo get_option('we_text_details')!='' ? get_option('we_text_details') : esc_html__("Details", "exthemes");?></span>
                    </th>
                    <th class="we-mb-hide"><?php echo get_option('we_text_loca')!='' ? get_option('we_text_loca') : esc_html__("Location", "exthemes");?></th>
                    <th class="we-mb-hide"><?php echo get_option('we_text_price')!='' ? get_option('we_text_price') : esc_html__("Price", "exthemes");?></th>
                    <th class="we-mb-hide"><?php echo get_option('we_text_status')!='' ? get_option('we_text_status') : esc_html__("Status", "exthemes");?></th>
                  </tr>
                </thead>
                <?php }?>
                <tbody>
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
					wooevent_template_plugin('table', true);
                }?>
                </tbody>
			</table>
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
							<input type="hidden"  name="id_table" value="table-'.$ID.'">
							<input type="hidden"  name="num_page" value="'.$num_pg.'">
							<input type="hidden"  name="num_page_uu" value="1">
							<input type="hidden"  name="current_page" value="1">
							<input type="hidden"  name="ajax_url" value="'.esc_url(admin_url( 'admin-ajax.php' )).'">
							<input type="hidden"  name="param_query" value="'.esc_html(str_replace('\/', '/', json_encode($args))).'">
							<input type="hidden" id="param_shortcode" name="param_shortcode" value="'.esc_html(str_replace('\/', '/', json_encode($atts))).'">
							<a  href="javascript:void(0)" class="loadmore-grid table-loadmore" data-id="table-'.$ID.'">
								<span class="load-text">'.$loadtrsl.'</span><span></span>&nbsp;<span></span>&nbsp;<span></span>
							</a>';
					echo'</div>';
				}
			}?>
		</div>
		<?php
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'we_table', 'parse_we_table_func' );
add_action( 'after_setup_theme', 'we_reg_vc' );
function we_reg_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Table", "exthemes"),
	   "base" => "we_table",
	   "class" => "",
	   "icon" => "icon-table",
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
			 	esc_html__('Default', 'exthemes') => '',
				esc_html__('Style 1', 'exthemes') => '1',
				esc_html__('Style 2', 'exthemes') => '2',
				esc_html__('Border style', 'exthemes') => '3',
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
			 "heading" => esc_html__("Show add to cart", 'exthemes'),
			 "param_name" => "show_atc",
			 "value" => array(
			 	esc_html__('No', 'exthemes') => '',
				esc_html__('Yes', 'exthemes') => '1',
			 ),
			 "description" => esc_html__("Show add to cart button instead if view details button", 'exthemes'),
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