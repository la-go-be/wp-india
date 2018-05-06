<?php
/*
template name: Combine Page(Homepage)
*/
get_header('single');

global $redux_demo  // This is your opt_name.
?>

<div class="<?php echo $fpg_content_grid; ?>">
<?php


$enabled = $redux_demo['com-switch-on'];
$banner_1_img = $redux_demo['com-banner-1-img'];
$banner_2_img = $redux_demo['com-banner-2-img'];



$banner_1_title = $redux_demo['com-banner-1-title'];
$banner_1_subtitle = $redux_demo['com-banner-1-subtitle'];
$banner_1_shortdesc = $redux_demo['com-banner-1-shortdesc'];
$banner_1_btn_txt = $redux_demo['com-banner-1-btn-txt'];
$banner_1_btn_url = $redux_demo['com-banner-1-btn-url'];



$banner_2_title = $redux_demo['com-banner-2-title'];
$banner_2_subtitle = $redux_demo['com-banner-2-subtitle'];
$banner_2_shortdesc = $redux_demo['com-banner-2-shortdesc'];
$banner_2_btn_txt = $redux_demo['com-banner-2-btn-txt'];
$banner_2_btn_url = $redux_demo['com-banner-2-btn-url'];










$cat_sec_title_en = $redux_demo['cat_sec_title_en'];
$cat_sec_subtitle_en = $redux_demo['cat_sec_subtitle_en'];
$cat_sec_btn_txt_en = $redux_demo['cat_sec_btn_txt_en'];
$cat_sec_btn_url_en = $redux_demo['cat_sec_btn_url_en'];


$cat_sec_title_th = $redux_demo['cat_sec_title_th'];
$cat_sec_subtitle_th = $redux_demo['cat_sec_subtitle_th'];
$cat_sec_btn_txt_th = $redux_demo['cat_sec_btn_txt_th'];
$cat_sec_btn_url_th = $redux_demo['cat_sec_btn_url_th'];


$col_sec_title_en = $redux_demo['col_sec_title_en'];
$col_sec_subtitle_en = $redux_demo['col_sec_subtitle_en'];
$col_sec_btn_txt_en = $redux_demo['col_sec_btn_txt_en'];
$col_sec_btn_url_en = $redux_demo['col_sec_btn_url_en'];


$col_sec_title_th = $redux_demo['col_sec_title_th'];
$col_sec_subtitle_th = $redux_demo['col_sec_subtitle_th'];
$col_sec_btn_txt_th = $redux_demo['col_sec_btn_txt_th'];
$col_sec_btn_url_th = $redux_demo['col_sec_btn_url_th'];



$sel_sec_title_en = $redux_demo['sel_sec_title_en'];
$sel_sec_subtitle_en = $redux_demo['sel_sec_subtitle_en'];
$sel_sec_btn_txt_en = $redux_demo['sel_sec_btn_txt_en'];
$sel_sec_btn_url_en = $redux_demo['sel_sec_btn_url_en'];


$sel_sec_title_th = $redux_demo['sel_sec_title_th'];
$sel_sec_subtitle_th = $redux_demo['sel_sec_subtitle_th'];
$sel_sec_btn_txt_th = $redux_demo['sel_sec_btn_txt_th'];
$sel_sec_btn_url_th = $redux_demo['sel_sec_btn_url_th'];

$ins_sec_title_en = $redux_demo['ins_sec_title_en'];
$ins_sec_id_en = $redux_demo['ins_sec_id_en'];
$ins_sec_aft_user_en = $redux_demo['ins_sec_aft_user_en'];

$ins_sec_title_th = $redux_demo['ins_sec_title_th'];
$ins_sec_id_th = $redux_demo['ins_sec_id_th'];
$ins_sec_aft_user_th = $redux_demo['ins_sec_aft_user_th'];

/*use MetzWeb\Instagram\Instagram;
$instagram = new Instagram('fb2e77d.47a0479900504cb3ab4a1f626d174d2d');
echo $result = $instagram->getPopularMedia();*/

