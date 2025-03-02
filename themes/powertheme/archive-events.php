<?php get_header(); ?>

<div class="categories-btn__wrap">
   
    <?php
        $taxonomy = 'event_categories';
        $post_type = get_post_type();

        // Get the current term ID if we are on a taxonomy page.
        $current_term_id = is_tax() ? get_queried_object_id() : 0;

        // Get all the terms for the specified taxonomy.
        $terms = get_terms( array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ) );

        if ( ! empty( $terms ) ) {
            echo '<ul>';
            echo '<li><a class="btn btn--red" href="/events/">All</a></li>';
            foreach ( $terms as $term ) {
                $args = array(
                    'post_type' => $post_type,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'term_id',
                            'terms' => $term->term_id,
                        ),
                    ),
                );

                $query = new WP_Query( $args );

                $current_class = ( $current_term_id === $term->term_id && $query->have_posts() ) ? 'btn--red' : 'btn--white';

                echo '<li><a class="btn ' . esc_attr( $current_class ) . '" href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';

                wp_reset_postdata();
            }

            echo '</ul>';
        }
    ?>
</div>

<?php
$args = array(
    'post_type'      => 'events', // Replace with your desired post type
    'posts_per_page' => -1, // Retrieve all posts
);

$custom_query = new WP_Query($args);

if ($custom_query->have_posts()) {
    $posts = array();

    while ($custom_query->have_posts()) {
        $custom_query->the_post();

        // Get the ACF date field value
        $acf_date = get_field('event_details', get_the_ID());

        $posts[] = array(
            'post_id' => get_the_ID(),
            'acf_date' => $acf_date['date_start'],
        );
    }
    wp_reset_postdata();

    // Sort the posts array using the custom comparison function
    usort($posts, 'custom_acf_date_sort');
    ?>

<section class="archive-content">
    <div class="container">

        <div class="blog-posts loadmore-container">
            <?php
            foreach ($posts as $post) {
                $post_id = $post['post_id'];
                $post_title = get_the_title($post_id);
                $acf_date = $post['acf_date'];

                get_template_part('lib/parts/event-card',false,array(
                    'post_id' => $post_id,
                    'title' => $post_title,
                ));
            } 
            ?>
        </div>

    </div>
</section> 

<?php
} else {
    echo 'No posts found.';
}
?>

<?php get_template_part('lib/layout/flexible'); ?>

<?php get_footer(); ?>