<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'title' => array(
		'label'   => esc_html__('Heading','plan-up'),
		'desc'    => esc_html__('Write some text','plan-up'),
		'type'    => 'text',
	),
	'icon' => array(
		'label' => esc_html__('Icon', 'plan-up'),
		'type' => 'icon',
		'value' => 'fa-smile-o',
	),
	'content' => array(
		'type'   => 'wp-editor',
		'reinit' => true,
		'label'  => esc_html__( 'Content', 'plan-up'),
		'desc'   => esc_html__( '', 'plan-up'),
		'size'  => 'large',
		'editor_type' => 'tinymce',
		// 'editor_height' => 800,
		'tinymce' => true,
		'teeny' => false,
		'wpautop' => false,
	)
);