<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'tw_user' => array(
		'label'   => esc_html__('UserID','plan-up'),
		'desc'    => esc_html__('','plan-up'),
		'type'    => 'text',
		'help'    => esc_html__('Eg: @UserName','plan-up')
	),
	'tw_number' => array(
		'label' => esc_html__('Number of tweets', 'plan-up'),
		'type' =>  'text'
	)
);