<?php 
// Function to filter posts based on post names and content type
function filter_case_studies() {

    $post_name_1 = isset($_POST['post_name_1']) ? $_POST['post_name_1'] : array();
    $post_name_2 = isset($_POST['post_name_2']) ? $_POST['post_name_2'] : array();
    $post_name_3 = isset($_POST['post_name_3']) ? $_POST['post_name_3'] : array();


    // Initialize an empty array to hold the filtered posts.
        $args = array(
            'post_type' => 'case_studies',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );

        // Check if any terms are selected for taxonomy1 and add the filter to the query.
        if (!empty($post_name_1)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'case_study_solutions',
                'field' => 'slug',
                'terms' => $post_name_1,
            );
        }

        // Check if any terms are selected for taxonomy2 and add the filter to the query.
        if (!empty($post_name_2)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'case_study_spend_areas',
                'field' => 'slug',
                'terms' => $post_name_2,
            );
        }

        // Check if any terms are selected for taxonomy3 and add the filter to the query.
        if (!empty($post_name_3)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'case_study_industry',
                'field' => 'slug',
                'terms' => $post_name_3,
            );
        }
        $query = new WP_Query($args);


      // Check if any posts are found in this query.
      if ($query->have_posts()) {
      // Generate HTML markup for the filtered posts
        while ($query->have_posts()) {
                $query->the_post();
                ob_start();
                get_template_part('lib/parts/resource-card');
                $output .= ob_get_clean();
            }
        }
         else {
            $output = '<span class="h2">No content matches the filter criteria.</span>';
         }

        // Reset the post data for the main query
        wp_reset_postdata();


  

  // Return the HTML markup in the response
    wp_send_json($output);

}

// Action hook for logged in users
add_action('wp_ajax_filter_case_studies', 'filter_case_studies');

// Action hook for non-logged in users
add_action('wp_ajax_nopriv_filter_case_studies', 'filter_case_studies');