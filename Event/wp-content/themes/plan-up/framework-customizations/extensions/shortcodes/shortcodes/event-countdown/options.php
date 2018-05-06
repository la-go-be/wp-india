<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'section_2' => array(
		'type' => 'tab',
		'title' => esc_html__('Event Time countdown', 'plan-up'),
		'options' => array(
			'color' => array(
				'label' => esc_html__('Color Text', 'plan-up'),
				'type' => 'color-picker',
				'value' => '#fff'
			),
			'datetime' => array(
				'label' => esc_html__('Time', 'plan-up'),
				'desc'  => esc_html__('Enter date. For example: April 1, 2015 00:00:00', 'plan-up'),
				'type'  => 'text',
				'value' => 'April 1, 2020 00:00:00'
			),
			'day_text' => array(
				'label' => esc_html__('Day Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'days'
			),
			'hour_text' => array(
				'label' => esc_html__('Hour Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'hours'
			),
			'min_text' => array(
				'label' => esc_html__('Minute Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'minutes'
			),
			'sec_text' => array(
				'label' => esc_html__('Second Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'seconds',
				'help' => esc_html__('Leave it empty if you do not want to show seconds', 'plan-up')
			),
		)
	),
	'section_3' => array(
		'type' => 'tab',
		'title' => esc_html__('Background Slide', 'plan-up'),
		'options' => array(
			'use_slide' => array(
				'type' => 'switch',
				'label' => esc_html__('Use slide as background?', 'plan-up')
			),
			'slide' => array(
				'type' => 'multi-select',
				'population' => 'posts',
				'source' => 'fw-slider',
				'limit' => 1
			),
			'direction' => array(
				'type' => 'select',
				'label' => esc_html__('Slide direction', 'plan-up'),
				'choices' => array(
					'vertical' => esc_html__('Vertical', 'plan-up'),
					'horizontal' => esc_html__('Horizontal', 'plan-up')
				)
			)
		)
	),
	'section_4' => array(
		'type' => 'tab',
		'title' => esc_html__('Share links', 'plan-up'),
		'options' => array(
			'share_label' => array(
				'type' => 'text',
				'label' => esc_html__('Share text', 'plan-up'),
				'value' => 'SHARE THIS EVENT'
			),
			'share_links' => array(
				'type' => 'addable-option',
				'label' => esc_html__('Links', 'plan-up'),
				'desc' => esc_html__('Enter URL of social networks', 'plan-up'),
				'popup-options' => array(
					'url' => array('type' => 'text')
				)
			)
		)
	)
);