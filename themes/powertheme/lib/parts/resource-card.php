<?php
$imageid = get_field('overview_image') ?: get_post_thumbnail_id() ?: get_field('blog_default_thumbnail', 'option')['ID'];
$button = get_field('button', get_the_ID());
if($button):
$pdf_link = $button['pdf_link'] ;
endif;
?>

<article class="resource-card">
    <div class="img-content-img">
        <?php if($button){ ?>
        <a href="<?php echo $pdf_link; ?>">
        <?php }else{ ?>
        <a href="<?php echo get_the_permalink(); ?>">
        <?php } ?>
        
            <div class="overlay"></div>
            <div class="positioner">
                
                <?php 
                // If ACF image exists, display it; otherwise, display the featured image
                if ($imageid) {
                    echo getIMG($imageid);
                }
                ?>
            </div>
        </a>
    </div>
    <div class="img-content-content">
        <div class="img-content__intro">
            <?php 
            $post_type = get_post_type(get_the_ID()); 

            // echo get_post_type_archive_link($post_type);

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
        <h4><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>

        <?php
        if (!is_post_type_archive('news')) {
            echo '<p>' . get_field('excerpt') . '</p>';
        }
        ?>

        <?php if($button){ ?>
        <a class="readmore" target="_target" href="<?php echo $pdf_link; ?>">
        <?php }else{ ?>
        <a class="readmore" href="<?php echo get_the_permalink(); ?>">
        <?php } ?>
            Read More <?php echo getSVG('chevron'); ?>
        </a>
    </div>
</article>