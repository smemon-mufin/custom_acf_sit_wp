<?php get_header(); 



$post_type = get_post_type();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type'      => $post_type,   // Replace with your desired post type
    'posts_per_page' => 12,       // Retrieve 12 posts
    'paged' => $paged,
);

$query = new WP_Query($args);

?>

<section class="archive-content">
    <div class="container">

        <div class="blog-posts loadmore-container">

            <?php if( $query->have_posts() ):
				while( $query->have_posts() ): $query->the_post();
					get_template_part('lib/parts/post-card');
				endwhile;

				else : ?>
            <h2>No Posts Found</h2>
            <?php endif; ?>

        </div>

        <?php 
        
        // Pagination using WP PageNavi
        if (function_exists('wp_pagenavi')) {
            wp_pagenavi(array('query' => $query));
        }
        ?>

    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>