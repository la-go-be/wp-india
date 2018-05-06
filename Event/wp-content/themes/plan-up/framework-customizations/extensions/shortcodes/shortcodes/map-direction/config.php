<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Map Direction', 'plan-up' ),
	'description' => esc_html__( 'Add an Accordion', 'plan-up' ),
	'tab'         => esc_html__( 'Content Elements', 'plan-up' ),
    'popup_size' => 'large'
);