<?php
class Widget_WooEvent_Search extends WP_Widget {	

	function __construct() {
    	$widget_ops = array(
			'classname'   => 'wooevent-search', 
			'description' => esc_html__('Events Search ','exthemes')
		);
    	parent::__construct('course-search-widget', esc_html__('WE - Events Search ','exthemes'), $widget_ops);
	}


	function widget($args, $instance) {
		ob_start();
		extract($args);
		
		$ids 			= empty($instance['ids']) ? '' : $instance['ids'];
		$title 			= empty($instance['title']) ? '' : $instance['title'];
		$title          = apply_filters('widget_title', $title);
		$cats 			= empty($instance['cats']) ? '' : $instance['cats'];

		
		$args = array(
			'hide_empty'        => false, 
			'include'           => explode(",",$cats)
		); 
		
		$terms = get_terms('product_cat', $args);
		
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title; ?>
        <div class="we-search-form">
        <form role="search" method="get" id="searchform" class="we-product-search-form" action="<?php echo home_url(); ?>/">
        	<div class="input-group">
            
            <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
              <div class="input-group-btn we-search-dropdown">
				<button name="product_cat" type="button" class="btn btn-default we-product-search-dropdown-button we-showdrd"><span class="button-label">
					<?php
					$def_cat='';
                    if($cats!=''){
                        foreach ( $terms as $term ) {
							$def_cat = $term->slug;
							echo $term->name;
							break;
						}
                    }else{
                        echo get_option('we_text_all')!='' ? get_option('we_text_all') : esc_html__('All','exthemes');
                    }?>
                	</span> <span class="fa fa-angle-down"></span>
                </button>
                <ul class="we-dropdown-select">
                	<?php if($cats==''){?>
                  		<li><a href="#" data-value=""><?php echo get_option('we_text_all')!='' ? get_option('we_text_all') : esc_html__('All','exthemes'); ?></a></li>
                  
                  	<?php 
					}
				  	foreach ( $terms as $term ) {
				  		echo '<li><a href="#" data-value="'. $term->slug .'">'. $term->name .'</a></li>';
				  	}
				  ?>
                </ul>
              </div><!-- /btn-group -->
            <?php } //if have terms ?>
            
              <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php echo get_option('we_text_search')!='' ? get_option('we_text_search') : esc_html__('Search','exthemes'); ?>" class="form-control" />
              <input type="hidden" name="post_type" value="product" />
              <input type="hidden" name="product_cat" class="we-product-search-cat" value="<?php echo $def_cat;?>" />
              <span class="input-group-btn">
              	<button type="submit" id="searchsubmit" class="btn btn-default we-product-search-submit" ><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        </div>
        <script>
		jQuery(document).ready(function(e) {
            jQuery(".we-search-dropdown:not(.we-sfilter)").on('click', 'li a', function(){
			  jQuery(".we-search-dropdown:not(.we-sfilter) .we-product-search-dropdown-button .button-label").html(jQuery(this).text());
			  jQuery(".we-product-search-cat").val(jQuery(this).data('value'));
			  jQuery(".we-product-search-dropdown").removeClass('open');
			  return false;
			});
        });
		</script>
        <?php
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['cats'] = strip_tags($new_instance['cats']);
		return $instance;
	}
	
	
	
	function form( $instance ) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$cats = isset($instance['cats']) ? esc_attr($instance['cats']) : '';?>
        
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:','exthemes'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <p>
          <label for="<?php echo $this->get_field_id('cats'); ?>"><?php esc_html_e('Included Categories (IDs. Ex: 68, 86)','exthemes'); ?></label> 
          <textarea rows="4" cols="46" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>"><?php echo $cats; ?></textarea>
        </p>
<?php
	}
}

// register widget
add_action( 'widgets_init', create_function( '', 'return register_widget("Widget_WooEvent_Search");' ) );
