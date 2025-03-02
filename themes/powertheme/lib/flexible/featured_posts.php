
<?php
    $headline = get_sub_field('headline');
	$link = get_sub_field('link');
	$featured_posts = get_sub_field('featured_posts');
    $classList[] = 'featured-posts section-bg';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">

        <div class="featured-posts__intro">
            <?php if($headline): ?><h2><?php echo $headline; ?></h2><?php endif; ?>
            <?php 
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="bordered-cta" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('chevron'); ?></a>
            <?php endif; ?>
        </div>

        
            

        
        <?php
        if( $featured_posts ): ?>
        <div class="featured-posts__posts">
            <?php foreach( $featured_posts as $post ): 

                // Setup this post for WP functions (variable must be named $post).
                setup_postdata($post); 
                get_template_part('lib/parts/featured-post-card');
                ?>
                
            <?php endforeach; ?>
      
            <?php 
            // Reset the global post object so that the rest of the page works correctly.
            wp_reset_postdata(); ?>
        </div>
        <?php endif; ?>

        
    </div>
</section>

