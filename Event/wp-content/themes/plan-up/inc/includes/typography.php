<?php
/**
 * Typography Registration.
 */

/**
 * Register google font to
 */
function planup_fonts_register(){
    $body_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('body_font') : 'Droid Serif';
    $heading_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_font') : 'Roboto';

    $font_url = '';

    // Check body variation
    if($body_font != '' || $heading_font != ''){

        // Variation condition
        $body_font_variation = $menu_font_variation = $heading_font_variation = '';
        if($body_font['variation'] == 'regular'){
            $body_font_variation = '';
        }elseif($body_font['variation'] == 'italic'){
            $body_font_variation = ':400italic';
        }else{
            $body_font_variation = ':'.$body_font['variation'];
        }

        if($heading_font['variation'] == 'regular'){
            $heading_font_variation = '';
        }elseif($heading_font['variation'] == 'italic'){
            $heading_font_variation = ':400italic';
        }else{
            $heading_font_variation = ':'.$heading_font['variation'];
        }

        $font_families[] = $body_font['family'].$body_font_variation;
        $font_families[] = $heading_font['family'].$heading_font_variation;

        // Using subset when Unyson fix it
        $font_subset = '';
        if($body_font['subset'] != false){
            $font_subset[] = $body_font['subset'];
        }

        if($heading_font['subset'] != false){
            $font_subset[] = $heading_font['subset'];
        }


        $query_args['family'] = implode('|', $font_families);
        // Check if font support subset
        if(!empty($font_subset)){
            $query_args['subset'] = implode(',', $font_subset);
        }
        if( $query_args['family'] != ':|:' )
            $font_url = add_query_arg($query_args, "//fonts.googleapis.com/css");
        else{
            return false;
        }

    }

    return esc_url_raw($font_url);
}

/**
 * Ehqueue google font
 */
function planup_google_font_enqueue(){
    // Get value of google font from customizer
    $body_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('body_font') : '';
    $heading_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_font') : '';
    $h1_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h1') : '';
    $h2_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h2') : '';
    $h3_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h3') : '';
    $h4_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h4') : '';
    $h5_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h5') : '';
    $h6_font = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('heading_typo_h6') : '';

    $typography = array(
        'body_font' => $body_font,
        'heading_font' => $heading_font,
        'h1_font'     => $h1_font,
        'h2_font'     => $h2_font,
        'h3_font'     => $h3_font,
        'h4_font'     => $h4_font,
        'h5_font'     => $h5_font,
        'h6_font'     => $h6_font,
    );
    if(defined('FW')){
        // Using custom font from customizer
        if(planup_fonts_register() != false)
            wp_enqueue_style('fw-google-font', planup_fonts_register(), array(), '1.0');
        wp_enqueue_style(
            'custom-style-font',
            get_template_directory_uri() . '/css/custom.css'
        );
        $typography_css = planup_get_custom_typography($typography);
        wp_add_inline_style('custom-style-font', $typography_css);


    }else{
        wp_enqueue_style('planup_google_fonts', plan_up_theme_font_url(), array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'planup_google_font_enqueue',99);



/*
 * Return css for typography customizer
 */
function planup_get_custom_typography($typography){
    // Font variation condition
    $body_font_style = $menu_font_style = '';
    if ( '100italic' == $typography['body_font']['variation'] || '300italic' == $typography['body_font']['variation'] || '400italic' == $typography['body_font']['variation'] || '600italic' == $typography['body_font']['variation'] || '700italic' == $typography['body_font']['variation'] || '800italic' == $typography['body_font']['variation'] || '900italic' == $typography['body_font']['variation'] )  {
        $body_font_weight = substr($typography['body_font']['variation'], 0, -5);
        $body_font_style = 'font-style: italic;';
    }else{
        $body_font_weight = $typography['body_font']['variation'];
    }
    if($body_font_weight == 'regular'){
        $body_font_weight = '400';
    }

    if ( '100italic' == $typography['heading_font']['variation'] || '300italic' == $typography['heading_font']['variation'] || '400italic' == $typography['heading_font']['variation'] || '600italic' == $typography['heading_font']['variation'] || '700italic' == $typography['heading_font']['variation'] || '800italic' == $typography['heading_font']['variation'] || '900italic' == $typography['heading_font']['variation'] )  {
        $heading_font_weight = substr($typography['heading_font']['variation'], 0, -5);
    }else{
        $heading_font_weight = $typography['heading_font']['variation'];
    }
    if($heading_font_weight == 'regular'){
        $heading_font_weight = '400';
    }
    if( $typography['heading_font']['variation'] != false ):
    // CSS output
    $css_heading = "h1,h2,h3,.font-title-bold, article.page .entry-title, article.page a.readmore, .fw-block-info .info-heading, .fw-block-info .info-text a, .textblock-shortcode .text-link a, .textblock-shortcode .text-heading, .timeline > li > .timeline-panel h4, .timelines-navigation a, .fw_form_fw_form, .fw_form_fw_form input[type='submit'], .tweet-entry .tw-head .tw-user h3, .tweet-entry .tw-head .tw-follow a, .fw-testimonials-item .fw-testimonials-author .author-name, .ht-online-gallery .follow-link a, .apimap_form input[type='submit'], .registration-wrapper .price-table .price-items .entry .features .feature-price strong, .registration-wrapper .register-form-name, .registration-wrapper .price-table-name, .event-register-form input[type='submit'], .event-register-form select[type='submit'], .event-register-form span.price-display[type='submit'], .ht-btn-wrapper .fw-btn, .fw-btn, .page-banner h2.header-title, .main-navigation li, .widget-title, .widget_categories .cat-item, .widget_mailchimp_form button, .widget_recent_posts_thumb .recent-post-entry .post-title, article.post .entry-title, article.post a.readmore, article.post .entry-content.quote .quote-au, .post-paging .page-numbers, .post-author .au-name, .comment-list .block-1 .reply, .comment-list .block-1 cite, #commentform, #commentform input#submit, .comments-title
    {
        font-family: {$typography['heading_font']['family']};
        font-weight: {$heading_font_weight};
    }";
    else:
        $css_heading = '';
    endif;
    if( $typography['body_font']['variation'] != false ):
    $css_body = "
    /*Body font*/
    .font-body, article.page .entry-content, .textblock-shortcode, .fw-testimonials-item, .ht-meta-block p, .countdown-wrapper .event-content, .registration-wrapper .price-table .price-items .entry .features, .registration-wrapper .price-table .price-desc, .widget-area, article.post .entry-content, article.post .entry-meta, .comment-list .block-2,
    body, button, input, select, textarea
    {
        font-family: {$typography['body_font']['family']};
        font-weight: {$heading_font_weight};
    }
    .fw-testimonials-item .fw-testimonials-text
    {
        font-family: {$typography['body_font']['family']} !important;
        font-weight: {$heading_font_weight};
    }";
    else:
        $css_body = '';
    endif;
    $css_headings = "
    /*Heading font*/
    h1, .fw-special-title{
        font-size: {$typography['h1_font']['size']}px;
    }
    h2,.font-size-h2, .apimap_form .map-form-title, .event-register-form h3.form-title, .page-banner h2.header-title{
        font-size: {$typography['h2_font']['size']}px;
    }
    h3{
        font-size: {$typography['h3_font']['size']}px;
    }
    h4{
        font-size: {$typography['h4_font']['size']}px;
    }
    h5{
        font-size: {$typography['h5_font']['size']}px;
    }
    h5{
        font-size: {$typography['h6_font']['size']}px;
    }";

    return $css_heading.$css_body.$css_headings;

}
?>