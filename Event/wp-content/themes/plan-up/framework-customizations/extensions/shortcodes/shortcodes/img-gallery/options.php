<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'source' => array(
		'type'     => 'multi-picker',
		'label'    => false,
		'desc'     => false,
		'picker' => array(
			'img_source' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Image Source', 'plan-up' ),
				'desc'    => esc_html__( '', 'plan-up' ),
				'choices' => array(
					'flickr' => esc_html__( 'Flickr', 'plan-up' ),
					'instagram'  => esc_html__( 'Instagram', 'plan-up' ),
				)
			)
		),
		'choices'     => array(
			'flickr' => array(
				'user_id' => array(
					'type' => 'text',
					'label' => esc_html__('User ID', 'plan-up')
				),
				'user_set_id' => array(
					'type' => 'text',
					'label' => esc_html__('User set ID', 'plan-up')
				),
				'group_id' => array(
					'type' => 'text',
					'label' => esc_html__('Group ID', 'plan-up')
				),
				'number' => array(
					'type' => 'slider',
					'label' => esc_html__('Number of pic', 'plan-up'),
					'properties' => array(
				        'min' => 1,
				        'max' => 10,
				        'sep' => 1,
					),
					'value' => 5
				)
			),
			'instagram' => array(
				'user_id' => array(
					'type' => 'text',
					'label' => esc_html__('User ID', 'plan-up'),
					'help' => esc_html__('Please go to http://jelled.com/instagram/lookup-user-id to get the user ID', 'plan-up')
				),
				'client_id' => array(
					'type' => 'hidden',
					'label' => esc_html__('Client ID', 'plan-up'),
					'value' => ''
				),
				'access_token' => array(
					'type' => 'text',
					'label' => esc_html__('Access Token', 'plan-up'),
					'value' => '1702244543.dbced68.ee49480cad29402f94887366a2eefea2'
				),
				'number' => array(
					'type' => 'slider',
					'label' => esc_html__('Number of pic', 'plan-up'),
					'properties' => array(
				        'min' => 1,
				        'max' => 15,
				        'sep' => 1,
					),
					'value' => 5
				)
			)
		)
	),
	'f_link' => array(
		'type' => 'text',
		'label' => esc_html__('Follow text', 'plan-up'),
	),
	'f_url' => array(
		'type' => 'text',
		'label' => esc_html__('Follow URL', 'plan-up')
	),
	'icon' => array(
		'label' => esc_html__('Icon', 'plan-up'),
		'type' => 'icon',
		'value' => '',
	),
);
