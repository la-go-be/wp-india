;(function($){
		function ex_carousel(){
			$(".is-carousel").each(function(){
				var carousel_id = $(this).attr('id');
				var auto_play = $(this).data('autoplay');
				var items = $(this).data('items');
				var navigation = $(this).data('navigation');
				var pagination = $(this).data('pagination');
				var paginationNumbers = $(this).data('paginationNumbers');
				//if (typeof owlCarousel === "undefined") { return;}
				if($(this).hasClass('single-carousel')){ //single style
					$(this).owlCarousel({
						singleItem:true,
						autoHeight: true,
						autoPlay: auto_play?true:false,
						navigation: navigation?true:false,
						autoHeight : true,
						navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
						addClassActive : true,
						pagination:pagination?true:false,
						paginationNumbers:paginationNumbers?true:false,
						stopOnHover: true,
						slideSpeed : 600,
						transitionStyle : "fade"
					});
				}else{
					$(this).owlCarousel({
						autoPlay: auto_play?true:false,
						items: items?items:4,
						itemsDesktop: items?false:4,
						itemsDesktopSmall: items?(items>3?3:false):3,
						singleItem: items==1?true:false,
						//autoHeight : true,
						navigation: navigation?true:false,
						paginationNumbers:paginationNumbers?true:false,
						navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
						pagination:pagination?true:false,
						slideSpeed: 500,
						addClassActive : true
					});
				}
			});
		}	
		$(document).ready(function() {
			ex_carousel();
			jQuery( '.single .we-main div.quantity:not(.buttons_added), .single .we-main td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" id="add_ticket" class="plus" />' ).prepend( '<input type="button" value="-" id="minus_ticket" class="minus" />' );
		jQuery('.single:not(.fusion-body) .we-main:not(.we-remove-click) .buttons_added #minus_ticket').click(function(e) {
			var value = parseInt(jQuery(this).next().val()) - 1;
			if(value>0){
				jQuery(this).next().val(value);
			}
		});
		if(jQuery(".submit-time").length>0){
			jQuery(".submit-time").timepicker();
		}
		if(jQuery(".submit-date").length>0){
			jQuery(".submit-date").datepicker({
					"todayHighlight" : true,
					"startDate": new Date(),
					"autoclose": true
			});
		}
		jQuery('.single:not(.fusion-body) .we-main:not(.we-remove-click) .buttons_added #add_ticket').click(function(e) {
			var value = parseInt(jQuery(this).prev().val()) + 1;
			jQuery(this).prev().val(value);
		});
		function getDataAttr(date) {
			var $mont = (date.getMonth() + 1);
			$mont = parseFloat($mont);
			if($mont < 10){
				return date.getFullYear() + "-0" + ($mont) + "-" + (date.getDate().toString().length === 2 ? date.getDate() : "0" + date.getDate());
			}else{
				return date.getFullYear() + "-" + ($mont) + "-" + (date.getDate().toString().length === 2 ? date.getDate() : "0" + date.getDate());
			}
		};
		function addClassByDate(date,id) {
			var dataAttr = getDataAttr(date);
			$("[data-date='" + dataAttr + "']").addClass("hasevent");
			var ids = $("[data-date='" + dataAttr + "']").attr( "data-ids");
			if(typeof ids !='undefined'){
				ids = ids+','+id;
			}else{
				ids = id;
			}
			$("[data-date='" + dataAttr + "']").attr( "data-ids", ids );
		}
		$(".we-calendar").each(function(){
			var $this = $(this);
			var id_crsc  		= $(this).data('id');
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var calendar_cat  		= $('#'+id_crsc+' input[name=calendar_cat]').val();
			var calendar_orderby  		= $('#'+id_crsc+' input[name=calendar_orderby]').val();
			var calendar_view  		= $('#'+id_crsc+' input[name=calendar_view]').val();
			var calendar_defaultDate  		= $('#'+id_crsc+' input[name=calendar_defaultDate]').val();
			var calendar_firstDay  		= $('#'+id_crsc+' input[name=calendar_firstDay]').val();
			var show_bt  		= $('#'+id_crsc+' input[name=show_bt]').val();
			var curent_url  		= $('#'+id_crsc+' input[name=curent_url]').val();
			var events;
			var $defaultView =  'month';
			var $target = 'bottom';
			if(calendar_view == 'week'){
				$defaultView =  'agendaWeek';
				$target = 'mouse';
			}else if(calendar_view == 'day'){
				$defaultView =  'agendaDay';
				$target = 'mouse';
			}else if(calendar_view != ''){
				$defaultView = calendar_view;
				if(calendar_view != 'month'){ $target = 'mouse';}
			}
			$('#'+id_crsc+' #calendar').fullCalendar({
				header: {
					left: 'title',
					center: '',
					right: 'prev,next'
				},
				defaultDate: calendar_defaultDate,
				defaultView: $defaultView,
				firstDay: calendar_firstDay,
				lang: $('#'+id_crsc+' input[name=calendar_language]').val(),
				eventLimit: false, // allow "more" link when too many events
				nextDayThreshold: '00:00:00',
				/*minTime: '09:00:00',
				maxTime: '22:00:00',*/
				events: function(start, end, timezone, callback) {
					$('#'+id_crsc).addClass('loading');
					$.ajax({
						type: 'GET',
						url: ajax_url,
						dataType: 'json',
						data: {
							action: 'we_get_events_calendar',
							start: start.unix(),
							end: end.unix(),
							category: calendar_cat,
							orderby: calendar_orderby,
							show_bt: show_bt,
							curent_url: curent_url,
							type:calendar_view,
						},
						success: function(data){
							$('#'+id_crsc).removeClass('loading');
							we_event_ofday();
							if(data != '0')
							{
								events = (data);
								if(typeof(events)!='object' || events==null){
									$('#'+id_crsc+' .calendar-info').removeClass('hidden');
								}else{
									$('#'+id_crsc+' .calendar-info').addClass('hidden');
								}
								callback(events);
							}
						}
					});
				},
				eventRender: function(event, element) {
					if($('#'+id_crsc+' #calendar').hasClass('widget-style')){
						var evStartDate = new Date(event.start),
							evFinishDate = new Date(event.end);
						if (event.end) {
							while (evStartDate < evFinishDate) {
								addClassByDate(evStartDate,event.id);
								evStartDate.setDate(evStartDate.getDate() + 1);
							}
						} else {
							addClassByDate(evStartDate,event.id);
						}
					}else{
						element.find('.fc-title').html(event.title);
						var content = '<div class="we-tooltip">'
						+'<div class="we-tooltip-content"><h4>'+event.title+'</h4>'
						+'<p><i class="fa fa-calendar"></i>'+event.startdate+'</p>'
						+(event.enddate && '<p><i class="fa fa-calendar-times-o"></i>'+event.enddate+'</p>' || '')
						+'<p class="we-info"><i class="fa fa-map-marker"></i> '+event.location + '</p>'
						+(event.status && '<p><i class="fa fa-ticket"></i> '+event.status+'</p>' || '')
						+(event.price && '<p class="tt-price"><i class="fa fa-shopping-basket"></i><span>'+event.price+'</span></p>' || '')
						+(event.url_ontt && '<p class="tt-bt"><a href="'+event.url_ontt+'" class="btn btn btn-primary we-button">'+event.text_onbt+'</a></p>' || '')
						+'</div><div class="tt-image"><img src="'+event.thumbnail+'"/></div</div>';
						element.qtip({
							content: {
								text:content,
							},
							style: {
								tip: {
									corner: false,
									width: 12
								},
								classes: 'ex-qtip'
							},
							position: {
								my: 'bottom left',
								at: 'bottom center',
								target:$target,
							},
							show: {
							  solo: true,
							  
						   },
						   hide: {
							  delay: 200,
							  fixed: true,
							  effect: function() { $(this).fadeOut(250); }
						   },
						});
					}
				},
				eventAfterAllRender: function(event, element) {
					$( '.fc-day-number.fc-state-highlight' ).trigger( "click" );
				}
			});
		});
		we_event_ofday();
		function we_event_ofday(){
			jQuery(".fc-day-number").on('click', function() {
				if($(this).hasClass('hasevent')){
					var ids = $(this).data('ids');
					var id_crsc = $(this).closest('.we-calendar').data('id');
					$('#'+id_crsc+' .fc-day-number').removeClass('fc-state-highlight');
					$('#'+id_crsc).addClass('loading');
					$('#'+id_crsc+' .wt-eventday').addClass('de-active');
					$(this).addClass('fc-state-highlight');
					var param = {
						action: 'ex_loadevent_ofday',
						param_day: $(this).data('date'),
						ids:ids,
					};
					var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
					$.ajax({
						type: "post",
						url: ajax_url,
						dataType: 'html',
						data: (param),
						success: function(data){
							$('#'+id_crsc).removeClass('loading');
							$('#'+id_crsc+' .wt-eventday').removeClass('de-active');
							if(data != '0')
							{
								if(data == ''){ 
									$('#'+id_crsc+' .wt-eventday').html('');
								}
								else{
									$('#'+id_crsc+' .wt-eventday .day-event-details').remove();
									var $g_container = $('#'+id_crsc+' .wt-eventday');
									$g_container.append(data);
									setTimeout(function(){ 
										$('#'+id_crsc+' .wt-eventday').addClass("active");
									}, 200);
								}
							}else{$('#'+id_crsc+' .wt-eventday').html('');}
						}
					});
				}
			});
			return false;
		};
		$(".we-coundown-item").each(function(){
			var cd_id = $(this).attr('id');
			var day_text  		= $('.we-countdonw input[name=cd-days]').val();
			var hr_text  		= $('.we-countdonw input[name=cd-hr]').val();
			var min_text  		= $('.we-countdonw input[name=cd-min]').val();
			var sec_text  		= $('.we-countdonw input[name=cd-sec]').val();
			var cd_date = $(this).data('date');
			var cd_date_timezone = $(this).data('timezone');
			if(cd_date_timezone!='' && cd_date_timezone!='def'){
				cd_date_timezone = cd_date_timezone*60;
				var cd_date_tz = moment($(this).data('date'));
				
				var date_another = cd_date_tz.clone();
				date_another.utcOffset(cd_date_timezone);
				date_another.add(cd_date_tz.utcOffset() - date_another.utcOffset(), 'minutes');
				cd_date = date_another.toDate();
				
			}
			$(this).wecountdown(cd_date, function(event) {
				$(this).html(
				 event.strftime(''
				 + '<div class="cd-item"><span class="cd-number">%D</span><span> '+day_text+' </span></div>'
				 + '<div class="cd-item"><span class="cd-number">%H</span><span> '+hr_text+' </span></div>'
				 + '<div class="cd-item"><span class="cd-number">%M</span><span> '+min_text+' </span></div>'
				 + '<div class="cd-item"><span class="cd-number">%S</span><span> '+sec_text+'</span></div>'
				 ));
			});
		});
		jQuery(".we-search-dropdown:not(.we-sfilter)").on('click', 'li a', function(){
			jQuery(".we-search-dropdown:not(.we-sfilter) .we-search-dropdown-button .button-label").html(jQuery(this).text());
			jQuery(".we-product-cat").val(jQuery(this).data('value'));
			jQuery(".we-search-dropdown").removeClass('open');
			return false;
		});
		jQuery(".button-scroll").click(function() {
			var $scrtop = jQuery(".summary").offset().top;
			jQuery('html, body').animate({
				scrollTop: ($scrtop-100)
			}, 500);
		});
		
		$('.input-group-btn:not(.we-sfilter)').on('click', function(e) {
			$menu = $(this);
			if (!$menu.hasClass('open')) {
				$menu.addClass('open');
		
				$(document).one('click', function closeTooltip(e) {
					if ($menu.has(e.target).length === 0 && $('.input-group-btn').has(e.target).length === 0) {
						$menu.removeClass('open');
					} else if ($menu.hasClass('open')) {
						$(document).one('click', closeTooltip);
					}
				});
			} else {
				$menu.removeClass('open');
			}
		}); 
		$('.input-group-btn.we-sfilter').on('click', function(e) {
			$this = $(this);
			var id_crsc  		= $this.data('id');
			if(!$this.hasClass('we-sfilter-close')){
				$this.addClass('we-sfilter-close');
				$('#'+id_crsc+' .we-filter-expand').addClass('active');
			}else{
				$this = $(this);
				$this.removeClass('we-sfilter-close');
				$('#'+id_crsc+' .we-filter-expand').removeClass('active');
			}
		});
		$('.loadmore-grid').on('click',function() {
			var $this_click = $(this);
			if($this_click.hasClass('table-loadmore')){ return;}
			$this_click.addClass('disable-click');
			var id_crsc  		= $this_click.data('id');
			var n_page = $('#'+id_crsc+' input[name=num_page_uu]').val();
			$('#'+id_crsc+' .loadmore-grid').addClass("loading");
			var param_query  		= $('#'+id_crsc+' input[name=param_query]').val();
			var page  		= $('#'+id_crsc+' input[name=current_page]').val();
			var num_page  		= $('#'+id_crsc+' input[name=num_page]').val();
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
				var param = {
					action: 'ex_loadmore_grid',
					param_query: param_query,
					page: page*1+1,
					param_shortcode: param_shortcode,
				};
	
				$.ajax({
					type: "post",
					url: ajax_url,
					dataType: 'html',
					data: (param),
					success: function(data){
						if(data != '0')
						{
							n_page = n_page*1+1;
							$('#'+id_crsc+' input[name=num_page_uu]').val(n_page)
							if(data == ''){ 
								$('#'+id_crsc+' .loadmore-grid').remove();
							}
							else{
								$('#'+id_crsc+' input[name=current_page]').val(page*1+1);
								var $g_container = $('#'+id_crsc+' .grid-container');
								$g_container.append(data);
								setTimeout(function(){ 
									$('#'+id_crsc+' .grid-row').addClass("active");
								}, 200);
								$('#'+id_crsc+' .loadmore-grid').removeClass("loading");
								$this_click.removeClass('disable-click');
							}
							if(n_page == num_page){
								$('#'+id_crsc+' .loadmore-grid').remove();
							}
							
						}else{$('.row.loadmore').html('error');}
					}
				});
			return false;	
		});
		$('.loadmore-grid.table-loadmore').on('click',function() {
			var $this_click = $(this);
			$this_click.addClass('disable-click');
			var id_crsc  		= $this_click.data('id');
			var n_page = $('#'+id_crsc+' input[name=num_page_uu]').val();
			$('#'+id_crsc+' .loadmore-grid').addClass("loading");
			var param_query  		= $('#'+id_crsc+' input[name=param_query]').val();
			var page  		= $('#'+id_crsc+' input[name=current_page]').val();
			var num_page  		= $('#'+id_crsc+' input[name=num_page]').val();
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
				var param = {
					action: 'ex_loadmore_table',
					param_query: param_query,
					page: page*1+1,
					param_shortcode: param_shortcode,
				};
	
				$.ajax({
					type: "post",
					url: ajax_url,
					dataType: 'html',
					data: (param),
					success: function(data){
						if(data != '0')
						{
							n_page = n_page*1+1;
							$('#'+id_crsc+' input[name=num_page_uu]').val(n_page)
							if(data == ''){ 
								$('#'+id_crsc+' .loadmore-grid').remove();
							}else{
								$('#'+id_crsc+' input[name=current_page]').val(page*1+1);
								var $g_container = $('#'+id_crsc+' tbody');
								$g_container.append(data);
								setTimeout(function(){ 
									$('#'+id_crsc+' tbody .tb-load-item').addClass("active");
								}, 200);
								$('#'+id_crsc+' .loadmore-grid').removeClass("loading");
								$this_click.removeClass('disable-click');
							}
							if(n_page == num_page){
								$('#'+id_crsc+' .loadmore-grid').remove();
							}
						}else{$('.row.loadmore').html('error');}
					}
				});
			return false;	
		});
		function we_remove_ft(){
			$('.we-active-filters span').on('click', function(e) {
				var $this = $(this);
				var id_crsc  		= $this.data('id');
				var data_rm = $this.data('filter'); 
				var cat_data = jQuery(".woo-event-toolbar .we-product-cat").val();
				var tag_data = jQuery(".woo-event-toolbar .we-product-tag").val();
				var year_data = jQuery(".woo-event-toolbar .we-product-year").val();
				if(cat_data.indexOf(data_rm) >= 0){ 
					var cat_data = cat_data.replace(data_rm, "");
					jQuery(".woo-event-toolbar .we-product-cat").val(cat_data);
				}else if(tag_data.indexOf(data_rm) >= 0){ 
					var tag_data = tag_data.replace(data_rm, "");
					jQuery(".woo-event-toolbar .we-product-tag").val(tag_data);
				}else if(year_data.indexOf(data_rm) >= 0){ 
					var year_data = year_data.replace(data_rm, "");
					jQuery(".woo-event-toolbar .we-product-year").val(year_data);
				}
				jQuery('.we-filter-expand a[data-value="'+data_rm+'"]').removeClass('active');
				we_ajax_search(id_crsc,$this);
				$this.remove();
			});	
			return false;
		}
		function we_ajax_search(id_crsc,$this){
			$('#'+id_crsc).addClass('loading');
			$('#'+id_crsc).addClass('remove-view-tb');
			var key_word  		= $('.wooevent-search-form input[name=s]').val();
			var cat_search  		= $('#'+id_crsc+' input[name=product_cat]').val();
			var tag_search  		= $('#'+id_crsc+' input[name=product_tag]').val();
			var year_search  		= $('#'+id_crsc+' input[name=product_year]').val();
			var ajax_url  		= $('input[name=ajax_url]').val();
			var param = {
				action: 'we_search_ajax',
				key_word: key_word,
				cat_search: cat_search,
				tag: tag_search,
				year: year_search,
			};

			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'html',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data == ''){ 
						}
						else{
							$this.removeClass('disable-click');
							$( '#'+id_crsc+' #calendar').fadeOut();
							$( '.we-calendar-view ul.products, .we-calendar-view .woocommerce-ordering, .we-calendar-view .woocommerce-pagination, .we-calendar-view .woocommerce-result-count').fadeOut({
								duration:0,
								complete:function(){
									$( this ).remove();
								}
							});
							$('#'+id_crsc).removeClass("loading");
							$( '#'+id_crsc).append(data);
						}
						we_remove_ft();
					}else{ alert('error');}
				}
			});
			return false;
		}
		$('#we-ajax-search button.we-search-submit').on('click',function() {
			var $this_click = $(this);
			var id_crsc  		= $this_click.data('id');
			$this_click.addClass('disable-click');
			we_ajax_search(id_crsc,$this_click);
			return false;	
		});
		$('.we-filter-expand a').on('click', function(e) {
			e.preventDefault();
			var $this = $(this);
			var id_crsc  		= $this.data('id');
			$('#'+id_crsc).addClass('remove-view-tb');
			if($this.hasClass('active')){ return;}
			else{ $this.addClass('active'); }
			var cat_data = jQuery(".woo-event-toolbar .we-product-cat").val();
			if(cat_data!=''){ cat_data = cat_data+','; }
			var tag_data = jQuery(".woo-event-toolbar .we-product-tag").val();
			if(tag_data!=''){ tag_data = tag_data+','; }
			var year_data = jQuery(".woo-event-toolbar .we-product-year").val();
			if(year_data!=''){ 
				year_data = year_data+',';
			}
			if($this.hasClass('add-cat')){
				jQuery(".woo-event-toolbar .we-product-cat").val(cat_data+$this.data('value'));
			}else if($this.hasClass('add-tag')){
				jQuery(".woo-event-toolbar .we-product-tag").val(tag_data+$this.data('value'));
			}else if($this.hasClass('add-year')){
				jQuery(".woo-event-toolbar .we-product-year").val(year_data+$this.data('value'));
			}
			$('.woo-event-toolbar .we-active-filters').append('<span data-id="'+id_crsc+'" data-filter="'+$this.data('value')+'">'+ $this.html() +'<i class="fa fa-times" aria-hidden="true"></i></span');
			we_ajax_search(id_crsc,$this);
			return false;
		});
		
	});	
}(jQuery));
/*jQuery(document).ready(function ($) {
	$('.product:not(.product-type-external) .single_add_to_cart_button').on('click', function(event){
		event.preventDefault();
		$(this).parents('.cart').submit();		
	 	event.stopPropagation();
	});	
});*/