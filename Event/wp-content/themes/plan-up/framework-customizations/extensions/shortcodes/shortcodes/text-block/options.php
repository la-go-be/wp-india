<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'text' => array(
		'type'   => 'wp-editor',
		'reinit' => true,
		'label'  => false,
		'desc'   => esc_html__( 'Enter some content for this texblock', 'plan-up'),
		'size'  => 'large',
		'editor_type' => 'tinymce',
		'editor_height' => 600,
		'tinymce' => true,
		'teeny' => false,
		'wpautop' => false,
	)
);
