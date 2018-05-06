<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Time CountDown', 'plan-up' ),
	'description' => esc_html__( 'Add a time countdown', 'plan-up' ),
	'tab'         => esc_html__( 'Home Page', 'plan-up' ),
    'popup_size' => 'large'
);