?>
	<main>
			<?php if($enabled == 1) { ?>
			<div class="slider-section">
				
				<div class="left-sec">
					<div class="bottom-menu">
				<ul>
					
					<li><?php echo $redux_demo['add-services'][0]; ?></li>
					<li><?php echo $redux_demo['add-services'][1]; ?></li>
					<li><?php echo $redux_demo['add-services'][2]; ?></li>
					
				</ul>
			</div>	
			
					<img src="<?php echo $banner_1_img['url']; ?>">
					<div class="caption">
					<?php if($banner_1_title != "") { ?>
					<h2><?php echo $banner_1_title; ?></h2>
					<?php } ?>
					<?php if($banner_1_subtitle != "") { ?>
					<span><?php echo $banner_1_subtitle; ?></span>
					<?php } ?>
					
					<?php if($banner_1_btn_txt != "") { ?>
					<a href="<?php echo $banner_1_btn_url; ?>" class="btn"><?php echo $banner_1_btn_txt; ?></a>
					<?php } ?>
                    </div>
                    
				</div>
				
				<div class="right-sec">
					<div class="right-top-sec">
						<?php if($banner_1_shortdesc != "") { ?>
                        <a target="_blank" href="https://facebook.com/lagobefashion"><img src="<?php echo $banner_1_shortdesc['url']; ?>"></a>
						<?php } ?>
					</div>
					
					<div class="right-bottom-sec">
						<div class="desc">
							<!--<div class="left">
							<?php if($banner_2_title != "") { ?>
							<h2><?php echo $banner_2_title; ?></h2>
							<?php } ?>
							<?php if($banner_2_subtitle != "") { ?>
							<span><?php echo $banner_2_subtitle; ?></span>
							<?php } ?>
							<?php if($banner_2_btn_txt != "") { ?>
							<a href="<?php echo $banner_2_btn_url; ?>"><?php echo $banner_2_btn_txt; ?></a>
							<?php } ?>
                            </div>-->
                            <div class="right">
							<a target="_blank" href="<?php echo $banner_2_btn_url; ?>"><img src="<?php echo $banner_2_img['url']; ?>"></a>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<?php } ?>

								<div id="frontpage">
									<div class="grid">
											<div class="category-area">
												<div class="cat-title">
												
													  <h2><?php echo $cat_sec_title_en; ?></h2>
												
													  <span><?php echo $cat_sec_subtitle_en; ?></span>
												</div>
													  <a href="<?php echo site_url(); ?>/product-category/combine/" class="btn"><?php echo $cat_sec_btn_txt_en; ?></a>
												<div class="categories">
													<?php
													$taxonomyName = "product_cat";
												    $parent_terms = get_terms($taxonomyName, array(
                                                        'parent' => 214,
														'childless' => false, 
														'orderby' => 'slug', 
														'hide_empty' => false
													)); ?>
													<ul>
													<?php 
													$i = 0;
													foreach ($parent_terms as $pterm) { 
														if ($i++ > 18) break;
													?>
													<li><a href="<?php echo esc_url( get_term_link($pterm, $pterm->taxonomy)); ?>">
														<span><?php echo $pterm->name; ?></span>
														<?php
														$thumbnail_id = get_woocommerce_term_meta($pterm->term_id, 'thumbnail_id', true);

														$image = wp_get_attachment_image_url( $thumbnail_id, 'category-img' ); ?>

														<img src="<?php echo $image; ?>" alt='' />
														</a>
													</li>	
													<?php } ?>
													</ul>
												</div>
											</div>
											
											
											<div class="collection-area">
												<div class="cat-title">
												
													  <h2><?php echo $col_sec_title_en; ?></h2>
												
												
													  <span><?php echo $col_sec_subtitle_en; ?></span>
												</div>
												
												<a href="<?php echo site_url(); ?>/collections/combine/" class="btn"><?php echo $col_sec_btn_txt_en; ?></a>
												
												
												
												
												
												<div class="categories">
													<?php
                                                    $terms = get_terms( array(
														'taxonomy'     => 'collection',
                                                        'parent'       => 205,
                                                        'childless' => false,
                                                        'orderby' => 'slug',
                                                        'hide_empty' => false
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
															<?php //$texo_cat = get_term_meta($term->ID, '_cmb2_les_img', true); ?>
															<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_com_img', true); 
																  $image_id = pippin_get_image_id($texo_cat);
																  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
																  $image = $image_thumb[0];
															?>
															<?php //$image = wp_get_attachment_image_url($term->image_id, 'collection-large' ); ?>
															<?php } elseif($counter % 2 == 1) { ?>
															<?php $texo_catd = get_term_meta($term->term_id, '_cmb2_com_img', true); 
																  $image_idc = pippin_get_image_id($texo_catd);
																  $image_thxumb = wp_get_attachment_image_src($image_idc, 'collection-mediun');
																  $image = $image_thxumb[0]; ?>
															<?php } ?>
															<img src="<?php echo $image; ?>" alt='' />
															
															<?php 
															/*$texo_cat = get_term_meta($term->term_id, '_cmb2_les_img', true); 
															$image_id = pippin_get_image_id($texo_cat);
															?>
															<?php $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
															$image = $image_thumb[0]; ?>
															<?php } elseif($counter % 2 == 1) { ?>
															<?php $image_thumb = wp_get_attachment_image_src($image_id, 'collection-medium');
															$image = $image_thumb[0]; ?>
															<?php }*/ ?>
															
															
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
															<?php //$texo_cat = get_term_meta($term->ID, '_cmb2_les_img', true); ?>
															<?php $texo_cat = get_term_meta($term->term_id, '_cmb2_com_img', true); 
																  $image_id = pippin_get_image_id($texo_cat);
																  $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
																  $image = $image_thumb[0];
																  
															?>
															<?php //$image = wp_get_attachment_image_url($term->image_id, 'collection-large' ); ?>
															<?php } elseif($count % 2 == 1) { ?>
															<?php $texo_catd = get_term_meta($term->term_id, '_cmb2_com_img', true); 
																  $image_idc = pippin_get_image_id($texo_catd);
																  $image_thxumb = wp_get_attachment_image_src($image_idc, 'collection-mediun');
																  $image = $image_thxumb[0]; ?>
															<?php } ?>
															<img src="<?php echo $image; ?>" alt='' />
															
															<?php 
															/*$texo_cat = get_term_meta($term->term_id, '_cmb2_les_img', true); 
															$image_id = pippin_get_image_id($texo_cat);
															?>
															<?php $image_thumb = wp_get_attachment_image_src($image_id, 'collection-large');
															$image = $image_thumb[0]; ?>
															<?php } elseif($counter % 2 == 1) { ?>
															<?php $image_thumb = wp_get_attachment_image_src($image_id, 'collection-medium');
															$image = $image_thumb[0]; ?>
															<?php }*/ ?>
															
															
															</a>
														</li>
														
													<?php } $count ++;
													if ($count > 8) break; 
													?>
													<?php } ?>
													</ul>
													
													
													
													
													
													
													
													<?php } ?>
													
													
													
												</div>
												
												
												
												
											</div>
											
											
											<div class="sellers-area">
												<div class="cat-title">
												<h2><?php echo $sel_sec_title_en; ?></h2>
												
												
												<span><?php echo $sel_sec_subtitle_en; ?></span>
												</div>
												<a href="<?php echo site_url(); ?>/shop-combine" class="btn"><?php echo $sel_sec_btn_txt_en; ?></a>
												<div class="categories">
													<ul>
													<?php
													$args = array(
														'post_type' => 'product',
														'meta_key' => 'total_sales',
														'orderby' => 'meta_value_num',
														'posts_per_page' => 60,
														'tax_query' => array(
															array(
																'taxonomy' => 'product_cat',
																'field' => 'slug',
																'terms' => 'combine',
															),
														),
													);
													 
													$loop = new WP_Query( $args );
													while ( $loop->have_posts() ) : $loop->the_post(); 
													global $product; 
													$currency = get_woocommerce_currency_symbol();
													$price = get_post_meta( get_the_ID(), '_regular_price', true);
													$sale = get_post_meta( get_the_ID(), '_sale_price', true);
													?>
 
													
													<li><a id="id-<?php the_id(); ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
														<?php if (has_post_thumbnail( $loop->post->ID )){ ?>
														<?php echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); ?>
														<?php } else { ?>
														<img src="<?php echo woocommerce_placeholder_img_src(); ?>" alt="product placeholder Image"/>'; 
														<?php } ?>
														<?php if($sale) : ?>
														<strong class="product-price-tickr"><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></strong>    
														<?php elseif($price) : ?>
														<strong class="product-price-tickr"><?php echo $currency; echo $price; ?></strong>    
														<?php endif; ?>
														<span><?php the_title(); ?></span>
														</a>
													</li>	
													<?php endwhile; ?>
													<?php wp_reset_query(); ?>
													</ul>
												</div>
											</div>
											
											<div class="sellers-area insta">
												<div class="cat-title">
													  	<h2><?php echo $ins_sec_title_en; ?></h2>
														<span>#<?php echo $ins_sec_id_en; ?></span>
														<?php
														$otherPage = $ins_sec_id_en;
														$response = file_get_contents("https://www.instagram.com/$otherPage/?__a=1");
														if ($response !== false) {
															$data = json_decode($response, true);
															if ($data !== null) {
																$follows = $data['user']['follows']['count'];
																$followedBy = $data['user']['followed_by']['count']; ?>
														<p><?php echo $followedBy; ?> <?php echo $ins_sec_aft_user_en; ?></p>																
														<?php	}
														}
														?>
												</div>
												<div class="instragram-images">
													<?php echo do_shortcode('[jr_instagram id="2"]'); ?>
													<ul class="grid">
            											
        											</ul>
												</div>
												
											</div>
											
											
											<div class="news-letter">

