

<?php get_header(); ?>

<div class="case-studies-wrap">

<?php get_template_part('lib/parts/case-study-filters'); ?>

<section class="archive-content">
    <div class="container">

        <div class="blog-posts loadmore-container resource-posts">

            <?php 
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'case_studies',
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
        
        // Restore original post data
        wp_reset_postdata();
        
        ?>
                    
    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>

</div>

<?php get_footer(); ?>