<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(
    'general' => array(
        'title'   => esc_html__( 'General', 'plan-up'),
        'type'    => 'tab',
        'options' => array(
            'logo'    => array(
                'label' => esc_html__('Logo Default', 'plan-up'),
                'desc'  => esc_html__('Used in Blog page', 'plan-up'),
                'type'  => 'upload',
                'value' => array(
                    'attachment_id' => '',
                    'url' => ''
                )
            ),
            'logo_2' => array(
                'label' => esc_html__('Logo Sticky', 'plan-up'),
                'desc' => esc_html__('Used in sticky menu', 'plan-up'),
                'type' => 'upload',
                'value' => array(
                    'attachment_id' => '',
                    'url' => ''
                )
            ),
            'sticky_nav' => array(
                'type' => 'switch',
                'label' => esc_html__('Sticky Navigation', 'plan-up')
            )
        )
    )
);