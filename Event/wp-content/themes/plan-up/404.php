<?php
/**
 * The template for displaying 404 pages (Not Found)
 */
$customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');
$not_found_desc = isset($customizer['c_404_desc']) ? $customizer['c_404_desc'] : false;
get_header(); ?>

	<div id="primary" class="content-full">

			<div class="notfound-wrapper">
				<div class="inner">
					<?php if( $not_found_desc ){
						echo html_entity_decode($not_found_desc);
					}else{ ?>
						<h1 class="heading">404</h1>
						<p class="sub-heading">Opps! Seems Like the page is missing.</p>
						<p class="desc">Sorry but something goes wrong here. The page you are looking for does not exists for some reasons. Please go <a href="<?php echo esc_url( home_url() ); ?>">back to homepage</a> or enter keywords into the form below to search. Thank you!</p>
					<?php } ?>
					<span class="guide"><i class="ion-ios-arrow-thin-down"></i></span>
					<form method="get" id="searchform" action="<?php echo esc_url(home_url()); ?>">
					  <div>
					    <input type="text" value="" name="s" id="s" placeholder="<?php echo apply_filters( 'fw_404_search_placeholder', esc_html__('Enter keyword to search', 'plan-up') ); ?>" />
					    <i class="ion-ios-search-strong"></i>
					  </div>
					</form>
				</div>
			</div>

	</div><!-- #primary -->

<?php
get_footer();
