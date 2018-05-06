<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'tabs' => array(
		'type'          => 'addable-popup',
		'label'         => esc_html__( 'Tabs', 'plan-up' ),
		'popup-title'   => esc_html__( 'Add/Edit Tabs', 'plan-up' ),
		'desc'          => esc_html__( 'Create your tabs', 'plan-up' ),
		'template'      => '{{=tab_title}}',
		'popup-options' => array(
			'tab_title'   => array(
				'type'  => 'text',
				'label' => esc_html__('Title', 'plan-up')
			),
			'tab_content' => array(
				'type'   => 'wp-editor',
				'reinit' => true,
				'label'  => esc_html__( 'Content', 'plan-up'),
				'desc'   => esc_html__( '', 'plan-up'),
				'size'  => 'large',
				'editor_type' => 'tinymce',
				'editor_height' => 300,
				'tinymce' => true,
				'teeny' => false,
				'wpautop' => false,
			)
		)
	)
);