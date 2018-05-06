<?php
$options = array(
    'c_typo' => array(
        'type' => 'tab',
        'title' => esc_html__('Typography', 'plan-up'),
        'options' => array(
            'heading_font'                => array(
                'label' => esc_html__( 'Heading Font', 'plan-up' ),
                'type' => 'typography-v2',
                'value' => array(
                    'family' => 'Roboto Bold',
                    'variation' => '400',
                ),
                'components' => array(
                    'family'         => true,
                    // 'style', 'weight', 'subset', 'variation' will appear and disappear along with 'family'
                    'size'           => 18,
                    'line-height'    => false,
                    'letter-spacing' => false,
                    'color'          => false,
                    'style'          => true
                ),
                'desc'  => esc_html__( 'This setting will change font size, font type and font style of heading elements.',
                    'plan-up' ),
            ),
            'body_font'                => array(
                'label' => esc_html__( 'Body Font', 'plan-up' ),
                'type'  => 'typography-v2',
                'value' => array(
                    'family' => 'Droid',
                    // For standard fonts, instead of subset and variation you should set 'style' and 'weight'.
                    // 'style' => 'italic',
                    // 'weight' => 700,
                    'subset' => 'latin',
                    'variation' => 'regular',
                    'line-height'    => 24,
                    'size' => 14,
                ),
                'components' => array(
                    'family'         => true,
                    // 'style', 'weight', 'subset', 'variation' will appear and disappear along with 'family'
                    'size'           => true,
                    'line-height'    => true,
                    'letter-spacing' => false,
                    'color'          => false,
                    'subset'         => true,
                    'variation'      => true,
                    'style'          => true
                ),
                'desc'  => esc_html__( 'This setting will change font size, font type and font style of paragraph elements.',
                    'plan-up' ),
            ),
            'heading_typo_h1' => array(
                'label' => esc_html__('H1 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 30
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            ),
            'heading_typo_h2' => array(
                'label' => esc_html__('H2 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 24
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            ),
            'heading_typo_h3' => array(
                'label' => esc_html__('H3 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 20
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            ),
            'heading_typo_h4' => array(
                'label' => esc_html__('H4 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 16
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            ),
            'heading_typo_h5' => array(
                'label' => esc_html__('H5 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 14
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            ),
            'heading_typo_h6' => array(
                'label' => esc_html__('H6 Font Size','plan-up'),
                'type' => 'typography',
                'value' => array(
                    'size' => 14
                ),
                'components' => array(
                    'family' => false,
                    'color' => false,
                    'style' => false
                )
            )
        ),
    ),
);
?>