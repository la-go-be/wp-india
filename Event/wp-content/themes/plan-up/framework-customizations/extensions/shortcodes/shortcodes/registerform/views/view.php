<?php if (!defined('FW')) die('Forbidden');
if( is_front_page() ){
    $current_rel_uri = home_url();
}else{
    $current_rel_uri = home_url( add_query_arg( NULL, NULL ) );
}
$first_name = isset($_GET['first_name']) ? $_GET['first_name'] : '';
$last_name = isset($_GET['last_name']) ? $_GET['last_name'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
$phone = isset($_GET['phone']) ? $_GET['phone'] : '';
$quantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';
$ticket = isset($_GET['ticket']) ? $_GET['ticket'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';
$has_right_pane = 'wow fadeInLeft';
if( isset($atts['show_right_pane']) && $atts['show_right_pane'] == false )
    $has_right_pane = 'no_right_pane';
?>
<div class="registration-wrapper">
    <div class="register-form <?php echo esc_attr($has_right_pane); ?>">
        <?php
        $paypal_mode = isset($atts['paypal_mode']) ? $atts['paypal_mode'] : 'https://www.paypal.com/cgi-bin/webscr'; ?>
        <form action="<?php echo esc_url($paypal_mode); ?>" method="post" class="event-register-form">
            <!-- *******PAYPAL******** -->
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="<?php echo esc_attr($atts['paypal']); ?>">
            <input type="hidden" name="item_name" value="<?php echo get_bloginfo('name').__(' Event Registration', 'plan-up'); ?>">
            <input type="hidden" name="item_number" value="1">
            <input type="hidden" name="return" value="<?php echo esc_url($current_rel_uri).'/?action=success&payment_method=Paypal'; ?>">
            <input type="hidden" name="rm" value="2">
            <input type="hidden" name="cancel_return" value="<?php echo esc_url($current_rel_uri).'/?action=done'; ?>">
            <!-- ********************** -->
            <input type="text" name="mail_chimp" value="<?php echo $atts['form_action']; ?>" class="hidden">
            <h3 class="form-title"><?php echo $has_right_pane == 'no_right_pane' ? '<i class="ion-ios-compose" style="margin-right: 10px;"></i>' : ''; ?> <?php echo html_entity_decode($atts['form_title']); ?></h3>
            <label class="c-label half">
                <?php _e('First Name*', 'plan-up'); ?>
                <br>
                <input name="FNAME" class="c-input hidden" id="mce-FNAME" type="text">
                <!-- *******PAYPAL******** -->
                <input name="first_name" class="c-input required" id="mce-FNAME" type="text" required value="<?php echo esc_attr($first_name); ?>">
                <!-- ********************* -->
            </label>
            <label class="c-label half float-right">
                <?php _e('Last Name*', 'plan-up'); ?>
                <br>
                <input name="LNAME" class="c-input hidden" id="mce-LNAME" type="text">
                <!-- *******PAYPAL******** -->
                <input name="last_name" class="c-input required" id="mce-LNAME" type="text" required value="<?php echo esc_attr($last_name); ?>">
                <!-- ********************* -->
            </label>
            <label class="c-label half">
                <?php _e('Email*', 'plan-up'); ?>
                <br>
                <input name="EMAIL" class="email c-input hidden" id="mce-EMAIL" type="email">
                <!-- *******PAYPAL******** -->
                <input name="email" class="required email c-input" id="mce-EMAIL" type="email" required value="<?php echo esc_attr($email); ?>">
                <!-- ********************* -->
            </label>
            <label class="c-label half float-right">
                <?php _e('Phone', 'plan-up'); ?>
                <br>
                <input name="PHONE" class="c-input" id="mce-PHONE" type="text" value="<?php echo esc_attr($phone); ?>">
            </label>
            <label class="c-label half float-left">
                <?php echo html_entity_decode($atts['form_select']); ?>
                <br>
                <input type="hidden" value="<?php echo esc_attr($atts['currency']); ?>" name="currency_code" class="price-currency">
                <?php
                    if( isset($atts['form_option']) && !empty($atts['form_option']) ):
                ?>
                    <select name="amount">
                        <?php foreach ($atts['form_option'] as $key => $value) {
                    ?>
                        <option value="<?php echo esc_attr($value['price']); ?>"><?php echo esc_html( $value['name'] ); ?></option>
                    <?php
                        } ?>
                    </select>
                <?php
                    endif;
                ?>
            </label>
            <label class="c-label half float-right">
                <?php _e('Number of tickets', 'plan-up'); ?>
                <br>
                <input name="quantity" class="c-input" id="mce-quantity" type="number" min="1" max="50" step="1" value="1">
            </label>

            <?php if( $atts['form_action'] != '' ): ?>
                <label class="c-label full-width mail-chimp">
                    <?php _e('Subscribe for newsletter', 'plan-up'); ?>
                    <br>
                    <input type="checkbox" checked value="1" name="MAILCHIMP"><span class="desc"><?php echo html_entity_decode($atts['form_desc']); ?></span>
                </label>
            <?php endif; ?>
            <input id="mc-embedded-subscribe" type="submit" name="subscribe" class="ht-btn fw-btn fw-btn-1" value="<?php echo html_entity_decode($atts['form_submit']); ?>">
        </form>
        <?php if( isset($atts['form_name']) && $atts['form_name'] != '' ): ?>
            <h3 class="register-form-name"><?php echo html_entity_decode($atts['form_name']); ?></h3>
        <?php endif; ?>
    </div>
    <!-- /register-form -->
    <?php if( !isset($atts['show_right_pane']) || ( isset($atts['show_right_pane']) && $atts['show_right_pane'] == true) ): ?>
        <div class="price-table wow fadeInRight">
            <?php if( isset($atts['price_name']) && $atts['price_name'] != '' ):  ?>
                <h3 class="price-table-name"><?php echo html_entity_decode($atts['price_name']); ?></h3>
            <?php endif; ?>
            <div class="price-items">
                <?php if( !empty($atts['tickets']) ):
                        $i = 0;
                        foreach ($atts['tickets'] as $key => $value):
                            $f_price =  $value['name']." (".mauris_currency_symbol($atts['currency']).$value['price'].")";
                            $c1 = '';
                            $c2 = '';
                            if( count($atts['tickets']) < 2 ){
                                $c1 = 'current';
                            }else{
                                if( $i == 1 ){
                                    $c2 = 'current';
                                }
                            }
                        ?>
                    <div class="entry <?php echo esc_attr($c1.' '.$c2); ?>" data-price="<?php echo esc_attr($f_price); ?>" data-value="<?php echo esc_attr($value['price']); ?>">
                        <p class="name"><i class="ion-ios-checkmark-empty"></i> <?php echo esc_html($value['name']); ?></p>
                        <div class="features">
                            <div class="feature-items">
                                <div class="fw-row">
                                    <?php
                                        if( $value['feature'] != '' ):
                                            $items = explode("\n", $value['feature']);
                                            foreach ($items as $k => $v): ?>
                                                <div class="fw-col-sm-6">
                                                    <span class="item"><i class="ion-ios-checkmark-empty"></i> <?php echo esc_html($v); ?></span>
                                                </div>
                                    <?php
                                            endforeach;
                                        endif; ?>
                                </div>
                            </div>
                            <div class="feature-price">
                                <strong><?php echo esc_html(mauris_currency_symbol($atts['currency']).$value['price']); ?></strong><br>
                                <small><?php echo esc_html($value['quantity']); ?></small>
                            </div>
                        </div>
                    </div>
                <?php
                            $i++;
                        endforeach;
                    endif; ?>
                <p class="price-desc"><?php echo html_entity_decode($atts['price_desc']); ?></p>
            </div>
        </div>
        <!-- /price-table -->
    <?php endif; ?>
</div>