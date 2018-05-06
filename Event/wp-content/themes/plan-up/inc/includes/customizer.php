<?php
{
    if ( class_exists( 'WP_Customize_Control' ) ) {
        /**
         * Class Planup_Subtitle_Control
         */
        class Planup_Subtitle_Control extends WP_Customize_Control
        {
            public $type = 'subtitle';

            /**
             * Render the control's content
             */
            public function render_content()
            {
                ?>
                <span class="customize-control-subtitle"><?php echo esc_html($this->label); ?></span>
                <?php
            }
        }
    }

    /**
     * Implement Theme Customizer additions and adjustments.
     *
     * @param WP_Customize_Manager $wp_customize Theme Customizer object.
     *
     * @internal
     */
    function _action_theme_customize_register( $wp_customize ) {
        $color_default = planup_set_color_default();
        $primary_color = $color_default['primary_color'];
        $secondary_color = $color_default['secondary_color'];

        // Add custom description to Colors and Background sections.
        $wp_customize->get_section( 'colors' )->description           = esc_html__( 'In this section you can change color of the site.',
            'plan-up' );
        if(defined('FW')){
            $wp_customize->get_section( 'general' )->description = esc_html__( 'In this section you can control all general settings of your site.', 'plan-up' );
            // $wp_customize->get_section( 'c_typo' )->description = esc_html__( 'In this section you can control all typography settings of your site.', 'plan-up' );
            // $wp_customize->get_section( 'c_header' )->description = esc_html__( 'In this section you can control all settings of Header.', 'plan-up' );
        }

        // Add postMessage support for site title and description.
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

        // Add custom primary color setting and control.
        $wp_customize->add_setting( 'primary_color', array(
            'default'           => $primary_color,
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
            'label'       => esc_html__( 'Primary Color', 'plan-up' ),
            'description' => esc_html__( 'Choose the most dominant theme color.', 'plan-up' ),
            'section'     => 'colors',
        ) ) );
        // Add custom secondary color setting and control.
        $wp_customize->add_setting( 'secondary_color', array(
            'default'           => $secondary_color,
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
            'label'       => esc_html__( 'Secondary Color', 'plan-up' ),
            'description' => esc_html__( '', 'plan-up' ),
            'section'     => 'colors',
        ) ) );

        // Heading color
        $wp_customize->add_setting( 'heading_color', array(
            'default'           => '#36392e',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heading_color', array(
            'label'       => esc_html__( 'Heading Color', 'plan-up' ),
            'description' => esc_html__( 'Choose the color for heading text.', 'plan-up' ),
            'section'     => 'colors',
        ) ) );

        // Body color
        $wp_customize->add_setting( 'body_color', array(
            'default'           => '#727272',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_color', array(
            'label'       => esc_html__( 'Body Color', 'plan-up' ),
            'description' => esc_html__( 'Choose the color for body text.', 'plan-up' ),
            'section'     => 'colors',
        ) ) );

    }

    add_action( 'customize_register', '_action_theme_customize_register', 11 );

    /**
     * Set default color
     * @return array
     */
    function planup_set_color_default(){
        $color_default = array(
            'primary_color' => '#f30c74',
            'secondary_color' => '#e7b740',
            'heading_color' => '#404040',
            'body_color' => '#727272',
        );

        return $color_default;
    }

    /**
     * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
     * @internal
     */
    function planup_action_theme_customize_preview_js() {
        wp_enqueue_script(
            'fw-theme-customizer',
            get_template_directory_uri() . '/js/customizer.js',
            array( 'jquery','customize-preview' ),
            '1.0',
            true
        );
    }

    add_action( 'customize_preview_init', 'planup_action_theme_customize_preview_js' );

    /**
     * Enqueue front-end CSS for color
     */
    function planup_enqueue_color_css(){
        // Equeue custom css file
        wp_enqueue_style(
            'planup-custom-style',
            get_template_directory_uri() . '/css/custom.css'
        );

        //Get new value of color option
        $default_color = planup_set_color_default(); // get default value
        $primary_color = get_theme_mod('primary_color', $default_color['primary_color']); // get new value
        $secondary_color = get_theme_mod('secondary_color', $default_color['secondary_color']); // get new value
        $heading_color = get_theme_mod('heading_color', $default_color['heading_color']); // get new value
        $body_color = get_theme_mod('body_color', $default_color['body_color']); // get new value

        $colors = array(
            'primary_color' => $primary_color,
            'secondary_color' => $secondary_color,
            'heading_color' => $heading_color,
            'body_color' => $body_color,
        );

        $color_css = planup_get_color_css($colors);
        wp_add_inline_style('planup-custom-style', $color_css);
    }
    add_action('wp_enqueue_scripts', 'planup_enqueue_color_css',999);

    /**
     * Return CSS for the color customizer section
     * @param $colors
     * @return string Color
     */
    function planup_get_color_css($colors){

        $css = "/* Primary color */
        .bg-color-primary, article.page .post-cates a, .countdown-wrapper p.event-badge, .widget-title::before, .widget_mailchimp_form button, article.post .post-cates a, .post-paging .page-numbers, #commentform input#submit, .timeline-badge.warning, .main-navigation ul ul,
        .timeline > li:hover .timeline-badge,
        .ht-btn-wrapper .fw-btn.fw-btn-1, .fw-btn.fw-btn-1,
        .fw_form_fw_form input[type='submit'], .btn.secondary,
        .slide-info .owl-nav > div:hover,
        .ht-accordion .accordion-title.active,
        .registration-wrapper .price-table .price-items .entry.current .features .feature-price,
        .menu.primary li.reserve a:hover,
        .apimap_form input[type='submit'],
        .btn.transparent:hover,
        .sticky li.reserve a:hover,
        .tl2-nav a.tl2-nav-current,
        .tl-content-item:hover:before,
        .speakers-popup .flex-next:hover,
        .speakers-popup .flex-prev:hover
        {
            background-color: {$colors['primary_color']};
        }

        .sticky li.reserve a:hover
        {
            background-color: {$colors['primary_color']} !important;
        }

        ::-webkit-scrollbar-thumb{
          background: {$colors['primary_color']};
        }

        ::-webkit-scrollbar-thumb:window-inactive{
          background: {$colors['primary_color']};
          opacity: 0.5;
        }

        Mozilla based browsers
        ::-moz-selection {
               background-color: {$colors['primary_color']};
        }

        Works in Safari
        ::selection {
               background-color: {$colors['primary_color']};
        }

        #back-to-top, .color-primary, article.page .entry-content a .tweet-entry .tw-body a:hover, .ht-carousel.speakers .slider-inner .speaker-social a:hover, .registration-wrapper .price-table .price-desc a, .dl-menuwrapper .current_page_item > a, .dl-menuwrapper .current-menu-item > a, .dl-menuwrapper .current_page_ancestor > a, .dl-menuwrapper .current-menu-parent > a, .widget_recent_entries a, .widget_rss ul a, .widget_recent_comments ul a, article.post .entry-content a, article.post .sticky-gim, .post-paging .page-numbers:hover, .post-paging .page-numbers.current, #commentform input#submit:hover, .single .meta.meta-social a.sd-button:hover::before,
        section.fw-main-row .flexslider a.flex-next,
        section.fw-main-row .flexslider a.flex-prev,
        .fw-block-info .info-text a:hover,
        .timeline > li > .timeline-panel h4.timeline-place,
        social-link a:hover,
        .apimap_form input[type='submit']:hover,
        .btn.secondary:hover,
        .fw_form_fw_form input[type='submit']:hover,
        .event-register-form input[type='submit']:hover,
        #back-to-top:hover,
        .widget_mailchimp_form button:hover,
        .team-desc a:hover
        {
            color: {$colors['primary_color']};
        }

        .page-template .textblock-shortcode .text-link a:hover,
        .page-template footer .social-link a:hover::before,
        .page-template .fw-block-info .info-text a:hover,
        .page-template .tw-footer a:hover,
        .tl-header-place
        {
            color: {$colors['primary_color']} !important;
        }

        .timeline > li:hover .timeline-badge, .timeline > li > .timeline-badge,
        label span.check-checkbox.active::before,
        .ht-meta-block,
        table > thead > tr > th, table > tbody > tr > th, table > tfoot > tr > th, table > thead > tr > td, table > tbody > tr > td, table > tfoot > tr > td,
        article.post .sticky-gim,
        .registration-wrapper .price-table .price-items .entry.current .features .feature-price,
        .fw_form_fw_form input[type='submit'], .btn.secondary,
        .apimap_form input[type='submit']:hover,
        .slide-info .owl-nav > div:hover,
        .fw_form_fw_form input[type='submit']:hover,
        .menu.primary li.reserve a:hover,
        .btn.transparent:hover,
        .timelines-navigation a.active,
        .event-register-form input[type='submit']:hover,
        .sticky li.reserve a:hover,
        .tables-group .table-entry.highlighted,
        .timelines-navigation a:hover,
        .post-paging .page-numbers:hover, .post-paging .page-numbers.current,
        .tl2-nav a.tl2-nav-current,
        .tl2-nav a:hover,
        .tl-content-item::before,
        .widget_mailchimp_form button:hover,
        .speakers-popup .flex-next:hover,
        .speakers-popup .flex-prev:hover
        {
            border-color: {$colors['primary_color']};
        }
        .sticky li.reserve a:hover
        {
            border-color: {$colors['primary_color']} !important;
        }
        .blog-navigation.sc.sticky .main-navigation.sc{
            box-shadow: 1px 0px 5px 0px {$colors['primary_color']};
        }


        /* Secondary color */
        .color-second, a:hover, article.page a:hover, .tweet-entry .tw-body a, .current_page_ancestor > a, .current-menu-parent > a, .widget-area aside.widget a:hover, .widget_rss ul a:hover, .widget_recent_comments ul a:hover, .widget_mailchimp_form .desctiption a, .widget_recent_posts_thumb .recent-post-entry:hover h4, article.post a:hover,
        .info-text:hover, .text-link:hover,{
            color: {$colors['secondary_color']};
        }

        .ht-carousel.speakers .owl-nav > div
        {
            background-color: {$colors['secondary_color']};
        }
        .ht-carousel.speakers .slider-inner::before{
            background-color: {$colors['secondary_color']};
            opacity: 0;
        }
        .ht-carousel.speakers .owl-nav > div:hover{
            background-color: {$colors['secondary_color']};
            opacity: 0.5;
        }
        .ht-carousel.speakers .slider-inner:hover::before{
            background-color: {$colors['secondary_color']};
            opacity: 0.3;
        }
        .widget_tag_cloud a:hover{
            border-color: {$colors['secondary_color']};
        }

        .timelines-navigation a:hover, .timelines-navigation a.active{
            background-color: {$colors['primary_color']};
            opacity: 1;
        }

        /* Heading color */
        .color-heading, article.page .entry-title, .fw-block-info .info-heading, .textblock-shortcode .text-heading, .timelines-navigation a, .tweet-entry .tw-head .tw-user h3, .fw-testimonials-item .fw-testimonials-author .author-name, .ht-meta-block p, .ht-online-gallery .follow-link a, .apimap_form .direction-label, .countdown-wrapper p.event-badge, .registration-wrapper .price-table .price-items .entry .features .feature-price strong, .event-register-form, .event-register-form select[type='submit'], .event-register-form span.price-display[type='submit'], .fw-heading .fw-special-title, .fw-heading .fw-special-subtitle_2, .widget-title, .widget_categories .cat-item, .widget_recent_posts_thumb .recent-post-entry .post-title, article.post .entry-title, .post-author .au-name, .comment-list .block-1 .reply, .comment-list .block-1 cite, #commentform, .comments-title
        {
            color: {$colors['heading_color']};
        }
        .textblock-shortcode .text-link a{
            color: {$colors['heading_color']} !important;
        }
        /* Body Color */
        body, .fw-testimonials .fw-testimonials-text, .accordion-content, .color-body, article.page .entry-content, .timeline > li > .timeline-panel h4, .fw_form_fw_form sup, .tweet-entry .tw-head .tw-user p, .fw-testimonials-item, .ht-accordion .accordion-title, .ht-accordion .accordion-content, .ht-meta-block p span, .apimap_form .c-enter input, .registration-wrapper .price-table .price-items .entry .features, .registration-wrapper .price-table, footer, footer .social-link a::before, .widget-area, article.post .entry-content, article.post .entry-meta, .post-author .au-social, .comment-list .block-2, .single .meta.meta-social a.sd-button::before, .event-register-form .mail-chimp span.desc
        {
            color: {$colors['body_color']};
        }";
        return $css;
    }

    // Enqueue script for custom customize control
    function planup_customizer_control_js(){
        // Load customizer stylesheet
        wp_enqueue_style('planup-customizer', get_template_directory_uri(). '/css/customizer.css');
    }
    add_action('customize_controls_enqueue_scripts', 'planup_customizer_control_js');

    // Custom CSS customizer
    function planup_custom_css(){
        $c_custom_css = (function_exists('fw_get_db_customizer_option')) ? fw_get_db_customizer_option('c_custom_css') : '';
        ?>
        <style type="text/css">
            <?php echo html_entity_decode($c_custom_css); ?>
        </style>
        <?php
    }
    add_action('wp_head', 'planup_custom_css',999);
}
?>