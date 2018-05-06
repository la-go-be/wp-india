<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'cate' => array(
		'type' => 'multi-select',
		'label' => esc_html__("Posts categories", 'plan-up'),
		'help' => esc_html__("Specify categories of posts will be rendered.", 'plan-up'),
		'population' => 'taxonomy',
		'source' => 'category' ,
		'limit' => 3,
	),
	'number' => array(
		'type' => 'text',
		'label' => esc_html__('Number of posts rendered', 'plan-up'),
		'value' => '3',
		'help' => esc_html__('Enter -1 to show all', 'plan-up')
	),
	'read_more' => array(
		'type' => 'text',
		'label' => esc_html__('Read more text', 'plan-up'),
		'value' => 'Read more...'
	)
);