<?php
// Template modification Hook
do_action( 'hoot_template_before_menu', 'primary' );
//if ( has_nav_menu( 'primary' ) ) : // Check if there's a menu assigned to the 'primary' location.
	?>
<?php global $redux_demo; ?>	
	<h3 class="screen-reader-text"><?php _e( 'Primary Navigation Menu', 'creattica' ); ?></h3>
	<nav <?php hybridextend_attr( 'menu', 'primary' ); ?>>
		<div class="menu-toggle"><span class="menu-toggle-text"><?php _e( 'Menu', 'creattica' ); ?></span><i class="fa fa-bars"></i></div>
		<!--<div class="menu-expand"><i class="fa fa-bars"></i></div>-->
		
	<div class="menu-items sf-menu menu" id="menu-primary-items">
		<?php if($_SESSION['item'] == 'man') { ?>
		<?php
			$menu_args = array(
			'menu'  => 'Main Menu Man',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else if($_SESSION['item'] == 'woman') { ?>
		<?php
			$menu_args = array(
			'menu'  => 'Main Menu Woman',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else if($_SESSION['item'] == 'combine'){ ?>
		<?php
			$menu_args = array(
			'theme_location'  => 'primary',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else { ?>
		<?php
			$menu_args = array(
			'theme_location'  => 'primary',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } ?>
						
				<div class="sidebar-left-top">
					<strong id="filter-by"><?php echo $redux_demo['shop_fillter_en']; ?></strong>
						<div id="side-left" style="display:none;">	
							<?php dynamic_sidebar('sidebar-left-top');	?>
						</div>
				</div>
				<div class="sidebar-left-bottom">	
					<strong id="short-by"><?php echo $redux_demo['shop_short_en']; ?> </strong>
					<div id="side-left-btm" style="display:none;">
						<?php dynamic_sidebar('sidebar-left-bottom');	?>
						
						<!--<select name="order" class="order new-order">
							<option value="menu_order" selected="selected">Default sorting</option>
							<option value="popularity">Sort by popularity</option>
							<option value="rating">Sort by average rating</option>
							<option value="date">Sort by newness</option>
							<option value="price">Sort by price: low to high</option>
							<option value="price-desc">Sort by price: high to low</option>
						</select>-->
			
					</div>
					
					
					
				
				</div>
				
				
				
				<div id="tabs">
  <ul>
    <li><a href="#tabs-1"><?php echo $redux_demo['shop_text_en']; ?> </a></li>
    <li><a href="#tabs-2"><i class="fa fa-sliders" aria-hidden="true"></i> <?php echo $redux_demo['shop_fillter_en']; ?> </a></li>
    <li><a href="#tabs-3"><i class="fa fa-sort" aria-hidden="true"></i> <?php echo $redux_demo['shop_short_en']; ?> </a></li>
  </ul>
  <div id="tabs-1" class="mobile-menu">
		<?php if($_SESSION['item'] == 'man') { ?>
		<?php
			$menu_args = array(
			'menu'  => 'Main Menu Man',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else if($_SESSION['item'] == 'woman') { ?>
		<?php
			$menu_args = array(
			'menu'  => 'Main Menu Woman',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else if($_SESSION['item'] == 'combine'){ ?>
		<?php
			$menu_args = array(
			'theme_location'  => 'primary',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } else { ?>
		<?php
			$menu_args = array(
			'theme_location'  => 'primary',
			'container'       => false,
			'fallback_cb'     => '',
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		wp_nav_menu( $menu_args ); ?>
		<?php } ?>
		
  </div>
  <div id="tabs-2">
    <?php dynamic_sidebar('sidebar-left-top');	?>
  </div>
  				<?php //if((!is_page('my-account')) && (!is_page('wishlist')) && (!is_page('checkout'))){?>	
  				<div id="tabs-3">
					<?php dynamic_sidebar('sidebar-left-bottom');	?>
  				</div>
				<?php //} ?>
  <?php //dynamic_sidebar('sidebar-left-bottom');	?>
</div>
		</div>	
		
		
		
			
	</nav><!-- #menu-primary -->
	
	<?php
	
	
//endif; // End check for menu.
// Template modification Hook
do_action( 'hoot_template_after_menu', 'primary' );