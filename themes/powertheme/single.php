<?php get_header(); 
$template = get_field('template');
$resource_posts = get_field('resource_posts');
$form_shortcode = get_field('form_shortcode');
$authors = get_field('author');
$event_cb_heading = get_field('intro_heading');
$event_cb_content = get_field('intro_content');
$key_box = get_field('key_box');
$is_custom_author = get_field('is_custom_author');
$custom_author = get_field('custom_author');
$thumbnail_id = get_field('blog_default_thumbnail', 'option')['ID'];
?>

<div class="template-wrapper <?php echo $template; ?>">

    
    <div class="template-col">
        
        <section class="hero-event"> 
            
            <div class="hero-event__img">
                <div class="positioner">
                    <div class="overlay"></div>
                    <?php echo getIMG(get_post_thumbnail_id()); ?>
                </div>
            </div>
        
            <div class="container">
                <div class="hero-event__date-time">
                    <span class="date"><?php echo get_the_date(); ?></span>
                    &bull;
                    <span class="time"><?php echo readTime(get_the_content()); ?></span>
                </div>
                
        
                <?php if(!empty($authors) || !empty($custom_author)) : ?>
                    <?php if ( ! is_singular( 'resource_videos' ) ) { ?>
                        <div class="hero-event__author">
                            Written by: 
                            <?php 
                            if($is_custom_author){ 
                                echo $custom_author; 
                            }else{ ?>
                                <?php 
                                if($authors): 
                                    $count = 1; 
                                    foreach( $authors as $author ):
                                        echo ($count==1) ? $author->post_title : ', '.$author->post_title  ;
                                    $count++; endforeach;
                                endif;
                            } ?>
                        </div>
                    <?php } ?>
                <?php endif; ?>
                
                <h2><?php echo get_the_title(); ?></h2>
        
                <?php $categories = get_the_terms( $post->ID, 'category' ); ?>
        
                <?php if($categories): ?>
                    <div class="hero-event__categories">
                        <?php foreach( $categories as $category ): ?>
                            <a href="<?php echo get_category_link($category->term_id); ?>" class="tag"><?php echo $category->name; ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    
        <section class="page-content">
            <div class="container <?php echo get_field('form_shortcode') ? '' : 'container--medium' ?>">
                
                
                <?php
                // Get the YouTube URL from the custom field
                $youtube_url = get_field('youtube_video');
                ?>
        
                <?php if($youtube_url): ?>
                    <div class="resource-video">
                        <?php
                        // Check if the URL is a valid YouTube URL
                        if (wp_http_validate_url($youtube_url) && strpos($youtube_url, 'youtube.com') !== false) {
                            // Get the YouTube video ID from the URL
                            $video_id = getYouTubeVideoID($youtube_url);
        
                            // Construct the iframe HTML code
                            if ($video_id) {
                                ?>
                                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                <?php
                            }
                        }
                        ?>
                    </div>
                <?php endif; ?>
        
                <div class="page-content__wrap">
                    <div class="page-content__col">
        
                        <div class="event_intro_content">
                
                
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
                        
                        <?php 
                        // get_template_part('lib/parts/authors-single',false,array(
                        //     'author' => $authors,
                        // )); 
                        ?>
                    </div>
        
                
                </div>
        
        
            </div>
        </section>

    </div>

    <?php if($template == 'gated'): ?>
        <div class="template-col">
            <div class="gated-form-outer">
                <div class="gated-form">
                    <?php 
                        if($form_shortcode){

                        }else{
                            echo '<h4>No form added.</h4>';
                        }
                        echo do_shortcode($form_shortcode); 
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>



<?php 
    $current_post_id = get_the_ID();
    $args = array(
        'post_type'      => get_post_type(),
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'post__not_in'   => array( $current_post_id ),
    );
    $custom_query = new WP_Query( $args );
    $related_posts = get_field('related_posts');
?>

<?php
   if ($related_posts && is_array($related_posts)) {?>

        <section class="related-posts section-bg">
            <div class="container">

                <h2 class="related-posts__heading">Related Resources </h2>

                <div class="related-posts__wrap">
                    <?php 
                    
                        foreach ($related_posts as $post):
                            setup_postdata($post); ?>
                            
                            <div class="related-posts__col">

                                <?php get_template_part('lib/parts/post-card'); ?>
                            </div>
                        <?php 
                        endforeach;
                        wp_reset_postdata()
                    ?>
                </div>
            </div>
        </section>
        
        <?php
        wp_reset_postdata();
    } else {
?>

    <?php if(!is_singular('news')): ?>
        <section class="related-posts section-bg">
            <div class="container">

                <h2 class="related-posts__heading">Related Resources </h2>

                <div class="related-posts__wrap">
                    <?php 
                    if ( $custom_query->have_posts() ) :
                        while ( $custom_query->have_posts() ) :
                            $custom_query->the_post(); ?>
                            
                            <div class="related-posts__col">

                                <div class="img-content-img">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <div class="overlay"></div>
                                        <div class="positioner">
                                            <?php echo (get_the_post_thumbnail()) ? get_the_post_thumbnail() : getIMG($thumbnail_id) ; ?>
                                        </div>
                                    </a>
                                </div>
                                <div class="img-content-content">
                                    <div class="img-content__intro">
                                        <?php 
                                        $category1 = get_the_category(); ?>
                                        <?php if($category1): ?><a href="" class="tag"><?php echo $category1[0]->name; ?></a><?php endif; ?>
                                        <span class="read"><?php echo readTime(get_the_content()); ?></span>
                                    </div>
                                    <h3><?php echo get_the_title(); ?></h3>
                                    <p><?php echo get_small_excerpt(get_the_excerpt()); ?></p>
                                    <a class="readmore" href="<?php echo get_the_permalink(); ?>">Read More <?php echo getSVG('chevron'); ?></a>
                                </div>
                            </div>
                        <?php 
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

            </div> 
        </section>
    <?php
        endif;
}
?>



<?php get_footer(); ?>