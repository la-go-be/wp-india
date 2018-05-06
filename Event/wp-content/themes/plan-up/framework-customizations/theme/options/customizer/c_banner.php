<?php
$options = array(
    'c_banner_setting' => array(
        'type' => 'tab',
        'title' => esc_html__('Banner', 'plan-up'),
        'options' => array(
            'c_show_banner' => array(
                'type' => 'switch',
                'value' => true,
                'label' => esc_html__('Show banner', 'plan-up')
            ),
            'c_blog_title' => array(
                'type' => 'text',
                'value' => 'News',
                'label' => esc_html__('Banner title', 'plan-up')
            ),
            'c_blog_desc' => array(
                'type' => 'text',
                'value' => 'Everything related to our event',
                'label' => esc_html__('Banner description', 'plan-up')
            ),
            'c_blog_banner_color' => array(
                'type' => 'color-picker',
                'label' => esc_html__('Color', 'plan-up'),
                'value' => '#fff'
            ),
            'c_blog_df' => array(
                'type' => 'switch',
                'value' => true,
                'label' => esc_html__('Use post title', 'plan-up'),
                'help' => esc_html__('Title and subtitle of the posts will overwrite', 'plan-up'),
            ),
            'c_blog_bg' => array(
                'type' => 'upload',
                'label' => esc_html__('Header Background', 'plan-up'),
                'image_only' => true,
                'limit' => 1,
                'value' => array(
                    'attachment_id' => '',
                    'url' => ''
                )
            )
        )
    )
);
?>