<!--START Scripts : this is the script part you can add to the header of your theme-->

<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/wysija-newsletters/js/validate/languages/jquery.validationEngine-en.js?ver=2.7.10"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/wysija-newsletters/js/validate/jquery.validationEngine.js?ver=2.7.10"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/wysija-newsletters/js/front-subscribers.js?ver=2.7.10"></script>
<script type="text/javascript">
                /* <![CDATA[ */
                var wysijaAJAX = {"action":"wysija_ajax","controller":"subscribers","ajaxurl":"<?php echo site_url(); ?>/wp-admin/admin-ajax.php","loadingTrans":"Loading..."};
                /* ]]> */
                </script><script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/wysija-newsletters/js/front-subscribers.js?ver=2.7.10"></script>
<!--END Scripts-->

<div class="widget_wysija_cont html_wysija"><div id="msg-form-wysija-html595f6e3baaf78-1" class="wysija-msg ajax"></div><form id="form-wysija-html595f6e3baaf78-1" method="post" action="#wysija" class="widget_wysija html_wysija">

<h2><?php echo $redux_demo['news_txt_en']; ?> <br><?php echo $redux_demo['news_sign_txt_en']; ?></h2>


<p class="wysija-paragraph">
    
    
    	<input type="text" name="wysija[user][email]" class="wysija-input validate[required,custom[email]]" title="Enter your email" placeholder="<?php echo $redux_demo['news_email_txt_en']; ?>" value="" />
    
    
    
    <span class="abs-req">
        <input type="text" name="wysija[user][abs][email]" class="wysija-input validated[abs][email]" value="" />
    </span>
    
</p>
<input class="wysija-submit wysija-submit-field" type="submit" value="<?php echo $redux_demo['news_email_sign_txt_en']; ?>" />

    <input type="hidden" name="form_id" value="1" />
    <input type="hidden" name="action" value="save" />
    <input type="hidden" name="controller" value="subscribers" />
    <input type="hidden" value="1" name="wysija-page" />

    
        <input type="hidden" name="wysija[user_list][list_ids]" value="1" />
    
 </form></div>
 
 
												<?php //echo do_shortcode('[wysija_form id="1"]'); ?>
											</div>
											
									</div>
								</div>
							

	</main><!-- #content -->
</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>