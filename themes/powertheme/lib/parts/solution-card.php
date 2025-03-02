<?php
    $thumbnail_id = get_field('blog_default_thumbnail', 'option')['ID'];

    if(!empty(get_post_thumbnail_id())) $thumbnail_id = get_post_thumbnail_id();

    $feat_img = getIMG($thumbnail_id, 'lg');
    $permalink = get_the_permalink();
    $role = $args['role'];
?>

<article class="solution-card">
    <a class="solution-card__thumb zoom-img" href="<?php echo $permalink; ?>">
        <div class="positioner"><?php echo $feat_img; ?></div>
    </a>
    <div class="solution-card__content">
        <h4 class="solution-card__title"><?php the_title(); ?></h4>
        <p class="solution-card__excerpt"><?php echo get_field('excerpt'); ?></p> 
        <a class="solution-card__link arrow-hvr" href="<?php echo $permalink; ?>">Learn More <?php echo getSVG('chevron'); ?></a>
    </div> 
</article>