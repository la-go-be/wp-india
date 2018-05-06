jQuery(document ).ready(function() {
	
	/*jQuery('p#billing_postcode_field #billing_postcode').on("change paste keyup", function() {
  	var value=jQuery(this).text();
	//alert(value);
	var lastChar = value.substr(0, 2);
	//alert(lastChar);
		$.ajax({
			url: "https://sc.lagobe.com/apis/location/provinces?zipcode="+value,
			type: "GET"
		})
		.done(function(data) {
			var city = 'TH='+lastChar;
			//alert(lastChar);
			//alert(city);
			jQuery("#billing_state").find("option:contains("+city+")").each(function()
			{
			 if( jQuery(this).text() == city )
			 {
			  jQuery(this).attr("selected","selected");
			  }
			});

	   		jQuery('#billing_city').val(data);
			//alert(jQuery('#billing_city').val(data));
		})
	});
	*/
	
	
	
	
	jQuery('.yith-wcpsc-product-table tr th').each(function() {
		jQuery(this).wrapInner( "<span></span>");
	});	
	
	jQuery('.yith-wcpsc-product-table tr th span').each(function() {
		var thval = jQuery(this).text().toLowerCase();;
		var thr = thval.trim();
		//var tetetr = thr.charAt(0);
		jQuery(this).attr('data-id',thr);
		jQuery(this).attr('data-size','size-'+thr);
		
	});
	
	jQuery('.select2OptionPicker ul li a').each(function() {	
		var asa = jQuery(this).text();
		var firstc = asa.charAt(0);
		jQuery(this).attr('data-id',firstc);
	});
	jQuery('.yith-wcpsc-product-table tr th span').click(function(){ 
					
					jQuery('.variations tr:nth-child(2) .value .tawcvs-swatches span').each(function(){
						if (jQuery(this).hasClass('selected')) {
							jQuery(this).click();
						}
					});																		 
					
					jQuery('.yith-wcpsc-product-table tr th span').removeClass('active');
					jQuery('.yith-wcpsc-product-table tr th span').removeAttr('style');
					jQuery(this).css('color','#fff');
					jQuery(this).addClass('active');
					
					var dsize = jQuery(this).attr('data-size').toLowerCase();
					var x = jQuery(this).parent().index();
					var y = x+1;
					jQuery('.yith-wcpsc-product-table tr td').removeAttr('style');
					jQuery('.yith-wcpsc-product-table tr td:nth-child('+y+')').css('color','white');
					
					
						jQuery('.variations tr:nth-child(2) .value .tawcvs-swatches span').each(function(){
							if(jQuery(this).attr('data-value')==dsize){
								jQuery(this).click();   
							} else if(jQuery(this).attr('data-value') != dsize){
								jQuery(this).unbind('click');
							}
						});
		});
		
		
		
		
	
        

		});	
		
		
		
		
		
		
		

	
	
	
	
