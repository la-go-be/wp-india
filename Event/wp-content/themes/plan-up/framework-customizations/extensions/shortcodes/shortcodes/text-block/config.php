<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Text Block', 'plan-up'),
	'description' => esc_html__( 'Add a Text Block', 'plan-up'),
	'tab'         => esc_html__( 'Basic', 'plan-up'),
	'popup_size'  => 'large',
	'title_template' => '{{- title }}{{ if (o.text.replace(/(<([^>]+)>)/ig,"")) { }} : {{- o.text.replace(/(<([^>]+)>)/ig,"") }}{{ } }}',
);
