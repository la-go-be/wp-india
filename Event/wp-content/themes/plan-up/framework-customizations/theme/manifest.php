<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$manifest = array();

$manifest['id'] = 'scratch';

$manifest['supported_extensions'] = array(
	'page-builder' => array(),
	'backups' => array(),
	'slider' => array(),
	'social' => array(),
	'fw-pending-mode' => array(),
    'event-register-management' => array(),
);
