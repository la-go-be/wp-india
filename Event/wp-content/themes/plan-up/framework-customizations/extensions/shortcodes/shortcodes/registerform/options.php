<?php if (!defined('FW')) die('Forbidden');

$options = array(
	'form_settings' => array(
		'type' => 'tab',
		'title' => esc_html__('Form', 'plan-up'),
		'options' => array(
			'form_name' => array(
				'type' => 'text',
				'label' => esc_html__('Form name', 'plan-up'),
				'value' => 'REGISTRATION'
			),
			'form_title' => array(
				'type' => 'text',
				'label' => esc_html__('Form title', 'plan-up'),
				'value' => 'Online Event Register Form'
			),
			'form_select' => array(
				'type' => 'text',
				'label' => esc_html__('Select label', 'plan-up'),
				'value' => 'Select your price type*'
			),
			'form_option' => array(
				'type' => 'addable-box',
				'label' => esc_html__('Options to choose', 'plan-up'),
				'template' => '{{=name}}',
				'box-options' => array(
					'name' => array('type' => 'text', 'label' => esc_html__('Name', 'plan-up')),
					'price' => array('type' => 'text', 'label' => esc_html__('Price', 'plan-up'))
				)
			),
			'form_submit' => array(
				'type' => 'text',
				'label' => esc_html__('Submit text', 'plan-up'),
				'value' => 'RESERVE MY SEAT NOW!'
			),
			'paypal_mode' => array(
                'type' => 'switch',
                'label' => esc_html__('Paypal Mode', 'plan-up'),
                'desc' => esc_html__('Switch mode of Paypal: Sandbox (Text) or Live', 'plan-up'),
                'left-choice' => array(
                    'value' => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
                    'label' => esc_html__('Test', 'plan-up')
                ),
                'right-choice' => array(
                    'value' => 'https://www.paypal.com/cgi-bin/webscr',
                    'label' => esc_html__('Live', 'plan-up')
                )
            ),
			'paypal' => array(
				'type' => 'text',
				'label' => esc_html__('Paypal account', 'plan-up'),
				'value' => 'dinhvantrang-facilitator@outlook.com',
				'help' => esc_html__('To make sure that payment system with Paypal work properly and safe, please make sure that your customers MUST RETURN BACK to your website after payment. To do that <a target="_blank" href="https://nimbus.everhelper.me/client/notes/share/401605/169s1s9p7e0n6ozz4wkz">View this</a> and <a target="_blank" href="https://nimbus.everhelper.me/client/notes/share/401609/02ul1p8b8tamspzbtrxl">View this</a> (Note: learners mean customers)','mauris')
			)
		)
	),
	'price_table' => array(
		'type' => 'tab',
		'title' => esc_html__('Price Table', 'plan-up'),
		'options' => array(
			'show_right_pane' => array(
				'type' => 'switch',
				'label' => esc_html__('Show show price table', 'plan-up'),
			),
			'price_name' => array(
				'type' => 'text',
				'label' => esc_html__('Price table name', 'plan-up'),
				'value' => 'PRICE TABLE'
			),
			'tickets' => array(
				'type' => 'addable-popup',
				'label' => esc_html__('Add/Edit price options', 'plan-up'),
				'template' => '{{=name}}',
				'popup-options' => array(
					'name' => array(
						'type' => 'text',
						'label' => esc_html__('Name', 'plan-up')
					),
					'feature' => array(
						'type' => 'textarea',
						'label' => esc_html__('Features', 'plan-up'),
						'desc' => esc_html__('Each feature, each line', 'plan-up')
					),
					'price' => array(
						'type' => 'text',
						'label' => esc_html__('Price', 'plan-up'),
						'desc' => esc_html__('Must be a number', 'plan-up')
					),
					'quantity' => array(
						'type' => 'text',
						'label' => esc_html__('Quantity', 'plan-up'),
					)
				)
			),
			'price_desc' => array(
				'type' => 'textarea',
				'label' => esc_html__('Price description', 'plan-up')
			),
		)
	),
	'other_settings' => array(
		'type' => 'tab',
		'title' => esc_html__('Other Settings', 'mauris'),
		'options' => array(
			'currency' => array(
				'type' => 'text',
				'label' => esc_html__('Currency Code', 'plan-up'),
				'value' => 'USD'
			),
			'form_action' => array(
				'type' => 'textarea',
				'label' => esc_html__('MailChimp List/Campaign', 'plan-up'),
				'desc' => esc_html__('MailChimp form action link', 'plan-up'),
				'help' => esc_html__('Go to one your MailChimp List/Campaign, then see the subscribe form in view of draw HTML, you will paste the code between action attribe of the form to here', 'plan-up')
			),
			'form_desc' => array(
				'type' => 'textarea',
				'label' => esc_html__('Subscribe description', 'plan-up'),
				'value' => 'Don’t want to miss anything from this special event. Join our newsletter and stay up-to-date by using your email above.'
			),
		)
	)
);