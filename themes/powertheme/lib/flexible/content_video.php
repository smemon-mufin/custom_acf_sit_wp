<?php
    $add_link_to_image = get_sub_field('add_link_to_image');
    $video = get_sub_field('video');
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $link = get_sub_field('link');
    $image_link = get_sub_field('image_link');
    $classList[] = 'content_image small-img';
    $classList[] = 'content_video';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="content_image__wrap">

            <div class="content_image__col">
                <div class="content_image__img">
                    <div class="responsive-iframe-container">
                        <iframe class="responsive-iframe" src="<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <div class="content_image__col">
                <div class="content_image__content">
                    <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                    <?php 
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>
                        <a class="btn btn--red" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>
                </div>
            </div>

           
        </div>
    </div>
</section>