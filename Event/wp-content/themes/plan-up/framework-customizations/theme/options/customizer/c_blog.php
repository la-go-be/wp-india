<?php
$options = array(
    'c_blog_setting' => array(
        'type' => 'tab',
        'title' => esc_html__('Blog Setting', 'plan-up'),
        'options' => array(
            'c_post_show' => array(
                'type' => 'checkboxes',
                'label' => esc_html__('Show post metadata on', 'plan-up'),
                'choices' => array(
                    'bloglist' => esc_html__('Posts list page', 'plan-up'),
                    'single' => esc_html__('Single post view', 'plan-up')
                ),
                'value' => array(
                    'bloglist' => true,
                    'single' => true
                )
            ),
            'c_post_meta' => array(
                'type' => 'checkboxes',
                'label' => esc_html__('Show post metadata', 'plan-up'),
                'value' => array(
                    'datetime' => true,
                    'author' => true,
                    'comment' => true,
                    'social' => true
                ),
                'choices' => array(
                    'datetime' => esc_html__('Show Datetime', 'plan-up'),
                    'author' => esc_html__('Show Author', 'plan-up'),
                    'comment' => esc_html__('Show comment count', 'plan-up'),
                    'social' => esc_html__('Show social icons', 'plan-up')
                ),
            ),
            'c_social_icon' => array(
                'type' => 'checkboxes',
                'label' => esc_html__('Social icons', 'plan-up'),
                'value' => array(
                    'facebook' => true,
                    'twitter' => true,
                    'googleplus' => true
                ),
                'choices' => array(
                    'facebook' => esc_html__('Facebook', 'plan-up'),
                    'twitter' => esc_html__('Twitter', 'plan-up'),
                    'googleplus' => esc_html__('Google Plus', 'plan-up'),
                    'linkedin' => esc_html__('Linkin', 'plan-up'),
                    'pinterest' => esc_html__('Pinterest','plan-up')
                )
            ),
            'c_single_author' => array(
                'type' => 'switch',
                'label' => esc_html__('Show author block on single post view', 'plan-up'),
                'value' => true
            )
        )
    )
)
?>