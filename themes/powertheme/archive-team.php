<?php get_header(); 
$featured_posts = get_field('post','cpt_team');?>

<section class="archive-content archive-team">
    <div class="container">

        <div class="blog-posts ">

            <?php if( $featured_posts ): ?>
            
                <?php foreach( $featured_posts as $post ): 

                    // Setup this post for WP functions (variable must be named $post).
                    setup_postdata($post); 
                    

                    get_template_part('lib/parts/team-card','null',
                        array(
                            'image' =>  get_field('image'),
                            'role' =>  get_field('role'),
                        )
                    );
                    
                    ?>
                    
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <?php // if(have_posts()) get_template_part('lib/parts/loadmore'); ?>

    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>