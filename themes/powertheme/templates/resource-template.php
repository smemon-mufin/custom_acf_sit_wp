

<?php 
/**
 * Template Name: Resources Archive
 * Description: Custom template for the Resources archive.
 */
?>
<?php get_header(); ?>


<div class="resources-template">

<?php get_template_part('lib/parts/resource-filters'); ?>


<section class="archive-content">
    <div class="container">

        <div class="blog-posts loadmore-container resource-posts">

            <?php 
            $custom_post_types = array('articles', 'resource_videos', 'post', 'resources');
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => $custom_post_types,
                'post_status' => 'publish',
                'posts_per_page' => 12,
                'paged' => $paged,
            );
    
            $query = new WP_Query($args);
            
            
            if( $query->have_posts() ):
                while( $query->have_posts() ): $query->the_post();
                    get_template_part('lib/parts/resource-card', false, array(
                        'post_id' => get_the_ID(),
                    ));
                endwhile;
                // Restore original post data
                else : ?>
            <h2>No Posts Found</h2>
            <?php endif; ?>
                    
        </div>  
        <?php 
         
         // Pagination using WP PageNavi
         if (function_exists('wp_pagenavi')) {
             wp_pagenavi(array('query' => $query));
         }
         
        
        wp_reset_postdata();
        
        ?>

</section>

                    
</div>

</div>

<?php get_footer(); ?>