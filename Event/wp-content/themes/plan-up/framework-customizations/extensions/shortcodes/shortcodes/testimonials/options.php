<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style' => array(
		'label' => esc_html__('Testimonial Style', 'plan-up'),
		'type' => 'switch',
		'value' => 'theme',
		'right-choice' => array(
			'value' => 'plugin',
			'label' => esc_html__('Slide', 'plan-up')
		),
		'left-choice' => array(
			'value' => 'theme',
			'label' => esc_html__('Block', 'plan-up')
		)
	),
	'testimonials' => array(
		'label'         => esc_html__( 'Testimonials', 'plan-up' ),
		'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'plan-up' ),
		'desc'          => esc_html__( 'Here you can add, remove and edit your Testimonials.', 'plan-up' ),
		'type'          => 'addable-popup',
		'template'      => '{{=author_name}}',
		'popup-options' => array(
			'content'       => array(
				'label' => esc_html__( 'Quote', 'plan-up' ),
				'desc'  => esc_html__( 'Enter the testimonial here', 'plan-up' ),
				'type'  => 'textarea',
				'teeny' => true
			),
			'author_avatar' => array(
				'label' => esc_html__( 'Image', 'plan-up' ),
				'desc'  => esc_html__( 'Either upload a new, or choose an existing image from your media library', 'plan-up' ),
				'type'  => 'upload',
			),
			'author_name'   => array(
				'label' => esc_html__( 'Name', 'plan-up' ),
				'desc'  => esc_html__( 'Enter the Name of the Person to quote', 'plan-up' ),
				'type'  => 'text'
			),
			'author_job'    => array(
				'label' => esc_html__( 'Position', 'plan-up' ),
				'desc'  => esc_html__( 'Can be used for a job description', 'plan-up' ),
				'type'  => 'text'
			),
		)
	),

);