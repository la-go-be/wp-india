<?php
if(!function_exists('we_startsWith')){
	function we_startsWith($haystack, $needle)
	{
		return !strncmp($haystack, $needle, strlen($needle));
	}
} 
if(!function_exists('we_get_google_fonts_url')){
	function we_get_google_fonts_url ($font_names) {
	
		$font_url = '';
	
		$font_url = add_query_arg( 'family', urlencode(implode('|', $font_names)) , "//fonts.googleapis.com/css" );
		return $font_url;
	} 
}
if(!function_exists('we_get_google_font_name')){
	function we_get_google_font_name($family_name){
		$name = $family_name;
		if(we_startsWith($family_name, 'http')){
			// $family_name is a full link, so first, we need to cut off the link
			$idx = strpos($name,'=');
			if($idx > -1){
				$name = substr($name, $idx);
			}
		}
		$idx = strpos($name,':');
		if($idx > -1){
			$name = substr($name, 0, $idx);
			$name = str_replace('+',' ', $name);
		}
		return $name;
	}
}


function we_filter_wc_get_template_single($template, $slug, $name){
	if($slug=='content' && $name =='single-product'){
		return wooevent_template_plugin('single-product');
	}else{ 
		return $template;
	}
}
function filter_wc_get_template_shop($template, $slug, $name){
	if($slug=='content' && $name =='product'){
		return wooevent_template_plugin('product');
	}else{ 
		return $template;
	}
}
function we_filter_wc_get_template_related($located, $template_name, $args){
	if($template_name =='single-product/related.php'){
		if (locate_template('woo-events/related.php') != '') {
			return get_template_part('woo-events/related');
		} else {
			return we_get_plugin_url().'templates/related.php';
		}
	}else{ 
		return $located;
	}
}

function we_filter_wc_get_template_no_result($located, $template_name, $args){
	if(($template_name =='loop/no-products-found.php')){
		$shop_view = get_option('we_shop_view');
		if(is_tax() || ($shop_view=='list' && !isset($_GET['view'])) || (isset($_GET['view']) && $_GET['view']=='list' ) ){
			if (locate_template('woo-events/no-products-found.php') != '') {
				return get_template_part('woo-events/no-products-found');
			} else {
				return we_get_plugin_url().'templates/no-products-found.php';
			}
		}else{
			return $located;
		}
	}else{ 
		return $located;
	}
}

