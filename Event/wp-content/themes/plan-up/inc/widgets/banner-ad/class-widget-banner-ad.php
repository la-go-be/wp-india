<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Banner_Ad extends WP_Widget {

    /**
     * @internal
     */
    function __construct() {
        $widget_ops = array( 'description' => '' );
        parent::__construct( false, esc_html__( 'Banner Ad', 'plan-up'), $widget_ops );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        extract( $args );
        $banner_url     = esc_attr( $instance['banner-url'] );
        $des_url     = esc_attr( $instance['des-url'] );

        $filepath = get_template_directory()."/inc/widgets/banner-ad/views/widget.php";
        if ( file_exists( $filepath ) ) {
            include( $filepath );
        }
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'des-url' => '', 'banner-url' => '' ) );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'banner-url' ) ); ?>"><?php esc_html_e( 'Banner Image URL', 'plan-up'); ?> </label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name('banner-url') ); ?>"
                   value="<?php echo esc_attr( $instance['banner-url'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'banner-url' ); ?>"/>
            <small><?php esc_html_e('URL of the image', 'plan-up'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'des-url' )); ?>"><?php esc_html_e( 'Destination URL', 'plan-up'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name( 'des-url' )); ?>"
                   value="<?php echo esc_attr( $instance['des-url'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'des-url' ); ?>"/>
            <small><?php esc_html_e('Eg: http://google.com', 'plan-up'); ?></small>
        </p>
    <?php
    }
}