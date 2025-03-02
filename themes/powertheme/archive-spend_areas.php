<?php get_header(); 
$featured_posts = get_field('post','cpt_spend_areas');
$sub_title = get_field('post','sub_headline');
?>
        
<section class="archive-content archive-spend_areas">

    <div class="container">
<h3 class="sub_titeles">Spend Areas</h3>
        <div class="blog-posts loadmore-container">

            <?php if( $featured_posts ): ?>

                <?php 
                $args = array(
                    'post__in' => wp_list_pluck($featured_posts, 'ID'), // Extract IDs of related posts
                    'post_type' => 'spend_areas', // Change to your custom post type if needed
                    'posts_per_page' => -1, // Show all related posts
                    'orderby' => 'post__in',
                );    
                $custom_query = new WP_Query($args);
                ?>
           
                <?php 

                    if ($custom_query->have_posts()) :
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                    
                        get_template_part('lib/parts/spend_areas-card',null,
                        array(
                            'desc' => get_field('descriptive_subhead'),
                        )); 

                    endwhile;
                        wp_reset_postdata();
                    else:
                        // No related posts found
                    endif;
                endif; ?>
        </div>

    </div>
</section>


    <script>
document.body.classList.add('spend_areas-utilities-2');
</script>
<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>

