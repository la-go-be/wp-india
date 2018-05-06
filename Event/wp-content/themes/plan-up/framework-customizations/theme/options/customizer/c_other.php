<?php

$options = array(
    'c_other' => array(
        'type' => 'tab',
        'title' => esc_html__('Other', 'plan-up'),
        'options' => array(
            'c_smooth_scroll' => array(
                'type' => 'switch',
                'label' => esc_html__('Enable smooth scroll?', 'plan-up'),
                'value' => false
            ),
            'c_back_to_top_show' => array(
                'type' => 'switch',
                'label' => esc_html__('Show back to top button?', 'plan-up'),
            ),
            'c_404_desc' => array(
                'type'   => 'textarea',
                'label'  => esc_html__( '404 Page', 'plan-up' ),
                'desc'   => esc_html__( 'Content for 404 page', 'plan-up'),
            )
        )
    )
);

?>