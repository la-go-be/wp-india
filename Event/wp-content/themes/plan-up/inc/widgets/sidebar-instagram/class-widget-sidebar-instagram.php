<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Sidebar_Instagram extends WP_Widget {

	/**
	 * @internal
	 */
	function __construct() {
		$widget_ops = array(
			'description' => esc_html__('Instagram image gallery on sidebar','plan-up') ,
			'classname' => 'hw-gallery'
		);
		parent::__construct( false, esc_html__( 'Sidebar Instagram', 'plan-up' ), $widget_ops );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$user_id = esc_attr( $instance['flickr_id'] );
		$client_id = esc_attr( $instance['client_id'] );
		$access_token = esc_attr( $instance['access_token'] );
		$title     = esc_attr( $instance['title'] );
		$number    = ( (int) ( esc_attr( $instance['number'] ) ) > 0 ) ? esc_attr( $instance['number'] ) : 16;
		$title     = $before_title. $title . $after_title;

		wp_enqueue_script(
			'fw-sidebar-instagram-widget',
			get_template_directory_uri() . '/inc/widgets/sidebar-instagram/static/js/scripts.js',
			array( 'jquery' ),
			'1.0'
		);

		$filepath = get_template_directory()."/inc/widgets/sidebar-instagram/views/widget.php";

		if ( file_exists( $filepath ) ) {
			include( $filepath );
		}
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array(
			'flickr_id' => '1702244543',
			'number' => '12',
			'title' => 'INSTAGRAM GALLERY',
			'client_id' => 'dbced689c6da4c3d904fd0ee8d123781',
			'access_token' => '1702244543.dbced68.ee49480cad29402f94887366a2eefea2'
		) );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'plan-up' ); ?> </label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"
			       value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'flickr_id' )); ?>"><?php esc_html_e( 'User ID', 'plan-up' ); ?> (<a
					href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'flickr_id' )); ?>"
			       value="<?php echo esc_attr( $instance['flickr_id'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'flickr_id' )); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'client_id' )); ?>"><?php esc_html_e( 'Client ID', 'plan-up' ); ?> (<a
					href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'client_id' )); ?>"
			       value="<?php echo esc_attr( $instance['client_id'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'client_id' )); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>"><?php esc_html_e( 'Access Token', 'plan-up' ); ?> (<a
					href="http://www.idgettr.com" target="_blank">idGettr</a>):</label>
			<input type="text" name="<?php echo esc_attr($this->get_field_name( 'access_token' )); ?>"
			       value="<?php echo esc_attr( $instance['access_token'] ); ?>" class="widefat"
			       id="<?php echo esc_attr($this->get_field_id( 'access_token' )); ?>"/>
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
