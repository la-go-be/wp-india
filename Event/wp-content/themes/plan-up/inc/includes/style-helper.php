<?php
    // Check Unyson is active before hook this action
    if(defined('FW')) :
        add_action('wp_head', 'mauris_font_url_gen');
        // add_action('wp_head', 'mauris_selector_styling');
    endif;

    function mauris_font_url_gen() {
        $customizer = fw_get_db_customizer_option();
        $fonts = array(
            // $customizer['c_site_body_font_family'],
            // $customizer['c_site_heading_font_family'],
            // $customizer['c_site_special_font_family'],
            // $customizer['c_header_main_nav_font_family']
        );
        foreach ($fonts as $key => $font) {

            $font_family = str_replace(' ', '+', $font['family']);
            $font_variation = isset($font['variation']) ? ':'.$font['variation'] : '';
            $font_subset = isset($font['subset']) ? '&subset='.$font['subset'] : '';

            $output  = '<link class="cherry-font-family" href="http://fonts.googleapis.com/css?family=';
            $output .= $font_family . $font_variation . $font_subset;
            $output .= '" rel="stylesheet">';

            echo html_entity_decode($output);
        }
    }


    function mauris_selector_font_styling_match($value, $selector) {
        return $selector . '{font-family:"'.$value['family'].'";}';
    }
    function mauris_selector_styling_match($property, $value, $selector, $unit = '') {
        return $selector . '{' . $property.':'.$value.$unit.';}';
    }


    function mauris_selector_styling() {

        $customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : '';
        $page_options = ( function_exists( 'fw_get_db_post_option' ) ) ? fw_get_db_post_option(get_queried_object_id()) : '';

        $output = '<style type="text/css" id="cherry-customizer">';

        /**
         Font Family
         */
        $output .= mauris_selector_font_styling_match (
            $customizer['c_site_body_font_family'],'
            .body-font,
            body,
            button,
            input,
            select,
            textarea
        ');
        $output .= mauris_selector_font_styling_match (
            $customizer['c_site_heading_font_family'],'
            .heading-font,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6
        ');
        $output .= mauris_selector_font_styling_match (
            $customizer['c_site_special_font_family'],'
            .special-font,
            .fw-section-header .title,
            .ht-feature-boxes .entry-title,
            .ht-intro .mid-line,
            .ht-heading-group .title.special,
            #page-heading.simple h2,
            .site-header .site-title,
            .site-pre-footer .widget .widget-title,
            .entry-post-header .entry-title
        ');

        $output .= mauris_selector_font_styling_match (
            $customizer['c_header_main_nav_font_family'],'
            .site-header .primary-navigation a
        ');

        /**
         Font Size
         */
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_body_font_size'],'
            body,
            .body-font-size,
            .post .entry-author-meta .author-id .fullname,
            .fw_menu .entry-author-meta .author-id .fullname,
            #comments .comments-title,
            #comments .comment-respond .comment-reply-title
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h1_font_size'],'
            h1
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h2_font_size'],'
            h2
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h3_font_size'],'
            h3
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h4_font_size'],'
            h4
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h5_font_size'],'
            h5
        ','px');
        $output .= mauris_selector_styling_match (
            'font-size',
            $customizer['c_site_h6_font_size'],'
            h6,
        ','px');

        /**
         Text Color
         */
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_primary_color'],'
            .primary-color,
            #sidebar .widget.widget_archive select,
            #sidebar .widget.widget_categories select,
            #comments .comment-respond input,
            #comments .comment-respond textarea
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_secondary_color'],'
            .secondary-color,
            .ht-button.no-bg,
            .ht-reservation button.no-bg,
            #back-to-top,
            .widget.widget_archive > ul > li a:hover,
            .widget.widget_categories > ul > li a:hover,
            .widget.widget_pages > ul > li a:hover,
            .widget.widget_meta > ul > li a:hover,
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_secondary_color'],'
            .secondary-color-important,
            .ht-button.border:hover,
            .dtpicker-buttonCont .dtpicker-button.border:hover,
            .post.entry-content input[type="submit"].border:hover,
            .fw_menu.entry-content input[type="submit"].border:hover
        ',' !important');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_body_color'],'
            body,
            .paging-navigation .page-numbers
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_link_color'],'
            a
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_site_link_color_hover'],'
            a:hover
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_header_text_color'],'
            .site-header,
            .site-header a,
            .site-header .primary-navigation .cart a,
            .site-header .primary-navigation .search-toggle > a,
            .site-header .primary-navigation .primary-menu ul li a,
            .site-header .primary-navigation > div ul li a
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_header_submenu_text_color'],'
            .site-header .primary-navigation .primary-menu > ul ul > li > a,
            .site-header .primary-navigation .primary-menu > ul ul > li > a:hover
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['c_header_link_color_hover'],'
            .site-header a:hover,
            .site-header .primary-navigation .cart a:hover,
            .site-header .primary-navigation .search-toggle > a:hover,
            .site-header .primary-navigation .primary-menu ul li a:hover,
            .site-header .primary-navigation > div ul li a:hover
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['pre_footer_color'],'
            .pre-footer-color,
            .site-pre-footer .entry-description,
            .site-pre-footer .widget,
            .site-pre-footer .widget a
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['pre_footer_heading_color'],'
            .pre-footer-heading-color,
            .site-pre-footer .widget .widget-title
        ');
        $output .= mauris_selector_styling_match (
            'color',
            $customizer['footer_color'],'
            .site-footer
        ');
        // Init transparent header colors
        $output .= '@media only screen and ( min-width: 768px ) {';
            $output .= mauris_selector_styling_match (
                'color',
                $customizer['c_header_text_color_trans'],'
                .transparent-header-color,
                .site-header.init-transparent.headroom--top .site-title a,
            ');
            $output .= mauris_selector_styling_match (
                'color',
                $customizer['c_header_link_color_hover_trans'],'
                .transparent-header-link-hover,
                .site-header.init-transparent.headroom--top .site-title a:hover,
            ');
        $output .= '}';

        /**
         Background color
         */
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['c_site_primary_color'],'
            .primary-bg-color,
            ::-webkit-scrollbar-thumb,
            ::-webkit-scrollbar-thumb:window-inactive,
            .site-footer
        ');
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['c_site_secondary_color'],'
            .secondary-bg-color,
            .ht-button.solid,
            .dtpicker-buttonCont .dtpicker-button,
            .paging-navigation .page-numbers:hover,
            .paging-navigation .page-numbers.current
        ');
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['c_header_background'],'
            .site-header
        ');
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['c_header_submenu_background'],'
            .site-header .primary-navigation .primary-menu > ul > li > ul,
            .site-header .primary-navigation > div > ul > li > ul
        ');
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['pre_footer_background'],'
            .site-pre-footer
        ');
        $output .= mauris_selector_styling_match (
            'background-color',
            $customizer['footer_background'],'
            .site-footer
        ');

        /**
         Other
         */
        $output .= mauris_selector_styling_match (
            'border-bottom-color',
            $customizer['c_header_submenu_background'],'
            .site-header .primary-navigation .primary-menu > ul > li.menu-item-has-children > a:before,
            .site-header .primary-navigation .primary-menu > ul > li.page_item_has_children > a:before,
            .site-header .primary-navigation > div > ul > li.menu-item-has-children > a:before,
            .site-header .primary-navigation > div > ul > li.page_item_has_children > a:before
        ');
        $output .= mauris_selector_styling_match (
            'border-color',
            $customizer['c_site_secondary_color'],'
            .ht-menu.preset-detail .entry-prices,
            .paging-navigation .page-numbers:hover,
            .paging-navigation .page-numbers.current
        ');
        $output .= mauris_selector_styling_match (
            'border-color',
            $customizer['c_site_body_color'],'
            .paging-navigation .page-numbers
        ');

        /**
         Override customizer's options by page option
         */
        if ( isset($page_options['pa_o_custom_header_option']) && $page_options['pa_o_custom_header_option'] ) {
            $output .= mauris_selector_styling_match (
                'background-color',
                $page_options['pa_o_header_background'],'
                .site-header
            ');
            $output .= mauris_selector_styling_match (
                'color',
                $page_options['pa_o_header_text_color'],'
                .site-header,
                .site-header a,
                .site-header .primary-navigation .cart a,
                .site-header .primary-navigation .search-toggle > a,
                .site-header .primary-navigation .primary-menu ul li a,
                .site-header .primary-navigation > div ul li a
            ');
            $output .= mauris_selector_styling_match (
                'color',
                $page_options['pa_o_header_link_color_hover'],'
                .site-header a:hover,
                .site-header .primary-navigation .cart a:hover,
                .site-header .primary-navigation .search-toggle > a:hover,
                .site-header .primary-navigation .primary-menu ul li a:hover,
                .site-header .primary-navigation > div ul li a:hover
            ');
        }

        $output .= $customizer['custom_css'];

        $output .= '</style>';

        echo html_entity_decode($output);
    }
?>