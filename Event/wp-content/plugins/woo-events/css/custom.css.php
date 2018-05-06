<?php
$we_main_color = get_option('we_main_color');
$hex  = $we_main_color = str_replace("#", "", $we_main_color);

if(strlen($hex) == 3) {
  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
} else {
  $r = hexdec(substr($hex,0,2));
  $g = hexdec(substr($hex,2,2));
  $b = hexdec(substr($hex,4,2));
}
$rgb = $r.','. $g.','.$b;
$we_shop_view = get_option('we_shop_view');
if(($we_shop_view!='list' && !isset($_GET['view']) && !is_search()) || ($we_shop_view!='list' && $_GET['view']!='list' && !is_search()) || (isset($_GET['view']) && $_GET['view']!='list')){
	?>
    .we-calendar-view ul.products:not(.we-search-ajax){ display:none;}
    <?php
}
if($we_main_color!=''){?>
	.we-latest-events-widget .thumb.item-thumbnail .item-evprice,
    .widget.we-latest-events-widget .thumb.item-thumbnail .item-evprice,
	.woocommerce table.my_account_orders th, .woocommerce table.shop_table th, .we-table-lisst .we-table th,
    .we-table-lisst.table-style-2 .we-table .we-first-row,
    .we-calendar #calendar a.fc-event,
    .wpcf7 .we-submit input[type="submit"], .we-infotable .bt-buy.btn,
    .woocommerce ul.products li.product a.button,
    .shop-we-stdate,
    .btn.we-button, .woocommerce div.product form.cart button.button, .woocommerce div.product form.cart div.quantity.buttons_added [type="button"], .woocommerce #exmain-content .we-main.layout-2 .event-details .btn, .we-icl-import .btn,
    .ex-loadmore .loadmore-grid,
    .we-countdonw.list-countdown .cd-number,
    .we-grid-shortcode figure.ex-modern-blog .date,
    .we-grid-shortcode.we-grid-column-1 figure.ex-modern-blog .ex-social-share ul li a,
    .we-grid-shortcode figure.ex-modern-blog .ex-social-share,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
    .we-latest-events-widget .item .we-big-date > div,
    .widget.we-latest-events-widget .item .we-big-date > div,
    .we-timeline-shortcode ul li .timeline-content .tl-tdate,
    .we-timeline-shortcode ul li:after,
    .we-timeline-shortcode ul li .tl-point,
    .we-timeline-shortcode ul li .timeline-content,
    .we-calendar .wpex-spinner > div,
    .we-calendar .widget-style .fc-row:first-child table th,
    .widget-style .fc-day-number.hasevent:after,
    .wt-eventday .day-event-details > div.day-ev-image .item-evprice,
    .woocommerce #exmain-content .we-navigation div a{ background:#<?php echo esc_html($we_main_color);?>}
    .woocommerce #exmain-content h4.wemap-title a, .we-infotable .wemap-details h4.wemap-title a,
    .woocommerce #exmain-content .woo-event-info a,
    .qtip h4,
    .we-tooltip .we-tooltip-content p.tt-price ins, .we-tooltip .we-tooltip-content p.tt-price :not(i),
    .we-table-lisst .we-table td.tb-price, .we-table-lisst .we-table td span.amount{ color:#<?php echo esc_html($we_main_color);?>}
    .woocommerce-page .woocommerce .myaccount_address, .woocommerce-page .woocommerce .address address, .woocommerce-page .woocommerce .myaccount_user,
    .we-calendar #calendar a.fc-event,
    .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register, .woocommerce table.shop_table, .woocommerce table.my_account_orders, .we-table-lisst .we-table{ border-color:#<?php echo esc_html($we_main_color);?>}
    .we-timeline-shortcode ul li .timeline-content:before{ border-right-color:#<?php echo esc_html($we_main_color);?>}
    @media screen and (min-width: 768px) {
        .we-timeline-shortcode ul li:nth-child(odd) .timeline-content:before{ border-left-color:#<?php echo esc_html($we_main_color);?>}
    }
    @media screen and (max-width: 600px) {
    	.woocommerce table.shop_table th.product-remove, .woocommerce table.shop_table td.product-remove,
        .woocommerce table.shop_table_responsive tr:nth-child(2n) td.product-remove,
    	.woocommerce-page table.shop_table tr.cart-subtotal:nth-child(2n-1){background: #<?php echo esc_html($we_main_color);?>}
    }
    .we-table-lisst.table-style-2.table-style-3 .we-table td.tb-viewdetails .btn.we-button,
    .we-table-lisst.table-style-2.table-style-3 .we-table .we-first-row{border-left-color:#<?php echo esc_html($we_main_color);?>}
<?php
}
$we_fontfamily = get_option('we_fontfamily');
$main_font_family = explode(":", $we_fontfamily);
$main_font_family = $main_font_family[0];
if($we_fontfamily!=''){?>
    .woocommerce-page form .form-row .input-text::-webkit-input-placeholder,
    .we-search-form input.form-control::-webkit-input-placeholder,
    .woocommerce-page form .form-row .input-text::-moz-placeholder,
    .woocommerce-page form .form-row .input-text:-ms-input-placeholder,
    .we-search-form input.form-control:-ms-input-placeholder,
    .woocommerce-page form .form-row .input-text:-moz-placeholder,
    .we-search-form input.form-control:-moz-placeholder{
        font-family: "<?php echo esc_html($main_font_family);?>", sans-serif;
    }
    .we-tooltip,
    .woocommerce-cart .woocommerce,
    .woocommerce-account .woocommerce,
    .woocommerce-checkout .woocommerce,
	.we-timeline-shortcode ul li,
    .we-search-form input.form-control,
    .we-table-lisst .we-table,
    .woocommerce #exmain-content .we-sidebar input,
    .woocommerce #exmain-content .we-sidebar,
    .we-content-speaker,
    .woocommerce #exmain-content,
    .we-calendar,
    .we-grid-shortcode, .we-search-form,
    .we-countdonw{
        font-family: "<?php echo esc_html($main_font_family);?>", sans-serif;
    }
<?php }
$we_fontsize = get_option('we_fontsize');
if($we_fontsize!=''){?>
    .we-calendar,
    .we-timeline-shortcode ul li,
    .woocommerce-page .woocommerce,
    .woocommerce #exmain-content,
    .woo-event-toolbar .we-showdrd,
    .we-social-share ul li,
    body.woocommerce-page #exmain-content .related ul.products li.product h3,
    .woocommerce #exmain-content div.product form.cart .variations td.label,
    .we-table-lisst .we-table ,
    .we-table-lisst .we-table td h3,
    .wpcf7 .we-submit,
    .woocommerce form .form-row input.input-text, .woocommerce form .form-row textarea,
    .wpcf7 .we-submit input[type="text"],
    .woocommerce-cart table.cart td.actions .coupon .input-text,
    .wpcf7 .we-submit textarea,
    .wpcf7 .we-submit input[type="date"],
    .wpcf7 .we-submit input[type="number"],
    .woocommerce .select2-container .select2-choice,
    .wpcf7 .we-submit input[type="email"],
    .woocommerce-page .woocommerce .myaccount_user,
    .woocommerce table.shop_table .quantity input,
    .woocommerce-cart table.cart td, .woocommerce-cart table.cart th, .woocommerce table.my_account_orders th, .woocommerce table.my_account_orders td, .we-table-lisst .we-table td, .we-table-lisst .we-table th,
    .wooevent-search .btn.we-product-search-dropdown-button,
    .we-content-speaker,
    .we-grid-shortcode figure.ex-modern-blog .grid-excerpt,
    .woocommerce #exmain-content .we-navigation div a,
    .woo-event-toolbar .we-viewas .we-viewas-dropdown-button,
    .woocommerce #exmain-content a, .woocommerce #exmain-content,
    .btn.we-button, .woocommerce div.product form.cart button.button, .woocommerce div.product form.cart div.quantity.buttons_added [type="button"], .woocommerce #exmain-content .we-main.layout-2 .event-details .btn, .we-icl-import .btn,
    .ex-loadmore .loadmore-grid,
    .woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register, .woocommerce table.shop_table, 
    .woocommerce table.my_account_orders, .we-table-lisst .we-table,
    .woo-event-toolbar .we-search-form .we-search-dropdown button,
    .we-countdonw.list-countdown .cd-title a{
        font-size: <?php echo esc_html($we_fontsize) ?>;
    }
    .woocommerce-page form .form-row .input-text::-webkit-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control::-webkit-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .woocommerce-page form .form-row .input-text::-moz-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .woocommerce-page form .form-row .input-text:-ms-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control:-ms-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .woocommerce-page form .form-row .input-text:-moz-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control:-moz-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }

<?php }
$we_hfont = get_option('we_hfont');
$h_font_family = explode(":", $we_hfont);
$h_font_family = $h_font_family[0];
if($h_font_family!=''){?>
	.qtip h4,
    .we-calendar .widget-style .fc-row:first-child table th,
    .we-timeline-shortcode ul li .timeline-content h3 a,
    .we-table-lisst .we-table td h3 a,
    .we-grid-shortcode figure.ex-modern-blog h3 a,
    .woocommerce-page .woocommerce h4,
    .woocommerce #exmain-content h4.wemap-title a, .we-infotable .wemap-details h4.wemap-title a,
    .woocommerce #exmain-content h1, .woocommerce-page .woocommerce h2, .woocommerce-page .woocommerce h3, 
    .woocommerce-page.woocommerce-edit-account .woocommerce fieldset legend, .woocommerce #exmain-content h2, body.woocommerce div.product .woocommerce-tabs .panel h2, .woocommerce div.product .product_title, .we-content-speaker h3, figure.ex-modern-blog h3, .woocommerce #exmain-content h3,
    .archive.woocommerce #exmain-content h2,
    .archive.woocommerce #exmain-content h3,
    .woocommerce #exmain-content .we-sidebar h2,
    .woocommerce #exmain-content .we-sidebar h3,
    .woocommerce #exmain-content .we-content-custom h1,
    .woocommerce #exmain-content .product > *:not(.woocommerce-tabs) h1,
    .woocommerce-page .woocommerce .product > *:not(.woocommerce-tabs) h2,
    .woocommerce-page .woocommerce .product > *:not(.woocommerce-tabs) h3,
    .woocommerce-page.woocommerce-edit-account .woocommerce fieldset legend,
    .woocommerce #exmain-content .product > *:not(.woocommerce-tabs) h2,
    body.woocommerce div.product .woocommerce-tabs .panel h2:first-child,
    .woocommerce div.product .product_title,
    .we-content-speaker h3,
    figure.ex-modern-blog h3,
    .woocommerce #reviews #comments h2,
    .woocommerce #reviews h3,
    .woocommerce #exmain-content .product > *:not(.woocommerce-tabs) h3{
        font-family: "<?php echo esc_html($h_font_family);?>", sans-serif;
    }
<?php }

$we_hfontsize = get_option('we_hfontsize');
if($we_hfontsize!=''){?>
	.we-calendar h2,
    .we-calendar .widget-style .fc-row:first-child table th,
    .we-timeline-shortcode ul li .timeline-content h3,
	.woocommerce #exmain-content h1, .woocommerce-page .woocommerce h2, .woocommerce-page .woocommerce h3, .woocommerce-page.woocommerce-edit-account .woocommerce fieldset legend, .woocommerce #exmain-content h2, body.woocommerce div.product .woocommerce-tabs .panel h2, .woocommerce div.product .product_title, .we-content-speaker h3, figure.ex-modern-blog h3, .woocommerce #exmain-content h3{
        font-size: <?php echo esc_html($we_hfontsize); ?>;
    }
<?php }

$we_metafont = get_option('we_metafont');
$meta_font_family = explode(":", $we_metafont);
$meta_font_family = $meta_font_family[0];
if($meta_font_family!=''){?>
	.shop-we-short-des .cat-meta *, .woocommerce #exmain-content .shop-we-short-des .cat-meta a, .shop-we-more-meta span,
    .we-latest-events-widget .event-details span,
    .widget.we-latest-events-widget .event-details span,
    .we-grid-shortcode figure.ex-modern-blog .we-more-meta span,
	.woo-event-info span.sub-lb{
        font-family: "<?php echo esc_html($meta_font_family);?>", sans-serif;
    }
<?php }

$we_matafontsize = get_option('we_matafontsize');
if($we_matafontsize!=''){?>
	.shop-we-short-des .cat-meta *, .woocommerce #exmain-content .shop-we-short-des .cat-meta a, .shop-we-more-meta span,
    .we-latest-events-widget .event-details span,
    .widget.we-latest-events-widget .event-details span,
    .we-grid-shortcode figure.ex-modern-blog .we-more-meta span,
	.woo-event-info span.sub-lb{
        font-size: <?php echo esc_html($we_matafontsize); ?>;
    }
<?php }?>
@media screen and (max-width: 600px) {
	/*
	Label the data
	*/
	.woocommerce-page table.shop_table td.product-name:before {
		content: "<?php _e( 'Product', 'woocommerce' ); ?>";
	}
	
	.woocommerce-page table.shop_table td.product-price:before {
		content: "<?php _e( 'Price', 'woocommerce' ); ?>";
	}
	
	.woocommerce-page table.shop_table td.product-quantity:before {
		content: "<?php _e( 'Quantity', 'woocommerce' ); ?>";
	}
	
	.woocommerce-page table.shop_table td.product-subtotal:before {
		content: "<?php _e( 'Subtotal', 'woocommerce' ); ?>";
	}
	
	.woocommerce-page table.shop_table td.product-total:before {
		content: "<?php _e( 'Total', 'woocommerce' ); ?>";
	}
}
<?php


$we_custom_css = get_option('we_custom_css');
if($we_custom_css!=''){
	echo $we_custom_css;
}