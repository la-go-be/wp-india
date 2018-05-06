jQuery(function(){
				 jQuery('ul.ui-tabs-nav li:nth-child(1)').click(function(){
			
			if(jQuery(this).hasClass('ui-state-active')){
				jQuery('.fw-col-sm-8 .tl2:nth-child(3)').hide();
				jQuery('.fw-col-sm-8 .tl2:nth-child(2)').show();
			}
		});
		
		jQuery('ul.ui-tabs-nav li:nth-child(2)').click(function(){																			 																
			if(jQuery(this).hasClass('ui-state-active')){
				jQuery('.fw-col-sm-8 .tl2:nth-child(2)').hide();
				jQuery('.fw-col-sm-8 .tl2:nth-child(3)').show();
			}			 
		});
		
		
		jQuery('#schedule  .fw-col-sm-8 .tl2:nth-child(3) .tl2-nav a').click(function(){
			var id = jQuery(this).attr('href');
			jQuery('#schedule  .fw-col-sm-8 .tl2:nth-child(3) .tl2-tabs .tl2-content').hide();
			jQuery('#schedule  .fw-col-sm-8 .tl2:nth-child(3) .tl2-tabs .tl2-content').removeClass('tl2-content-current');
			jQuery('#schedule  .fw-col-sm-8 .tl2:nth-child(3) .tl2-tabs .tl2-content'+id+'').show();
			jQuery('#schedule  .fw-col-sm-8 .tl2:nth-child(3) .tl2-tabs .tl2-content'+id+'').addClass('tl2-content-current');
		});
		
				

		
		 
})