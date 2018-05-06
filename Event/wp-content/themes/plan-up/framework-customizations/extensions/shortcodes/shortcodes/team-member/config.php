<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Team Member', 'plan-up' ),
	'description' => esc_html__( 'Add a Team Member', 'plan-up' ),
	'tab'         => esc_html__( 'Content Elements', 'plan-up' ),
	'popup_size'  => 'medium'
);