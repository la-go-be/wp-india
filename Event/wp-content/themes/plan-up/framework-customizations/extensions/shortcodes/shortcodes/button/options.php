<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'label'  => array(
		'label' => esc_html__( 'Button Label', 'plan-up' ),
		'desc'  => esc_html__( 'This is the text that appears on your button', 'plan-up' ),
		'type'  => 'text',
		'value' => 'Submit'
	),
	'link'   => array(
		'label' => esc_html__( 'Button Link', 'plan-up' ),
		'desc'  => esc_html__( 'Where should your button link to', 'plan-up' ),
		'type'  => 'text',
		'value' => '#'
	),
	'target' => array(
		'type'  => 'switch',
		'label'   => esc_html__( 'Open Link in New Window', 'plan-up' ),
		'desc'    => esc_html__( 'Select here if you want to open the linked page in a new window', 'plan-up' ),
		'right-choice' => array(
			'value' => '_blank',
			'label' => esc_html__('Yes', 'plan-up'),
		),
		'left-choice' => array(
			'value' => '_self',
			'label' => esc_html__('No', 'plan-up'),
		),
	),
	'color'  => array(
		'label'   => esc_html__( 'Button Color', 'plan-up' ),
		'desc'    => esc_html__( 'Choose a color for your button', 'plan-up' ),
		'type'    => 'select',
		'choices' => array(
			''      => esc_html__('Default', 'plan-up'),
			'secondary'   => esc_html__( 'Pinks', 'plan-up' ),
			'transparent'   => esc_html__( 'Transparent', 'plan-up' ),
			'black' => esc_html__( 'Black', 'plan-up' ),
			'blue'  => esc_html__( 'Blue', 'plan-up' ),
			'green' => esc_html__( 'Green', 'plan-up' ),
			'red'   => esc_html__( 'Red', 'plan-up' ),
		)
	),
	'style' => array(
		'type' => 'select',
		'label' => esc_html__('Style','plan-up'),
		'choices' => array(
			'circle' => esc_html__('Circle', 'plan-up'),
			'square' => esc_html__('Square', 'plan-up')
		)
 	),
 	'align' => array(
 		'type' => 'select',
 		'label' => esc_html__('Align', 'plan-up'),
 		'choices' => array(
 			'normal' => esc_html__('Normal', 'plan-up'),
 			'left' => esc_html__('Left', 'plan-up'),
 			'center' => esc_html__('Center', 'plan-up'),
 			'right' => esc_html__('Right', 'plan-up')
 		)
 	)
);