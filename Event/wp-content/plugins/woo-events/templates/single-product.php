<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$we_sidebar = get_post_meta(get_the_ID(),'we_sidebar',true);
if($we_sidebar==''){
	$we_sidebar = get_option('we_sidebar','right');
}
get_header( 'shop' );
$we_layout = wooevent_global_layout();
if($we_layout=='layout-3'){
	$we_layout ='layout-2 layout-3';
}
$clss ='';
if(!is_active_sidebar('wooevent-sidebar')){
	$clss = 'no-sidebar';
}
if(isset($_GET['view']) && $_GET['view']=='list' && is_shop()){
	$clss .= ' we-list-view';
}elseif(is_shop()){
	$clss .= ' we-calendar-view';
}
$we_click_remove = get_option('we_click_remove','');
if($we_click_remove=='yes'){
	$clss .= ' we-remove-click';
}
global $we_main_purpose;
$we_main_purpose = get_option('we_main_purpose');
$we_layout_purpose = get_post_meta(get_the_ID(),'we_layout_purpose',true);
if($we_main_purpose=='custom' && $we_layout_purpose!='event'){
	$we_main_purpose = 'woo';
}
?>
<div class="container">
	<div id="exmain-content" class="row<?php if($we_main_purpose=='woo'){ echo ' hidden-info-event';}?>">
    
    <div id="content" class="we-main <?php echo $we_layout.' '.$clss.' '; echo $we_sidebar!='hide'?'col-md-9':'col-md-12' ?><?php echo ($we_sidebar == 'left') ? " revert-layout":"";?>">
		<?php
            /**
             * woocommerce_before_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             */
            do_action( 'woocommerce_before_main_content' );
        ?>
    
            <?php while ( have_posts() ) : the_post(); ?>
    
                <?php wc_get_template_part( 'content', 'single-product' ); ?>
    
            <?php endwhile; // end of the loop. ?>
    
        <?php
            /**
             * woocommerce_after_main_content hook.
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action( 'woocommerce_after_main_content' );
        ?>
	</div>
    <?php 
	if($we_sidebar != 'hide'){?>
        <div class="we-sidebar col-md-3">
        <?php
            /**
             * woocommerce_sidebar hook.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
            dynamic_sidebar('wooevent-sidebar');
        ?>
        </div>
    <?php }?>
    </div>
</div>
<?php get_footer( 'shop' ); ?>
