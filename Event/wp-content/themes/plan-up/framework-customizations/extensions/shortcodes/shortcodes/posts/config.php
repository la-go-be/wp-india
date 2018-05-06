<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Posts', 'plan-up' ),
	'description' => esc_html__( 'Add posts', 'plan-up' ),
	'tab'         => esc_html__( 'Content Elements', 'plan-up' ),
	'popup_size'  => 'medium'
);