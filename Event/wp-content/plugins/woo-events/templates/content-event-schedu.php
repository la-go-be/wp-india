<?php
global $woocommerce, $post,$we_main_purpose;
$we_startdate = we_global_startdate();
$we_enddate = we_global_enddate() ;
$we_schedu = get_post_meta( $post->ID, 'we_schedu', false );
wooevent_template_plugin('event-sponsors');
if($we_main_purpose!='woo'){?>
    <div class="clear"></div>
    <?php we_ical_google_button( $post->ID ); ?>
    <div class="woo-event-schedu col-md-12">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h3><?php echo get_option('we_text_status')!='' ? get_option('we_text_status') : esc_html__('Status','exthemes')?></h3>
                <div class="we-sche-detail we-status ">
                    <?php echo do_shortcode('[we_countdown single="1" ids ="'.$post->ID.'" show_title="0"]');
                    global $product; 
                    $total = get_post_meta($post->ID, 'total_sales', true);?>
                    <p><i class="fa fa-ticket"></i> 
                        <?php echo woo_event_status( $post->ID, $we_enddate)?>
                    </p>
                    <p><i class="fa fa-user"></i> 
						<?php 
						$hasstrsl = get_option('we_text_hassold')!='' ? get_option('we_text_hassold') : esc_html__('Has Sold','exthemes');
						echo $total.'  '.$hasstrsl;?>
                    </p>
                </div>
                <div class="clear"></div>
                <?php if(!empty($we_schedu)){ ?>
                    <h3 class="h3-ev-schedu"><?php echo get_option('we_text_schedule')!='' ? get_option('we_text_schedule') : esc_html__('Schedule','exthemes')?></h3>
                    <div class="we-sche-detail ev-schedu">
                        <?php foreach($we_schedu as $item){ ?>
                                <p><?php echo $item; ?></p>
                                <?php 
                        }?>
                    </div>
                <?php }?>
            </div>
            <div class="col-md-6 col-sm-6">
                <?php if(get_option('we_single_map') =='yes'){
					if(get_post_meta( $post->ID, 'we_adress', true )==''){
						$we_latitude_longitude = get_post_meta($post->ID,'we_latitude_longitude', true );
						$we_latitude_longitude = explode(',',$we_latitude_longitude);
						if(isset($we_latitude_longitude[0]) && $we_latitude_longitude[0] !=''){
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($we_latitude_longitude[0]).','.trim($we_latitude_longitude[1]).'&sensor=false');
							$geocodeFromLatLong = curl_exec($ch);
							curl_close($ch);
							
							$output = json_decode($geocodeFromLatLong);
							$status = $output->status;
							$addre = ($status=="OK")?$output->results[1]->formatted_address:'';
						}
					}else{
						$addre = get_post_meta( $post->ID, 'we_adress', true );
					}
					if($addre!=''){
						?>
						<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"width="100%" height="100%" src="https://maps.google.com/maps?hl=en&q=<?php echo ($addre);?>&ie=UTF8&t=roadmap&z=10&iwloc=B&output=embed"></iframe>
						<?php
					}
				}else{ echo do_shortcode('[we_map ids="'.get_the_ID().'" height="300"]');}?>
            </div>
        </div>
    </div>
<?php }
$off_ssocial = get_option('we_ssocial');
if($off_ssocial!='off'){
	?>
	<div class="we-social-share col-md-12">
		<div class="row">
			<?php echo  we_social_share();?>
		</div>
	</div>
<?php }?>
<div class="clear"></div>