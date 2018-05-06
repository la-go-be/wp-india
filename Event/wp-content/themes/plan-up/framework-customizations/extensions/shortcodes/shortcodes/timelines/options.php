<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'timelines' => array(
		'type' => 'addable-popup',
		'label' => esc_html__('Add timeline entries', 'plan-up'),
		'popup-options' => array(
			'tm_date' => array(
				'type' => 'text',
				'label' => esc_html__('Date', 'plan-up')
			),
			'tm-entries' => array(
				'type' => 'addable-popup',
				'template' => '{{- time}}',
				'popup-options' => array(
					'time' => array(
						'label'   => esc_html__('Time','plan-up'),
						'desc'    => esc_html__('','plan-up'),
						'type'    => 'text',
					),
					'place' => array(
						'label'   => esc_html__('Place','plan-up'),
						'desc'    => esc_html__('','plan-up'),
						'type'    => 'text',
					),
					'content' => array(
						'type'   => 'wp-editor',
						'reinit' => true,
						'label'  => esc_html__( 'Content', 'plan-up'),
						'desc'   => esc_html__( '', 'plan-up'),
						'size'  => 'large',
						'editor_type' => 'tinymce',
						// 'editor_height' => 800,
						'tinymce' => true,
						'teeny' => false,
						'wpautop' => false,
					)
				)
			)
		),
		'template' => '{{- tm_date}}'
	)
);