<?php
/*
template name: Welcome Seller
*/
get_header('seller');
?>

<div class="overlay-slide">
	<?php hoot_logo(); ?>
	<div class="backgroung-clr"></div>

</div>

<div class="seller-main">
	<div class="slider-section">
				<div class="left-sec">
					<h2>Welcome</h2>
					<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
					<select id="language">
						<option value="en">EN</option>
						<option value="th">TH</option>
					</select>
					
					<div class="bottom-link">
						<a href="#">Get Started</a>
					</div>
				</div>
				
				<div class="right-sec">
					<div class="right-top-sec">
						<?php hoot_logo(); ?>
					</div>
					
					<div class="right-bottom-sec">
						<div class="desc">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/A-happy-couple.jpg"></a>
						</div>
					</div>
				</div>				
	</div>
</div>



<?php get_footer(); ?>