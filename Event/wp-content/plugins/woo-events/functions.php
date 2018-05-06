<?php
if (!function_exists('we_filter_wc_get_template_fix')) {
	function we_filter_wc_get_template_fix($located, $template_name, $args, $template_path, $default_path){
		if($located==''){
			return get_stylesheet_directory() . '/woo-events/blank.php';;
		}else{
			return $located;
		}
	}
	add_filter( 'wc_get_template', 'we_filter_wc_get_template_fix', 999, 5 );
}
