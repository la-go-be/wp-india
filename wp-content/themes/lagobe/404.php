<?php 
// Loads the header.php template.

if(is_page('cart')){
	get_header('single');
} else {
get_header();
}


 global $redux_demo; 
?>



<?php
// Dispay Loop Meta at top
hoot_display_loop_title_content( 'pre', 'page.php' );
if ( hoot_page_header_attop() ) {
	get_template_part( 'template-parts/loop-meta' ); // Loads the template-parts/loop-meta.php template to display Title Area with Meta Info (of the loop)
	hoot_display_loop_title_content( 'post', 'page.php' );
}

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'page.php' );
?>

<div class="grid main-content-grid">

	<div id="content-wrap">
    

    <div id="logo-error" class="<?php echo 'site-logo-' . hoot_get_mod( 'logo' );
						if ( hoot_get_mod('logo_background_type') == 'accent' )
							echo ' accent-typo with-background';
						elseif ( hoot_get_mod('logo_background_type') == 'background' )
							echo ' with-background';
						?>">
						<?php
						// Display the Image Logo or Site Title
						//hoot_logo();
						?>
						<a href="<?php echo site_url(); ?>" class="custom-logo-link" rel="home" itemprop="url">
							<img src="<?php echo get_template_directory_uri(); ?>/images/logo-chk.png" class="custom-logo" alt="<?php bloginfo('title'); ?>" itemprop="logo">
						</a>
					</div>
    <h1><?php echo $redux_demo['page_not_txt_en']; ?></h1>
    <p><?php echo $redux_demo['page_link_txt_en']; ?></p>
    <span><?php echo $redux_demo['page_link_visit_txt_en']; ?> <a href="<?php echo site_url(); ?>"><?php echo $redux_demo['page_link_home_txt_en']; ?></a><span>
    
    </div>

</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>