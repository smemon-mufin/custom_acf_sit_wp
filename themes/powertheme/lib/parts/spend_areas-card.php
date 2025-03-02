<?php
    $thumbnail_id = get_field('blog_default_thumbnail', 'option')['ID'];

    if(!empty(get_post_thumbnail_id())) $thumbnail_id = get_post_thumbnail_id();

    $feat_img = getIMG($thumbnail_id, 'lg');
    $permalink = get_the_permalink();
    $desc = $args['desc'];
?>

<article class="post-card">
    <a class="post-card__thumb zoom-img" href="<?php echo $permalink; ?>">
        <div class="positioner"><?php echo $feat_img; ?></div>
    </a>
    <div class="post-card__content">
        <h4 class="post-card__title"><?php the_title(); ?></h4>
        <?php if($desc): ?><span class="post-card__desc"><?php echo $desc; ?><?php endif; ?></span> 
        <p class="post-card__excerpt"><?php echo get_field('excerpt'); ?></p> 
        <a class="post-card__link arrow-hvr" href="<?php echo $permalink; ?>">Learn More <?php echo getSVG('chevron'); ?></a>
    </div> 
</article>