$we_main_purpose = get_option('we_main_purpose');
if($we_main_purpose!='meta'){
	add_filter( 'wc_get_template_part', 'we_filter_wc_get_template_single', 10, 3 );
	add_filter( 'wc_get_template_part', 'filter_wc_get_template_shop', 99, 3 );
	//if($we_main_purpose=='custom'){
		add_filter( 'wc_get_template', 'we_filter_wc_get_template_related', 99, 3 );
		add_filter( 'wc_get_template', 'we_filter_wc_get_template_no_result', 99, 3 );
	//}

}
// Change number or products per row to 3
if(!function_exists('wooevent_template_plugin')){
	function wooevent_template_plugin($pageName,$shortcode=false){
		if(isset($shortcode) && $shortcode== true){
			if (locate_template('woo-events/content-shortcode/content-' . $pageName . '.php') != '') {
				get_template_part('woo-events/content-shortcode/content', $pageName);
			} else {
				include we_get_plugin_url().'shortcode/content/content-' . $pageName . '.php';
			}

		}else{
			if (locate_template('woo-events/content-' . $pageName . '.php') != '') {
				get_template_part('woo-events/content', $pageName);
			} else {
				include we_get_plugin_url().'templates/content-' . $pageName . '.php';
			}
		}
	}
}
//
if(!function_exists('ex_cat_info')){
	function ex_cat_info($status,$post_type = false, $tax=false, $show_once= false){
		ob_start();
		if($status=='off'){ return;}
		if(isset($post_type) && $post_type!='post'){
			if($post_type == 'product' && class_exists('Woocommerce')){
				$tax = 'product_cat';
			}
			if(isset($tax) && $tax!=''){
				$args = array(
					'hide_empty'        => false, 
				);
				$terms = get_terms($tax, $args);
				if(!empty($terms)){
					$c_tax = count($terms);
					?>
					<span class="info-cat">
						<i class="ion-ios-photos-outline"></i>
						<?php
						$i=0;
						foreach ( $terms as $term ) {
							$i++;
							echo '<a href="'.get_term_link( $term ).'" title="' . $term->name . '">'. $term->name .'</a>';
							if($i != $c_tax){ echo ', ';}
						}
						?>
                    </span>
                    <?php
				}
			}
		}else{
			$category = get_the_category();
			if(!isset($show_once) || $show_once!='1'){
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="ion-ios-photos-outline"></i>
						<?php the_category(', '); ?>
					</span>
					<?php  
				}
			}else{
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="ion-ios-photos-outline"></i>
						<?php
						foreach($category as $cat_item){
							if(is_array($cat_item) && isset($cat_item[0]))
								$cat_item = $cat_item[0];
								echo '
									<a href="' . esc_url(get_category_link( $cat_item->term_id )) . '" title="' . esc_html__('View all posts in ') . $cat_item->name . '">' . $cat_item->name . '</a>';
								if($show_once==1){
									break;
								}
							}
							?>
                    </span>
                    <?php
				}
			}
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
// Get has purchased
function we_get_all_products_ordered_by_user() {
    $orders = we_get_all_user_orders(get_current_user_id(), 'completed');
    if(empty($orders)) {
        return false;
    }
    $order_list = '(' . join(',', $orders) . ')';//let us make a list for query
    //so, we have all the orders made by this user that were completed.
    //we need to find the products in these orders and make sure they are downloadable.
    global $wpdb;
    $query_select_order_items = "SELECT order_item_id as id FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id IN {$order_list}";
    $query_select_product_ids = "SELECT meta_value as product_id FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE meta_key=%s AND order_item_id IN ($query_select_order_items)";
    $products = $wpdb->get_col($wpdb->prepare($query_select_product_ids, '_product_id'));
    return $products;
}
function we_get_all_user_orders($user_id, $status = 'completed') {
    if(!$user_id) {
        return false;
    }
    $args = array(
        'numberposts' => -1,
        'meta_key' => '_customer_user',
        'meta_value' => $user_id,
        'post_type' => 'shop_order',
        'post_status' => array( 'wc-completed' )
        
    );
    $posts = get_posts($args);
    //get the post ids as order ids
    return wp_list_pluck($posts, 'ID');
}
// Query function
if(!function_exists('woo_event_query')){
	function woo_event_query($posttype, $count, $order, $orderby, $meta_key, $cat, $tag, $ids,$page=false,$data_qr=false,$spe_day=false, $feature=false ){
		if($orderby=='has_signed_up'){
			if(get_current_user_id()){
				$ids = we_get_all_products_ordered_by_user(); 
			}else{
				$ids = '-1';
			}
		}elseif($orderby=='has_submited'){
			if(get_current_user_id()){
				$ids = get_user_meta(get_current_user_id(), '_my_submit', true);
				if($ids =='' || empty($ids)){ $ids ='-1';}
			}else{
				$ids = '-1';
			}
		}
		
		if($ids!='' || (is_array($ids) && !empty($ids))){ //specify IDs
			
			if(!is_array($ids)){
				$ids = explode(",", $ids);
			}
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => 'publish',
				'post__in' =>  $ids,
				'order' => $order,
				'orderby' => $orderby,
				'meta_key' => $meta_key,
				'ignore_sticky_posts' => 1,
			);
		}elseif($ids==''){
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => 'publish',
				'order' => $order,
				'orderby' => $orderby,
				'meta_key' => $meta_key,
				'ignore_sticky_posts' => 1,
			);
			if($tag!=''){
				$tags = explode(",",$tag);
				if(is_numeric($tags[0])){$field_tag = 'term_id'; }
				else{ $field_tag = 'slug'; }
				if(count($tags)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($tags as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'product_tag',
								  'field' => $field_tag,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'product_tag',
								  'field' => $field_tag,
								  'terms' => $tags,
							  )
					  );
				}
			}
			//cats
			if($cat!=''){
				$cats = explode(",",$cat);
				if(is_numeric($cats[0])){$field = 'term_id'; }
				else{ $field = 'slug'; }
				if(count($cats)>1){
					  $texo = array(
						  'relation' => 'OR',
					  );
					  foreach($cats as $iterm) {
						  $texo[] = 
							  array(
								  'taxonomy' => 'product_cat',
								  'field' => $field,
								  'terms' => $iterm,
							  );
					  }
				  }else{
					  $texo = array(
						  array(
								  'taxonomy' => 'product_cat',
								  'field' => $field,
								  'terms' => $cats,
							  )
					  );
				}
			}
			if(isset($texo)){
				$args += array('tax_query' => $texo);
			}
			if(isset($data_qr) && $data_qr!='' && is_numeric($data_qr)){
				$args['meta_query'] = array (
					 array(
						'key' => 'we_speakers',
						'value' => $data_qr,
						'compare' => 'LIKE'
					)
				);
			}
			$cure_time =  strtotime("now");
			if($orderby=='ontoup'){
				if($order==''){$order='ASC';}
				$args += array(
					'meta_key' => 'we_startdate', 
					'meta_query' => array( 
						'relation' => 'OR',
						 array(
							'key'     => 'we_startdate',
							'value'   => $cure_time,
							'compare' => '>',
						 ),
						 array(
							'key'     => 'we_enddate',
							'value'   => $cure_time,
							'compare' => '>',
						),
					)
				);
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
			}elseif($orderby=='upcoming'){
				if($order==''){$order='ASC';}
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
				$args['meta_key']= 'we_startdate';
				/*$args['meta_value']= $cure_time;
				$args['meta_compare']= '>';*/
				$args['meta_query'] = array(
					'relation' => 'AND',
					array(
						'key'  => 'we_startdate',
						'value' => $cure_time,
						'compare' => '>'
					)
				);
			}elseif($orderby=='past'){
				if($order==''){$order='DESC';}
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
				$args['meta_key']= 'we_enddate';
				/*$args['meta_value']= $cure_time;
				$args['meta_compare']= '<';*/
				$args['meta_query'] = array(
					'relation' => 'AND',
					array(
						'key'  => 'we_enddate',
						'value' => $cure_time,
						'compare' => '<'
					)
				);
			}elseif($orderby=='day'){
				$args += array(
						 'meta_key' => 'we_startdate',
						 'meta_query' => array( 
						 array('key'  => 'we_startdate',
							   'value' => $cure_time,
							   'compare' => '=')
						 )
				);
			}elseif($orderby=='week'){
				$day = date('w');
				$week_start = date('m/d/Y', strtotime('-'.$day.' days'));
				if($order==''){$order='ASC';}
				$week_end = date('m/d/Y', strtotime('+'.(6-$day).' days'));
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'meta_query' => array( 
						 'relation' => 'AND',
						  array('key'  => 'we_startdate',
							   'value' => strtotime($week_start),
							   'compare' => '>'),
						  array('key'  => 'we_startdate',
							   'value' => strtotime($week_end),
							   'compare' => '<=')
						 )
				);
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
			}elseif($orderby=='month'){
				$month_start = date("m/1/Y") ;
				if($order==''){$order='DESC';}
				$month_end =  date("m/t/Y") ;
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'meta_query' => array( 
						 'relation' => 'AND',
						  array('key'  => 'we_startdate',
							   'value' => strtotime($month_start),
							   'compare' => '>'),
						  array('key'  => 'we_startdate',
							   'value' => strtotime($month_end),
							   'compare' => '<=')
						 )
				);
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
			}elseif($orderby=='year'){
				$y_start = date("1/1/Y") ;
				$y_end =  date("12/t/Y") ;
				if($order==''){$order='DESC';}
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'meta_query' => array( 
						 'relation' => 'AND',
						  array('key'  => 'we_startdate',
							   'value' => strtotime($y_start),
							   'compare' => '>'),
						  array('key'  => 'we_startdate',
							   'value' => strtotime($y_end),
							   'compare' => '<=')
						 )
				);
				$args['orderby']= 'meta_value_num';
				$args['order']= $order;
			}
		}	
		if(isset($page) && $page!=''){
			$args['paged'] = $page;
		}
		if($orderby=='has_submited'){
			$args['post_status'] = array( 'publish', 'pending', 'trash' );
		}
		if(isset($feature) && $feature==1){
			if(!empty($args['meta_query'])){
				$args['meta_query']['relation'] = 'AND';
			}
			$args['meta_query'][] = array(
				'key'  => '_featured',
				'value' => 'yes',
				'compare' => '='
			);
		}
		
		return $args;
	}
}
//View search bar
if(!function_exists('wooevent_search_view_bar')){
	function wooevent_search_view_bar($ID=false){
		ob_start();
		$we_search_ajax = get_option('we_search_ajax');
		$we_search_style = get_option('we_search_style');
		if($we_search_style =='sc'){
			$we_search_ajax = '';
		}
		?>
        <div class="woo-event-toolbar" <?php if($we_search_ajax=='yes'){?> id="we-ajax-search"<?php }?>>
        	<div class="row">
                <div class="<?php if(is_search()){?>col-md-12<?php }else{?> col-md-8<?php }?>">
                	<?php if($we_search_style =='sc'){
						$cat_include =  get_option('we_scat_include');
						$tag_include = get_option('we_stag_include');
						$we_syear_include = get_option('we_syear_include');
						$we_loca_include = get_option('we_loca_include');
						echo do_shortcode('[we_search cats="'.$cat_include.'" tags="'.$tag_include.'" location="'.$we_loca_include.'" years="'.$we_syear_include.'"]');
					}else{?>
                    <div class="we-search-form">
                    	<span class="search-lb lb-sp"><?php echo get_option('we_text_search')!='' ? get_option('we_text_search') : esc_html__('Search','exthemes');?></span>
                        <form role="search" method="get" id="searchform" class="wooevent-search-form" action="<?php echo home_url(); ?>/">
                            <div class="input-group">
                                <?php 
                                
                                if ( $we_search_ajax=='yes' ){ ?>
                                    <div class="input-group-btn we-search-dropdown we-sfilter" <?php if($we_search_ajax=='yes'){?> data-id="we-ajax-search"<?php }?>>
                                      <button name="product_cat" type="button" class="btn btn-default we-search-dropdown-button we-showdrd"><span class="button-label"><?php echo get_option('we_text_evfilter')!='' ? get_option('we_text_evfilter') : esc_html__('Filter','exthemes'); ?></span> <span class="fa fa-angle-down"></span></button>
                                    </div>
                                <?php }else{
									$args = array(
										'hide_empty'        => false, 
									); 
									$cat_include =  $we_scat_include = get_option('we_scat_include');
									if($we_scat_include!=''){
										$we_scat_include = explode(",", $we_scat_include);
										if(is_numeric($we_scat_include[0])){
											$args['include'] = $we_scat_include;
										}else{
											$args['slug'] = $we_scat_include;
										}
									}
									$terms = get_terms('product_cat', $args);
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
									  <div class="input-group-btn we-search-dropdown">
										<button name="product_cat" type="button" class="btn btn-default we-product-search-dropdown-button we-showdrd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="button-label"><?php echo get_option('we_text_all')!='' ? get_option('we_text_all') : esc_html__('All','exthemes'); ?></span> <span class="fa fa-angle-down"></span></button>
										<ul class="we-dropdown-select">
											<li><a href="#" data-value=""><?php echo get_option('we_text_all')!='' ? get_option('we_text_all') : esc_html__('All','exthemes'); ?></a></li>
											<?php 
											foreach ( $terms as $term ) {
											  echo '<li><a href="#" data-value="'. $term->slug .'">'. $term->name .'</a></li>';
											}
											?>
										</ul>
									  </div>
									<?php } //if have terms ?>
                                
                                <?php }?>
                                <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php echo get_option('we_text_search')!='' ? get_option('we_text_search') : esc_html__('Search','exthemes'); ?>" class="form-control" />
                                <input type="hidden" name="post_type" value="product" />
                                <input type="hidden" name="product_cat" class="we-product-cat" value="" />
                                <input type="hidden" name="product_tag" class="we-product-tag" value="" />
                                <input type="hidden" name="product_year" class="we-product-year" value="" />
                                <span class="input-group-btn">
                                    <button type="submit" id="searchsubmit" class="btn btn-default we-search-submit" <?php if(isset($ID) && $ID!=''){?> data-id ="<?php echo esc_attr($ID);?>" <?php }?>><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                            <?php if ( $we_search_ajax=='yes' ){ woo_event_filter_list($ID); }?>
                        </form>
                    </div>
                    <?php }?>
                </div>
                <?php if(!is_search()){?>
                    <div class="col-md-4">
                        <div class="we-viewas">
                            <?php $pageURL = 'http';
                            if(isset($_SERVER["HTTPS"]) && ($_SERVER["HTTPS"] == "on")) {$pageURL .= "s";}
                            $pageURL .= "://";
                            if ($_SERVER["SERVER_PORT"] != "80") {
                            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
                            } else {
                            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
                            }?>
                            <span class="viewas-lb lb-sp"><?php echo get_option('we_text_viewas')!='' ? get_option('we_text_viewas') : esc_html__('View as','exthemes');?></span>
                            <div class="input-group-btn we-viewas-dropdown">
                                <button name="we-viewas" type="button" class="btn btn-default we-viewas-dropdown-button we-showdrd">
                                    <span class="button-label">
                                        <?php 
										$we_shop_view = get_option('we_shop_view');
										if(isset($_GET['view']) && $_GET['view']=='day' || !isset($_GET['view']) && $we_shop_view=='day'){
											echo get_option('we_text_day')!='' ? get_option('we_text_day') : esc_html__('Day','exthemes'); 
										}elseif(isset($_GET['view']) && $_GET['view']=='week' || !isset($_GET['view']) && $we_shop_view=='week'){
											echo get_option('we_text_week')!='' ? get_option('we_text_week') : esc_html__('Week','exthemes');
										}elseif(isset($_GET['view']) && $_GET['view']=='map' || !isset($_GET['view']) && $we_shop_view=='map'){
											echo get_option('we_text_map')!='' ? get_option('we_text_map') : esc_html__('Map','exthemes'); 
										}elseif(isset($_GET['view']) && $_GET['view']=='list' || !isset($_GET['view']) && $we_shop_view=='list'){
											echo get_option('we_text_list')!='' ? get_option('we_text_list') : esc_html__('List','exthemes');
										}elseif(isset($_GET['view']) && $_GET['view']=='month' || !isset($_GET['view']) && $we_shop_view=='month'){
											echo get_option('we_text_month')!='' ? get_option('we_text_month') : esc_html__('Month','exthemes');
										}elseif(!isset($_GET['view']) ){
											echo '<span>'.get_option('we_text_select')!='' ? get_option('we_text_select') : esc_html__('Select','exthemes').'</span>';
										}?>
                                    </span> <span class="icon-arr fa fa-angle-down"></span>
                                </button>
                                <ul class="we-dropdown-select">
                                    <?php if((!isset($_GET['view']) && $we_shop_view !='list') || (isset($_GET['view']) && $_GET['view']!='list')){?>
                                        <li><a href="<?php echo add_query_arg( array('view' => 'list'), $pageURL); ?>" data-value=""><?php echo get_option('we_text_list')!='' ? get_option('we_text_list') : esc_html__('List','exthemes'); ?></a></li>
                                    <?php }
                                    if((!isset($_GET['view']) && $we_shop_view !='map') || (isset($_GET['view']) && $_GET['view']!='map')){?>
                                        <li><a href="<?php echo add_query_arg( array('view' => 'map'), $pageURL); ?>" data-value=""><?php echo get_option('we_text_map')!='' ? get_option('we_text_map') : esc_html__('Map','exthemes'); ?></a></li>
                                    <?php }
                                    if((!isset($_GET['view']) && $we_shop_view !='month') ||  (isset($_GET['view']) && $_GET['view']!='month')){?>
                                    <li><a href="<?php echo add_query_arg( array('view' => 'month'), $pageURL); ?>" data-value=""><?php echo get_option('we_text_month')!='' ? get_option('we_text_month') : esc_html__('Month','exthemes'); ?></a></li>
                                    <?php }
                                    if((!isset($_GET['view']) && $we_shop_view !='week') || (isset($_GET['view']) && $_GET['view']!='week')){?>
                                    <li><a href="<?php echo add_query_arg( array('view' => 'week'), $pageURL); ?>" data-value=""><?php echo get_option('we_text_week')!='' ? get_option('we_text_week') : esc_html__('Week','exthemes'); ?></a></li>
                                    <?php }
                                    if((!isset($_GET['view']) && $we_shop_view !='week') || (isset($_GET['view']) && $_GET['view']!='day')){?>
                                    <li><a href="<?php echo add_query_arg( array('view' => 'day'), $pageURL); ?>" data-value=""><?php echo get_option('we_text_day')!='' ? get_option('we_text_day') : esc_html__('Day','exthemes'); ?></a></li>
                                    <?php }?>
                                </ul>
                            </div><!-- /btn-group -->
                        </div>
                    </div>
                <?php }?>
            </div>

        </div>    
    	<?php
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
if(!function_exists('woo_event_filter_list')){
	function woo_event_filter_list($ID=false){
		$column = 3;
		$cat_include =  $we_scat_include = get_option('we_scat_include');
		$tag_include = get_option('we_stag_include');
		$we_syear_include = get_option('we_syear_include');
		if($cat_include=='hide'){
			$column = $column -1;
		}
		if($tag_include=='hide'){
			$column = $column -1;
		}
		if($we_syear_include=='hide'){
			$column = $column -1;
		}
		?>
    	<div class="we-active-filters"></div>
		<div class="we-filter-expand <?php echo esc_attr('we-column-'.$column)?>">
			<?php 
			if($cat_include!='hide'){
				$args = array(
					'hide_empty'        => false, 
				); 
				if($we_scat_include!=''){
					$we_scat_include = explode(",", $we_scat_include);
					if(is_numeric($we_scat_include[0])){
						$args['include'] = $we_scat_include;
					}else{
						$args['slug'] = $we_scat_include;
					}
				}
				$terms = get_terms('product_cat', $args);
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
					<div class="we-filter">
						<span class=""><?php echo get_option('we_text_evcat')!='' ? get_option('we_text_evcat') : esc_html__('Category','exthemes');?></span>
						<ul class="we-cat-select">
							<?php 
							foreach ( $terms as $term ) {
							  echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '" data-value="'. $term->slug .'" class="add-cat" data-id ="'.esc_attr($ID).'">'. $term->name .'</a></li>';
							}
							?>
						</ul>
					</div>
			<?php } 
			}?>
        	<?php 
			if($tag_include!='hide'){
				$args = array(
					'hide_empty'        => false, 
				); 
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
					<div class="we-filter">
						<span class=""><?php echo get_option('we_text_evtag')!='' ? get_option('we_text_evtag') : esc_html__('Tags','exthemes');?></span>
						<ul class="we-cat-select">
							<?php 
							foreach ( $terms as $term ) {
							  echo '<li><a href="' . esc_url( get_term_link( $term ) ) . '" data-value="'. $term->slug .'" class="add-tag" data-id ="'.esc_attr($ID).'">'. $term->name .'</a></li>';
							}
							?>
						</ul>
					</div>
			<?php } 
			}?>
        	<?php 
			if($we_syear_include!='hide'){
				$cr_y = date("Y");
				if($we_syear_include!=''){
					$arr_ya = explode(",", $we_syear_include);
				}else{
					$arr_ya = array($cr_y-2,$cr_y-1,$cr_y,$cr_y+1,$cr_y+2);
				}
				if ( ! empty( $arr_ya ) ){ ?>
					<div class="we-filter">
						<span class=""><?php echo get_option('we_text_evyears')!='' ? get_option('we_text_evyears') : esc_html__('Years','exthemes');?></span>
						<ul class="we-cat-select">
							<?php 
							foreach ( $arr_ya as $item ) {
							  echo '<li><a href="javascript:;" data-value="'. $item .'" class="add-year" data-id ="'.esc_attr($ID).'">'. $item .'</a></li>';
							}
							?>
						</ul>
					</div>
			<?php }
			}?>
        
        </div>
	<?php
    }
}
// Ical button
function woo_events_ical() {
	if(isset($_GET['ical_product'])&& $_GET['ical_product']>0){
		// - start collecting output -
		ob_start();
		
		// - file header -
		header('Content-type: text/calendar');
		header('Content-Disposition: attachment; filename="'.esc_attr(get_the_title($_GET['ical_product'])).' - ical.ics"');
		global $post;
		// - content header -
		?>
        <?php
		$content = "BEGIN:VCALENDAR\r\n";
		$content .= "VERSION:2.0\r\n";
		$content .= 'PRODID:-//'.get_bloginfo('name')."\r\n";
		$content .= "CALSCALE:GREGORIAN\r\n";
		$content .= "METHOD:PUBLISH\r\n";
		$content .= 'X-WR-CALNAME:'.get_bloginfo('name')."\r\n";
		$content .= 'X-ORIGINAL-URL:'.get_permalink($_GET['ical_product'])."\r\n";
		$content .= 'X-WR-CALDESC:'.esc_attr(get_the_title($_GET['ical_product']))."\r\n";
		?>
		<?php
		$date_format = get_option('date_format');
		$hour_format = get_option('time_format');
		$startdate = get_post_meta($_GET['ical_product'],'we_startdate', true );
		if($startdate){
			$startdate = gmdate("Ymd\THis", $startdate);// convert date ux
		}
		$enddate = get_post_meta($_GET['ical_product'],'we_enddate', true );
		if($enddate){
			$enddate = gmdate("Ymd\THis", $enddate);
		}
		
		$gmts = get_gmt_from_date($startdate); // this function requires Y-m-d H:i:s, hence the back & forth.
		$gmts = strtotime($gmts);
		
		// - grab gmt for end -
		//$gmte = date('Y-m-d H:i:s', $conv_enddate);
		$gmte = get_gmt_from_date($enddate); // this function requires Y-m-d H:i:s, hence the back & forth.
		$gmte = strtotime($gmte);
		
		// - Set to UTC ICAL FORMAT -
		$stime = date('Ymd\THis', $gmts);
		$etime = date('Ymd\THis', $gmte);
		
		// - item output -
		?>
        <?php
		$content .= "BEGIN:VEVENT\r\n";
		$content .= 'DTSTART:'.$startdate."\r\n";
		$content .= 'DTEND:'.$enddate."\r\n";
		$content .= 'SUMMARY:'.esc_attr(get_the_title($_GET['ical_product']))."\r\n";
		$content .= 'DESCRIPTION:'.get_post($_GET['ical_product'])->post_excerpt."\r\n";
        $content .= 'LOCATION:'.get_post_meta($_GET['ical_product'], 'we_adress', true )."\r\n";
		$content .= "END:VEVENT\r\n";
		$content .= "END:VCALENDAR\r\n";
		// - full output -
		$tfeventsical = ob_get_contents();
		ob_end_clean();
		echo $content;
		exit;
		}
}
//Status
if(!function_exists('woo_event_status')){
	function woo_event_status( $post_id, $we_enddate=false){
		if(!$we_enddate){$we_enddate = get_post_meta( $post_id, 'we_enddate', true ) ;}
		global $product; 
		$we_main_purpose = we_global_main_purpose();
		$stock_status = get_post_meta($post_id, '_stock_status',true);
		$numleft  = $product->get_stock_quantity();
		if($stock_status !='outofstock') { 
			  $now =  strtotime("now");
			  
			  $we_time_zone = get_post_meta($post_id,'we_time_zone',true);
			  if($we_time_zone!='' && $we_time_zone!='def'){
				  $we_time_zone = $we_time_zone * 60 * 60;
				  $now = $we_time_zone + $now;
			  }
			  
			  if($now > $we_enddate && $we_enddate!=''){
				  $stt =  get_option('we_text_event_pass')!='' ? get_option('we_text_event_pass') : esc_html__('This event has passed','exthemes');
			  }else{
				  if($numleft==0){
					  $stt = get_option('we_text_unl_tic')!='' ? get_option('we_text_unl_tic') : esc_html__('Unlimited tickets','exthemes');
					  if($we_main_purpose=='woo'){
						  $stt = get_option('we_text_unl_pie')!='' ? get_option('we_text_unl_pie') : esc_html__('Unlimited pieces','exthemes');
					  }
				  }else{
					  $qtyavtrsl = get_option('we_text_qty_av')!='' ? get_option('we_text_qty_av') :  esc_html__(' Qty Available','exthemes');
					  $stt = $numleft.'  '.$qtyavtrsl;
					  if($we_main_purpose=='woo'){
						  $pietrsl = get_option('we_text_pie_av')!='' ? get_option('we_text_pie_av') :  esc_html__(' Pieces Available','exthemes');
						  $stt = $numleft.'  '.$pietrsl;
					  }
				  }
			  }
		  }else{ 
			  $stt = get_option('we_text_no_tk')!='' ? get_option('we_text_no_tk') : esc_html__('There are no ticket available at this time.','exthemes'); 
			  if($we_main_purpose=='woo'){
				  $stt = get_option('we_text_no_pie')!='' ? get_option('we_text_no_pie') : esc_html__('There are no pieces available at this time.','exthemes'); 
			  }
		  }
		  return $stt;
	}
}
add_action('init','woo_events_ical');
//Calendar event ajax
add_action( 'wp_ajax_we_get_events_calendar', 'we_get_events_calendar' );
add_action( 'wp_ajax_nopriv_we_get_events_calendar', 'we_get_events_calendar' );
function we_get_events_calendar() {	
	  $result ='';	
	  $args = array(
		  'post_type' => 'product',
		  'posts_per_page' => -1,
		  'post_status' => 'publish',
		  'ignore_sticky_posts' => 1,
	  );
	  $time_now =  strtotime("now");
	  if(isset($_GET['orderby']) && $_GET['orderby']=='upcoming'){
		  $_GET['start'] = $time_now;
	  }elseif(isset($_GET['orderby']) && $_GET['orderby']=='past'){
		  $_GET['end'] = $time_now;
	  }
	  if($_GET['end'] && $_GET['start']){
		  $args = array(
				'post_type' => 'product',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'meta_key' => 'we_startdate',
				'orderby' => 'meta_value_num',
				'meta_query' => array(
				'relation' => 'AND',
				array('key'  => 'we_enddate',
					 'value' => $_GET['start'],
					 'compare' => '>='),
				array('key'  => 'we_startdate',
					 'value' => $_GET['end'],
					 'compare' => '<=')
				)
		  );
		  //cats
		  $cat ='';
		  if(isset($_GET['category']) && $_GET['category']!=''){
			  $cat = $_GET['category'];
		  }
		  if($cat!=''){
			  $cats = explode(",",$cat);
			  if(is_numeric($cats[0])){$field = 'term_id'; }
			  else{ $field = 'slug'; }
			  if(count($cats)>1){
					$texo = array(
						'relation' => 'OR',
					);
					foreach($cats as $iterm) {
						$texo[] = 
							array(
								'taxonomy' => 'product_cat',
								'field' => $field,
								'terms' => $iterm,
							);
					}
				}else{
					$texo = array(
						array(
								'taxonomy' => 'product_cat',
								'field' => $field,
								'terms' => $cats,
							)
					);
			  }
		  }
		  if(isset($texo)){
			  $args += array('tax_query' => $texo);
		  }
		  $the_query = new WP_Query( $args );
		  $it = $the_query->post_count;
		  $rs=array();
		  $show_bt =  isset($_GET['show_bt']) ? $_GET['show_bt'] :'';
		  $curent_url =  isset($_GET['curent_url']) ? $_GET['curent_url'] :'';
		  if($the_query->have_posts()){
			  $date_format = get_option('date_format');
			  $hour_format = get_option('time_format');
			  while($the_query->have_posts()){ $the_query->the_post();
				  $image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumb_150x160' );
				  $we_startdate_unix = get_post_meta(get_the_ID(),'we_startdate', true );
				  $we_enddate_unix = get_post_meta(get_the_ID(),'we_enddate', true );
				  $all_day = get_post_meta(get_the_ID(),'we_allday', true );
				  if($we_startdate_unix!=''){
					 // $startdate_cal = gmdate("Ymd\THis", $startdate);
					  $we_startdate = gmdate("Y-m-d\TH:i:s", $we_startdate_unix);// convert date ux
				  }
				  if($we_enddate_unix!=''){
					  $we_enddate = gmdate("Y-m-d\TH:i:s", $we_enddate_unix);
					  if($all_day==1){
						  $we_enddate = gmdate("Y-m-d\TH:i:s", $we_enddate_unix*1 + 86400);
					  }
				  }
				  if($all_day==1){$start_hourtime = $end_hourtime = '';}
				  if($we_startdate_unix!=''){
					  $alltrsl = get_option('we_text_allday')!='' ? get_option('we_text_allday') : esc_html__('(All day)','exthemes');
					  if($all_day=='1'){ 
					  	$h_st = '';
						$h_e = $alltrsl;
					  }else{ 
						  $h_st = date_i18n( $hour_format, $we_startdate_unix);  
						  $h_e = date_i18n( $hour_format, $we_enddate_unix);
					  }
					  if(date_i18n( $date_format, $we_startdate_unix) == date_i18n( $date_format, $we_enddate_unix)){
						  if($all_day!='1'){ $h_e = ' - '.$h_e;}
						  $dt_fm = date_i18n( $date_format, $we_startdate_unix).' '.$h_st.$h_e;
						  $edt_fm ='';
					  }else{
						  $dt_fm = date_i18n( $date_format, $we_startdate_unix).' '.$h_st;
						  if($we_enddate_unix!=''){
							  $edt_fm = date_i18n( $date_format, $we_enddate_unix).' '.$h_e;
						  }
					  }
					  global $product;	
					  $type = $product->get_type();
					  $price ='';
					  if($type=='variable'){
						  $price = we_variable_price_html();
					  }else{
						  	if ( $price_html = $product->get_price_html() ) :
						  		$price = $price_html; 
							endif; 	
					  }
					  $we_eventcolor = we_event_custom_color(get_the_ID());
					  if($we_eventcolor==''){$we_eventcolor = we_autochange_color();}
					  $url_tt = $tbt = '';
					  if($show_bt == 'addtocart'){
						  $variations = '';
						  $product = wc_get_product(get_the_ID());
						  if($product!==false) { $variations = $product->get_type();}
						  if($variations == 'variable' || $variations=='variation'){
							  $url_tt = get_permalink();
							  $tbt = get_option('we_text_sl_op')!='' ? get_option('we_text_sl_op') : esc_html__('Select options','exthemes');
						  }else{
							  $url_tt = add_query_arg( array('add-to-cart' => get_the_ID()), get_permalink());
							  $tbt = get_option('we_text_add_to_cart')!='' ? get_option('we_text_add_to_cart') : esc_html__('Add to cart','exthemes');
						  }
					  }elseif($show_bt == 'details'){
						  $url_tt = get_permalink();
						  $tbt = get_option('we_text_viewdetails')!='' ? get_option('we_text_viewdetails') : esc_html__('View Details','exthemes');
					  }
					  $ar_rs= array(
						  'id'=> get_the_ID(),
						  'number'=> $it,
						  'title'=> esc_attr(get_the_title()),
						  'url'=> get_permalink(),
						  'start'=>$we_startdate,
						  'end'=>$we_enddate,
						  'startdate'=> $dt_fm,
						  'enddate'=> $edt_fm,
						  'thumbnail' => $image_src[0],
						  'price'=> $price,
						  'color'=> $we_eventcolor,
						  'status'=> woo_event_status( get_the_ID(), $we_enddate_unix),
						  'description'=> get_the_excerpt(),
						  'location' => get_post_meta(get_the_ID(),'we_adress', true ),
						  'allDay' => $all_day,
						  'url_ontt'=> $url_tt,
						  'text_onbt'=> $tbt,
					  );
				  }
				  $result[]=$ar_rs;
			  }
		  }
		  //print_r($rs);
		  echo str_replace('\/', '/', json_encode($result));
		  exit;
	  }
}
//
if(!function_exists('we_social_share')){
	function we_social_share( $id = false){
		$id = get_the_ID();
		$tl_share_button = array('fb','tw','li','tb','gg','pin','vk','em',);
		ob_start();
		if(is_array($tl_share_button) && !empty($tl_share_button)){
			?>
			<ul class="wooevent-social-share">
				<?php if(in_array('fb', $tl_share_button)){ ?>
					<li class="facebook">
						<a class="trasition-all" title="<?php esc_html_e('Share on Facebook','exthemes');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i>
						</a>
					</li>
				<?php }
	
				if(in_array('tw', $tl_share_button)){ ?>
					<li class="twitter">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Twitter','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i>
						</a>
					</li>
				<?php }
	
				if(in_array('li', $tl_share_button)){ ?>
						<li class="linkedin">
							<a class="trasition-all" href="#" title="<?php esc_html_e('Share on LinkedIn','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($id)); ?>&amp;title=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i>
							</a>
						</li>
				<?php }
	
				if(in_array('tb', $tl_share_button)){ ?>
					<li class="tumblr">
					   <a class="trasition-all" href="#" title="<?php esc_html_e('Share on Tumblr','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&amp;name=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i>
					   </a>
					</li>
				<?php }
	
				if(in_array('gg', $tl_share_button)){ ?>
					 <li class="google-plus">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Google Plus','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i>
						</a>
					 </li>
				 <?php }
	
				 if(in_array('pin', $tl_share_button)){ ?>
					 <li class="pinterest">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Pin this','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&amp;media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&amp;description=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i>
						</a>
					 </li>
				 <?php }
				 
				 if(in_array('vk', $tl_share_button)){ ?>
					 <li class="vk">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on VK','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//vkontakte.ru/share.php?url=<?php echo urlencode(get_permalink(get_the_ID())); ?>','vk-share-dialog','width=626,height=436');return false;"><i class="fa fa-vk"></i>
						</a>
					 </li>
				 <?php }
	
				 if(in_array('em', $tl_share_button)){ ?>
					<li class="email">
						<a class="trasition-all" href="mailto:?subject=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php esc_html_e('Email this','exthemes');?>"><i class="fa fa-envelope"></i>
						</a>
					</li>
				<?php }?>
			</ul>
			<?php
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
// member social
if(!function_exists('speaker_print_social_accounts')){
	function speaker_print_social_accounts(){
		$accounts = array('facebook','instagram','envelope','twitter','linkedin','tumblr','google-plus','pinterest','youtube','flickr','github','dribbble');
		
		$html ='';
		foreach($accounts as $account){
			$url = get_post_meta( get_the_ID(), $account, true );
			if($url){
				if($account == 'envelope'){
					$url = 'mailto:' . $url;
				}
				$html .= '<li class="'.$account.'"><a href="'.$url.'" title="'.$account.'"><i class="fa fa-'.$account.'"></i></a></li>';
			}
		}
		if($html !=''){
			$html ='<ul class="wooevent-social-share speaker-social">'.$html.'</ul>';
		}
		return $html;
	}
}

//User Submit Event
function we_usersubmit_hook_cf7($cf) {
	if(!class_exists('WPCF7_Submission')){
		return false;
	}
	$submission = WPCF7_Submission::get_instance();
	if($submission) {
		$cf_data = $submission->get_posted_data();
		if(isset($cf_data['we-startdate']) && isset($cf_data['we-enddate'])){
			$title = isset($cf_data['we-event-title'])?$cf_data['we-event-title']:'';
			$email = isset($cf_data['your-email'])?$cf_data['your-email']:'';
			$name = isset($cf_data['your-name'])?$cf_data['your-name']:'';
			$email_event = isset($cf_data['we-event-mail'])?$cf_data['we-event-mail']:'';
			$phone_event = isset($cf_data['we-event-phone'])?$cf_data['we-event-phone']:'';
			$url_event = isset($cf_data['we-event-url'])?$cf_data['we-event-url']:'';
			$location_event = isset($cf_data['we-event-location'])?$cf_data['we-event-location']:'';
			$content = isset($cf_data['we-event-details'])?$cf_data['we-event-details']:'';
			
			$event_recurrence = isset($cf_data['we-recurrence'])?$cf_data['we-recurrence']:'';
			$event_recurrence_end = isset($cf_data['we-recurr-enddate'])?$cf_data['we-recurr-enddate']:'';
			$event_color = isset($cf_data['we-event-color'])?$cf_data['we-event-color']:'';
			if($event_color!=''){ $event_color = '#'.$event_color;}
			$event_price = isset($cf_data['we-event-price'])?$cf_data['we-event-price']:'0';
			$event_stock = isset($cf_data['we-event-stock'])?$cf_data['we-event-stock']:'';
			$event_tag = isset($cf_data['we-event-tag'])?$cf_data['we-event-tag']:'';
			$event_tag = explode(",",$event_tag);
			$event_cat = isset($cf_data['we-event-cat'])?$cf_data['we-event-cat']:'';
			if($name==''){ $name = $email;}
			$title = sprintf(__("%s Submit event: %s",'exthemes'), $name,$title);
			$event = array(
				'post_content'   => $content,
				'post_name' 	   => sanitize_title($title),
				'post_title'     => $title,
				'post_status'    => 'pending',
				'post_type'      => 'product'
			);
			if($new_event = wp_insert_post( $event, false )){
				
				$list_ids 			= get_user_meta(get_current_user_id(), '_my_submit', true);
				if(!$list_ids || !is_array($list_ids)) $list_ids = array();
				$list_ids = array_merge($list_ids, array($new_event));
				update_user_meta(get_current_user_id(), '_my_submit', $list_ids);
				
				add_post_meta( $new_event, 'we_startdate', strtotime($cf_data['we-startdate'].' '.$cf_data['we-starttime']) );
				add_post_meta( $new_event, 'we_enddate', strtotime($cf_data['we-enddate'].' '.$cf_data['we-endtime']));
				add_post_meta( $new_event, '_visibility', 'visible' );
				if(is_numeric($event_price)){
					add_post_meta( $new_event, '_regular_price', $event_price);
					add_post_meta( $new_event, '_price', $event_price);
				}
				add_post_meta( $new_event, '_stock_status', 'instock');
				if(is_numeric($event_stock)){
					add_post_meta($new_event, '_stock', $event_stock);
					add_post_meta($new_event, '_manage_stock', 'yes');
				}
				if($event_recurrence_end!='' && $event_recurrence!=''){
					add_post_meta( $new_event, 'we_recurrence_end', strtotime($event_recurrence_end) );
					add_post_meta( $new_event, 'we_recurrence', $event_recurrence );
				}
				add_post_meta( $new_event, 'we_eventcolor', $event_color);
				add_post_meta( $new_event, 'we_email_submit', $email);
				add_post_meta( $new_event, 'we_adress', $location_event);
				add_post_meta( $new_event, 'we_phone', $phone_event);
				add_post_meta( $new_event, 'we_email', $email_event);
				add_post_meta( $new_event, 'we_website', $url_event);
				wp_set_object_terms( $new_event, $event_cat, 'product_cat' );
				wp_set_object_terms( $new_event, $event_tag, 'product_tag' );
				if(isset($cf_data["we-event-image"]) && $cf_data["we-event-image"]!=''){
					$title_img = $cf_data["we-event-image"];
					$loc_img = $submission->uploaded_files();
					$loc_img = $loc_img["we-event-image"];
					$img = file_get_contents($loc_img);
					$upload_dir = wp_upload_dir(); 
					$upload = wp_upload_bits( $title_img, '', $img);
					$filename= $upload['file'];
					require_once(ABSPATH . 'wp-admin/includes/admin.php');
					$file_type = wp_check_filetype(basename($filename), null );
					  $attachment = array(
					   'post_mime_type' => $file_type['type'],
					   'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					   'post_content' => '',
					   'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename, $new_event);
					//$attach_url = wp_get_attachment_url( $attach_id );
					$attach_url = get_attached_file( $attach_id );
					set_post_thumbnail( $new_event, $attach_id );
					$attach_data =  wp_generate_attachment_metadata( $attach_id, $attach_url );
					wp_update_attachment_metadata( $attach_id,  $attach_data );
				}
				//wp_update_post( $new_event );
			}
		}
	}
}
// email notification
add_action( 'save_post', 'we_notify_submit');
function we_notify_submit( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || get_option('we_sm_notify')!='1' ){
		return;
	}
	$email = get_post_meta($post_id,'we_email_submit',true);
	if($email!='' && get_post_status($post_id)=='publish'){
		$subject = esc_html__('Your event submission has been approved','exthemes');
		$message = esc_html__('Your event has been approved. You can see it here','exthemes').' '.get_permalink($post_id);
		wp_mail( $email, $subject, $message );
		update_post_meta( $post_id, 'we_email_submit', '');
	}
}
add_action("wpcf7_before_send_mail", "we_usersubmit_hook_cf7");
function we_time_cf7_field($tag){
	/*$output = '
	<input type="text"  name="'.$tag['name'].'" id="'.$tag['name'].'" class="time submit-time" placeholder="'.esc_html__('H:i','exthemes').'">';
	return $output;*/
	
	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) { return ''; }

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}
	$class .= ' time submit-time ';

	$atts = array();
	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();
	$atts['placeholder'] = esc_html__('H:i','exthemes');
	if ( $tag->is_required() ) { $atts['aria-required'] = 'true'; }

	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

	$atts['type'] = 'text';

	$atts['name'] = $tag->name;

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><input %2$s />%3$s</span>',
		sanitize_html_class( $tag->name ), $atts, $validation_error );

	ob_start();
	wp_enqueue_style('we-jquery.timepicker', WOO_EVENT_PATH.'js/jquery-timepicker/jquery.timepicker.css');
	wp_enqueue_script( 'we-jquery.timepicker', WOO_EVENT_PATH.'/js/jquery-timepicker/jquery.timepicker.min.js', array( 'jquery' ) );
	$js_string = ob_get_contents();
	ob_end_clean();
	return $html.$js_string;
}
function we_time_cf7_shortcode(){
	if(function_exists('wpcf7_add_form_tag')){
		wpcf7_add_form_tag(array('we_time','we_time*'), 'we_time_cf7_field', true);
	}
}
add_action( 'init', 'we_time_cf7_shortcode' );
// submit date
function we_date_cf7_field($tag){
	/*$output = '
	<input type="text"  name="'.$tag['name'].'" id="'.$tag['name'].'" class="date submit-date wpcf7-validates-as-required" aria-required="true" placeholder="">';
	return $output;
	*/
	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) { return ''; }

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}
	$class .= ' date submit-date ';

	$atts = array();
	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();

	if ( $tag->is_required() ) { $atts['aria-required'] = 'true'; }

	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

	$atts['type'] = 'text';

	$atts['name'] = $tag->name;

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><input %2$s />%3$s</span>',
		sanitize_html_class( $tag->name ), $atts, $validation_error );
	ob_start();
	wp_enqueue_style('we-bootstrap-datepicker', WOO_EVENT_PATH.'js/jquery-timepicker/lib/bootstrap-datepicker.css');
	wp_enqueue_script( 'we-bootstrap-datepicker', WOO_EVENT_PATH.'/js/jquery-timepicker/lib/bootstrap-datepicker.js', array( 'jquery' ) );
	if(get_option('we_jscolor_js')!='on'){
		wp_enqueue_script( 'we-color-picker', WOO_EVENT_PATH. 'js/jscolor.min.js', array('jquery'), '2.0', true );
	}
	$js_string = ob_get_contents();
	ob_end_clean();
	return $html.$js_string;
		
}
add_filter( 'wpcf7_validate_we_date', 'wpcf7_we_date_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_we_date*', 'wpcf7_we_date_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_we_time', 'wpcf7_we_date_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_we_time*', 'wpcf7_we_date_validation_filter', 10, 2 );

