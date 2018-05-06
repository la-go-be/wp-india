<?php
global $woocommerce, $post,$we_main_purpose;
if($we_main_purpose=='woo'){
	return;
}
	
$we_startdate = we_global_startdate();;
$we_enddate = we_global_enddate() ;;
$we_adress = get_post_meta( $post->ID, 'we_adress', true ) ;
$we_lat = get_post_meta( $post->ID, 'we_latitude_longitude', true ) ;
$we_phone = get_post_meta( $post->ID, 'we_phone', true ) ;
$we_email = get_post_meta( $post->ID, 'we_email', true ) ;
$we_website = get_post_meta( $post->ID, 'we_website', true ) ;
$we_speakers = get_post_meta( $post->ID, 'we_speakers', true );
$we_schedu = get_post_meta( $post->ID, 'we_schedu', false );?>
<div class="woo-event-info col-md-12">
	<?php
	if(!is_array($we_speakers) && $we_speakers!=''){
		$we_speakers = explode(",",$we_speakers);
	}
	$we_text_speaker = get_option('we_text_speaker');
	if(is_array($we_speakers)){?>
    <span class="sub-lb spk-sub"><?php if($we_text_speaker!=''){ echo esc_attr($we_text_speaker);}else{ echo esc_html__('Speaker','exthemes');}?></span>
	<div class="speaker-info row">
		<?php
        foreach($we_speakers as $speaker){?>
            <div class="col-md-6 col-sm-6">
                <div class="media">
                    <div class="media-body">
                        <div class="media-heading">
                            <div class="speaker-avatar"><?php echo get_the_post_thumbnail($speaker, 'thumbnail')?></div>
                            <div class="speaker-details">
                                <span><a href="<?php echo get_permalink($speaker);?>"><?php echo get_the_title($speaker);?></a></span>
                                <span><?php echo get_post_meta( $speaker, 'speaker_position', true );?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php
        }?>
    </div>
    <?php }?>
    <div class="date-info row">
        <?php
		$all_day = get_post_meta($post->ID,'we_allday', true );
        if($we_startdate){?>
            <div class="col-md-6 event-startdate">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_start')!='' ? get_option('we_text_start') : esc_html__('Start','exthemes');?></span>           	
                        <div class="media-heading">
                            <?php 
                            echo date_i18n( get_option('date_format'), $we_startdate).' ';
                            if(($we_enddate=='') || ($all_day!='1' && (date_i18n(get_option('time_format'), $we_startdate)!=date_i18n(get_option('time_format'), $we_enddate)))){ 
                                echo date_i18n(get_option('time_format'), $we_startdate);
                            }?>
                        </div>
                    </div>
                </div>
            </div><?php
        }
        if($we_enddate){?>
            <div class="col-md-6 event-enddate">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_end')!='' ? get_option('we_text_end') : esc_html__('End','exthemes');?> </span>     	
                        <div class="media-heading">
                            <?php 
                            echo date_i18n( get_option('date_format'), $we_enddate);
                            if($all_day!='1' && (date_i18n(get_option('time_format'), $we_startdate)!=date_i18n(get_option('time_format'), $we_enddate))){ 
                                echo ' '.date_i18n(get_option('time_format'), $we_enddate);
                            }elseif($all_day=='1'){ 
								$alltrsl = get_option('we_text_allday')!='' ? get_option('we_text_allday') : esc_html__('(All day)','exthemes');
								echo '<span> '.$alltrsl.'</span>';
							}?>
                        </div>
                    </div>
                </div>
            </div><?php
        }?>
    </div>
    <div class="row location-info">
            <?php 
            if($we_adress){?>
            <div class="col-md-6">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_addres')!='' ? get_option('we_text_addres') : esc_html__('Address','exthemes');?> </span>          	
                        <div class="media-heading">
                            <?php echo $we_adress;?>&nbsp;&nbsp;
                            <a href="http://maps.google.com/?q=<?php echo $we_lat!='' ? $we_lat : $we_adress;?>" target="_blank" class="map-link small-text"><?php echo get_option('we_text_vmap')!='' ? get_option('we_text_vmap') : esc_html__('View map','exthemes') ?> <i class="fa fa-map-marker"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php 
            if($we_phone){?>
            <div class="col-md-6">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_phone')!='' ? get_option('we_text_phone') : esc_html__('Phone','exthemes');?> </span>      	
                        <div class="media-heading">
                            <?php echo $we_phone;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
    </div>
    
    <div class="row more-info">
            <?php 
            if($we_email){?>
            <div class="col-md-6">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_email')!='' ? get_option('we_text_email') : esc_html__('Email','exthemes');?></span>   	
                        <div class="media-heading">
                            <a href="mailto:<?php echo $we_email;?>"><?php echo $we_email;?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <?php 
            if($we_website){?>
            <div class="col-md-6">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_web')!='' ? get_option('we_text_web') : esc_html__('Website','exthemes');?></span> 	
                        <div class="media-heading">
                            <a href="<?php echo esc_url($we_website);?>" target="_blank"><?php echo esc_url($we_website);?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
    </div>
    <?php 
	$we_custom_metadata = get_post_meta( $post->ID, 'we_custom_metadata', false );
	if(is_array($we_custom_metadata) && !empty($we_custom_metadata)){
		$number = count($we_custom_metadata);?>
		<div class="row we-custom-event-info">
			<?php 
			$i = 0;
			foreach($we_custom_metadata as $item){
				$i++;?>
				<div class="col-md-6 col-sm-6">
					<div class="media">
						<div class="media-body">
							<span class="sub-lb"><?php echo $item['we_custom_title'];?></span>
							<div class="media-heading">
                                <span class="we-sub-ct media-heading"><?php echo $item['we_custom_content'];?></span>
							</div>
						</div>
					</div>
				</div>
				<?php 
				if($i < $number && $i % 2==0){?>
				</div>
				<div class="row">	
				<?php }
			}?>
		</div>
	<?php }?>
</div>