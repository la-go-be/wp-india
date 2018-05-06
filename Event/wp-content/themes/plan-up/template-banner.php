<?php
    $customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');
    $show_banner = isset($customizer['c_show_banner']) ? $customizer['c_show_banner'] : true;
    $c_style_color = isset($customizer['c_blog_banner_color']) ? $customizer['c_blog_banner_color'] : '#fff';
    $c_style = isset($customizer['c_blog_banner_color']) ? 'color: '.$customizer['c_blog_banner_color'].';' : 'color: #fff;';
    $c_bg = isset($customizer['c_blog_bg']) ? $customizer['c_blog_bg'] : array('attachment_id' => '', 'url' => get_template_directory_uri().'/images/blog-banner.jpg');
    //BLOG
    if( is_home() || is_singular('post') ):
        $c_title = isset($customizer['c_blog_title']) ? $customizer['c_blog_title'] : esc_html__('News', 'plan-up');
        $c_desc = isset($customizer['c_blog_desc']) ? $customizer['c_blog_desc'] : esc_html__('All the thing related to our events', 'plan-up');
    endif;
    if( is_singular('post') ):
        if( (isset($customizer['c_blog_df']) && $customizer['c_blog_df'] == true) || !isset($customizer['c_blog_df']) ){
            $c_title = get_the_title();
            $c_desc = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'sb_sub_title','') : '';
        }
    endif;
    //PAGE
    if( is_archive() ) :
        $c_title = esc_html__('Archives' ,'plan-up');
        $c_desc = esc_html__('Archives page', 'plan-up');
        if(is_tag()){
            $c_title = single_tag_title( '', false );
        }
        if( is_author() ){
            $c_title = get_the_author();
            $c_desc = esc_html__('All posts by this author', 'plan-up');
        }
        if( is_month() ){
            $c_title = single_month_title(' ', false);
            $c_desc = esc_html__('All posts of this month', 'plan-up');
        }
    endif;
    if( is_page() ):
        $c_title = get_the_title();
        $c_desc = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(),'sp_sub_title','') : '';
    endif;
    //SEARCH
    if( is_search() ):
        $c_title = get_search_query();
        $c_desc = apply_filters( 'ht_search_desc_banner', __('Search results:', 'plan-up') );
    endif;
    //Attachment
    if( is_attachment() ):
        $c_title = esc_html__('Attachment', 'plan-up');
        $c_desc = '';
    endif;
    //404
    if( is_404() ):
        $c_title = apply_filters( 'ht_404_title_banner', __('404 Error', 'plan-up') );
        $c_desc =  apply_filters( 'ht_404_desc_banner', __('Page/Post not found!', 'plan-up') );
    endif;
    $c_style .= 'background-image: url('.$c_bg['url'].')';
?>
<?php if( (!is_page_template('page-templates/template-homepage.php') && $show_banner ) && !is_404() ) : ?>
<div class="page-banner" style="<?php echo ($c_style); ?>">
    <div class="container">
        <h2 class="header-title"><?php echo esc_html( $c_title ); ?></h2>
        <h3 class="header-desc font-title font-size-h3"><?php echo esc_html( $c_desc ); ?></h3>
        <?php if( function_exists('fw_ext_breadcrumbs') ) { fw_ext_breadcrumbs(); } ?>
    </div>
</div>
<?php endif; ?>