<?php
    $thumbnail_id = get_field('blog_default_thumbnail', 'option')['ID'];

    if(!empty(get_post_thumbnail_id())) $thumbnail_id = get_post_thumbnail_id();

    $feat_img = $args['image'];
    $permalink = get_the_permalink();
    $role = $args['role'];
?>

<article class="team-card">
   
    <a href="<?php echo $permalink; ?>">
        <div class="team-card__thumb zoom-img"> 
            <div class="positioner"><?php echo getIMG($feat_img,'md'); ?></div>
        </div>
    </a>
    <div class="team-card__content">
        <h4 class="team-card__title"><?php the_title(); ?></h4>
        <div class="team-card__role"><?php echo $role; ?></div>
    </div>
</article>