<?php if (!defined('FW')) die('Forbidden');

$options = array(
    'bg_color' => array(
        'type'  => 'rgba-color-picker',
        'value' => false,
        'label' => esc_html__('Background color', 'plan-up')
    ),
    'color' => array(
        'type' => 'rgba-color-picker',
        'value' => false,
        'label' => esc_html__('Text color', 'plan-up')
    )
);