<?php
function parse_we_search_func($atts, $content){
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$cats =  isset($atts['cats']) ? $atts['cats'] :'';
	$tags =  isset($atts['tags']) ? $atts['tags'] :'';
	$years =  isset($atts['years']) ? $atts['years'] :'';
	$location =  isset($atts['location']) ? $atts['location'] :'';
	ob_start();
	?>
	<div class="woo-event-toolbar we-search-shortcode" id="we-s<?php echo esc_attr($ID);?>">
        	<div class="row">
                <div class="col-md-12">
                	<div class="we-search-form">
                    	<span class="search-lb lb-sp"><?php echo get_option('we_text_search')!='' ? get_option('we_text_search') : esc_html__('Search','exthemes');?></span>
                        <form role="search" method="get" id="searchform" class="wooevent-search-form" action="<?php echo home_url(); ?>/">
                            <div class="input-group">
                                <div class="input-group-btn we-search-dropdown we-sfilter" data-id="we-s<?php echo esc_attr($ID);?>">
                                  <button name="product_cat" type="button" class="btn btn-default we-search-dropdown-button we-showdrd"><span class="button-label"><?php echo get_option('we_text_evfilter')!='' ? get_option('we_text_evfilter') : esc_html__('Filter','exthemes'); ?></span> <span class="fa fa-angle-down"></span></button>
                                </div>
                                <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php echo get_option('we_text_search')!='' ? get_option('we_text_search') : esc_html__('Search','exthemes'); ?>" class="form-control" />
                                <input type="hidden" name="post_type" value="product" />
                                <span class="input-group-btn">
                                    <button type="submit" id="searchsubmit" class="btn btn-default we-search-submit" <?php if(isset($ID) && $ID!=''){?> data-id ="<?php echo esc_attr($ID);?>" <?php }?>><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            <?php we_search_filters($cats,$tags,$years,$location);?>
                        </form>
                    </div>
                </div>
            </div>

        </div>	
	<?php
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}

