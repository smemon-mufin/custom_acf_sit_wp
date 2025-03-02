<?php get_header(); ?>

<section class="simple-hero">
    <div class="container container--small">
        <?php
            if ( is_tax() ) {
                $current_term = get_queried_object();
                echo '<h1>' . $current_term->name . '</h1>';

                $taxonomy_description = term_description();
                if ( ! empty( $taxonomy_description ) ) {
                    echo '<p>' . $taxonomy_description . '</p>';
                }
            }
        ?>
    </div>
</section>

<div class="categories-btn__wrap">
   
    <?php
        $taxonomy = 'event_categories';
        $post_type = 'events';

        // Get the current term ID if we are on a taxonomy page.
        $current_term_id = is_tax() ? get_queried_object_id() : 0;

        // Get all the terms for the specified taxonomy.
        $terms = get_terms( array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ) );

        if ( ! empty( $terms ) ) {
            echo '<ul>';
            echo '<li><a class="btn btn--white" href="/events/">All</a></li>';
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
$taxonomy = 'event_categories';
$current_term = get_queried_object();
// echo '<h1>' . $current_term->name . '</h1>';
$args = array(
    'post_type'      => 'events', // Replace with your desired post type
    'posts_per_page' => -1, // Retrieve all posts
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => $current_term->term_id,
        ),
    ),
);

?>

<section class="archive-content">
    <div class="container">
        <div class="blog-posts loadmore-container">

            <?php
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

                foreach ($posts as $post) {
                    $post_id = $post['post_id'];
                    $post_title = get_the_title($post_id);
                    $acf_date = $post['acf_date'];


                    get_template_part('lib/parts/event-card',false,array(
                        'post_id' => $post_id,
                        'title' => $post_title,
                    ));
                } 
            } else {
                echo 'No posts found.';
            } ?>

        </div>
    </div>
</section> 

<?php
    $newsletter_global = get_field('newsletter', 'option');
    $global_heading = $newsletter_global['heading'];
    $global_content = $newsletter_global['content'];
    $form_shortcode = $newsletter_global['form_shortcode'];
    $classList[] = 'newsletter section-bg';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="newsletter__wrap">
            <div class="newsletter__col">
                <div class="newsletter__content">
                    <h3><?php echo $global_heading; ?></h3>
                    <?php echo $global_content; ?>
                </div>
            </div>

            <div class="newsletter__col">
                <div class="newsletter__form">
                    <?php echo do_shortcode($form_shortcode); ?>
                    <span class="disclaimer">By subscribing you agree to with our <a href="/privacy/">Privacy Policy</a></span>

                </div>

            </div>

        </div>
    </div>

</section>


<?php get_footer(); ?>