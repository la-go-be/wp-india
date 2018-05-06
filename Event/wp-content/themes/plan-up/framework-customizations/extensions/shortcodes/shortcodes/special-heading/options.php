<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'title'    => array(
		'type'  => 'text',
		'label' => esc_html__( 'Heading Title', 'plan-up' ),
		'desc'  => esc_html__( 'Write the heading title content', 'plan-up' ),
	),
	'color' => array(
		'label' => esc_html__('Heading Color', 'plan-up'),
		'type' => 'color-picker',
		'value' => '#040404'
	),
	'subtitle' => array(
		'type'  => 'text',
		'label' => esc_html__( 'Heading Subtitle', 'plan-up' ),
		'desc'  => esc_html__( 'Write the heading subtitle content', 'plan-up' ),
	),
	'subtitle_2' => array(
		'type'  => 'text',
		'label' => esc_html__( 'Heading Subtitle 2', 'plan-up' ),
		'desc'  => esc_html__( 'Write the heading subtitle content', 'plan-up' ),
		'help' => esc_html__('This appear above the main heading', 'plan-up')
	),

	'centered' => array(
		'type'    => 'switch',
		'label'   => esc_html__('Centered', 'plan-up'),
		'value' => true
	)
);
