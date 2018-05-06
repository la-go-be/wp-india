<?php

$customizer = ( function_exists( 'fw_get_db_customizer_option' ) ) ? fw_get_db_customizer_option() : array('');

$copyright = isset($customizer['c_copyright']) ? $customizer['c_copyright'] : get_bloginfo('name').' &copy; '.date('Y');

$social_links = isset($customizer['c_social_link']) ? $customizer['c_social_link'] : array('http://facebook.com/'.get_bloginfo('name'), 'http://twitter.com/'.get_bloginfo('name'), 'http://plus.google.com/'.get_bloginfo('name'));

$c_style_color = isset($customizer['c_footer_bg']) ? $customizer['c_footer_bg'] : '#2C2C2C';

$c_style =  'background-color: '.$c_style_color.';';

?>



	</div><!-- #content -->

    <?php if( !is_404() && !is_page_template('page-templates/template-comming.php' ) ): ?>

	<footer id="colophon" class="site-footer" style="<?php echo esc_html($c_style); ?>">

        <div class="container">

            <div class="site-info">

                <?php echo html_entity_decode($copyright); ?>

            </div><!-- .site-info -->

            <div class="social-link">

                <?php

                    foreach ((array)$social_links as $key => $value) {

                        echo '<a href="'.$value.'"></a>';

                    }

                ?>

            </div>

        </div>

	</footer><!-- #colophon -->

    <?php endif; ?>

</div><!-- #page -->


<?php wp_footer(); ?>



</body>

</html>

