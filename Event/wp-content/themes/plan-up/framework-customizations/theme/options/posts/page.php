<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(
    'single_blog_setting' => array(
        'type' => 'tab',
        'title' => esc_html__('General', 'plan-up'),
        'options' => array(
            'sp_sub_title' => array(
                'type' => 'text',
                'value' => '',
                'label' => esc_html__('Page subtitle', 'plan-up')
            )
        )
    )
);