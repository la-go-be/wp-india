<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style' => array(
		'type'     => 'multi-picker',
		'label'    => false,
		'desc'     => false,
		'picker' => array(
			'ruler_type' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Ruler Type', 'plan-up' ),
				'desc'    => esc_html__( 'Here you can set the styling and size of the HR element', 'plan-up' ),
				'choices' => array(
					'space' => esc_html__( 'Whitespace', 'plan-up' ),
					'line'  => esc_html__( 'Line', 'plan-up' ),
				)
			)
		),
		'choices'     => array(
			'space' => array(
				'height' => array(
					'label' => esc_html__( 'Height', 'plan-up' ),
					'desc'  => esc_html__( 'How much whitespace do you need? Enter a pixel value. Positive value will increase the whitespace, negative value will reduce it. eg: \'50\', \'-25\', \'200\'', 'plan-up' ),
					'type'  => 'text',
					'value' => '30'
				)
			)
		)
	)
);