function wpcf7_we_date_validation_filter( $result, $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	$name = $tag->name;
	$value = isset( $_POST[$name] )
		? trim( strtr( (string) $_POST[$name], "\n", " " ) )
		: '';

	if ( $tag->is_required() && '' == $value ) {
		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
	}
	return $result;
}




function we_date_cf7_shortcode(){
	if(function_exists('wpcf7_add_form_tag')){
		wpcf7_add_form_tag(array('we_date','we_date*'), 'we_date_cf7_field', true);
	}
}
add_action( 'init', 'we_date_cf7_shortcode' );
// submit recurrence
function we_recurr_cf7_field($tag){
	$output = '
	<select name="'.$tag['name'].'" id="'.$tag['name'].'" class="recurrence submit-recurrence">
		<option value="">'.esc_html__('None','exthemes').'</option>
		<option value="day">'.esc_html__('Every Day','exthemes').'</option>
		<option value="week">'.esc_html__('Every Week','exthemes').'</option>
		<option value="month">'.esc_html__('Every Month','exthemes').'</option>
	</select>';
	return $output;
}
function we_recurr_cf7_shortcode(){
	if(function_exists('wpcf7_add_form_tag')){
		wpcf7_add_form_tag(array('we_recurrence','we_recurrence*'), 'we_recurr_cf7_field', true);
	}
}
add_action( 'init', 'we_recurr_cf7_shortcode' );
// submit category
function we_cat_shortcode(){
	if(function_exists('wpcf7_add_form_tag')){
		wpcf7_add_form_tag(array('we_category','we_category*'), 'we_cathtml', true);
	}
}
function we_cathtml($tag){
	$class = '';
	$is_required = 0;
	if(class_exists('WPCF7_FormTag')){
		$tag = new WPCF7_FormTag( $tag );
		if ( $tag->is_required() ){
			$is_required = 1;
			$class .= ' required-cat';
		}
	}
	$cat_exclude = get_option('we_sm_cat');
	$cargs = array(
		'hide_empty'    => false, 
		'exclude'       => explode(",",$cat_exclude)
	); 
	$cats = get_terms( 'product_cat', $cargs );
	if($cats){
		$output = '<div class="wpcf7-form-control-wrap event-cat"><div class="row wpcf7-form-control wpcf7-checkbox wpcf7-validates-as-required'.$class.'">';
		foreach ($cats as $acat){
			$output .= '
			<label class="col-md-4 wpcf7-list-item">
				<input type="checkbox" name="we-event-cat[]" value="'.$acat->slug.'" /> '.$acat->name.'
			</label>';
		}
		$output .= '</div>';
	}
	ob_start();
	if($is_required){
	?>
    <script>
	jQuery(document).ready(function(e) {
		jQuery("form.wpcf7-form").submit(function (e) {
			var checked = 0;
			jQuery.each(jQuery("input[name='we-event-cat[]']:checked"), function() {
				checked = jQuery(this).val();
			});
			if(checked == 0){
				if(jQuery('.cat-alert').length==0){
					jQuery('.wpcf7-form-control-wrap.event-cat').append('<span role="alert" class="wpcf7-not-valid-tip cat-alert"><?php echo wpcf7_get_message( 'invalid_required' ); ?></span>');
				}
				return false;
			}else{
				return true;
			}
		});
	});
	</script>
	<?php
	}
	$js_string = ob_get_contents();
	ob_end_clean();
	return $output.$js_string;
}
add_action( 'init', 'we_cat_shortcode' );
//Global function
function wooevent_global_layout(){
	if(is_singular('product')){
		global $layout,$post;
		if(isset($layout) && $layout!=''){
			return $layout;
		}
		$layout = get_post_meta( $post->ID, 'we_layout', true );
		if($layout ==''){
			$layout = get_option('we_slayout');
		}
		return $layout;
		}
}
function we_global_startdate(){
	global $we_startdate, $post;
	if(isset($we_startdate) && $we_startdate!='' && is_main_query() && is_singular('product')){
		return $we_startdate;
	}
	$we_startdate = get_post_meta( $post->ID, 'we_startdate', true ) ;
	return $we_startdate;
}
function we_global_enddate(){
	global $we_enddate, $post;
	if(isset($we_enddate) && $we_enddate!='' && is_main_query() && is_singular('product')){
		return $we_enddate;
	}
	$we_enddate = get_post_meta( $post->ID, 'we_enddate', true ) ;
	return $we_enddate;
}
function we_global_search_result_page(){
	global $we_search_result;
	if(isset($we_search_result)){
		return $we_search_result;
	}
	$we_search_result = get_option('we_search_result') ;
	return $we_search_result;
}
function we_global_main_purpose(){
	global $we_main_purpose;
	if(isset($we_main_purpose) && $we_main_purpose!=''){
		return $we_main_purpose;
	}
	$we_main_purpose = get_option('we_main_purpose');
	return $we_main_purpose;
}
function we_global_default_spurpose(){
	global $we_layout_purpose,$post;
	if(isset($we_layout_purpose) && $we_layout_purpose!=''){
		return $we_layout_purpose;
	}
	$we_layout_purpose = get_post_meta($post->ID,'we_layout_purpose',true);
	if($we_layout_purpose=='' || $we_layout_purpose=='def'){
		if(we_global_main_purpose() =='meta'){
			if(function_exists('we_event_cat_custom_layout')){
				$we_layout_purpose = we_event_cat_custom_layout($post->ID);
				if($we_layout_purpose!=''){
					return $we_layout_purpose;
				}
			}
		}
		$we_layout_purpose = get_option('we_slayout_purpose','woo');
	}
	return $we_layout_purpose;
}

