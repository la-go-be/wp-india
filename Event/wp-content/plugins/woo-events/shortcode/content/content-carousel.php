<?php
$we_startdate = get_post_meta( get_the_ID(), 'we_startdate', true );
$we_enddate = get_post_meta( get_the_ID(), 'we_enddate', true )  ;
global $product,$show_time,$style;	
$type = $product->get_type();
$price ='';
if($type=='variable'){
	$price = we_variable_price_html();
}else{
	if ( $price_html = $product->get_price_html() ) :
		$price = $price_html; 
	endif; 	
}
global $img_size;
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
                <?php }
				if($style == 'we-car-modern'){?>
                	<div class="we-ca-title">
						<h3><a href="<?php the_permalink(); ?>" class="link-more"><?php the_title();?></a></h3>
                        <?php
                        if($we_startdate!=''){ 
							$sttime = '';
							if($show_time=='1'){
								$sttime = ' - '.date_i18n(get_option('time_format'), $we_startdate);
							}
							echo '<span>'.date_i18n( get_option('date_format'), $we_startdate).$sttime.'</span>';
						}
						?>
                    </div>
                <?php }else{?>
                	<h3><a href="<?php the_permalink(); ?>" class="link-more"><?php the_title();?></a></h3>
                <?php }?>
				<div class="we-more-meta">
				<?php
					if($we_startdate!='' && $style != 'we-car-modern'){ 
						$sttime = '';
						if($show_time=='1'){
							$sttime = ' - '.date_i18n(get_option('time_format'), $we_startdate);
						}
						echo '<span><i class="fa fa-calendar"></i>'.date_i18n( get_option('date_format'), $we_startdate).$sttime.'</span>';
					}
					if($we_adress!='' && $style == 'we-car-modern'){?>
				  		<span class="tb-meta"><i class="fa fa-map-marker"></i> <?php echo $we_adress;?></span>
			  		<?php }
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
				<div class="grid-excerpt"><?php echo wp_trim_words(get_the_excerpt(),10,$more = '...');?></div>
			</figcaption>
		</div>
	</figure>    
</div>