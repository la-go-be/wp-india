<?php
/*Search form*/
?>
<form method="get" id="searchform" action="<?php echo esc_url(home_url()); ?>">
    <input type="text" value="" name="s" id="s" placeholder="<?php echo apply_filters( 'ht_searchform_placeholder', esc_html__('Enter keyword...', 'plan-up') ); ?>" />
    <i class="ion-ios-search"></i>
</form>