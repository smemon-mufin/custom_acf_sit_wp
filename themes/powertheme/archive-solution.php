<?php get_header(); 
$featured_posts = get_field('post','cpt_solution');
?>


<section class="archive-content archive-solution">

    <div class="container">
<h3 class="sub_titeles">Solutions</h3>
        <div class="blog-posts">

            <?php if( $featured_posts ): ?>

                <?php 
                $args = array(
                    'post__in' => wp_list_pluck($featured_posts, 'ID'), // Extract IDs of related posts
                    'post_type' => 'solution', // Change to your custom post type if needed
                    'posts_per_page' => -1, // Show all related posts
                    'orderby' => 'post__in',
                );    
                $custom_query = new WP_Query($args);
                ?>
           
                <?php 
                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                    

                            get_template_part('lib/parts/solution-card','null',
                                array(
                                    'role' =>  get_field('role'),
                                )
                            );

                        endwhile;
                            wp_reset_postdata();
                    else:
                        // No related posts found
                    endif;     
             endif; ?>
        </div>

    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>