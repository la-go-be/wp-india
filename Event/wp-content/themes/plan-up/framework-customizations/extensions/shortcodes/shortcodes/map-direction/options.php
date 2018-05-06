<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'c_map' => array(
		'type' => 'tab',
		'title' => esc_html__('Map Config', 'plan-up'),
		'options' => array(
			'destination_coor' => array(
				'type' => 'text',
				'label' => esc_html__('Destination Coordinator', 'plan-up'),
				'value' => '51.5125195,-0.1207246',
				'desc' => esc_html__('Map coordinator of the destination in latitude and longitude', 'plan-up'),
				'help' => esc_html__('Index seperated by a comma. Eg: 20.989507, 105.795668', 'plan-up')
			),
			'destination_marker' => array(
				'type' => 'text',
				'label' => esc_html__('Destination marker', 'plan-up'),
				'desc' => esc_html__('Name of the destination', 'plan-up'),
				'value' => esc_html__('Strand Underpass, London, UK'),
			),
			'map_placeholder' => array(
				'label' => esc_html__('Direction Placeholder', 'plan-up'),
				'type' => 'text',
				'value' => esc_html__("Kings College London", "plan-up")
			),
			'map_zoom' => array(
				'type' => 'slider',
				'value' => 16,
				'properties' => array(
					'min' => 8,
					'max' => 18,
					'step' => 1
				)
			),
			'map_scroll' => array(
				'type' => 'switch',
				'value' => false,
				'label' => esc_html__('Use mouse scroll', 'plan-up'),
				'desc' => esc_html__('Use mouse scroll over the map to zoom in, zoom out?', 'plan-up')
			),
			'map_style' => array(
				'type' => 'textarea',
				'label' => esc_html__('Map Style', 'plan-up'),
				'value' => '[{"featureType":"landscape","stylers":[{"hue":"#FFBB00"},{"saturation":43.400000000000006},{"lightness":37.599999999999994},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#FFC200"},{"saturation":-61.8},{"lightness":45.599999999999994},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":51.19999999999999},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#FF0300"},{"saturation":-100},{"lightness":52},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#0078FF"},{"saturation":-13.200000000000003},{"lightness":2.4000000000000057},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#00FF6A"},{"saturation":-1.0989010989011234},{"lightness":11.200000000000017},{"gamma":1}]}]',
				'desc' => esc_html__('Get from https://snazzymaps.com', 'plan-up')
			),
			'geo' => array(
				'type' => 'checkbox',
				'label' => esc_html__('GEO enable', 'plan-up'),
				'desc' => esc_html__('If yes, site will ask the user the current position to fill the form', 'plan-up')
			),
		)
	),
	'c_form' => array(
		'type' => 'tab',
		'title' => esc_html__('Form setting', 'plan-up'),
		'options' => array(
			'form_label' => array(
				'type' => 'text',
				'label' => esc_html__('Form Label', 'plan-up'),
				'value' => esc_html__('<i class="ion-ios-compose"></i>Get Direction', 'plan-up')
			)
		)
	)
);