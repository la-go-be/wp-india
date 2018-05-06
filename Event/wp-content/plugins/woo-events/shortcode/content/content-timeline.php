<?php
global $number_excerpt;
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
$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
$bg_style = 'style="background-image:url('.esc_url($image_src[0]).');"';
?>
<li id="tlct-<?php the_ID();?>">
    <div class="timeline-content">
    	 <?php
         if($we_startdate!=''){ ?>
    	<div class="tl-tdate">
            <span class="tlday"><?php echo date_i18n( 'd', $we_startdate)?></span>
            <div>
                <span><?php echo date_i18n( 'l', $we_startdate)?></span>
                <span><?php echo date_i18n( 'F,Y', $we_startdate)?></span>
            </div>
        </div>
        <?php }?>
        <?php
		if(1==10){?>
			<a class="img-left" href="<?php echo get_permalink(get_the_ID());?>" title="<?php the_title_attribute();?>">
				<span class="info-img"><?php the_post_thumbnail('wethumb_460x307');?></span>
			</a>
		<?php }?>
        <div class="we-more-meta" <?php echo $bg_style;?>>
        	<div class="bg-inner">
                <h3><a href="<?php the_permalink(); ?>" class="link-more"><?php the_title();?></a></h3>
                <?php
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
                <div class="timeline-excerpt"><?php echo wp_trim_words(get_the_excerpt(),$number_excerpt,$more = '...');?></div>
            </div>
        </div>
    </div>
    <div class="tl-point"></div>
    <div class="tl-readmore-center">
        <a href="<?php echo get_permalink(get_the_ID());?>" title="<?php the_title_attribute();?>">
            <?php echo get_option('we_text_viewdetails')!='' ? get_option('we_text_viewdetails') : esc_html__('View Details','exthemes');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </a>
    </div>
</li>