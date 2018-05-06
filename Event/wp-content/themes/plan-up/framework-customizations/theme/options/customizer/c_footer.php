<?php

$options = array(
    'c_footer' => array(
        'type' => 'tab',
        'title' => esc_html__('Footer', 'plan-up'),
        'options' => array(
            'c_copyright' => array(
                'label' => esc_html__('Copyright Text', 'plan-up'),
                'type' => 'textarea',
                'value' => get_bloginfo('name').' '.date('Y')
            ),
            'c_social_link' => array(
                'type' => 'addable-option',
                'label' => esc_html__('Social Links', 'plan-up'),
                'option' => array('type' => 'text'),
                'value' => array('http://facebook.com'),
                'desc' => esc_html__('Enter URL of your social network', 'plan-up')
            ),
            'c_footer_bg' => array(
                'type' => 'color-picker',
                'value' => '#2C2C2C',
                'label' => esc_html__('Background Color', 'plan-up')
            )
        )
    )
);

?>