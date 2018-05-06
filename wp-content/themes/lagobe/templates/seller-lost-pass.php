<?php
/*
template name: Seller Lost password
*/
?>
<?php get_header('seller'); ?>

<div class="seller-lost-pass">
	<?php
		// Start the loop.
		while ( have_posts() ) : the_post();
			// Include the page content template.
			the_content(); 
		// End the loop.
		endwhile;
		?>
		
</div>

<?php get_footer(); ?>