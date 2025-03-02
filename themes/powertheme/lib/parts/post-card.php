<?php
$image = get_field('overview_image') ?: get_post_thumbnail_id() ?: get_field('image') ?: get_field('blog_default_thumbnail', 'option')['ID'];
$excerpt = get_small_excerpt(get_the_excerpt(), 100);
$post_type = get_post_type(get_the_ID()); 
if($post_type=='post'){
    $post_type = "blog";
}
if($post_type=='resource_videos'){
    $post_type = "videos";
}
$sanitized_url = esc_url(home_url($post_type));
$final_url = $sanitized_url;
$button = get_field('button', get_the_ID());
$pdf_link = ($button) ? $button['pdf_link'] : '' ;
?>

<article class="resource-card">
    <div class="img-content-img">
        <?php if($pdf_link){ ?>
        <a href="<?php echo $pdf_link; ?>">
        <?php }else{ ?>
        <a href="<?php echo get_the_permalink(); ?>">
        <?php } ?>
        
            <div class="overlay"></div>
            <div class="positioner">
                
                <?php 
                // If ACF image exists, display it; otherwise, display the featured image
                if ($image) {
                    echo getIMG($image);
                }
                ?>
            </div>
        </a>
    </div>
    <div class="img-content-content">
        <div class="img-content__intro">
            <?php 
            if($post_type): ?>
                <a href="<?php echo esc_url($final_url); ?>" class="tag"><?php echo str_replace("_", ' ', $post_type); ?></a>

            <?php endif; ?>
            
            <span class="read"><?php echo readTime(get_the_content()); ?></span>
            
            <span class="date"><?php echo get_the_date(); ?></span>
        </div>
        <h4><?php echo get_the_title(); ?></h4>

        <?php
        if (!is_post_type_archive('news')) {
            echo '<p>' . get_field('excerpt') . '</p>';
        }
        ?>

        <?php if($pdf_link){ ?>
        <a class="readmore" target="_target" href="<?php echo $pdf_link; ?>">
        <?php }else{ ?>
        <a class="readmore" href="<?php echo get_the_permalink(); ?>">
        <?php } ?>
            Read More <?php echo getSVG('chevron'); ?>
        </a>
    </div>
</article>