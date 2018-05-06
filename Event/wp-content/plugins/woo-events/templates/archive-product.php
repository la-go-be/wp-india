<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$we_sidebar = '';
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
$we_shop_view = get_option('we_shop_view');
if($we_shop_view!=''){
	$clss .= ' we-default-'.$we_shop_view;
}
global $we_main_purpose;
$we_main_purpose = get_option('we_main_purpose');
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

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php
		$we_shop_view = get_option('we_shop_view');
		if(is_search() && we_global_search_result_page()=='map'){
			echo do_shortcode('[we_map]');
		}else if((!isset($_GET['view'])&& !is_search() && is_shop() && $we_shop_view!='list') || (isset($_GET['view']) && $_GET['view']!='list' && !is_search() && is_shop())){
			
		}else if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

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
