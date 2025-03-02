<?php
   
    $event_details = get_field('event_details', $args['post_id']);
    $cover_image = $event_details['cover_image'];
    $description = $event_details['description'];
      
    // Assuming you are on the events template
    // Get the start date and time and end date and time from the custom fields
    $start_date = $event_details['date_start'];
    $start_time = $event_details['time_start'];
    $end_date = $event_details['date_end'];
    $end_time = $event_details['time_end'];

    // Convert start and end dates/times to timestamps
    $start_timestamp = strtotime($start_date . ' ' . $start_time);
    $end_timestamp = strtotime($end_date . ' ' . $end_time);

    // Get the current date and time
    $current_timestamp = current_time('timestamp');

    // Check if the event is upcoming or past
    if ($end_timestamp >= $current_timestamp) {
        $current_status_class = 'upcoming';
        $current_status_label = "Upcoming";
    } else {
        $current_status_class = 'past';
        $current_status_label = "Past";
    }


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

<article class="event-card">
    <div class="img-content-img">
        <a href="<?php echo get_the_permalink($args['post_id']); ?>">
            <span class="status <?php echo $current_status_class; ?>">
            <?php echo $current_status_label; ?>    
            </span>
            <div class="overlay"></div>
            <div class="positioner">
                <?php echo ($cover_image) ? getIMG($cover_image) :  get_the_post_thumbnail() ; ?>
            </div>
        </a>
    </div>
    <div class="img-content-content">
        <div class="img-content__intro">
            <?php 
            $category1 = get_the_terms( get_the_ID(), 'event_categories' ); ?>

            <?php if($category1): ?>
                <a href="<?php echo get_term_link($category1[0]->term_id); ?>" class="tag"><?php echo $category1[0]->name; ?></a>
            <?php endif; ?>

            <p><?php echo $dateresult; ?></p>
        </div>
        <h3><?php echo $args['title']; ?></h3>
        <p><?php echo $description; ?></p>
        <a class="readmore" href="<?php echo get_the_permalink($args['post_id']); ?>">Read More <?php echo getSVG('chevron'); ?></a>
    </div>
</article>