<?php get_header(); 
$featured_posts = get_field('post','cpt_industry');?>

<section class="archive-content archive-industry">
    <div class="container">

        <div class="archive-industry__wrap">
            <div class="archive-industry__links">
                <h3>Our Industries</h3>
                <div class="archive-industry__links-sticky">

                        <?php 
                        if( $featured_posts ): ?>


                            <?php 
                            $args = array(
                                'post__in' => wp_list_pluck($featured_posts, 'ID'), // Extract IDs of related posts
                                'post_type' => 'industry', // Change to your custom post type if needed
                                'posts_per_page' => -1, // Show all related posts
                                'orderby' => 'post__in',
                            );    
                            $custom_query = new WP_Query($args);
                            ?>
           
                            <?php $count = 1; 
                            
                            if ($custom_query->have_posts()) :
                                while ($custom_query->have_posts()) : $custom_query->the_post();

                                // Setup this post for WP functions (variable must be named $post).
                                setup_postdata($post); 

                                $link_class = ($count === 1) ? 'active' : ''; ?>
                                
                                    <a class="<?php echo $link_class; ?>" href="#item<?php echo $count; ?>"><?php echo get_the_title(); ?></a>
                                
                            <?php $count++; 
                            
                            endwhile;
                                wp_reset_postdata();
                            else:
                                // No related posts found
                            endif;
                  
                        endif; ?>
                        
                </div>
            </div>
    
            <div class="blog-posts loadmore-container">

                <?php if( $featured_posts ): ?>

                    <?php 
                    $args = array(
                        'post__in' => wp_list_pluck($featured_posts, 'ID'), // Extract IDs of related posts
                        'post_type' => 'industry', // Change to your custom post type if needed
                        'posts_per_page' => -1, // Show all related posts
                        'orderby' => 'post__in',
                    );    
                    $custom_query = new WP_Query($args);
                    $count = 1; 
                    
                        if ($custom_query->have_posts()) :
                            while ($custom_query->have_posts()) : $custom_query->the_post(); 

                            get_template_part('lib/parts/industry-card',null,
                            array(
                                'desc' => get_field('descriptive_subhead'),
                                'count' => 'item'.$count,
                            )); 
                            $count++;
                        endwhile;
                            wp_reset_postdata();
                        else:
                            // No related posts found
                        endif;
                    endif; ?>
    
            </div>
        </div>


    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>