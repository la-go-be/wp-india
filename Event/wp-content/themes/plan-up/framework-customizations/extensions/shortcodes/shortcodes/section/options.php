<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'section_id' => array(
		'type' => 'text',
		'label' => esc_html__('ID of the section', 'plan-up'),
		'desc' => esc_html__('A unique word, no space, in lower cases', 'plan-up'),
		'help' => esc_html__('This name is used to fill in the menu bar of the home page', 'plan-up')
	),
	'layout' => array(
		'type'    => 'group',
		'options' => array(
			'is_fullwidth' => array(
				'label' => esc_html__('Full Width', 'plan-up'),
				'type'  => 'switch',
			),
			'no_padding' => array(
				'label' => esc_html__('No Gutter', 'plan-up'),
				'type'  => 'switch',
			),
			'padding_top' => array(
				'label' => esc_html__('Padding top', 'plan-up'),
				'type'  => 'text',
				'desc'  => esc_html__('Unit: px', 'plan-up'),
			),
			'padding_bottom' => array(
				'label' => esc_html__('Padding bottom', 'plan-up'),
				'type'  => 'text',
				'desc'  => esc_html__('Unit: px', 'plan-up'),
			),
			'margin_top' => array(
				'label' => esc_html__('Margin top', 'plan-up'),
				'type'  => 'text',
				'desc'  => esc_html__('Unit: px', 'plan-up'),
			),
			'margin_bottom' => array(
				'label' => esc_html__('Margin bottom', 'plan-up'),
				'type'  => 'text',
				'desc'  => esc_html__('Unit: px', 'plan-up'),
			),
		)
	),

	'design' => array(
		'type'    => 'group',
		'options' => array(
			'color' => array(
				'label' => esc_html__('Text Color', 'plan-up'),
				'type'  => 'rgba-color-picker',
				'value' => ''
			),
			'background_color' => array(
				'label' => esc_html__('Background/Overlay Color', 'plan-up'),
				'desc'  => esc_html__('Please select the background color. This option can also be used as overlay if opacity is lower than 1', 'plan-up'),
				'type'  => 'rgba-color-picker',
				'value' => ''
			),
			'background_image' => array(
				'label'   => esc_html__('Background Image', 'plan-up'),
				'desc'    => esc_html__('Please select the background image', 'plan-up'),
				'type'    => 'background-image',
				'choices' => array(

				)
			),
			'video' => array(
				'label' => esc_html__('Background Video', 'plan-up'),
				'desc'  => esc_html__('Insert Video URL to embed this video', 'plan-up'),
				'type'  => 'text',
			)
		)
	),

	'parallax' => array(
		'type'    => 'group',
		'options' => array(
			'parallax_toggle' => array(
				'label' => esc_html__('Enable parallax', 'plan-up'),
				'type'  => 'switch',
				'right-choice' => array(
					'value' => 'is-parallax',
					'label' => esc_html__( 'On', 'plan-up' )
				),
				'left-choice'  => array(
					'value' => '',
					'label' => esc_html__( 'Off', 'plan-up' )
				),
				'value' => '',
			),
			'parallax_distance' => array(
				'label' => esc_html__('Parallax distance', 'plan-up'),
				'type'  => 'text',
				'value' => '200',
				'desc' => esc_html__('Amount of pixel the background will moving during scrolling in px', 'plan-up'),
			),
		)
	),

);