//edit link recurrence
add_action( 'admin_bar_menu', 'toolbar_link_recurren_edit', 999 );

function toolbar_link_recurren_edit( $wp_admin_bar ) {
	if(is_singular('product')){
		global $post;
		$ex_recurr = get_post_meta($post->ID,'recurren_ext', true );
		$ex_recurr  = explode("_",$ex_recurr);
		if(isset($ex_recurr[1]) && $ex_recurr[1]!=''){
			$wp_admin_bar->remove_node( 'edit' );
			$args_e = array(
				'id'    => 'edit-single',
				'title' => 'Edit Single',
				'href'  => get_edit_post_link( $post->ID, true ),
				'meta'  => array( 'class' => 'single-edit' )
			);
			$wp_admin_bar->add_node( $args_e );
			$args = array(
				'id'    => 'recurren_edit',
				'title' => 'Edit All Recurrence',
				'href'  => get_edit_post_link( $ex_recurr[1], true ),
				'meta'  => array( 'class' => 'recurren-page' )
			);
			$wp_admin_bar->add_node( $args );
		}
	}
}
//barcode
add_action( 'wpo_wcpdf_after_order_details', 'wooevents_add_barcode', 10, 2 );
function wooevents_add_barcode ($template_type, $order) {
	?>
        <div class="we-barcode">
        <h3><?php esc_html_e('Your order Barcode:','exthemes');?></h3>
        <p><img src="http://www.barcode-generator.org/zint/api.php?bc_number=20&bc_data=<?php echo $order->get_order_number(); ?>"/></p>
        </div>
        <?php
}
//Add info to pdf invoice
add_action( 'wpo_wcpdf_after_item_meta', 'wooevents_add_event_meta', 10, 3 );
function wooevents_add_event_meta ($template_type, $item, $order) {
	$we_startdate = get_post_meta( $item['product_id'], 'we_startdate', true ) ;
	$we_enddate = get_post_meta( $item['product_id'], 'we_enddate', true ) ;
	$we_adress = get_post_meta( $item['product_id'], 'we_adress', true ) ;
	$all_day = get_post_meta($item['product_id'],'we_allday', true );
	$html ='';
	if($all_day!='1' && $we_startdate!=''){
		  $stdatetrsl = get_option('we_text_stdate')!='' ? get_option('we_text_stdate') :  esc_html__('Start Date','exthemes');
		  $edatetrsl = get_option('we_text_edate')!='' ? get_option('we_text_edate') : esc_html__('End Date','exthemes');
		  $alltrsl = get_option('we_text_allday')!='' ? get_option('we_text_allday') : esc_html__('(All day)','exthemes');
		  $html .='<dl class="meta">'.$stdatetrsl.': '.date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate).'</dl>';
		  $html .='<dl class="meta">'.$edatetrsl.': '.date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate).'</dl>';
	  }elseif($we_startdate!=''){
		  $html .='<dl class="meta">'.$stdatetrsl.': '.date_i18n( get_option('date_format'), $we_startdate).'</dl>';
		  $html .='<dl class="meta">'.$edatetrsl.': '.date_i18n( get_option('date_format'), $we_enddate).' '.$alltrsl.'</dl>';
	  }
	  $eaddtrsl = get_option('we_text_addres')!='' ? get_option('we_text_addres') : esc_html__('Address','exthemes');
	  $html .='<dl class="meta">'.$eaddtrsl.': '.$we_adress.'</dl>';
	  // user info
	  
	  $metadata = get_post_meta($order-> id,'att_info-'.$item['product_id'], true);
	  if($metadata !=''){
		  
		  $t_atten = get_option('we_text_attende_')!='' ? get_option('we_text_attende_') : esc_html__('Attendees info','exthemes');
		  $t_name = get_option('we_text_name_')!='' ? get_option('we_text_name_') : esc_html__('Name: ','exthemes');
		  $t_email = get_option('we_text_email_')!='' ? get_option('we_text_email_') : esc_html__('Email: ','exthemes');
		  
		  $metadata = explode("][",$metadata);
		  if(!empty($metadata)){
			  $i=0;
			  foreach($metadata as $item){
				  $i++;
				  $item = explode("||",$item);
				  $f_name = isset($item[1]) && $item[1]!='' ? $item[1] : '';
				  $l_name = isset($item[2]) && $item[2]!='' ? $item[2] : '';
				  $html .= '<div class="we-user-info">'.$t_atten.' ('.$i.') ';
				  $html .=  $f_name!='' && $l_name!='' ? '<span style="margin-right:15px;"><b>'.$t_name.'</b>'.$f_name.' '.$l_name.'</span>' : '';
				  $html .=  isset($item[0]) && $item[0]!='' ? '<span><b>'.$t_email.' </b>'.$item[0].'</span>' : '';
				  $html .= '</div>';
			  }
		  }
	  }
	  
	  
	  echo $html;
}
//ver 1.1
add_action( 'wp_ajax_ex_loadmore_grid', 'ajax_ex_loadmore_grid' );
add_action( 'wp_ajax_nopriv_ex_loadmore_grid', 'ajax_ex_loadmore_grid' );

