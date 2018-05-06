<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'tables' => array(
		'type' => 'addable-popup',
		'label' => esc_html__('Add items', 'plan-up'),
		'popup-options' => array(
			'name' => array(
				'type' => 'text',
				'label' => esc_html__('Name', 'plan-up')
			),
			'value' => array(
				'type' => 'text',
				'label' => esc_html__('Value', 'plan-up')
			),
			'currency' => array(
				'type' => 'text',
				'label' => esc_html__('Currency code', 'plan-up'),
				'value' => 'USD',
				'help' => esc_html__('Enter USD, RUB, EGP GIP, VND, ... and it will be converted to symbol automatically', 'plan-up')
			),
			'quantity' => array(
				'type' => 'text',
				'label' => esc_html__('Additional content', 'plan-up')
			),
			'icon' => array(
				'type' => 'icon',
				'set' => 'ionicon',
			),
			'desc' => array(
				'type' => 'textarea',
				'label' => esc_html__('Description', 'plan-up'),
				'desc' => esc_html__('Each line, each entry', 'plan-up')
			),
			'typical' => array(
				'type' => 'switch',
				'label' => esc_html__('Highlighted', 'plan-up')
			),
			'url' => array(
				'type' => 'text',
				'label' => esc_html__('URL', 'plan-up'),
				'value' => '#'
			)
		),
		'size' => 'large',
		'template' => '{{=name}}',
		'limit' => '4'
	)
);