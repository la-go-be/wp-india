<?php 
/*
template name: Collections
*/
get_header();

global $redux_demo; 


$col_sec_title_en = $redux_demo['col_sec_title_en'];
$col_sec_subtitle_en = $redux_demo['col_sec_subtitle_en'];
$col_sec_btn_txt_en = $redux_demo['col_sec_btn_txt_en'];
$col_sec_btn_url_en = $redux_demo['col_sec_btn_url_en'];



?>

<div class="grid main-content-grid">
  <main>
  <?php 
  // Display Featured Image if present
			if ( hoot_get_mod( 'post_featured_image' ) && !hybridextend_is_404() ) {
				$img_size = apply_filters( 'hoot_post_image_page', '' );
				hoot_post_thumbnail( 'entry-content-featured-img', $img_size, true );
			}

  ?>
  
  <div id="loop-meta" class="loop-meta-wrap pageheader-bg-default">
			<div class="grid">

				<div class=" archive-header loop-meta  grid-span-12" itemscope="itemscope" itemtype="http://schema.org/WebPageElement">
					<?php $banner =  $redux_demo['shop-page-banner']; ?>
					<?php
					//	$id = get_queried_object_id();
						//$category = get_category($id);
						//$texo_metabox = get_term_meta($id, '_cmb2_banner_img', true);
						$image_id = pippin_get_image_id($banner['url']);
						$image_thumb = wp_get_attachment_image_src($image_id, 'loop-meta-img');
						?>
						<?php if($image_thumb != "") { ?>
						<img src="<?php echo $image_thumb[0]; ?>" />
						<?php } else { ?>
						<img src="<?php echo get_template_directory_uri(); ?>/images/seller-banner.jpg" />
						<?php } ?>
					
					<div class="title-sec">
					<h2><?php the_title(); ?>.</h2>
					<a href="<?php echo $redux_demo['col_page_man_url']; ?>" class="btn"><?php echo $col_sec_btn_txt_en; ?></a>
					</div>
				</div><!-- .loop-meta -->

			</div>
		</div>
		
    <div class="collection-area">
      <div class="cat-title">
		  <h2><?php echo $col_sec_title_en; ?></h2>
		  <span><?php echo $col_sec_subtitle_en; ?></span>
		</div>
		  <a href="<?php echo site_url(); ?>/man/collections/" class="btn"><?php echo $col_sec_btn_txt_en; ?></a>
	  
	  
	 
      <div class="categories">

			<?php
			$terms = get_terms( array(
				'taxonomy'     => 'collection',
				'hide_empty' => false,
				'childless' => true
			) );
			if ( ! empty( $terms ) ) { ?>
			<ul class='row'>
			<?php 
			$counter = "0"; 
			foreach (array_slice($terms, 0, 4) as $term) { 
				
			?>
				<li><a href="<?php echo esc_url( get_term_link( $term, $term->taxonomy ) ); ?>">
					<span><?php echo $term->name; ?></span>
					<?php if($counter % 2 == 0) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
						  $image = $image_thumb[0];
					?>
					<?php } elseif($counter % 2 == 1) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-mediun');
						  $image = $image_thumb[0];
					?>
					<?php } ?>
					<img src="<?php echo $image; ?>" alt='' />
					</a>
				</li>
				
			<?php $counter ++; 
			if ($counter > 7) break;
			?>
			<?php } ?>
			</ul>
			
			
			
			
			
			
			<ul class='row row-2'>
			<?php 
			$count = "0"; 
			foreach ($terms as $term) { 
			?>
			<?php 
				if ($count==3) {
			   //print your div here
			   $count++; //added here after edit.
			  // continue;
			   } else if ( $count > 3 ){
			?>
				<li><a href="<?php echo esc_url( get_term_link( $term, $term->taxonomy ) ); ?>">
					<span><?php echo $term->name; ?></span>
					<?php if($count % 2 == 0) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
						  $image = $image_thumb[0];
					?>
					<?php } elseif($count % 2 == 1) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-mediun');
						  $image = $image_thumb[0];
					?>
					<?php } ?>
					<img src="<?php echo $image; ?>" alt='' />
					</a>
				</li>
				
			<?php } $count ++;
			if ($count > 8) break; 
			?>
			<?php } ?>
			</ul>
			
			
			
			
			<ul class='row row-3'>
			<?php 
			$count = "0"; 
			foreach ($terms as $term) { 
			?>
			<?php 
				if ($count==6) {
			   //print your div here
			   $count++; //added here after edit.
			  // continue;
			   } else if ( $count > 6 ){
			?>
				<li><a href="<?php echo esc_url( get_term_link( $term, $term->taxonomy ) ); ?>">
					<span><?php echo $term->name; ?></span>
					<?php if($count % 2 == 0) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
						  $image = $image_thumb[0];
					?>
					<?php } elseif($count % 2 == 1) { ?>
					<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_man_img', true); 
						  $image_id = pippin_get_image_id($texo_cat);
						  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-mediun');
						  $image = $image_thumb[0];
					?>
					<?php } ?>
					<img src="<?php echo $image; ?>" alt='' />
					</a>
				</li>
				
			<?php } $count ++;
			if ($count > 11) break; 
			?>
			<?php } ?>
			</ul>
			
			
			
			
			
			
			
			<?php } ?>
													
													
													
												</div>
		
		
										
    
  </main>
  <!-- #content -->
</div>
<div class="bottom-title-sec">
	<h2><?php the_title(); ?></h2>
	
			<span><?php echo $redux_demo['all_text_en']; ?></span>
	
</div>
<!-- .grid -->
<?php get_footer(); // Loads the footer.php template. ?>
