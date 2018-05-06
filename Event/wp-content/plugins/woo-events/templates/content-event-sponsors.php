<?php
global $woocommerce, $post;
$we_sponsors = get_post_meta( $post->ID, 'we_sponsors', false );
if(is_array($we_sponsors) && !empty($we_sponsors)){?>
<div class="clear"></div>
<div class="woo-event-schedu woo-sponsors col-md-12">
	<h3><?php echo get_option('we_text_spon')!='' ? get_option('we_text_spon') : esc_html__('Sponsors','exthemes')?></h3>
    <div class="event-sponsors">
        <div class="is-carousel" data-items="6" data-autoplay=1  data-navigation=1 data-pagination=0>
            <?php 
            foreach($we_sponsors as $item){
                if(isset($item['we_sponsors_link']) && $item['we_sponsors_link']!=''){?>
                    <div class="item-sponsor">
                        <?php echo '<a href="'.esc_url($item['we_sponsors_link']).'" target="_blank">'.wp_get_attachment_image( $item['we_sponsors_logo'], 'full' ).'</a>'; ?>
                    </div>
                <?php }else{?>
                    <div class="item-sponsor">
                        <?php echo wp_get_attachment_image( $item['we_sponsors_logo'], 'full' ); ?>
                    </div>
                <?php 
                }
            }?>
        </div>
    </div>
</div>
<?php }?>