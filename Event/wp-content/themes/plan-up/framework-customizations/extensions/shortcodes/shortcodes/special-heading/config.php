<?php if (!defined('FW')) die('Forbidden');

$cfg = array();

$cfg['page_builder'] = array(
	'title'         => esc_html__('Special Heading', 'plan-up'),
	'description'   => esc_html__('Add a Special Heading', 'plan-up'),
	'tab'           => esc_html__('Basic', 'plan-up'),
	'title_template' => '{{- title }}: {{- o.title }}',
);