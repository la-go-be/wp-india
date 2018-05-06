/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title,  .site-description' ).css( {
					'clip': 'auto',
					'position': 'static'
				} );

				$( '.site-title a' ).css( {
					'color': to
				} );
			}
		} );
	} );
	// Primary color
	wp.customize('primary_color', function(value){
       value.bind(function(newval){
           $('.bg-color-primary, article.page .post-cates a, .timelines-navigation a:hover, .timelines-navigation a.active, .fw_form_fw_form input[type="submit"], .apimap_form input[type="submit"], .countdown-wrapper p.event-badge, .registration-wrapper .price-table .price-items .entry .features .feature-price, .fw-btn.fw-btn-1, .widget-title::before, .widget_mailchimp_form button, article.post .post-cates a, .post-paging .page-numbers, #commentform input#submit').css('background', newval);
       })
    });
	// Secondary Color
	wp.customize('secondary_color', function(value){
       value.bind(function(newval){
           $('.color-second, a:hover, article.page a:hover, .timeline > li > .timeline-panel h4.timeline-place, .tweet-entry .tw-body a, .current_page_item > a, .current-menu-item > a, .current_page_ancestor > a, .current-menu-parent > a, .active > a, .widget-area aside.widget a:hover, .widget_rss ul a:hover, .widget_recent_comments ul a:hover, .widget_mailchimp_form .desctiption a, .widget_recent_posts_thumb .recent-post-entry:hover h4, article.post a:hover').css('color', newval);
           	$('.timeline > li:hover .timeline-badge, .timeline::before, .ht-carousel.speakers .owl-nav > div, .registration-wrapper .price-table .price-items .entry .features span.item i, .registration-wrapper .price-table .price-items .entry:hover .features .feature-price, .registration-wrapper .price-table .price-items .entry.current .features .feature-price, .registration-wrapper .price-table .price-items .entry:hover p.name i, .registration-wrapper .price-table .price-items .entry:hover p.name i, .registration-wrapper .price-table .price-items .entry.current p.name i').css('background-color', newval);
       })
    });
	// Footer color

	// Heading color
	wp.customize('heading_color', function(value){
		value.bind(function(newval){
			$('.color-heading, article.page .entry-title, .fw-block-info .info-heading, .textblock-shortcode .text-heading, .timelines-navigation a, .fw_form_fw_form input[type="submit"], .tweet-entry .tw-head .tw-user h3, .fw-testimonials-item .fw-testimonials-author .author-name, .ht-meta-block p, .ht-online-gallery .follow-link a, .apimap_form input[type="submit"], .apimap_form .direction-label, .countdown-wrapper p.event-badge, .registration-wrapper .price-table .price-items .entry .features .feature-price strong, .event-register-form, .event-register-form input[type="submit"], .event-register-form select[type="submit"], .event-register-form span.price-display[type="submit"], .fw-heading .fw-special-title, .fw-heading .fw-special-subtitle_2, .fw-btn.fw-btn-1, .main-navigation li, .widget-title, .widget_categories .cat-item, .widget_mailchimp_form button, .widget_recent_posts_thumb .recent-post-entry .post-title, article.post .entry-title, .post-author .au-name, .comment-list .block-1 .reply, .comment-list .block-1 cite, #commentform, #commentform input#submit, .comments-title').css('color', newval);
			$('.textblock-shortcode .text-link a').css('color', newval);
		});
	});
	/*Body Color*/
	wp.customize('body_color', function(value){
       value.bind(function(newval){
           $('body, .fw-testimonials .fw-testimonials-text, .accordion-content, .color-body, article.page .entry-content, .timeline > li > .timeline-panel h4, .fw_form_fw_form sup, .tweet-entry .tw-head .tw-user p, .fw-testimonials-item, .ht-accordion .accordion-title, .ht-accordion .accordion-content, .ht-meta-block p span, .apimap_form .c-enter input, .registration-wrapper .price-table .price-items .entry .features, .registration-wrapper .price-table .price-desc, footer, footer .social-link a::before, .widget-area, article.post .entry-content, article.post .entry-meta, .post-author .au-social, .comment-list .block-2, .single .meta.meta-social a.sd-button::before, .event-register-form .mail-chimp span.desc').css('color', newval);
       })
    });
} )( jQuery );