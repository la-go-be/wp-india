<?php if (!defined('FW')) die('Forbidden');

$cfg = array(
	'page_builder' => array(
		'tab'         => esc_html__('Layout Elements', 'plan-up'),
		'title'       => esc_html__('Section', 'plan-up'),
		'description' => esc_html__('Add a Section', 'plan-up'),
		'type'        => 'section', // WARNING: Do not edit this,
        'popup_size'  => 'large',
        'title_template' => '{{-title}}{{ if (o.section_id) { }} : <strong>{{= o.section_id}}</strong>{{ } }}',
	)
);