function ajax_ex_loadmore_grid(){
	global $columns,$number_excerpt,$show_time,$orderby,$img_size;
	$atts = json_decode( stripslashes( $_POST['param_shortcode'] ), true );
	$columns = $atts['columns']	=  isset($atts['columns']) ? $atts['columns'] : 1;
	$img_size =  isset($atts['img_size']) ? $atts['img_size'] :'wethumb_460x307';
	$show_time =  isset($atts['show_time']) ? $atts['show_time'] :'';
	$orderby =  isset($atts['orderby']) ? $atts['orderby'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'';
	$number_excerpt =  isset($atts['number_excerpt'])&& $atts['number_excerpt']!='' ? $atts['number_excerpt'] : '10';
	$style =  isset($atts['style']) ? $atts['style'] :'';
	$page = $_POST['page'];
	$param_query = json_decode( stripslashes( $_POST['param_query'] ), true );
	$end_it_nb ='';
	if($page!=''){ 
		$param_query['paged'] = $page;
		$count_check = $page*$posts_per_page;
		if(($count_check > $count) && (($count_check - $count)< $posts_per_page)){$end_it_nb = $count - (($page - 1)*$posts_per_page);}
		else if(($count_check > $count)) {die;}
	}
	//echo '<pre>';
	//print_r($param_query);//exit;
	$the_query = new WP_Query( $param_query );
	$it = $the_query->post_count;
	ob_start();
	if($the_query->have_posts()){
		?>
        <div class="grid-row de-active">
        <?php
		$i =0;
		while($the_query->have_posts()){ $the_query->the_post();
			$i++;
			if($style=='classic'){
				wooevent_template_plugin('grid-classic', true);
			}else{
				wooevent_template_plugin('grid', true);
			}
			if($i%$columns==0){?>
				</div>
				<div class="grid-row de-active">
				<?php
			}
			if($end_it_nb!='' && $end_it_nb == $i){break;}
		}
		?>
        </div>
        <?php
	}
	$html = ob_get_clean();
	echo  $html;
	die;
}
//table load
add_action( 'wp_ajax_ex_loadmore_table', 'ajax_ex_loadmore_table' );
add_action( 'wp_ajax_nopriv_ex_loadmore_table', 'ajax_ex_loadmore_table' );

function ajax_ex_loadmore_table(){
	global $style;
	$atts = json_decode( stripslashes( $_POST['param_shortcode'] ), true );
	$style =  isset($atts['style']) ? $atts['style'] :'';
	$count =  isset($atts['count']) ? $atts['count'] :'6';
	$posts_per_page =  isset($atts['posts_per_page']) ? $atts['posts_per_page'] :'';
	$page = $_POST['page'];
	$style =  isset($atts['style']) ? $atts['style'] :'';
	$param_query = json_decode( stripslashes( $_POST['param_query'] ), true );
	$end_it_nb ='';
	if($page!=''){ 
		$param_query['paged'] = $page;
		$count_check = $page*$posts_per_page;
		if(($count_check > $count) && (($count_check - $count)< $posts_per_page)){$end_it_nb = $count - (($page - 1)*$posts_per_page);}
		else if(($count_check > $count)) {die;}
	}
	$the_query = new WP_Query( $param_query );
	$it = $the_query->post_count;
	ob_start();
	global $ajax_load;
	if($the_query->have_posts()){
		while($the_query->have_posts()){ $the_query->the_post();
			$ajax_load =1;
			include we_get_plugin_url().'shortcode/content/content-table.php';
			if($end_it_nb!='' && $end_it_nb == $i){break;}
		}
	}
	$html = ob_get_clean();
	echo  $html;
	die;
}
// auto change color when low stock
if(!function_exists('we_autochange_color')){
	function we_autochange_color(){
		$color = '';
		$we_auto_color = get_option('we_auto_color');
		if($we_auto_color=='on'){
			global $product,$post;
			$stock_status = get_post_meta($post->ID, '_stock_status',true);
			$numleft  = $product->get_stock_quantity();
			if($stock_status !='outofstock') { 
				$total = get_post_meta($post->ID, 'total_sales', true);
				if($total >= $numleft && $numleft!=0){
					$color = '#FFEB3B';
				}elseif($numleft=='0'){
					$color = '#cc0000';
				}
			}else{
				$color = '#cc0000';
			}
		}
		return $color;
	}
}
//ajax search
add_action( 'wp_ajax_we_search_ajax', 'ajax_ex_search_ajax' );
add_action( 'wp_ajax_nopriv_we_search_ajax', 'ajax_ex_search_ajax' );

function ajax_ex_search_ajax(){
	$page = isset($_POST['page']) ? $_POST['page'] : '';
	$args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		's' => $_POST['key_word'],
		'ignore_sticky_posts' => 1,
	);
	//cats
	$cat = $tag = $year = '';
	if(isset($_POST['cat_search']) && $_POST['cat_search']!=''){
		$cat = $_POST['cat_search'];
	}
	if(isset($_POST['tag']) && $_POST['tag']!=''){
		$tag = $_POST['tag'];
	}
	if(isset($_POST['year']) && $_POST['year']!=''){
		$year = $_POST['year'];
		$year = explode(",",$year);
		$year = array_filter($year);
		sort($year);
		if(count($year)>1){
			$start = mktime(0, 0, 0, 1, 1, $year[0]);
			$end = mktime(0, 0, 0, 12, 31, end($year));
			$args += array(
					 'meta_query' => array( 
					 'relation' => 'AND',
					  array('key'  => 'we_startdate',
						   'value' => $start,
						   'compare' => '>'),
					  array('key'  => 'we_startdate',
						   'value' => $end,
						   'compare' => '<=')
					 )
			);
		}else if(!empty($year)){
			$year = date($year[0]);
			$start = mktime(0, 0, 0, 1, 1, $year);
			$end = mktime(0, 0, 0, 12, 31, $year);
			$args += array(
					 'meta_query' => array( 
					 'relation' => 'AND',
					  array('key'  => 'we_startdate',
						   'value' => $start,
						   'compare' => '>'),
					  array('key'  => 'we_startdate',
						   'value' => $end,
						   'compare' => '<=')
					 )
			);
		}
	}
	if($tag!=''){
		$texo['relation'] = 'AND';
		$tags = explode(",",$tag);
		if(is_numeric($tags[0])){$field_tag = 'term_id'; }
		else{ $field_tag = 'slug'; }
		if(count($tags)>1){
			  foreach($tags as $iterm) {
				  if($iterm!=''){
				  $texo[] = array(
						  'taxonomy' => 'product_tag',
						  'field' => $field_tag,
						  'terms' => $iterm,
					  );
				  }
			  }
		  }else{
			  if(!empty($tags)){
			  $texo[] = array(
					  'taxonomy' => 'product_tag',
					  'field' => $field_tag,
					  'terms' => $tags,
			  );
			  }
		}
	}
	if($cat!=''){
		$texo['relation'] = 'AND';
		$cats = explode(",",$cat);
		if(is_numeric($cats[0])){$field = 'term_id'; }
		else{ $field = 'slug'; }
		if(count($cats)>1){
			  foreach($cats as $iterm) {
				  if($iterm!=''){
				  $texo[] = array(
						  'taxonomy' => 'product_cat',
						  'field' => $field,
						  'terms' => $iterm,
					  );
				  }
			  }
		  }else{
			  if(!empty($cats)){
				  $texo[] = array(
							  'taxonomy' => 'product_cat',
							  'field' => $field,
							  'terms' => $cats,
				  );
			  }
		}
	}
	if(isset($texo)){
		$args += array('tax_query' => $texo);
	}
	$args = apply_filters( 'we_ajax_search_arg', $args );
	$the_query = new WP_Query( $args );
	$it = $the_query->post_count;
	ob_start();
	/*echo '<pre>';
	print_r($args);
	echo '<pre>';*/
	if($the_query->have_posts()){?>
        <ul class="products we-search-ajax">
        <?php
		while($the_query->have_posts()){ $the_query->the_post();
			wooevent_template_plugin('product');
		}?>
        </ul><?php
	}else{
		$textrsl = get_option('we_text_no_resu')!='' ? get_option('we_text_no_resu') : esc_html__('Nothing matched your search terms. Please try again with some different keywords.','exthemes');
		echo '<ul class="products we-search-ajax no-result-info"><p class="woocommerce-info calendar-info">'.$textrsl.'</p></ul>';
	}
	$html = ob_get_clean();
	ob_end_clean();
	echo  $html;
	die;
}
if(!function_exists('we_variable_price_html')){
	function we_variable_price_html(){
		$price_html = get_post_meta(get_the_ID(),'_min_variation_price', true );
		$fromtrsl = get_option('we_text_from')!='' ? get_option('we_text_from') : esc_html__('From  ','exthemes');
		$currency_pos = get_option( 'woocommerce_currency_pos' );
		if($currency_pos=='left' || $currency_pos==''){ $price = $fromtrsl.get_woocommerce_currency_symbol().$price_html; }
		else if($currency_pos=='left_space'){ $price = $fromtrsl.get_woocommerce_currency_symbol().' '.$price_html; }
		elseif($currency_pos=='right'){ $price = $fromtrsl.$price_html.get_woocommerce_currency_symbol(); }
		else if($currency_pos=='right_space'){ $price = $fromtrsl.$price_html.' '.get_woocommerce_currency_symbol(); }
		
		return $price;
	}
}

