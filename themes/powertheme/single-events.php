<?php 
get_header();
$author_id = get_post_field( 'post_author', get_the_ID() );
$author_name = get_the_author_meta( 'display_name', $author_id ); 

$event_details = get_field('event_details');
      
// Assuming you are on the events template
// Get the start date and time and end date and time from the custom fields
$start_date = $event_details['date_start'];
$start_time = $event_details['time_start'];
$end_date = $event_details['date_end'];
$end_time = $event_details['time_end'];
$location = $event_details['location'];

// Convert start and end dates/times to timestamps
$start_timestamp = strtotime($start_date . ' ' . $start_time);
$end_timestamp = strtotime($end_date . ' ' . $end_time);

// Get the current date and time
$current_timestamp = current_time('timestamp');

// Display the date and time range
if ($start_date && $start_time && $end_date && $end_time) {
    $dateresult = '<span>' . date('F j, Y', $start_timestamp) . ' ' . ' - ' . date('F j, Y', $end_timestamp) .'</span>';
} elseif ($start_date && $start_time) {
    $dateresult =  '<span>' . date('F j, Y', $start_timestamp) . '</span>';
} elseif ($end_date && $end_time) {
    $dateresult = '<span>' . date('F j, Y', $end_timestamp) . ' ' . '</span>';
} else {
    $dateresult = '<span>' . date('F j, Y', $start_timestamp) . ' ' . ' - ' . date('F j, Y', $end_timestamp) . ' ' . '</span>';
}
?>

<section class="hero-event"> 
    
    <div class="hero-event__img">
        <div class="positioner">
            <div class="overlay"></div>
            <?php echo getIMG(get_post_thumbnail_id()); ?>
        </div>
    </div>

    <div class="container">
        <div class="hero-event__date-time">
            <span class="date"><?php echo $dateresult; ?></span>
        </div>
        <?php if($location): ?><div class="location"><?php echo "Location: ". $location; ?></div><?php endif; ?>
        <h2><?php echo get_the_title(); ?></h2>
        <?php $categories = get_the_terms( $post->ID, 'category' ); ?>

        <div class="hero-event__categories">
            
            <?php
                // Get all taxonomy names associated with the current post
                $taxonomy_names = get_object_taxonomies(get_post_type());

                if ($taxonomy_names) {
                    foreach ($taxonomy_names as $taxonomy) {
                        $terms = get_the_terms(get_the_ID(), $taxonomy);

                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $term_link = get_term_link($term);
                                echo '<a class="tag" href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a> ';
                            }
                        }
                    }
                }
            ?>
        </div>

    </div>
</section>



<section class="page-content">
    <div class="container container--medium">

        <div class="event_intro_content">
            <?php 
                $event_cb_heading = get_field('intro_heading');
                $event_cb_content = get_field('intro_content');
                $key_box = get_field('key_box');
              
            
         
            ?>

            <h2><?php echo $event_cb_heading; ?></h2>
            <?php echo $event_cb_content; ?>
            
            <?php if($key_box['heading']): ?>
                <div class="keybox">
                    <h2 class="keybox__heading"><?php echo getSVG('idea'); ?> <?php echo $key_box['heading']; ?></h2>
                    <?php echo $key_box['content']; ?>
                </div>
            <?php endif; ?>
        </div>
       
        <?php if( have_posts() ): ?>
           <?php while( have_posts() ): the_post(); ?>
               
                <?php the_content(); ?>
                
            <?php endwhile; ?>
        <?php endif; ?>

    </div>
</section>

<?php 
    $current_post_id = get_the_ID();
    $args = array(
        'post_type'      => 'events',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => array( $current_post_id ),
    );
    $custom_query = new WP_Query( $args );
?>


<?php 

    if( have_rows('flexible') ){
        while ( have_rows('flexible') ){ the_row();
            $id = null;
            $layout = get_row_layout();
            $modifiers = get_sub_field('modifiers');
            
            $classList = array();
            
            if( !empty($modifiers) ){
                $id = $modifiers['id'];
                $classes = explode(' ', $modifiers['classes']);
                $classList = array_merge($classList, $classes);
            }
                                                        
            include locate_template( 'lib/flexible/'.$layout.'.php', false, false );
        }
    }

?>

<?php get_footer(); ?>