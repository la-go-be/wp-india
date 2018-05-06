<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
	'subtitle' => array(
        'label'  => esc_html__( 'Main Description', 'plan-up'),
        'desc'   => esc_html__( 'This will appear above the description', 'plan-up'),
        'size'  => 'large',
        'type'   => 'wp-editor',
        'reinit' => true,
        'editor_type' => 'tinymce',
        'editor_height' => 600,
        'tinymce' => true,
        'teeny' => false,
        'wpautop' => true,
	)
);

