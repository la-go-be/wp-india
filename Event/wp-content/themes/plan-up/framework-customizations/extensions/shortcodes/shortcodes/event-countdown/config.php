<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Header', 'plan-up' ),
	'description' => esc_html__( 'Add the header for homepage with event countdown and slider', 'plan-up' ),
	'tab'         => esc_html__( 'Home Page', 'plan-up' ),
    'popup_size' => 'large'
);