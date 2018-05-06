<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'style' => array(
		'label' => esc_html__('Style', 'plan-up'),
		'type' => 'select',
		'value' => '1',
		'choices' => array(
			'1' => esc_html__('Theme style','plan-up'),
			'0' => esc_html__('Normal', 'plan-up')
		)
	),
	'speaker' => array(
		'type' => 'multi-select',
		'label' => esc_html__('Speaker', 'plan-up'),
		'desc' => esc_html__('Just choose a speaker from the list of your speakers and no need to set up the options below anymore.', 'plan-up'),
		'help' => esc_html__('This a upgraded feature, you can leave this empty and set up the options below as the old way, it is okay.', 'plan-up'),
		'population' => 'posts',
		'source' => 'speaker',
		'limit' => 1
	),
	'image' => array(
		'label' => esc_html__( 'Team Member Image', 'plan-up' ),
		'desc'  => esc_html__( 'Either upload a new, or choose an existing image from your media library', 'plan-up' ),
		'type'  => 'upload'
	),
	'name'  => array(
		'label' => esc_html__( 'Team Member Name', 'plan-up' ),
		'desc'  => esc_html__( 'Name of the person', 'plan-up' ),
		'type'  => 'text',
		'value' => ''
	),
	'job'   => array(
		'label' => esc_html__( 'Team Member Job Title', 'plan-up' ),
		'desc'  => esc_html__( 'Job title of the person.', 'plan-up' ),
		'type'  => 'text',
		'value' => ''
	),
	'desc'  => array(
		'label' => esc_html__( 'Team Member Social Network', 'plan-up' ),
		'desc'  => esc_html__( 'Example: '.htmlspecialchars('<a href="#" class="fa fa-linkedin-square"></a> <a href="#" class="fa fa-facebook-official"></a>'), 'plan-up' ),
		'type'  => 'textarea',
		'value' => ''
	),
	'desc_2'  => array(
		'label' => esc_html__( 'Team Member Description', 'plan-up' ),
		'desc'  => esc_html__( 'Enter a few words that describe the person', 'plan-up' ),
		'type'  => 'textarea',
		'value' => ''
	),
	'url' => array(
		'label' => esc_html__('URL', 'plan-up'),
		'type' => 'text',
		'value' => '#'
	)
);