<?php
    $thumbnail_id = get_field('blog_default_thumbnail', 'option')['ID'];

    if(!empty(get_post_thumbnail_id())) $thumbnail_id = get_post_thumbnail_id();

    $feat_img = getIMG($thumbnail_id, 'lg');
    $permalink = get_the_permalink();
    $desc = $args['desc'];
    $count = $args['count'];
?>

<article class="industry-card" id="<?php echo $count; ?>">
    <a class="industry-card__thumb" href="<?php echo $permalink; ?>">
        <div class="positioner"><?php echo $feat_img; ?></div>
    </a>
    <div class="industry-card__content">
        <h3 class="industry-card__title"><?php the_title(); ?></h3>
        <?php if($desc): ?><span class="industry-card__desc"><?php echo $desc; ?><?php endif; ?></span> 
        <p class="industry-card__excerpt"><?php echo get_field('excerpt',get_the_ID()); ?></p> 
        <a class="industry-card__link" href="<?php echo $permalink; ?>">Learn More <?php echo getSVG('chevron'); ?></a>
    </div> 
</article>