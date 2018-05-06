<?php
/**
 * Content Blocks Widget
 *
 * @package    Hoot
 * @subpackage Creattica
 */

/**
* Class Hoot_Content_Blocks_Widget
*/
class Hoot_Content_Blocks_Widget extends HybridExtend_WP_Widget {

	function __construct() {

		$settings['id'] = 'hoot-content-blocks-widget';
		$settings['name'] = __( 'Hoot > Content Blocks', 'creattica' );
		$settings['widget_options'] = array(
			'description'	=> __('Display Styled Content Blocks.', 'creattica'),
			'class'			=> 'hoot-content-blocks-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			array(
				'name'		=> __( "Title (optional)", 'creattica' ),
				'id'		=> 'title',
				'type'		=> 'text',
			),
			array(
				'name'		=> __( 'Blocks Style', 'creattica' ),
				'id'		=> 'style',
				'type'		=> 'images',
				'std'		=> 'style1',
				'options'	=> array(
					'style1'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-1.png',
					'style2'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-2.png',
					'style3'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-3.png',
					'style4'	=> HYBRIDEXTEND_INCURI . 'admin/images/content-block-style-4.png',
				),
			),
			array(
				'name'		=> __( 'No. Of Columns', 'creattica' ),
				'id'		=> 'columns',
				'type'		=> 'select',
				'std'		=> '3',
				'options'	=> array(
					'1'	=> __( '1', 'creattica' ),
					'2'	=> __( '2', 'creattica' ),
					'3'	=> __( '3', 'creattica' ),
					'4'	=> __( '4', 'creattica' ),
					'5'	=> __( '5', 'creattica' ),
				),
			),
			array(
				'name'		=> __( 'Border', 'creattica' ),
				'desc'		=> __( 'Top and bottom borders.', 'creattica' ),
				'id'		=> 'border',
				'type'		=> 'select',
				'std'		=> 'none none',
				'options'	=> array(
					'line line'		=> __( 'Top - Line || Bottom - Line', 'creattica' ),
					'line shadow'	=> __( 'Top - Line || Bottom - StrongLine', 'creattica' ),
					'line none'		=> __( 'Top - Line || Bottom - None', 'creattica' ),
					'shadow line'	=> __( 'Top - StrongLine || Bottom - Line', 'creattica' ),
					'shadow shadow'	=> __( 'Top - StrongLine || Bottom - StrongLine', 'creattica' ),
					'shadow none'	=> __( 'Top - StrongLine || Bottom - None', 'creattica' ),
					'none line'		=> __( 'Top - None || Bottom - Line', 'creattica' ),
					'none shadow'	=> __( 'Top - None || Bottom - StrongLine', 'creattica' ),
					'none none'		=> __( 'Top - None || Bottom - None', 'creattica' ),
				),
			),
			array(
				'name'		=> __( 'Content Boxes', 'creattica' ),
				'id'		=> 'boxes',
				'type'		=> 'group',
				'options'	=> array(
					'item_name'	=> __( 'Content Box', 'creattica' ),
				),
				'fields'	=> array(
					array(
						'name'		=> __( 'Title/Content/Image', 'creattica' ),
						'desc'		=> __( 'Page Title, Content and Featured Image will be used.', 'creattica' ),
						'id'		=> 'page',
						'type'		=> 'select',
						'options'	=> Hybridextend_WP_Widget::get_wp_list('page'),
					),
					array(
						'name'		=> __('Display excerpt instead of full content', 'creattica'),
						'desc'		=> __( 'In excerpts, "Read More" link will be automatically inserted if no custom link is provided below.', 'creattica' ),
						'id'		=> 'excerpt',
						'type'		=> 'checkbox'),
					array(
						'name'		=> __('Link Text (optional)', 'creattica'),
						'id'		=> 'link',
						'type'		=> 'text'),
					array(
						'name'		=> __('Link URL', 'creattica'),
						'id'		=> 'url',
						'std'		=> 'http://',
						'type'		=> 'text',
						'sanitize'	=> 'url'),
					array(
						'name'		=> __('Icon', 'creattica'),
						'desc'		=> __( 'Use an icon instead of featured image of the page selected above.', 'creattica' ),
						'id'		=> 'icon',
						'type'		=> 'icon',
					),
					array(
						'name'		=> __( 'Icon Style', 'creattica' ),
						'id'		=> 'icon_style',
						'type'		=> 'select',
						'std'		=> 'circle',
						'options'	=> array(
							'none'		=> __( 'None', 'creattica' ),
							'circle'	=> __( 'Circle', 'creattica' ),
							'square'	=> __( 'Square', 'creattica' ),
						),
					),
				),
			),
		);

		$settings = apply_filters( 'hoot_content_blocks_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Echo the widget content
	 */
	function display_widget( $instance, $before_title = '', $title='', $after_title = '' ) {
		extract( $instance, EXTR_SKIP );
		include( hybridextend_locate_widget( 'content-blocks' ) ); // Loads the widget/content-blocks or template-parts/widget-content-blocks.php template.
	}

}

/**
 * Register Widget
 */
function hoot_content_blocks_widget_register(){
	register_widget('Hoot_Content_Blocks_Widget');
}
add_action('widgets_init', 'hoot_content_blocks_widget_register');