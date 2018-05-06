<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'icon'       => array(
		'type' => 'icon',
		'label' => esc_html__( 'Icon', 'plan-up' )
	),
	'title'    => array(
		'type'  => 'text',
		'label' => esc_html__( 'Title', 'plan-up' ),
		'desc'  => esc_html__( 'Icon title', 'plan-up' ),
	),
	'url' => array(
		'type' => 'text',
		'label' => esc_html__('URL', 'plan-up')
	)
);