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
    .we-table-lisst.table-style-2 .we-table .we-first-row,
    .we-calendar #calendar a.fc-event,
    .wpcf7 .we-submit input[type="submit"], .we-infotable .bt-buy.btn,
    .shop-we-stdate,
    .btn.we-button, .we-icl-import .btn,
    .ex-loadmore .loadmore-grid,
    .we-countdonw.list-countdown .cd-number,
    .we-grid-shortcode figure.ex-modern-blog .date,
    .we-grid-shortcode.we-grid-column-1 figure.ex-modern-blog .ex-social-share ul li a,
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
    .we-table-lisst .we-table th,
    .we-grid-shortcode figure.ex-modern-blog .ex-social-share{ background:#<?php echo esc_html($we_main_color);?>}
    
    .we-timeline-shortcode ul li .timeline-content:before{ border-right-color:#<?php echo esc_html($we_main_color);?>}
    @media screen and (min-width: 768px) {
        .we-timeline-shortcode ul li:nth-child(odd) .timeline-content:before{ border-left-color:#<?php echo esc_html($we_main_color);?>}
    }
    
    .qtip h4,
    .we-tooltip .we-tooltip-content p.tt-price ins, .we-tooltip .we-tooltip-content p.tt-price :not(i),
    .we-table-lisst .we-table td.tb-price, .we-table-lisst .we-table td span.amount{ color:#<?php echo esc_html($we_main_color);?>}
    .we-calendar #calendar a.fc-event,
    .we-table-lisst .we-table{ border-color:#<?php echo esc_html($we_main_color);?>}
    
    .we-table-lisst.table-style-2.table-style-3 .we-table td.tb-viewdetails .btn.we-button,
    .we-table-lisst.table-style-2.table-style-3 .we-table .we-first-row{border-left-color:#<?php echo esc_html($we_main_color);?>}
    
<?php
}
$we_fontfamily = get_option('we_fontfamily');
$main_font_family = explode(":", $we_fontfamily);
$main_font_family = $main_font_family[0];
if($we_fontfamily!=''){?>
    .we-calendar,
    .we-search-form input.form-control::-webkit-input-placeholder,
    .we-search-form input.form-control,
    .we-search-form input.form-control:-ms-input-placeholder,
    .we-search-form input.form-control:-moz-placeholder,
    .we-table-lisst .we-table,
    .we-content-speaker,
    .we-tooltip,
    .we-countdonw{
        font-family: "<?php echo esc_html($main_font_family);?>", sans-serif;
    }
<?php }
$we_fontsize = get_option('we_fontsize');
if($we_fontsize!=''){?>
    .we-calendar,
    .woo-event-toolbar .we-showdrd,
    .we-social-share ul li,
    .we-table-lisst .we-table ,
    .we-table-lisst .we-table td h3,
    .wpcf7 .we-submit,
    .wpcf7 .we-submit input[type="text"],
    .wpcf7 .we-submit textarea,
    .wpcf7 .we-submit input[type="date"],
    .wpcf7 .we-submit input[type="number"],
    .wpcf7 .we-submit input[type="email"],
    .we-table-lisst .we-table td, .we-table-lisst .we-table th,
    .wooevent-search .btn.we-product-search-dropdown-button,
    .we-content-speaker,
    .we-grid-shortcode figure.ex-modern-blog .grid-excerpt,
    .btn.we-button, .we-icl-import .btn,
    .ex-loadmore .loadmore-grid,
    .we-table-lisst .we-table,
    .woo-event-toolbar .we-search-form .we-search-dropdown button,
    .we-countdonw.list-countdown .cd-title a{
        font-size: <?php echo esc_html($we_fontsize) ?>;
    }
    .we-search-form input.form-control::-webkit-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control:-ms-input-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }
    .we-search-form input.form-control:-moz-placeholder{ font-size: <?php echo esc_html($we_fontsize) ?>;  }

<?php }
$we_hfont = get_option('we_hfont');
$h_font_family = explode(":", $we_hfont);
$h_font_family = $h_font_family[0];
if($h_font_family!=''){?>
	.qtip h4,
    .we-calendar .widget-style .fc-row:first-child table th,
    .we-table-lisst .we-table td h3 a,
    .we-grid-shortcode figure.ex-modern-blog h3 a,
	.we-infotable .wemap-details h4.wemap-title a,
    .we-content-speaker h3, figure.ex-modern-blog h3{
        font-family: "<?php echo esc_html($h_font_family);?>", sans-serif;
    }
<?php }

$we_hfontsize = get_option('we_hfontsize');
if($we_hfontsize!=''){?>
	.we-calendar h2,
    .we-calendar .widget-style .fc-row:first-child table th,
	.we-content-speaker h3, figure.ex-modern-blog h3, .woocommerce #exmain-content h3{
        font-size: <?php echo esc_html($we_hfontsize); ?>;
    }
<?php }

$we_metafont = get_option('we_metafont');
$meta_font_family = explode(":", $we_metafont);
$meta_font_family = $meta_font_family[0];
if($meta_font_family!=''){?>
	.shop-we-short-des .cat-meta *, .shop-we-more-meta span,
    .we-latest-events-widget .event-details span,
    .widget.we-latest-events-widget .event-details span,
    .we-grid-shortcode figure.ex-modern-blog .we-more-meta span,
	.woo-event-info span.sub-lb{
        font-family: "<?php echo esc_html($meta_font_family);?>", sans-serif;
    }
<?php }

$we_matafontsize = get_option('we_matafontsize');
if($we_matafontsize!=''){?>
	.shop-we-short-des .cat-meta *, .shop-we-more-meta span,
    .we-latest-events-widget .event-details span,
    .widget.we-latest-events-widget .event-details span,
    .we-grid-shortcode figure.ex-modern-blog .we-more-meta span,
	.woo-event-info span.sub-lb{
        font-size: <?php echo esc_html($we_matafontsize); ?>;
    }
<?php }?>
<?php


$we_custom_css = get_option('we_custom_css');
if($we_custom_css!=''){
	echo $we_custom_css;
}