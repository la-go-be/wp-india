<?php
function parse_we_map_event_func($atts, $content){
		$we_zoom_map = get_option('we_zoom_map');
		$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
		$center_map  		=isset($atts['center_map']) ? $atts['center_map'] : '';
		$zoom  		=isset($atts['zoom']) ? $atts['zoom'] : $we_zoom_map?$we_zoom_map:'3';
		$height  		=isset($atts['height']) ? $atts['height'] : '400';
		$posttype 		= 'product';
		$type 		=isset($atts['type']) ? $atts['type'] : '';
		$count 		= isset($atts['count']) ? $atts['count'] : '10';
		$order 	= isset($atts['order']) ? $atts['order'] : 'DESC';
		$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
		$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
		$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
		$exclude 	= isset($atts['exclude']) ? $atts['exclude'] : '';
		
		ob_start();
		if($ids!=''){ //specify IDs
			$ids = explode(",", $ids);
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => array( 'publish','pending', 'draft'),
				'post__in' =>  $ids,
				'orderby' => 'post__in',
				'ignore_sticky_posts' => 1,
			);
		}elseif($ids==''){
			$args = array(
				'post_type' => $posttype,
				'posts_per_page' => $count,
				'post_status' => 'publish',
				'post__not_in' => $exclude,
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
						
			$time_now =  strtotime("now");
			if($type=='upcoming'){
				if($order==''){$order='ASC';}
				$args += array('meta_key' => 'we_startdate', 'meta_value' => $time_now, 'meta_compare' => '>','orderby' => 'meta_value_num', 'order' => $order);
			}elseif($type=='past'){
				if($order==''){$order='DESC';}
				$args += array('meta_key' => 'we_enddate', 'meta_value' => $time_now, 'meta_compare' => '<','orderby' => 'meta_value_num', 'order' => $order);
			}elseif($type=='day'){
				$args += array(
						 'meta_key' => 'we_startdate',
						 'meta_query' => array( 
						 array('key'  => 'we_startdate',
							   'value' => date('m/d/Y'),
							   'compare' => '=')
						 )
				);
			}elseif($type=='week'){
				$day = date('w');
				$week_start = date('m/d/Y', strtotime('-'.$day.' days'));
				if($order==''){$order='ASC';}
				$week_end = date('m/d/Y', strtotime('+'.(6-$day).' days'));
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'orderby' => 'meta_value_num',
						 'order' => $order,
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
			}elseif($type=='month'){
				$month_start = date("m/1/Y") ;
				if($order==''){$order='DESC';}
				$month_end =  date("m/t/Y") ;
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'orderby' => 'meta_value_num',
						 'order' => $order,
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
			}elseif($type=='year'){
				$y_start = date("1/1/Y") ;
				$y_end =  date("12/t/Y") ;
				if($order==''){$order='DESC';}
				$args += array(
						 'meta_key' => 'we_startdate',
						 //'meta_value' => date('m/d/Y'),
						 'orderby' => 'meta_value_num',
						 'order' => $order,
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
			}
		}		
	$the_query = new WP_Query( $args );
	if(is_search() && we_global_search_result_page()=='map'){
		global $wp_query;
		$the_query = $wp_query;
	}
	$we_api_map = get_option('we_api_map');
	$it = $the_query->post_count;
	$we_smap = get_option('we_smap');
	if($the_query->have_posts()){
		$ar_ad_two = array();
		while($the_query->have_posts()){ $the_query->the_post();
			$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumb_150x160' );
				$we_startdate = get_post_meta(get_the_ID(),'we_startdate', true );
				$date_id = $time_id ='';
				if($we_startdate){
					$date_id = date_i18n( get_option('date_format'), $we_startdate);
					$time_id = date_i18n( get_option('time_format'), $we_startdate);
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
				$address = get_post_meta(get_the_ID(),'we_adress', true );
				if($address!=''){
					$latitude = $longitude = '';
					$prepAddr = str_replace(' ','+',$address);
					$we_latitude_longitude = get_post_meta(get_the_ID(),'we_latitude_longitude', true );
					if($we_latitude_longitude!=''){
						$we_latitude_longitude = explode(',',$we_latitude_longitude);
						if(isset($we_latitude_longitude[0]) && $we_latitude_longitude[0] !=''){
							$latitude = trim($we_latitude_longitude[0])*1;
						}
						if(isset($we_latitude_longitude[1]) && $we_latitude_longitude[1] !=''){
							$longitude = trim($we_latitude_longitude[1])*1;
						}
					}else{
						$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
						$output= json_decode($geocode);
						$latitude = $output->results[0]->geometry->location->lat;
						$longitude = $output->results[0]->geometry->location->lng;
					}
					$ar_ad=array();
					$icon = plugins_url('/images/iconmap.png', __FILE__);
					$url_icon =  wp_get_attachment_image_src(get_post_meta(get_the_ID(),'we_iconmap', true ),'full');
					if(!isset($url_icon[0]) && $we_smap){
						$url_icon =  wp_get_attachment_image_src($we_smap,'full');
					}
					if(isset($url_icon[0])){
						$icon = $url_icon[0];
					}
				
					array_push($ar_ad, $address, $latitude, $longitude, $image_src[0],get_the_title(), $date_id, $time_id, $price,get_permalink(),$icon);
					$ar_ad_two[] = $ar_ad;
				}
		}	
		$js_array = json_encode($ar_ad_two);
		if($js_array=='[]'){return;}
		if($center_map!=''){
			$latitude_ct = $longitude_ct = '';
			$center_latitude_longitude = explode(',',$center_map);
			if(isset($center_latitude_longitude[0]) && $center_latitude_longitude[0] !='' && is_numeric(trim($center_latitude_longitude[0]))){
				$latitude_ct = trim($center_latitude_longitude[0])*1;
			}
			if(isset($center_latitude_longitude[1]) && $center_latitude_longitude[1] !='' && is_numeric(trim($center_latitude_longitude[0]))){
				$longitude_ct = trim($center_latitude_longitude[1])*1;
			}
			if($latitude_ct =='' || $longitude_ct == ''){
				$center_map = str_replace(' ','+',$center_map);
				$center = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$center_map.'&sensor=false');
				$out_put= json_decode($center);
				$latitude_ct = $out_put->results[0]->geometry->location->lat;
				$longitude_ct = $out_put->results[0]->geometry->location->lng;
			}
		}else{
			$latitude_ct =$ar_ad_two[0][1];
			$longitude_ct = $ar_ad_two[0][2] ;			
		}
		$we_googlemap_js = get_option('we_googlemap_js');
		if($we_googlemap_js!='on'){?>
			<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $we_api_map;?>"></script>
            <?php }
		?>
      	<script type="text/javascript" src="<?php echo plugins_url('/markerclusterer/markerclusterer.js', __FILE__)?>"></script>
  
      	<script>
        function initialize() {
		  var data = <?php echo $js_array ?>;  
          var center = new google.maps.LatLng(<?php echo $latitude_ct ?>, <?php echo $longitude_ct ?>);
  
          var map = new google.maps.Map(document.getElementById('we-map-<?php echo esc_attr($ID)?>'), {
            zoom: <?php echo esc_attr($zoom);?>,
            center: center,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          });
          var markers = [];
		  var infowindow = new google.maps.InfoWindow();
          for (var i = 0; i < data.length; i++) {
            var dataPhoto = data[i][3];
			var rd= (data[i][1] + (Math.random() -.5) / 1500);
			var rd2 = (data[i][2] + (Math.random() -.5) / 1500);
            var latLng = new google.maps.LatLng(rd, rd2);
			var map_icon = data[i][9];
            var marker = new google.maps.Marker({
              position: latLng,
			  icon: map_icon,
            });
			<?php if(!is_singular('product')){?>
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
				  return function() {
					infowindow.setContent('<div class="we-infotable"><div class="wemap-details">'+
					'<h4 class="wemap-title"><a href="'+data[i][8]+'">'+data[i][4]+'</a></h4>'+
					'<p class="weinfo-date"><b><?php echo get_option('we_text_date')!='' ? get_option('we_text_date') : esc_html__('Date','exthemes');?>: </b>'+data[i][5]+' - '+data[i][6]+'</p>'+
					'<p class="weinfo-loca"><b><?php echo get_option('we_text_loca')!='' ? get_option('we_text_loca') : esc_html__('Location','exthemes');?>: </b>'+data[i][0]+'</p>'+
					'<p class="bt-buy btn btn-primary"><a href="'+data[i][8]+'"><?php echo get_option('we_text_buytk')!='' ? get_option('we_text_buytk') : esc_html__('BUY TICKET - ','exthemes');?>'+data[i][7]+'</a></p>'+
					'</div><div class="wemap-img"><img src="'+data[i][3]+'"></div></div>');
					infowindow.open(map, marker);
				  }
				})(marker, i));
			<?php }else{?>
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
				  return function() {
					infowindow.setContent('<div class="we-infotable"><div class="wemap-details">'+
					'<p class="weinfo-loca"><b><?php echo get_option('we_text_loca')!='' ? get_option('we_text_loca') :  esc_html__('Location','exthemes');?>: </b>'+data[i][0]+'</p></div></div>');
					infowindow.open(map, marker);
				  }
				})(marker, i));
			<?php }?>
            markers.push(marker);
          }
          var markerCluster = new MarkerClusterer(map, markers,{imagePath: '<?php echo plugins_url('/markerclusterer/images/', __FILE__)?>m'});
		  <?php if(get_option('we_map_style')!=''){?>
		  var styleArray = <?php echo (get_option('we_map_style'));?>;
			
			map.setOptions({styles: styleArray});
			<?php }?>
        }
        google.maps.event.addDomListener(window, 'load', initialize);
      </script>
      <script>
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-12846745-20']);
        _gaq.push(['_trackPageview']);
  
        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' === document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>
      <div id="we-map-<?php echo esc_attr($ID)?>" style="width:100%; min-height:<?php if($height){ echo esc_attr($height).'px;';}else{?> 400px; <?php }?>"></div>
	  <?php
	}else{
		$noftrsl = get_option('we_text_no_evf')!='' ? get_option('we_text_no_evf') : esc_html__('No Events Found','exthemes');
		echo '<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i>  '.$noftrsl.'</div>';
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
add_shortcode( 'we_map', 'parse_we_map_event_func' );
add_action( 'after_setup_theme', 'we_reg_map_event_vc' );
function we_reg_map_event_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WooEvents - Maps", "exthemes"),
	   "base" => "we_map",
	   "class" => "",
	   "icon" => "icon-map",
	   "controls" => "full",
	   "category" => esc_html__('WooEvents','exthemes'),
	   "params" => array(
	   	  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Type", 'exthemes'),
			 "param_name" => "type",
			 "value" => array(
			 	esc_html__('All', 'exthemes') => '',
				esc_html__('Upcoming', 'exthemes') => 'upcoming',
				esc_html__('Past', 'exthemes') => 'past',
				esc_html__('Day', 'exthemes') => 'day',
				esc_html__('Week', 'exthemes') => 'week',
				esc_html__('Month', 'exthemes') => 'month',
				esc_html__('Year', 'exthemes') => 'year',
			 ),
			 "description" => ''
		  ),	
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Center Map", "exthemes"),
			"param_name" => "center_map",
			"value" => "",
			"description" => esc_html__("Enter Latitude and Longitude (https://ctrlq.org/maps/address/), separated by a comma or Type Address, Ex:Australia", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Zoom", "exthemes"),
			"param_name" => "zoom",
			"value" => "",
			"description" => esc_html__("Enter number", "exthemes"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Height", "exthemes"),
			"param_name" => "height",
			"value" => "",
			"description" => esc_html__("Enter number, ex: 400", "exthemes"),
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
	   )
	));
	}
}