if(!function_exists('we_search_filters')){
	function we_search_filters($cat_include, $tag_include, $we_syear_include, $we_location_include){
		$column = 4;
		if($cat_include=='hide'){
			$column = $column -1;
		}
		if($tag_include=='hide'){
			$column = $column -1;
		}
		if($we_syear_include=='hide'){
			$column = $column -1;
		}
		if($column=='3'){ $class = 'col-md-4';}elseif($column=='2'){$class = 'col-md-6';}
		elseif($column=='1'){$class = 'col-md-12';}else{$class = 'col-md-3';}
		$all_text = get_option('we_text_all')!='' ? get_option('we_text_all') : esc_html__('All','exthemes');?>
		<div class="we-filter-expand <?php echo esc_attr('we-column-'.$column)?> row">
			<?php 
			if($cat_include!='hide'){
				$args = array( 'hide_empty' => false ); 
				if($cat_include!=''){
					$cat_include = explode(",", $cat_include);
					if(is_numeric($cat_include[0])){
						$args['include'] = $cat_include;
					}else{
						$args['slug'] = $cat_include;
					}
				}
				$terms = get_terms('product_cat', $args);
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
					<div class="we-filter-cat <?php echo esc_attr($class);?> col-sm-4">
						<span class=""><?php echo get_option('we_text_evcat')!='' ? get_option('we_text_evcat') : esc_html__('Category','exthemes');?></span>
                        <select name="product_cat">
                            <option value=""><?php echo esc_html($all_text);?></option>
                            <?php 
                              foreach ( $terms as $term ) {
                                echo '<option value="'. $term->slug .'">'. $term->name .'</option>';
                              }?>
                        </select>
					</div>
			<?php } 
			}
			if($tag_include!='hide'){
				$args = array( 'hide_empty' => false ); 
				if($tag_include!=''){
					$tag_include = explode(",", $tag_include);
					if(is_numeric($tag_include[0])){
						$args['include'] = $tag_include;
					}else{
						$args['slug'] = $tag_include;
					}
				}
				$terms = get_terms('product_tag', $args);
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
					<div class="we-filter-tag <?php echo esc_attr($class);?> col-sm-4">
						<span class=""><?php echo get_option('we_text_evtag')!='' ? get_option('we_text_evtag') : esc_html__('Tags','exthemes');?></span>
                        <select name="product_tag">
                            <option value=""><?php echo esc_html($all_text);?></option>
                            <?php 
                              foreach ( $terms as $term ) {
                                echo '<option value="'. $term->slug .'">'. $term->name .'</option>';
                              }
                              ?>
                        </select>
					</div>
			<?php } 
			} 
			if($we_syear_include!='hide'){
				$cr_y = date("Y");
				if($we_syear_include!=''){
					$arr_ya = explode(",", $we_syear_include);
				}else{
					$arr_ya = array($cr_y-2,$cr_y-1,$cr_y,$cr_y+1,$cr_y+2);
				}
				if ( ! empty( $arr_ya ) ){ ?>
					<div class="we-filter-year <?php echo esc_attr($class);?> col-sm-4">
						<span class=""><?php echo get_option('we_text_evyears')!='' ? get_option('we_text_evyears') : esc_html__('Years','exthemes');?></span>
                        <select name="year">
                            <option value=""><?php echo esc_html($all_text);?></option>
                            <?php 
                              foreach ($arr_ya as $item ) {
                              	echo '<option value="'. $item .'">'. $item .'</option>';
                              }?>
                        </select>
					</div>
			<?php }
			}
			if($we_location_include!='hide'){
				if($we_location_include!=''){
					$ids = explode(",", $we_location_include);
				}else{ $ids = '';}
				$args = array(
					'post_type' => 'we_venue',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'post__in' =>  $ids,
					'ignore_sticky_posts' => 1,
				);
				$the_query = new WP_Query( $args );
				if($the_query->have_posts()){ ?>
					<div class="we-filter-loc <?php echo esc_attr($class);?> col-sm-4">
						<span class=""><?php echo get_option('we_text_evyears')!='' ? get_option('we_text_evyears') : esc_html__('Locations','exthemes');?></span>
                        <select name="location">
                            <option value=""><?php echo esc_html($all_text);?></option>
                            <?php 
                              while($the_query->have_posts()){ $the_query->the_post();
                              	echo '<option value="'. get_the_ID() .'">'. get_the_title() .'</option>';
                              }?>
                        </select>
					</div>
				<?php }
				wp_reset_postdata();
			}?>
        </div>
	<?php
    }
}


add_shortcode( 'we_search', 'parse_we_search_func' );
add_action( 'after_setup_theme', 'we_search_reg_vc' );
function we_search_reg_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Search", "exthemes"),
	   "base" => "we_search",
	   "class" => "",
	   "icon" => "icon-search",
	   "controls" => "full",
	   "category" => esc_html__('WooEvents','exthemes'),
	   "params" => array(
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Included Category", "exthemes"),
			"param_name" => "cats",
			"value" => "",
			"description" => esc_html__("List of Category ID (or slug), separated by a comma, Ex: 13,14 (enter hide to hire this field)", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Included Tags", "exthemes"),
			"param_name" => "tags",
			"value" => "",
			"description" => esc_html__("List of Tags ID (or slug), separated by a comma, Ex: 13,14 (enter hide to hire this field)", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Included Locations", "exthemes"),
			"param_name" => "location",
			"value" => "",
			"description" => esc_html__("List of Venue ID, separated by a comma, Ex: 13,14 (enter hide to hire this field)", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Included Years", "exthemes"),
			"param_name" => "years",
			"value" => "",
			"description" => esc_html__("List of year, separated by a comma, Ex: 2015,2016,2017 (enter hide to hire this field)", "exthemes"),
		  ),
	   )
	));
	}
}