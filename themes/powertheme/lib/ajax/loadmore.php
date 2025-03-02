<?php

function load_more_posts() {
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $posts_per_page = 12;

    $custom_post_types = explode(',',$_POST['post_types']);

    $args = array(
        'post_type' => $custom_post_types,
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('lib/parts/resource-card');
        }
        wp_reset_postdata();
    }

    $output = ob_get_clean();

    $max_pages = $query->max_num_pages; // Get the maximum number of pages

    wp_send_json_success(array(
        'content' => $output,
        'max_pages' => $max_pages, // Send the max_pages as part of the AJAX response
    ));

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

?>