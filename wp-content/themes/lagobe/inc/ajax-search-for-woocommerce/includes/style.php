<?php
add_action( 'wp_head', 'dgwt_wcas_print_style' );

function dgwt_wcas_print_style() {

	// Search form
	$bg_search_input	 = DGWT_WCAS()->settings->get_opt( 'bg_input_color' );
	$text_input_color	 = DGWT_WCAS()->settings->get_opt( 'text_input_color' );
	$border_input_color	 = DGWT_WCAS()->settings->get_opt( 'border_input_color' );
	$bg_submit_color	 = DGWT_WCAS()->settings->get_opt( 'bg_submit_color' );
	$text_submit_color	 = DGWT_WCAS()->settings->get_opt( 'text_submit_color' );

	// Suggestions
	$sug_hover_color	 = DGWT_WCAS()->settings->get_opt( 'sug_hover_color' );
	$sug_highlight_color = DGWT_WCAS()->settings->get_opt( 'sug_highlight_color' );
	$sug_text_color		 = DGWT_WCAS()->settings->get_opt( 'sug_text_color' );
	$sug_bg_color		 = DGWT_WCAS()->settings->get_opt( 'sug_bg_color' );
	$sug_border_color	 = DGWT_WCAS()->settings->get_opt( 'sug_border_color' );

	$preloader_url = trim( DGWT_WCAS()->settings->get_opt( 'preloader_url' ) );

	ob_start();
	?>
	<style type="text/css">
	<?php if ( !empty( $bg_search_input ) || !empty( $text_input_color ) || !empty( $border_input_color ) ): ?>
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input,
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input:hover,
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input:focus{
		<?php echo!empty( $bg_search_input ) ? 'background-color:' . sanitize_text_field( $bg_search_input ) . ';' : ''; ?>
		<?php echo!empty( $text_input_color ) ? 'color:' . sanitize_text_field( $text_input_color ) . ';' : ''; ?>
		<?php echo!empty( $border_input_color ) ? 'border-color:' . sanitize_text_field( $border_input_color ) . ';' : ''; ?>
			}
																																				
																																			
		<?php if ( !empty( $text_input_color ) ): ?>
				.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input::-webkit-input-placeholder {
					color: <?php echo sanitize_text_field( $text_input_color ); ?>;
					opacity:0.3;
				}
				.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input:-moz-placeholder{
					color: <?php echo sanitize_text_field( $text_input_color ); ?>;
					opacity:0.3;
				}  
				.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input::-moz-placeholder{
					color: <?php echo sanitize_text_field( $text_input_color ); ?>;
					opacity:0.3;
				}    
				.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-input:-ms-input-placeholder  {
					color: <?php echo sanitize_text_field( $text_input_color ); ?>;
					opacity:0.3;
				}
				.dgwt-wcas-no-submit.dgwt-wcas-search-wrapp .dgwt-wcas-ico-loupe {
					fill: <?php echo sanitize_text_field( $text_input_color ); ?>;
				}
		<?php endif; ?>		
	<?php endif; ?>
																				
																				
																							
	<?php
// Submit button
	if ( !empty( $bg_submit_color ) || !empty( $text_submit_color ) ):
		?>		
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit::before {
		<?php echo!empty( $bg_submit_color ) ? 'border-color: transparent ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>					
			}
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:hover::before,
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:focus::before {
		<?php echo!empty( $bg_submit_color ) ? 'border-right-color: ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>
			}
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit {
		<?php echo!empty( $bg_submit_color ) ? 'background-color: ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>
		<?php echo!empty( $text_submit_color ) ? 'color: ' . sanitize_text_field( $text_submit_color ) . ';' : ''; ?>
			}
																															
			.dgwt-wcas-search-wrapp .dgwt-wcas-ico-loupe{
		<?php echo!empty( $text_submit_color ) ? 'fill: ' . sanitize_text_field( $text_submit_color ) . ';' : ''; ?>
			}
	<?php endif; ?>	
												
	<?php
// Submit button
	if ( !empty( $bg_submit_color ) || !empty( $text_submit_color ) ):
		?>		
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit::before {
		<?php echo!empty( $bg_submit_color ) ? 'border-color: transparent ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>					
			}
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:hover::before,
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit:focus::before {
		<?php echo!empty( $bg_submit_color ) ? 'border-right-color: ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>
			}
			.dgwt-wcas-search-wrapp .dgwt-wcas-sf-wrapp .dgwt-wcas-search-submit {
		<?php echo!empty( $bg_submit_color ) ? 'background-color: ' . sanitize_text_field( $bg_submit_color ) . ';' : ''; ?>
		<?php echo!empty( $text_submit_color ) ? 'color: ' . sanitize_text_field( $text_submit_color ) . ';' : ''; ?>
			}
																															
			.dgwt-wcas-search-wrapp .dgwt-wcas-ico-loupe{
		<?php echo!empty( $text_submit_color ) ? 'fill: ' . sanitize_text_field( $text_submit_color ) . ';' : ''; ?>
			}
	<?php endif; ?>			
											
	<?php if ( !empty( $sug_bg_color ) ): ?>			
			.dgwt-wcas-search-wrapp .dgwt-wcas-suggestions-wrapp{
		<?php echo!empty( $sug_bg_color ) ? 'background-color: ' . sanitize_text_field( $sug_bg_color ) . ';' : ''; ?>
			}
	<?php endif; ?>
														
	<?php if ( !empty( $sug_hover_color ) ): ?>			
			.dgwt-wcas-search-wrapp .dgwt-wcas-suggestion-selected{
		<?php echo!empty( $sug_hover_color ) ? 'background-color: ' . sanitize_text_field( $sug_hover_color ) . ';' : ''; ?>
			}
	<?php endif; ?>
												
	<?php if ( !empty( $sug_text_color ) ): ?>			
			.dgwt-wcas-suggestion *
			{
		<?php echo!empty( $sug_text_color ) ? 'color: ' . sanitize_text_field( $sug_text_color ) . ';' : ''; ?>
			}
	<?php endif; ?>
										
	<?php if ( !empty( $sug_highlight_color ) ): ?>			
			.dgwt-wcas-search-wrapp .dgwt-wcas-st strong{
		<?php echo!empty( $sug_highlight_color ) ? 'color: ' . sanitize_text_field( $sug_highlight_color ) . ';' : ''; ?>
			}
	<?php endif; ?>
								
	<?php if ( !empty( $sug_border_color ) ): ?>			
			.dgwt-wcas-search-wrapp .dgwt-wcas-suggestions-wrapp,
			.dgwt-wcas-details-wrapp,
			.dgwt-wcas-suggestion{
		<?php echo!empty( $sug_border_color ) ? 'border-color: ' . sanitize_text_field( $sug_border_color ) . ';' : ''; ?>
			}
	<?php endif; ?>		
							
	<?php if ( !empty( $preloader_url ) ): ?>		
			.dgwt-wcas-inner-preloader	{
				background-image: url('<?php echo esc_url( $preloader_url ); ?>');
			}
	<?php endif; ?>		
							
	</style>
	<?php
	$css = ob_get_contents();
	ob_end_clean();

	echo dgwt_wcas_minify_css( $css );
}
