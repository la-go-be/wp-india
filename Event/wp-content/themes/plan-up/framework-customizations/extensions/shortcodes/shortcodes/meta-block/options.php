<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'meta-block' => array(
		'type' => 'addable-popup',
		'label' => esc_html__('Meta information', 'plan-up'),
		'popup-options' => array(
			'icon' => array(
				'label' => esc_html__('Icon', 'plan-up'),
				'type' => 'icon',
				'value' => '',
				'set' => 'ionicon',
			),
			'title' => array(
				'label'   => esc_html__('Title','plan-up'),
				'desc'    => esc_html__('Write some text','plan-up'),
				'type'    => 'text',
			),
			'sub-title' => array(
				'label'   => esc_html__('Sub','plan-up'),
				'desc'    => esc_html__('Write some text','plan-up'),
				'type'    => 'text',
			),
		),
		'template' => '{{=title}}',
		'limit' => 6,
		'size' => 'medium'
	)
);