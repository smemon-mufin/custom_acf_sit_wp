<?php
    $heading = get_sub_field('heading');
    $posts = get_sub_field('posts');
    $big_grid = $posts['big_grid'];
    $top_right_post = $posts['top_right'];
    $bottom_right_post = $posts['bottom_right'];
    $classList[] = 'case-study-grid';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>

    <div class="container">

        <?php if($heading): ?>
        <h2><?php echo $heading; ?></h2>
        <?php endif; ?>

        <div class="case-study-grid__row">
            <div class="case-study-grid__col">
                <div class="grid-box">

                    <div class="img-content-img">
                        <div class="overlay"></div>
                        <div class="positioner">
                            <?php echo get_the_post_thumbnail($big_grid); ?>
                            <?php if(get_field('overview_image', $big_grid)): ?>
                                <?php echo getIMG(get_field('overview_image', $big_grid)); ?> 
                            <?php else: ?>
                                <?php echo get_the_post_thumbnail($big_grid); ?>                                    
                            <?php endif; ?>                            
                        </div>
                    </div>

                    <div class="img-content-content">
                        <div class="img-content__intro">
                            <?php
                                $post_type = str_replace("_", " ", get_post_type($big_grid));
                                $post_type = ($post_type === 'post') ? 'blog' : $post_type;
                                $post_type_url = esc_url(home_url(get_post_type($big_grid)));
                            ?>
                            <a href="<?php echo $post_type_url; ?>" class="tag"><?php echo $post_type;?></a>
                            <span class="read"><?php echo readTime(get_the_content($big_grid)); ?></span> 
                        </div>
                        <h3><?php echo get_the_title($big_grid); ?></h3>
                        <a href="<?php echo get_the_permalink($big_grid); ?>">Read More <?php echo getSVG('chevron'); ?></a>
                    </div>
                   
                </div>
            </div>

            <div class="case-study-grid__col">
                <div class="grid-box fifty">

                    <div class="fifty__col">
                        <div class="img-content-img">
                            <div class="overlay"></div>
                            <div class="positioner">
                                <?php if(get_field('overview_image', $top_right_post)): ?>
                                    <?php echo getIMG(get_field('overview_image', $top_right_post)); ?> 
                                <?php else: ?>
                                    <?php echo get_the_post_thumbnail($top_right_post); ?>                                    
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="fifty__col">
                        <div class="img-content-content">
                            <div class="img-content__intro">
                                    <?php 
                                    $post_type_top = str_replace("_", " ", get_post_type($top_right_post)); 
                                    $post_type_top = ($post_type_top === 'post') ? 'blog' : $post_type_top;
                                    $post_type_url_top = esc_url(home_url(get_post_type($top_right_post)));
                                ?>
                                <a href="<?php echo $post_type_url_top; ?>" class="tag"><?php echo $post_type_top; ?></a>
                                <span class="read"><?php echo readTime(get_the_content($top_right_post)); ?></span>
                            </div>
                            <h4><?php echo get_the_title($top_right_post); ?></h4>
                            <a class="readmore" href="<?php echo get_the_permalink($top_right_post); ?>">Read More <?php echo getSVG('chevron'); ?></a>
                        </div>
                    </div>

                </div>
                <div class="grid-box fifty">

                    <div class="fifty__col">
                        <div class="img-content-img">
                            <div class="overlay"></div>
                            <div class="positioner">
                                <?php if(get_field('overview_image', $bottom_right_post)): ?>
                                    <?php echo getIMG(get_field('overview_image', $bottom_right_post)); ?> 
                                <?php else: ?>
                                    <?php echo get_the_post_thumbnail($bottom_right_post); ?>                                    
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="fifty__col">
                        <div class="img-content-content">
                            <div class="img-content__intro">
                                <?php 
                                 $post_type_bot = str_replace("_", " ", get_post_type($bottom_right_post)); 
                                 $post_type_bot = ($post_type_bot === 'post') ? 'blog' : $post_type_bot;
                                 $post_type_url_bot = esc_url(home_url(get_post_type($bottom_right_post)));
                                ?>
                                <a href="<?php echo $post_type_url_bot; ?>" class="tag"><?php echo $post_type_bot; ?></a>
                                <span class="read"><?php echo readTime(get_the_content($bottom_right_post)); ?></span>
                            </div>
                            <h4><?php echo get_the_title($bottom_right_post); ?></h4>
                            <a class="readmore" href="<?php echo get_the_permalink($bottom_right_post); ?>">Read More <?php echo getSVG('chevron'); ?></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>