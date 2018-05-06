<?php
global $columns,$number_excerpt,$show_time,$orderby,$img_size;
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

?>
<div class="item-post-n">
	<figure class="ex-modern-blog">
		<div class="image">
			<a href="<?php the_permalink(); ?>" class="link-more">
				<?php the_post_thumbnail($img_size);?>
            </a>    
		</div>
		<div class="grid-content">
			<figcaption>
            	<?php if($we_startdate!=''){?>
				<div class="date" <?php echo $bgev_color;?>><span class="day"><?php echo date_i18n( 'd', $we_startdate); ?></span><span class="month"><?php echo date_i18n('M', $we_startdate); ?></span></div>
                <?php }?>
				<h3><a href="<?php the_permalink(); ?>" class="link-more">
					<?php  if($orderby=='has_submited'){
						$title = get_the_title();
						$ft_ch = explode(":",$title);
						if(!isset($ft_ch[0])){ $ft_ch[0] ='';}
						if(get_post_status()=='pending'){
							$pd = get_option('we_text_pending');
							$pd = $pd!='' ? $pd : esc_html__('[pending] ','exthemes');
							echo '<span>'.$pd.'</span>'.str_replace($ft_ch[0],'',$title);
						}elseif(get_post_status()=='trash'){
							$tsh = get_option('we_text_trash');
							$tsh = $tsh!='' ? $tsh : esc_html__('[trash] ','exthemes');
							echo '<span>'.$tsh.'</span>'.str_replace($ft_ch[0],'',$title);
						}else{
							the_title();
						}
					}else{ the_title(); }?>
                </a></h3>
				<div class="we-more-meta">
				<?php
					if($we_startdate!=''){
						$sttime = '';
						if($show_time=='1'){
							$sttime = ' - '.date_i18n(get_option('time_format'), $we_startdate);
						}
						echo '<span><i class="fa fa-calendar"></i>'.date_i18n( get_option('date_format'), $we_startdate).$sttime.'</span>';
					}
					if($price!=''){
						echo  '<span><i class="fa fa-shopping-basket"></i>'.$price.'</span>';
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
                <?php if($number_excerpt!='0'){?>
				<div class="grid-excerpt"><?php echo wp_trim_words(get_the_excerpt(),$number_excerpt,$more = '...');?></div>
                <?php }?>
			</figcaption>
			<div class="ex-social-share" <?php if($columns!=1){ echo $bgev_color;}?> id="ex-social-<?php echo get_the_ID();?>">
				<?php 
				if($columns==1 && $we_eventcolor!=''){
					echo '<style type="text/css" scoped>
					.we-grid-shortcode.we-grid-column-1 figure.ex-modern-blog .ex-social-share#ex-social-'.get_the_ID().' ul li a{ background-color:'.$we_eventcolor.'}
					</style>';
				}
				echo we_social_share();?>
			</div>
		</div>
	</figure>    
</div>