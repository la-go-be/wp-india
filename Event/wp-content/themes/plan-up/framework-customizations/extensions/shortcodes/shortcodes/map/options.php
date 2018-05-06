<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$map_shortcode = fw_ext('shortcodes')->get_shortcode('map');
$options = array(
	'data_provider' => array(
		'type'  => 'multi-picker',
		'label' => false,
		'desc'  => false,
		'picker' => array(
			'population_method' => array(
				'label'   => esc_html__('Population Method', 'plan-up'),
				'desc'    => esc_html__( 'Select map population method (Ex: events, custom)', 'plan-up' ),
				'type'    => 'select',
				'choices' => $map_shortcode->_get_picker_dropdown_choices(),
			)
		),
		'choices' => $map_shortcode->_get_picker_choices(),
		'show_borders' => false,
	),
	'map_type' => array(
		'type'  => 'select',
		'label' => esc_html__('Map Type', 'plan-up'),
		'desc'  => esc_html__('Select map type', 'plan-up'),
		'choices' => array(
			'roadmap'   => esc_html__('Roadmap', 'plan-up'),
			'terrain' => esc_html__('Terrain', 'plan-up'),
			'satellite' => esc_html__('Satellite', 'plan-up'),
			'hybrid'    => esc_html__('Hybrid', 'plan-up')
		)
	),
	'map_zoom' => array(
	    'type'  => 'slider',
	    'value' => 16,
	    'properties' => array(
	        'min' => 5,
	        'max' => 20,
	        'step' => 1,
	    ),
	    'label' => esc_html__('Map Zoom', 'plan-up'),
	),
	'map_height' => array(
		'label' => esc_html__('Map Height', 'plan-up'),
		'desc'  => esc_html__('Set map height (Ex: 300)', 'plan-up'),
		'type'  => 'text'
	),
	'map_style' => array(
		'label' => esc_html__('Map style', 'plan-up'),
		'type' => 'textarea',
		'desc' => esc_html__('Please go to https://snazzymaps.com get one style for map', 'plan-up')
	),
	'disable_scrolling' => array(
		'type'  => 'switch',
		'value' => false,
		'label' => esc_html__('Disable zoom on scroll', 'plan-up'),
		'desc'  => esc_html__('Prevent the map from zooming when scrolling until clicking on the map', 'plan-up'),
		'left-choice' => array(
			'value' => false,
			'label' => esc_html__('Yes', 'plan-up'),
		),
		'right-choice' => array(
			'value' => true,
			'label' => esc_html__('No', 'plan-up'),
		),
	),
);