if(!function_exists('we_hide_booking_form')){
	function we_hide_booking_form(){
		$time_stops = get_post_meta(get_the_ID(),'we_stop_booking', true );
		if($time_stops =='' || $time_stops < 0 ){
			$time_stops = get_option('we_stop_booking');
		}
		$we_startdate =get_post_meta( get_the_ID(), 'we_startdate', true );
		if(is_numeric($time_stops)  && $we_startdate !='' && $we_startdate > 0){
			$time_now =  strtotime("now");
			$we_time_zone = get_post_meta(get_the_ID(),'we_time_zone',true);
			if($we_time_zone!='' && $we_time_zone!='def'){
				$we_time_zone = $we_time_zone * 60 * 60;
				$time_now = $we_time_zone + $time_now;
			}
			$we_main_purpose = we_global_main_purpose();
			$we_layout_purpose = we_global_default_spurpose();
			$time_stops = $we_startdate - $time_stops*86400;
			if(($time_now > $time_stops  && $we_main_purpose=='event') || ($time_now > $time_stops  && $we_layout_purpose=='event') || ($time_now > $time_stops  && $we_layout_purpose=='custom')){
				return '
				<style type="text/css">.woocommerce div.product form.cart, .woocommerce div.product p.cart{ display:none !important}</style>';
			}
		}
		return;
	}
}
if(!function_exists('we_update_total_sales')){
	add_action( 'woocommerce_order_status_cancelled', 'we_update_total_sales' );
	function we_update_total_sales($order_id) {
		$order = new WC_Order( $order_id );
		$items = $order->get_items();
		foreach ( $items as $item ) {
			$product_id = $item['product_id'];
			$total = get_post_meta( $product_id, 'total_sales', true );
			if($total !='' && $total > 0){
				$total = $total -1;
				update_post_meta( $product_id, 'total_sales', $total);
			}
		}
	}
}
add_action( 'wp_ajax_ex_loadevent_ofday', 'ajax_ex_loadevent_ofday' );
add_action( 'wp_ajax_nopriv_ex_loadevent_ofday', 'ajax_ex_loadevent_ofday' );
if(!function_exists('ajax_ex_loadevent_ofday')){
	function ajax_ex_loadevent_ofday(){
		$spe_day = $_POST['param_day'];
		$ids = $_POST['ids'];
		if($ids==''){ exit;}
		if(!is_array($ids)){
			$ids = explode(",", $ids);
		}
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'post__in' =>  $ids,
			'order' => 'ASC',
			'orderby' => 'meta_value_num',
			'meta_key' => 'we_startdate',
			'ignore_sticky_posts' => 1,
		);
		echo we_calendar_modern_data($args);
		exit;
	}
}
if(!function_exists('we_calendar_modern_data')){
	function we_calendar_modern_data($args) {
		ob_start();
		$the_query = new WP_Query( $args );
		$day_event = '';
		if($the_query->have_posts()){
			while($the_query->have_posts()){ $the_query->the_post();
				$we_startdate = get_post_meta( get_the_ID(), 'we_startdate', true );
				$we_enddate = get_post_meta( get_the_ID(), 'we_enddate', true )  ;
				global $product;	
				$type = $product->get_type();
				$price ='';
				if($type=='variable'){
					$price = we_variable_price_html();
				}else{
					if ( $price_html = $product->get_price_html() ) :
						$price = $price_html; 
					endif; 	
				}
				$we_adress = get_post_meta( get_the_ID(), 'we_adress', true );
				$we_status = woo_event_status( get_the_ID(), $we_enddate);
				$we_eventcolor = we_event_custom_color(get_the_ID());;
				if($we_eventcolor==''){$we_eventcolor = we_autochange_color();}
				$bgev_color = '';
				if($we_eventcolor!=""){
					$bgev_color = 'style="background-color:'.$we_eventcolor.'"';
				}
				?>
                
                <div class="day-event-details">
                	<?php 
					if(has_post_thumbnail(get_the_ID())){?>
                    <div class="day-ev-image">
                    	<a href="<?php the_permalink(); ?>" class="link-more">
							<?php the_post_thumbnail('wethumb_85x85');
							echo '<span class="bg-overlay"></span>';
							if($price!=''){
								echo '<span class="item-evprice" '.$bgev_color.'>'.$price.'</span>';
							}
							?>
                        </a>
                    </div>
                    <?php }?>
                    <div class="day-ev-des">
                        <h3><a href="<?php the_permalink(); ?>" class="link-more">
                            <?php  the_title();?>
                        </a></h3>
                        <div class="we-more-meta">
                        <?php
                            if($we_startdate!=''){
                                $sttime = '<span> - '.date_i18n(get_option('time_format'), $we_startdate).'</span>';
                                echo '<span class="st-date"><i class="fa fa-calendar"></i>'.date_i18n( get_option('date_format'), $we_startdate).$sttime.'</span>';
                            }
                            if($we_status!=''){
                                echo '
                                <span>
                                    <i class="fa fa-ticket"></i>
                                    '.$we_status.'
                                </span>';
                            }
                        ?>
                        </div>
                        <div class="ev-excerpt"><?php echo get_the_excerpt();?></div>
                    </div>
                </div>
                <?php
			}
		}else{
			$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
			echo '<span class="day-event-details">'.$noftrsl.'</span>';
		}
		wp_reset_postdata();
		$day_event = ob_get_contents();
		ob_end_clean();
		return $day_event;
	}
}
add_action('woocommerce_add_order_item_meta','we_add_info_to_order_item_meta',1,2);
if(!function_exists('we_add_info_to_order_item_meta')){
	function we_add_info_to_order_item_meta($item_id, $values)
	{
		$_ev_date = get_post_meta( $values['product_id'], 'we_startdate', true );
		if($_ev_date!='')
		{
			$_ev_date = date_i18n( get_option('date_format'), $_ev_date).' - '.date_i18n(get_option('time_format'), $_ev_date);
			wc_add_order_item_meta($item_id,'_startdate',$_ev_date);
		}
		$_ev_edate = get_post_meta( $values['product_id'], 'we_enddate', true );
		if($_ev_edate!='')
		{
			$_ev_edate = date_i18n( get_option('date_format'), $_ev_edate).' - '.date_i18n(get_option('time_format'), $_ev_edate);
			wc_add_order_item_meta($item_id,'_enddate',$_ev_edate);
		}
		
	}
}
if(!function_exists('we_event_custom_color')){
	function we_event_custom_color($id){
		if($id==''){
			return;	
		}
		$we_eventcolor = get_post_meta( $id, 'we_eventcolor', true );
		$we_cat_color = get_option('we_cat_ctcolor');
		if($we_eventcolor=='' && $we_cat_color=='on'){
			$args = array(
				'hide_empty'        => true, 
			);
			$terms = wp_get_post_terms($id, 'product_cat', $args);
			if(!empty($terms) && !is_wp_error( $terms )){
				foreach ( $terms as $term ) {
					$we_eventcolor = get_option('we_category_color_' . $term->term_id);
					$we_eventcolor = str_replace("#", "", $we_eventcolor);
					if($we_eventcolor!=''){
						$we_eventcolor = '#'.$we_eventcolor;
						break;
					}
				}
			}
		}
		$we_eventcolor = apply_filters( 'we_event_customcolor', $we_eventcolor,$id );
		return $we_eventcolor;
	}
}
if(!function_exists('we_taxonomy_info')){
	function we_taxonomy_info( $tax, $link=false, $id= false){
		if(isset($id) && $id!=''){
			$product_id = $id;
		}else{
			$product_id = get_the_ID();
		}
		$post_type = 'product';
		ob_start();
		if(isset($tax) && $tax!=''){
			$args = array(
				'hide_empty'        => false, 
			);
			$terms = wp_get_post_terms($product_id, $tax, $args);
			if(!empty($terms) && !is_wp_error( $terms )){
				$c_tax = count($terms);
				$i=0;
				foreach ( $terms as $term ) {
					$i++;
					if(isset($link) && $link=='off'){
						echo $term->name;
					}else{
						echo '<a href="'.get_term_link( $term ).'" title="' . $term->name . '">'. $term->name .'</a>';
					}
					if($i != $c_tax){ echo '<span>, </span>';}
				}
			}
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
if(!function_exists('we_ical_google_button')){
	function we_ical_google_button( $id ){
		if(isset($id) && $id!=''){
			$product_id = $id;
		}else{
			$product_id = get_the_ID();
		}
		$we_startdate = get_post_meta( $product_id, 'we_startdate', true ) ;
		$we_enddate = get_post_meta( $product_id, 'we_enddate', true ) ;
		$excerpt = get_post_field('post_excerpt', $product_id);
		if($excerpt !=''){
			$excerpt = apply_filters('the_excerpt', $excerpt);
		}
		$title = urlencode(html_entity_decode(get_the_title($product_id), ENT_COMPAT, 'UTF-8'));
		?>
        <div class="we-icl-import col-md-12">
            <div class="row">
                    <div class="btn btn-primary"><a href="<?php echo home_url().'?ical_product='.$product_id; ?>"><?php echo get_option('we_text_ical')!='' ? get_option('we_text_ical') : esc_html__('+ Ical Import','exthemes');?></a></div>
                    <div class="btn btn-primary"><a href="https://www.google.com/calendar/render?dates=<?php  echo gmdate("Ymd\THis", $we_startdate);?>/<?php echo gmdate("Ymd\THis", $we_enddate);?>&action=TEMPLATE&text=<?php echo $title;?>&location=<?php echo esc_attr(urlencode(get_post_meta($product_id,'we_adress', true )));?>&details=<?php echo esc_attr(urlencode( strip_tags($excerpt) ) );?>"><?php echo get_option('we_text_ggcal')!='' ? get_option('we_text_ggcal') : esc_html__('+ Google calendar','exthemes');?></a></div>
            </div>
        </div>
        <?php
	}
}
if(!function_exists('we_ical_google_button_inorder')){
	add_action( 'woocommerce_order_item_meta_end', 'we_ical_google_button_inorder', 10, 3 );
	function we_ical_google_button_inorder($item_id, $item, $order){
		$id = $item['product_id'];
		we_ical_google_button( $id );
	}
}
if(!function_exists('we_show_custom_meta_inorder')){
	add_action( 'woocommerce_order_item_meta_end', 'we_show_custom_meta_inorder', 9, 3 );
	function we_show_custom_meta_inorder($item_id, $item, $order){
		$id = $item['product_id'];
		$we_startdate = get_post_meta( $id, 'we_startdate', true ) ;
		$we_enddate = get_post_meta( $id, 'we_enddate', true ) ;
		$lbst = get_option('we_text_start')!='' ? get_option('we_text_start') : esc_html__('Start','exthemes');
		$lbe = get_option('we_text_end')!='' ? get_option('we_text_end') : esc_html__('End','exthemes');
		if($we_startdate!=''){
			echo '<span><strong>'.$lbst.':</strong> '
			.date_i18n( get_option('date_format'), $we_startdate).' - '.date_i18n(get_option('time_format'), $we_startdate).'
			</span>';
		}
		if($we_enddate!=''){
			echo '<span><strong>'.$lbe.':</strong> '
			.date_i18n( get_option('date_format'), $we_enddate).' - '.date_i18n(get_option('time_format'), $we_enddate).'
			</span>';
		}
	}
}
/* Search hook*/
add_action( 'pre_get_posts','we_event_search_hook_change',101 );
if (!function_exists('we_event_search_hook_change')) {
	function we_event_search_hook_change($query) {
		if( is_search() && $query->is_main_query() && is_shop() ){
			if( isset($_GET['orderby']) && $_GET['orderby']!='' ){
				$cure_time =  strtotime("now");
				$query->set('meta_key', 'we_startdate');
				$query->set('meta_value', $cure_time);
				if($_GET['orderby']=='upcoming'){
					$query->set('meta_compare', '>');
				}
				if($_GET['orderby']=='past'){
					$query->set('meta_compare', '<');
				}
			}
			if( isset($_GET['location']) && $_GET['location']!='' ){
				$meta_query_args['relation'] = 'AND';
				$meta_query_args = array(
					array(
					  'key' => 'we_default_venue',
					  'value' => $_GET['location'],
					  'compare' => 'LIKE',
					),
				);
			}
			if( isset($_GET['year']) && $_GET['year']!='' ){
				$start = mktime(0, 0, 0, 1, 1, $_GET['year']);
				$end = mktime(0, 0, 0, 12, 31, $_GET['year']);
				$meta_query_args [] =
					array('key'  => 'we_startdate',
						 'value' => $start,
						 'compare' => '>');
				$meta_query_args [] =		 
					array('key'  => 'we_startdate',
						 'value' => $end,
						 'compare' => '<='
				);
			}
			if(isset($meta_query_args)){
				$query->set('meta_query', $meta_query_args);
			}
		}
		return $query;
	}
}
