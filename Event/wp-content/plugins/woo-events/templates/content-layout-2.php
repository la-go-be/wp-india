<?php
global $woocommerce, $post,$we_main_purpose;
$we_startdate = we_global_startdate() ;
?>
<div class="we-content-custom col-md-12">
	<?php
    if($we_main_purpose=='woo'){
         wooevent_template_plugin('gallery');
    }else{?>
    <div class="we-info-top">
        <div class="event-details">
        	<div class="event-info-left">
            	<h1 class="ev-title">
                	<?php the_title();?>
                </h1>
                <?php 
				global $product;
				$type = $product->get_type();
				$price ='';
				if($type=='variable'){
					$price = we_variable_price_html();
				}else{
					  if ( $price_html = $product->get_price_html() ) :
						  $price = $price_html; 
					  endif; 	
				}?>
                <h3 class="event-price"><?php echo $price;?></h3>
                <div class="button-scroll btn btn-primary"><?php 
				$we_text_join_now = get_option('we_text_join_now');
				if($we_text_join_now!=''){
					echo $we_text_join_now;
				}else{
					esc_html_e('Join Now','exthemes');
				}
				?>
                </div>
            </div>
            <div class="event-info-right">
				<?php wooevent_template_plugin('event-meta'); ?>
            </div>
    	</div>
	</div>
    <?php }?>
    <div class="content-dt"><?php echo apply_filters('the_content',get_the_content($post->ID));?></div>
	<style type="text/css">.woocommerce .we-main.layout-2 .images{ display:none !important}</style>
</div>
<div class="clear"></div>