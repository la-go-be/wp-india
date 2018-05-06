<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'info' => array(
		'type' => 'addable-popup',
		'label' => esc_html__('Add items', 'plan-up'),
		'popup-options' => array(
			'content' => array(
				'type'   => 'wp-editor',
				'reinit' => true,
				'label'  => esc_html__( 'Content', 'plan-up' ),
				'desc'   => esc_html__( 'Enter some content for this texblock', 'plan-up' ),
				'size'  => 'large',
				'editor_type' => 'tinymce',
				'editor_height' => 700,
				'tinymce' => true,
				'teeny' => false,
				'wpautop' => false,
			)
		),
		'size' => 'large',
		'template' => 'Item'
	)
);