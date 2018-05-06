<?php
function wc_custom_lost_password_form( $atts ) {

    return wc_get_template( 'myaccount/form-lost-password.php', array( 'form' => 'lost_password' ) );

}
add_shortcode( 'lost_password_form', 'wc_custom_lost_password_form' );
