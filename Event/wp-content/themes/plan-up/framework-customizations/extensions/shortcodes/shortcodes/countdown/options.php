<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'pane-basic' => array(
		'type' => 'tab',
		'title' => esc_html__('Basic settings', 'plan-up'),
		'options' => array(
			'style' => array(
				'type' => 'select',
				'label' => esc_html__('Style','plan-up'),
				'desc' => esc_html__('If you choose style Extend, please set up tab DESC and VIDEO', 'plan-up'),
				'value' => 'circle',
				'choices' => array(
					'extend' => esc_html__('Extend','plan-up'),
					'basic' => esc_html__('Basic', 'plan-up'),
					'circle' => esc_html__('Basic circle', 'plan-up'),
					'square' => esc_html__('Basic square', 'plan-up')
				)
			),
			'color' => array(
				'label' => esc_html__('Color Text', 'plan-up'),
				'type' => 'color-picker',
				'value' => '#fff'
			),
			'datetime' => array(
				'label' => esc_html__('Time', 'plan-up'),
				'desc'  => esc_html__('Enter date. For example: April 1, 2015 00:00:00', 'plan-up'),
				'type'  => 'text',
				'value' => 'April 1, 2020 00:00:00'
			),
			'day_text' => array(
				'label' => esc_html__('Day Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'days'
			),
			'hour_text' => array(
				'label' => esc_html__('Hour Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'hours'
			),
			'min_text' => array(
				'label' => esc_html__('Minute Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'minutes'
			),
			'sec_text' => array(
				'label' => esc_html__('Second Text', 'plan-up'),
				'type'  => 'text',
				'value' => 'seconds',
				'help' => esc_html__('Leave it empty if you do not want to show seconds', 'plan-up')
			),
		)
	),
	'panel-1' => array(
		'type' => 'tab',
		'title' => esc_html__('DESC', 'plan-up'),
		'options' => array(
			'desc' => array(
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
			'btn_label' => array(
				'type' => 'text',
				'label' => esc_html__('Button label', 'plan-up'),
				'value' => 'VIEW'
			),
			'btn_url' => array(
				'type' => 'text',
				'label' => esc_html__('URL', 'plan-up'),
				'value' => ''
			)
		)
	),
	'pane-2' =>  array(
		'type' => 'tab',
		'title' => esc_html__('Video', 'plan-up'),
		'options' => array(
			'video' => array(
				'type' => 'text',
				'label' => esc_html__('Video ID', 'plan-up'),
				'help' => esc_html__('Paste YouTube or Vimeo ID here','plan-up')
			),
			'video-desc' => array(
				'type' => 'textarea',
				'label' => esc_html__('Video description', 'plan-up'),
				'help' => esc_html__('You may need add html tag to style it', 'plan-up')
			)
		)
	)
);
