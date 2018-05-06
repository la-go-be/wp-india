<?php if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}
if ( defined( 'FW' ) ) {
	$fw_social_facebook = fw()->extensions->get( 'social-facebook' );
	if ( ! empty( $fw_social_facebook ) ) {

		class Widget_Facebook_Page_Stream extends WP_Widget {

			/**
			 * @internal
			 */
			function __construct() {
				$widget_ops = array( 'description' => 'Page Steam' );
				parent::__construct( false, esc_html__( 'Facebook', 'plan-up' ), $widget_ops );
			}

			/**
			 * @param array $args
			 * @param array $instance
			 */
			function widget( $args, $instance ) {
				extract( $args );

				$title         = esc_attr( $instance['title'] );
				$page_id       = esc_attr( $instance['page_id'] );
				$number        = ( (int) ( esc_attr( $instance['number'] ) ) > 0 ) ? esc_attr( $instance['number'] ) : 5;
				$before_widget = str_replace( 'class="', 'class="widget_facebook_page_stream ', $before_widget );
				$title         = str_replace( 'class="', 'class="widget_facebook_page_stream ', $before_title ) . $title . $after_title;
				$title         = $before_title . $title . $after_title;

				$result = fw_ext_social_facebook_graph_api_explorer( 'GET', $page_id, array( 'fields' => 'posts.limit(' . $number . '){message}' ) );
				$result = json_decode( $result );
				if ( ! empty( $result->posts->data ) ) {
					$posts     = $result->posts->data;
					$view_path = get_template_directory()."/inc/widgets/facebook-page-stream/views/widget.php";
					echo fw_render_view( $view_path, compact( 'before_widget', 'title', 'posts', 'number', 'after_widget' ) );
				}
			}

			function update( $new_instance, $old_instance ) {
				return $new_instance;
			}

			function form( $instance ) {
				$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'page_id' => '', 'number' => '' ) );

				?>
				<p>
					<label
						for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title', 'plan-up' ); ?> </label>
					<input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"
					       value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
					       id="<?php $this->get_field_id( 'title' ); ?>"/>
				</p>
				<p>
					<label
						for="<?php echo esc_attr($this->get_field_id( 'page_id' )); ?>"><?php esc_html_e( 'Page ID:', 'plan-up' ); ?> </label>
					<input type="text" name="<?php echo esc_attr($this->get_field_name( 'page_id' )); ?>"
					       value="<?php echo esc_attr( $instance['page_id'] ); ?>" class="widefat"
					       id="<?php $this->get_field_id( 'page_id' ); ?>"/>
				</p>
				<p>
					<label
						for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e( 'Number of posts:', 'plan-up' ); ?>
						:</label>
					<input type="text" name="<?php echo esc_attr($this->get_field_name('number')); ?>"
					       value="<?php echo esc_attr( $instance['number'] ); ?>" class="widefat"
					       id="<?php echo esc_attr($this->get_field_id('number')); ?>"/>
				</p>
			<?php
			}
		}
	}
}


