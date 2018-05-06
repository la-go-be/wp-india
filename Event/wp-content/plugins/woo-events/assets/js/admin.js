;(function($){
	$(document).ready(function() {
		if(jQuery("#we_allday input").prop('checked')){
			jQuery('#we_startdate .exc_mb_timepicker').css('display', 'none');
			jQuery('#we_enddate .exc_mb_timepicker').css('display', 'none');
		}
		jQuery("#we_allday input").click(function(){
			if(jQuery('#we_allday input').prop('checked')){			
				jQuery('#we_startdate .exc_mb_timepicker').css('display', 'none');
				jQuery('#we_enddate .exc_mb_timepicker').css('display', 'none');
			}else{
				jQuery('#we_startdate .exc_mb_timepicker').css('display', 'inline');
				jQuery('#we_enddate .exc_mb_timepicker').css('display', 'inline');
			}
		});
		jQuery('#we_startdate #we_startdate-exc_mb-field-0-date').change(function() {
			jQuery('#we_enddate #we_enddate-exc_mb-field-0-date').val(this.value);
		});

		var we_layout_purpose_obj  = jQuery('.postbox-container #we_layout_purpose select');
		var we_layout_purpose = jQuery('.postbox-container #we_layout_purpose select').val();
		var we_event_settings = jQuery('#event-settings.postbox');
		var we_location_settings = jQuery('#location-settings.postbox');
		
		var we_custom_field = jQuery('.post-type-product .postbox-container #custom-field.postbox');
		var we_sponsor = jQuery('.post-type-product .postbox-container #sponsors-of-event.postbox');
		var we_layout_set = jQuery('.post-type-product .postbox-container #layout-settings.postbox');
		
		if(typeof(we_layout_purpose)!='undefined'){
			if(we_layout_purpose == 'event'){
				we_event_settings.show();
				we_event_settings.addClass('active-c');
				
				we_location_settings.show();
				we_location_settings.addClass('active-c');
				
				we_custom_field.show();
				we_custom_field.addClass('active-c');
				
				we_sponsor.show();
				we_sponsor.addClass('active-c');
				
				we_layout_set.show();
				we_layout_set.addClass();
			}else if(we_layout_purpose == 'woo'){
				we_event_settings.hide();
				we_event_settings.removeClass('active-c');
				
				we_location_settings.hide();
				we_location_settings.removeClass('active-c');
				
				we_custom_field.hide();
				we_custom_field.removeClass('active-c');
				
				we_sponsor.hide();
				we_sponsor.removeClass('active-c');
				
				we_layout_set.hide();
				we_layout_set.removeClass('active-c');
			}
			we_layout_purpose_obj.change(function(event) {
				if(jQuery(this).val() == 'event'){
					we_event_settings.show(200);
					we_event_settings.addClass('active-c');
					
					we_location_settings.show(200);
					we_location_settings.addClass('active-c');
					
					we_custom_field.show();
					we_custom_field.addClass('active-c');
					
					we_sponsor.show();
					we_sponsor.addClass('active-c');
					
					we_layout_set.show();
					we_layout_set.addClass('active-c');
				}else if(jQuery(this).val() == 'woo'){
					we_event_settings.hide(200);
					we_event_settings.removeClass('active-c');
					
					we_location_settings.hide(200);
					we_location_settings.removeClass('active-c');
					
					we_custom_field.hide();
					we_custom_field.removeClass('active-c');
					
					we_sponsor.hide();
					we_sponsor.removeClass('active-c');
					
					we_layout_set.hide();
					we_layout_set.removeClass('active-c');
				}else if(jQuery(this).val() == 'def'){
					we_event_settings.css("display","");
					we_location_settings.css("display","");
					
					we_custom_field.css("display","");
					we_sponsor.css("display","");
					we_layout_set.css("display","");
					
					we_event_settings.removeClass('active-c');
					we_location_settings.removeClass('active-c');
					we_custom_field.removeClass('active-c');
					we_sponsor.removeClass('active-c');
					we_layout_set.removeClass('active-c');
					
				}
			});
		}
		/*- Default venue -*/
		jQuery('.postbox-container #we_default_venue #we_default_venue-exc_mb-field-0').change(function() {
			$('#location-settings').addClass('loading');
			if(!$('#location-settings .wpex-loading').length){
				$('#location-settings').prepend('<div class="wpex-loading"><div class="wpex-spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
			}
			var valu = jQuery(this).val();
           	var param = {
	   			action: 'we_add_venue',
				value: valu
	   		};
	   		$.ajax({
	   			type: "post",
	   			url: woo_events.ajaxurl,
	   			dataType: 'json',
	   			data: (param),
	   			success: function(data){
					if(data != '0')
					{
						$('#location-settings #we_adress .field-item > input').val(data.we_adress);
						$('#location-settings #we_latitude_longitude .field-item > input').val(data.we_latitude_longitude);
						$('#location-settings #we_phone .field-item > input').val(data.we_phone);
						$('#location-settings #we_email .field-item > input').val(data.we_email);
						$('#location-settings #we_website .field-item > input').val(data.we_website);
					}
					$('#location-settings').removeClass('loading');
	   				return true;
	   			}	
	   		});
		});
	
	});
}(jQuery));

function initialize() {
	var input = document.getElementById('we_adress-exc_mb-field-0');
	if(input!=null){
		var autocomplete = new google.maps.places.Autocomplete(input);
	}
}
if (typeof google !== 'undefined' && google.maps.event.addDomListener) {
	google.maps.event.addDomListener(window, 'load', initialize);
};