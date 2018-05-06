<?php 
global $img_size,$show_meta;
$we_custom_metadata = get_post_meta( get_the_ID(), 'we_custom_metadata', false );
?>
<div class="item-post-n">
	<figure class="ex-modern-blog">
		<div class="image">
        	<a href="<?php the_permalink(); ?>" class="link-more">
				<?php the_post_thumbnail($img_size);?>
            </a>
		</div>
		<div class="grid-content">
			<figcaption>
            	<div class="s-ttname">
                    <h3><a href="<?php the_permalink(); ?>" class="link-more"><?php the_title();?></a></h3>
                    <span><?php echo get_post_meta( get_the_ID(), 'speaker_position', true );?></span>
                </div>
				<?php if($show_meta == '1' && is_array($we_custom_metadata) && !empty($we_custom_metadata)){
					$number = count($we_custom_metadata);?>
                    <div class="we-meta-info">
                    	<?php 
						foreach($we_custom_metadata as $item){?>
                        	<div class="s-ctmeta">
                                <span class="s-title"><?php echo $item['we_custom_title'];?></span>
                                <span class="s-content"><?php echo $item['we_custom_content'];?></span>
                            </div>
							<?php
						}?>
                    </div>
                <?php }?>
			</figcaption>
		</div>
	</figure>   
</div>