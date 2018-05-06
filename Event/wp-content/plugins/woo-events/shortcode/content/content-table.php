<?php
global $style,$show_time,$show_atc;
global $ajax_load;
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

$we_eventcolor = we_event_custom_color(get_the_ID());
if($we_eventcolor==''){$we_eventcolor = we_autochange_color();}
$bgev_color = '';
if($we_eventcolor!=""){
	$bgev_color = 'style="background-color:'.$we_eventcolor.'"';
}
if( $we_eventcolor!="" && $style=='3' ){
	$bgev_color = 'style="border-left:10px solid; border-left-color:'.$we_eventcolor.'"';
}
$we_category = we_taxonomy_info('product_cat','on');

if($style!='2' && $style!='3'){ ?>
	<tr <?php if(isset($ajax_load) && $ajax_load ==1){?>class="tb-load-item de-active" <?php }?>>
		<td class="we-first-row"><?php if($we_startdate!=''){ 
			$sttime = '';
			if($show_time=='1'){
				$sttime = ' - '.date_i18n(get_option('time_format'), $we_startdate);
			}
			echo date_i18n( get_option('date_format'), $we_startdate).$sttime;
		} ?></td>
		<td><h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<span class="event-meta we-hidden-screen">
			  <?php if($we_adress!=''){?>
				  <span class="tb-meta"><i class="fa fa-map-marker"></i> <?php echo $we_adress;?></span>
			  <?php }if($price!=''){?>
				  <span class="tb-meta"><i class="fa fa-shopping-basket"></i><?php echo $price;?></span>
			  <?php }if($we_status!=''){?>
				  <span class="tb-meta"><i class="fa fa-ticket"></i> <?php echo $we_status;?></span>
			  <?php }?>
			</span>
		</td>
		<td class="we-mb-hide"><?php echo $we_adress;?></td>
		<td class="tb-price we-mb-hide"><span><?php echo $price;?></span></td>
		<td class="we-mb-hide"><?php echo $we_status;?></td>
	</tr>
<?php }else{?>
	<tr <?php if(isset($ajax_load) && $ajax_load ==1){?>class="tb-load-item de-active" <?php }?>>
		<td class="we-first-row" <?php echo $bgev_color;?>>
		<?php if($we_startdate!=''){ 
			$st_d = date_i18n( 'd', $we_startdate);
			$e_d = date_i18n( 'd', $we_enddate);
			
			$st_m = date_i18n( 'F', $we_startdate);
			$e_m = date_i18n( 'F', $we_enddate);
			
			if(($st_d != $e_d) || ($st_m != $e_m)){
				echo '<span class="tb2-day tb-small">'.$st_d.' - '.$e_d.'</span>';	
			}else{
				echo '<span class="tb2-day">'.$st_d.' </span>';	
			}
			
			if($st_m != $e_m){
				echo '<span class="tb2-month tb-small">'.$st_m.' - '.$e_m.'</span>';
			}else{
				echo '<span class="tb2-month">'.$st_m.'</span>';
			}
		} ?>
		</td>
		<td>
			<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			<span class="event-meta">
			  <?php 
			  if($we_startdate!=''){
				  $sttime = '';
				  if($show_time=='1'){
					  $sttime = ' - '.date_i18n(get_option('time_format'), $we_startdate);
				  }
				  echo '<span class="tb-meta"><i class="fa fa-calendar"></i>'.date_i18n( get_option('date_format'), $we_startdate).$sttime.'</span>';
			  }
			  if($we_adress!=''){?>
				  <span class="tb-meta"><i class="fa fa-map-marker"></i> <?php echo $we_adress;?></span>
			  <?php }if($price!=''){?>
				  <span class="tb-meta"><i class="fa fa-shopping-basket"></i><?php echo $price;?></span>
			  <?php }if($we_status!=''){?>
				  <span class="tb-meta"><i class="fa fa-ticket"></i> <?php echo $we_status;?></span>
			  <?php }if($we_category!='' && $style=='3'){?>
				  <span class="tb-meta-cat " <?php echo 'style="border-left-color:'.$we_eventcolor.'"';?>><?php echo $we_category;?></span>
			  <?php }?>
			</span>
		</td>
		<td class="tb-viewdetails">
            <span>
                <?php 
				if($show_atc==1){
					$variations = '';
					$product = get_product(get_the_ID());
					if($product!==false) { $variations = $product->get_type();}
					$atts['id']= get_the_ID();
					$url = WC_Shortcodes::product_add_to_cart_url($atts);
					if($variations == 'variable'){
						$tbt = get_option('we_text_sl_op')!='' ? get_option('we_text_sl_op') : esc_html__('Select options','exthemes');
					}else{
						$tbt = get_option('we_text_add_to_cart')!='' ? get_option('we_text_add_to_cart') : esc_html__('Add to cart','exthemes');
					}?>
                    <a class="btn btn btn-primary we-button" <?php echo $bgev_color;?> href="<?php echo esc_url($url);?>">
                    	<?php echo $tbt;?>
                    </a>
                    <?php
				}else{?>                              
                    <a class="btn btn btn-primary we-button" <?php echo $bgev_color;?> href="<?php the_permalink();?>"><?php echo get_option('we_text_viewdetails')!='' ? get_option('we_text_viewdetails') : esc_html__('View Details','exthemes');?></a>
                <?php } ?>
            </span>
		</td>
	</tr>
<?php }
