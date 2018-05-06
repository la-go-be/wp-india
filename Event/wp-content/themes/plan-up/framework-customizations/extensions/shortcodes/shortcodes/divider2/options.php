<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'h_des' => array(
		'type' => 'text',
		'label' => esc_html__( 'Height on desktop', 'supershine' ),
		'value' => '30'
	),
	'h_mb' => array(
		'type' => 'text',
		'label' => esc_html__( 'Height on mobile', 'supershine' ),
		'value' => '15'
	)
);
