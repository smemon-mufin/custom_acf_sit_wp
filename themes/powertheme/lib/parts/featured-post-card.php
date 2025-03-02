<?php
// Get the ACF image custom field value
$imageid = get_sub_field('overview_image');

?>

<article class="resource-card">
    <div class="img-content-img zoom-img">
        <a href="<?php echo get_the_permalink(); ?>">
            <div class="overlay"></div>
            <div class="positioner">
                <?php 
                 // If ACF image exists, display it; otherwise, display the featured image
                if ($imageid) {
                    echo getIMG($imageid);
                } else {
                    // Display the featured image
                    echo get_the_post_thumbnail(get_the_ID(), 'full', array('alt' => get_the_title())); 
                }
                ?>
            </div>
        </a>
    </div>
    <div class="img-content-content">
        <div class="img-content__intro">
            <?php 
            $post_type = get_post_type(get_the_ID()); 
            if($post_type): ?>

                <?php 
                if($post_type=='post'){
                    $post_type = "blog";
                }
                if($post_type=='resource_videos'){
                    $post_type = "videos";
                }
                $sanitized_url = esc_url(home_url($post_type));
                $final_url = $sanitized_url;
                
                ?>
                <a href="<?php echo esc_url($final_url); ?>" class="tag"><?php echo str_replace("_", ' ', $post_type); ?></a>
            <?php endif; ?>

            <span class="read"><?php echo readTime(get_the_content()); ?></span>
        </div>
        <h4><?php echo get_the_title(); ?></h4>
        <p><?php echo get_small_excerpt(get_the_excerpt()); ?></p>
        <a class="readmore" href="<?php echo get_the_permalink(); ?>">Read More <?php echo getSVG('chevron'); ?></a>
    </div>
</article>