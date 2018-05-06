<?php

/*
Template name: Landing page
*/

get_header('landing');

global $redux_demo  // This is your opt_name.



?>



<div>
<?php

$landing_media_logo = $redux_demo['landing-media-logo']['url'];
$landing_media_left = $redux_demo['landing-media-left']['url'];
$landing_media_right = $redux_demo['landing-media-right']['url'];

$t = $redux_demo['landing-media-title']['url'];
$s = $redux_demo['landing-media-subtitle']['url'];

/*use MetzWeb\Instagram\Instagram;
$instagram = new Instagram('fb2e77d.47a0479900504cb3ab4a1f626d174d2d');
echo $result = $instagram->getPopularMedia();*/

?>
	<div class="main-page">
		<div class="left-sec">
			<?php if($landing_media_left != "") { ?>
					<a href="<?php echo site_url(); ?>/man?item=man">
						<img src="<?php echo $landing_media_left; ?>" alt="landing-page-left"/>
						<span><i class="fa fa-angle-left" aria-hidden="true"></i></span>
					</a>
				<?php } ?>
				<div class="lang-sel sel-dropdown">
				<?php echo do_shortcode('[menu_switch]'); ?>
				</div>
		</div>
		
		<div class="right-sec">
		<?php if($landing_media_right != "") { ?>
					<a href="<?php echo site_url(); ?>/woman?item=woman">
						<img src="<?php echo $landing_media_right; ?>" alt="landing-page-right"/>
						<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
					</a>
				<?php } ?>
				
				<a href="<?php echo site_url(); ?>/combine/?item=combine" class="btn enter-site"><strong><?php echo $redux_demo['enter-text-en']; ?></strong></a>
		</div>
		
		<div class="logo-sec">
			<div id="main-logo">
				<?php if($landing_media_logo != "") { ?>
					<a href="<?php echo site_url(); ?>/man?item=man"></a>
					<img src="<?php echo $landing_media_logo; ?>" alt="landing-page"/>
					<a href="<?php echo site_url(); ?>/woman?item=woman"></a>
				<?php } ?>
			</div>
			
			<div class="title-logo">
				
				<?php if($t != "") { ?>
					<!--<h1 data-descr="<?php echo substr($t, 0, 4); ?>"><?php echo $t; ?></h1>-->
					<a href="<?php echo site_url(); ?>/man?item=man"></a>
					<img src="<?php echo $t; ?>" alt="Sub-title"/>
					<a href="<?php echo site_url(); ?>/woman?item=woman"></a>
				<?php } ?>
			</div>
			
			<div class="subtitle-logo">
				<?php if($s != "") { ?>
					<!--<h4 data-descr="<?php echo substr($s, 0, 8); ?>"><?php echo $s; ?></h4>-->
					<a href="<?php echo site_url(); ?>/man?item=man"></a>
					<img src="<?php echo $s; ?>" alt="Main-title"/>
					<a href="<?php echo site_url(); ?>/woman?item=woman"></a>
				<?php } ?>
			</div>
		</div>
		
	</div>


</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>