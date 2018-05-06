<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Sidebar_Flickr extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__('Flickr image gallery on sidebar','plan-up'),
			'classname' => 'hw-gallery'
		);
		parent::__construct( false, esc_html__( 'Sidebar Flickr', 'plan-up' ), $widget_ops );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$flickr_id = esc_attr( $instance['flickr_id'] );
		$title     = esc_attr( $instance['title'] );
		$number    = ( (int) ( esc_attr( $instance['number'] ) ) > 0 ) ? esc_attr( $instance['number'] ) : 16;
		$title     = $before_title. $title . $after_title;

		wp_enqueue_script(
			'fw-sidebar-flickr-widget',
			get_template_directory_uri() . '/inc/widgets/sidebar-flickr/static/js/scripts.js',
			array( 'jquery' ),
			'1.0'
		);

		$filepath = get_template_directory()."/inc/widgets/sidebar-flickr/views/widget.php";

		if ( file_exists( $filepath ) ) {
			include( $filepath );
		}
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'flickr_id' => '52617155@N08', 'number' => '12', 'title' => 'FLICKR GALLERY' ) );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'plan-up' ); ?> </label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'flickr_id' )); ?>"><?php esc_html_e( 'Flickr ID', 'plan-up' ); ?> (<a
					href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'flickr_id' )); ?>"
			       value="<?php echo esc_attr( $instance['flickr_id'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'flickr_id' )); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e( 'Number of photos', 'plan-up' ); ?>
				:</label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>"
			       value="<?php echo esc_attr( $instance['number'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"/>
		</p>
	<?php
	}
}
