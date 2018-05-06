<?php
/*
template name: Thanks Registration
*/
?>
<?php get_header(); ?>

<?php


// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'page.php' );
?>

<div class="grid main-content-grid">
	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'page.php' );
	?>
	<main <?php hybridextend_attr( 'content' ); ?>>
		<div class="success-message">
			<h2>Registration <br />
				Successful.
			</h2>
			<span><strong>Thanks For Confirmation.</strong></span>
			
			<div class="thank-u">
				<h3>Thank you!</h3>
			</div>
		</div>
	</main>
</div><!-- .grid -->

<?php get_footer(); // Loads the footer.php template. ?>