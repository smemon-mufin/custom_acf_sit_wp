<?php get_header();
$term = $_REQUEST['s'];


$args = array(
    'orderby' => 'relevance',
    'posts_per_page' => -1,
    's' => $term,
);

$posts = new WP_Query($args);
$max_num_pages = $posts->max_num_pages;

?>

<section class="page-header">
    <div class="container">
        <h1 class="h3 page-title">
            <?php _e("Search Results for", "powertheme"); ?> <span class="search-term">'<?php echo get_search_query(); ?>'</span></h1>
    </div>
</section>

<section class="archive-content">
    <div class="container">
        <div class="blog-posts">
            <?php if( $posts->have_posts() ):
                while( $posts->have_posts() ): $posts->the_post();
                    get_template_part('lib/parts/post-card');
                endwhile; wp_reset_query(  );
            else : ?>
            <h2>No Posts Found</h2>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>