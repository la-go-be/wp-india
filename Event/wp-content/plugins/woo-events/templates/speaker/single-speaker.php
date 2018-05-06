<?php
get_header();
?>
<div class="we-content-speaker spk-single">
	<?php
	// Start the loop.
	while ( have_posts() ) : the_post();
		$we_custom_metadata = get_post_meta( get_the_ID(), 'we_custom_metadata', false );?>
        <div class="we-info-sp">
            <div class="row">
            <div class="col-md-4">
            <div class="speaker-avatar">
                <?php if(has_post_thumbnail()){?>
                <div class="img-spk"><?php the_post_thumbnail('wethumb_300x300');?></div>
                <?php } ?>
                <span><?php echo get_post_meta( get_the_ID(), 'speaker_position', true );?></span>
            </div>
            </div>
            <div class="col-md-8">
            <div class="speaker-details">
                <h3 class="speaker-title">
                    <?php the_title();?>
                </h3>
                <?php if(is_array($we_custom_metadata) && !empty($we_custom_metadata)){
					$number = count($we_custom_metadata);?>
                    <div class="we-custom-meta-info">
                    <div class="row">
                    	<?php 
						$i = 0;
						foreach($we_custom_metadata as $item){
							$i++;?>
                        	<div class="col-md-6 col-sm-6">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="custom-details">
                                            <span class="sub-lb we-sub-lb"><?php echo $item['we_custom_title'];?></span>
                                            <span class="we-sub-ct media-heading"><?php echo $item['we_custom_content'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        	<?php 
							if($i%2==0){?>
							</div>
                            <div class="row">	
							<?php }
						}?>
                    </div>
                    </div>
                <?php }?>
                <div class="speaker-info">
                    <div class="speaker-content"><?php the_content();?></div>
                </div>
                <div class="we-social-share"><?php  echo speaker_print_social_accounts();?></div>
                <div class="speaker-event-list">
                    <h3 class="speaker-title"><?php echo get_option('we_text_speaker_of')!='' ? get_option('we_text_speaker_of') : esc_html__('Speaker of Events','exthemes');?></h3>
                    <?php echo do_shortcode('[we_table orderby="date" style="1" data_qr="'.get_the_ID().'" count="100" posts_per_page="5"]');?>
                </div>
            </div>
            </div>
            </div>
        </div>
		<?php
	endwhile;?>
</div>
<?php get_footer(); ?>
