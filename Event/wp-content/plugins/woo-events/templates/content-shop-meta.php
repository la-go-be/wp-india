<?php
global $woocommerce, $post,$we_main_purpose;
$we_startdate = we_global_startdate();
$we_enddate = we_global_enddate() ;
$we_adress = get_post_meta( $post->ID, 'we_adress', true ) ;
$we_phone = get_post_meta( $post->ID, 'we_phone', true ) ;
$we_email = get_post_meta( $post->ID, 'we_email', true ) ;
$we_website = get_post_meta( $post->ID, 'we_website', true ) ;
$we_speakers = get_post_meta( $post->ID, 'we_speakers', true );
$we_schedu = get_post_meta( $post->ID, 'we_schedu', false );?>
<div class="woo-event-info">
	<?php
	if(!is_array($we_speakers) && $we_speakers!=''){
		$we_speakers = explode(",",$we_speakers);
	}
	if(is_array($we_speakers) && $we_main_purpose!='woo'){?>
    <span class="sub-lb spk-sub"><?php echo get_option('we_text_speaker')!='' ? get_option('we_text_speaker') :  esc_html__('Speaker','exthemes');?></span>
	<div class="speaker-info row">
		<?php
        foreach($we_speakers as $speaker){ $i++?>
            <div class="col-md-6">
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
        if($we_startdate){?>
            <div class="col-md-6 event-startdate">
                <div class="media">
                    <div class="media-body">
                        <span class="sub-lb"><?php echo get_option('we_text_start')!='' ? get_option('we_text_start') : esc_html__('Start','exthemes');?></span>           	
                        <div class="media-heading">
                            <?php 
                            echo date_i18n( get_option('date_format'), $we_startdate).' ';
                            if(date_i18n(get_option('time_format'), $we_startdate)!=date_i18n(get_option('time_format'), $we_enddate)){ 
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
                            if($we_enddate!=$we_startdate){
                                echo date_i18n( get_option('date_format'), $we_enddate);
                            }
                            if(date_i18n(get_option('time_format'), $we_startdate)!=date_i18n(get_option('time_format'), $we_enddate)){ 
                                echo ' '.date_i18n(get_option('time_format'), $we_enddate);
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
                            <a href="http://maps.google.com/?q=<?php echo $we_adress;?>" target="_blank" class="map-link small-text"><?php echo get_option('we_text_vmap')!='' ? get_option('we_text_vmap') : esc_html__('View map','exthemes') ?> <i class="fa fa-map-marker"></i></a>
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
                        <span class="sub-lb"><?php echo get_option('we_text_phone')!='' ? get_option('we_text_phone') : esc_html__('Phone: ','exthemes');?></span>      	
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
</div>