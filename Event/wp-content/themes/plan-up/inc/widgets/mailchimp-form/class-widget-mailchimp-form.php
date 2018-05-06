<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

class Widget_Mailchimp_Form extends WP_Widget {

    /**
     * @internal
     */
    function __construct() {
        $widget_ops = array( 'description' => '' );
        parent::__construct( false, esc_html__( 'MailChimp Form', 'plan-up'), $widget_ops );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        extract( $args );
        $title     = esc_attr( $instance['title'] );
        $title = $before_title.$title.$after_title;
        $mc_action     = esc_attr( $instance['mc_action'] );
        $mc_btn_label     = esc_attr( $instance['mc_btn_label'] );
        $mail_label     = esc_attr( $instance['mail_label'] );
        $name_label     = esc_attr( $instance['name_label'] );
        $desc     = html_entity_decode($instance['desc']);

        $filepath = get_template_directory()."/inc/widgets/mailchimp-form/views/widget.php";
        if ( file_exists( $filepath ) ) {
            include( $filepath );
        }
    }

    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'mc_action' => '', 'title' => 'Subscribe','mc_btn_label' => 'SUBSCRIBE US', 'mail_label' => 'Email*', 'name_label' => 'Name*', 'desc' => '' ) );
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title', 'plan-up'); ?> </label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                   value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'title' ); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'desc' )); ?>"><?php esc_html_e( 'Descitpion', 'plan-up'); ?></label>
            <textarea name="<?php echo esc_attr($this->get_field_name( 'desc' )); ?>" id="<?php $this->get_field_id( 'desc' ); ?>" class="widefat"><?php echo esc_attr( $instance['desc'] ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'mc_action' )); ?>"><?php esc_html_e( 'Action URL', 'plan-up'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name( 'mc_action' )); ?>"
                   value="<?php echo esc_attr( $instance['mc_action'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'mc_action' ); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'name_label' )); ?>"><?php esc_html_e( 'Name Label', 'plan-up'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name( 'name_label' )); ?>"
                   value="<?php echo esc_attr( $instance['name_label'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'name_label' ); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'mail_label' )); ?>"><?php esc_html_e( 'Mail Label', 'plan-up'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name( 'mail_label' )); ?>"
                   value="<?php echo esc_attr( $instance['mail_label'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'mail_label' ); ?>"/>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'mc_btn_label' )); ?>"><?php esc_html_e( 'Button Text', 'plan-up'); ?></label>
            <input type="text" name="<?php echo esc_attr($this->get_field_name( 'mc_btn_label' )); ?>"
                   value="<?php echo esc_attr( $instance['mc_btn_label'] ); ?>" class="widefat"
                   id="<?php $this->get_field_id( 'mc_btn_label' ); ?>"/>
        </p>
    <?php
    }
}