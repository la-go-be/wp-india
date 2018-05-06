<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style'   => array(
		'type'    => 'select',
		'label'   => esc_html__('Box Style', 'plan-up'),
		'choices' => array(
			'fw-iconbox-1' => esc_html__('Icon above title', 'plan-up'),
			'fw-iconbox-2' => esc_html__('Icon in line with title', 'plan-up')
		)
	),
	'icon'    => array(
		'type'  => 'icon',
		'label' => esc_html__('Choose an Icon', 'plan-up'),
		'set' => 'ionicon',
	),
	'title'   => array(
		'type'  => 'text',
		'label' => esc_html__( 'Title of the Box', 'plan-up' ),
	),
	'content' => array(
		'type'   => 'wp-editor',
		'reinit' => true,
		'label'  => false,
		'desc'   => esc_html__( 'Enter some content for this texblock', 'plan-up'),
		'size'  => 'large',
		'editor_type' => 'tinymce',
		'editor_height' => 300,
		'tinymce' => true,
		'teeny' => false,
		'wpautop' => false,
	),
	'link' => array(
		'type' => 'text',
		'label' => esc_html__('Link', 'plan-up')
	),
	'url' => array(
		'type' => 'text',
		'label' => esc_html__('URL', 'plan-up')
	),
	'color' => array(
		'type' => 'color-picker',
		'label' => esc_html__('Icon Color', 'plan-up'),
		'value' => '#36392e'
	),
	'target' => array(
		'type' => 'switch',
		'label' => esc_html__('Open in new tab?', 'plan-up'),
		'left-choice' => array(
			'value' => 'target=_blank',
			'label' => esc_html__('Yes', 'plan-up')
		),
		'right-choice' => array(
			'value' => 'target=_self',
			'label' => esc_html__('No', 'plan-up')
		)
	)
);