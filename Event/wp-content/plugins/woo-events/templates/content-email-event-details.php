<?php
global $event_items;
$check_ev = false;
foreach ( $event_items as $item ) {
	$product_id = $item['product_id'];
	$we_startdate = get_post_meta( $product_id, 'we_startdate', true );
	$we_enddate = get_post_meta( $product_id, 'we_enddate', true );
	if($we_startdate!=''){
		$check_ev = true;
		break;
	}
}
if($check_ev == true){
	?>
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:left;"><?php echo get_option('we_text_evname')!='' ? get_option('we_text_evname') : esc_html__( 'Event Name', 'exthemes' ); ?></th>
				<th class="td" scope="col" style="text-align:left;"><?php echo get_option('we_text_evdate')!='' ? get_option('we_text_evdate') : esc_html__( 'Event Date', 'exthemes' ); ?></th>
				<th class="td" scope="col" style="text-align:left;"><?php echo get_option('we_text_evlocati')!='' ? get_option('we_text_evlocati') : esc_html__( 'Event Location', 'exthemes' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $event_items as $item ) {
					$product_name = $item['name'];
					$product_id = $item['product_id'];
					$product_variation_id = $item['variation_id'];
					$we_startdate = get_post_meta( $product_id, 'we_startdate', true );
					$we_enddate = get_post_meta( $product_id, 'we_enddate', true );
					if($we_startdate!=''){
					?>
					<tr>
						<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;"><?php echo $item['name'];?></td>
						<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;">
							<span class=""><b><?php echo get_option('we_text_stdate')!='' ? get_option('we_text_stdate') : esc_html__('Start Date','exthemes');?>: </b><?php echo date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate);?></span><br>
							<span class=""><b><?php echo get_option('we_text_edate')!='' ? get_option('we_text_edate') : esc_html__('End Date','exthemes');?>: </b><?php echo date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate);?></span><br>
						</td>
						<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;"><?php echo get_post_meta( $product_id, 'we_adress', true );?></td>
					</tr>
					<?php
					}else{
						$product_id = wp_get_post_parent_id( $product_id );
						$we_startdate = get_post_meta( $product_id, 'we_startdate', true );
						$we_enddate = get_post_meta( $product_id, 'we_enddate', true );
						if($we_startdate!=''){
							?>
							<tr>
								<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;"><?php echo get_the_title($product_id);?></td>
								<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;">
									<span class=""><b><?php echo get_option('we_text_stdate')!='' ? get_option('we_text_stdate') : esc_html__('Start Date','exthemes');?>: </b><?php echo date_i18n( get_option('date_format'), $we_startdate).' '.date_i18n(get_option('time_format'), $we_startdate);?></span><br>
									<span class=""><b><?php echo get_option('we_text_edate')!='' ? get_option('we_text_edate') : esc_html__('End Date','exthemes');?>: </b><?php echo date_i18n( get_option('date_format'), $we_enddate).' '.date_i18n(get_option('time_format'), $we_enddate);?></span><br>
								</td>
								<td class="td" scope="col" style="text-align:left; border: 1px solid #e4e4e4;"><?php echo get_post_meta( $product_id, 'we_adress', true );?></td>
							</tr>
							<?php
						}
					}
					
				} ?>
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<?php
}