<?php 
/*
template name: Categories
*/
get_header();
?>
<div class="title-sec">
	<h2><?php the_title(); ?>.</h2>
	
	
	
			<span><?php echo $redux_demo['all_text_en']; ?></span>
	
</div>
<div class="grid main-content-grid">
  <main>
    <div class="collection-area">
      
      	<div class="categories">
													<?php
													$taxonomyName = "product_cat";
													$post_parent = get_post($post->post_parent);
													
													if($post_parent->post_name == "man") {
												    $parent_terms = get_terms($taxonomyName, array('parent' => 60, 'childless' => false, 'orderby' => 'slug', 'hide_empty' => false)); 
													} else if($post_parent->post_name == "woman") {
													$parent_terms = get_terms($taxonomyName, array('parent' => 61, 'childless' => false, 'orderby' => 'slug', 'hide_empty' => false)); 
													}
													?>
													<ul>
													<?php foreach ($parent_terms as $pterm) { ?>
													<li><a href="<?php echo esc_url( get_term_link($pterm, $pterm->taxonomy)); ?>">
														<span><?php echo $pterm->name; ?></span>
														
														<?php
														if($post_parent->post_name == "man") {
														$thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);
														$image = wp_get_attachment_image_url( $thumbnail_id, 'cat-page-img' ); ?>
														<img src="<?php echo $image; ?>" alt='' />
														<?php } else if($post_parent->post_name == "woman") { 
														$thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);
														$texo_metabox = get_term_meta($pterm->term_id, '_cmb2_les_img', true);
														$image = wp_get_attachment_image_url( $thumbnail_id, 'category-img' ); ?>
														<img src="<?php echo $texo_metabox; ?>" alt='' />
														<?php } ?>
														
														
														</a>
													</li>	
													<?php } ?>
													</ul>
												</div>
												
    
  </main>
  <!-- #content -->
</div>
<div class="bottom-title-sec">
	<h2><?php the_title(); ?>.</h2>
	
			<span><?php echo $redux_demo['all_text_en']; ?></span>
	
</div>
<!-- .grid -->
<?php get_footer(); // Loads the footer.php template. ?>
