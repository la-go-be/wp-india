<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'timeline2' => array(
		'type' => 'addable-popup',
		'label' => esc_html__('Add timeline entries', 'plan-up'),
		'template' => '{{- tl_date}}',
		'popup-options' => array(
			'tl_date' => array(
				'type' => 'text',
				'label' => esc_html__('Date', 'plan-up')
			),
			'tl_box' => array(
				'type' => 'addable-popup',
				'label' => esc_html__('Timeline item', 'plan-up' ),
				'template' => '{{- tl_time}}',
				'popup-options' => array(
					'tl_time' => array(
						'type' => 'text',
						'label' => esc_html__('Time', 'plan-up')
					),
					'tl_place' => array(
						'type' => 'text',
						'label' => esc_html__('Place', 'plan-up')
					),
					'tl_content' => array(
						'type' => 'textarea',
						'label' => esc_html__('Content', 'plan-up')
					),
				),
			),
		),
	)
);