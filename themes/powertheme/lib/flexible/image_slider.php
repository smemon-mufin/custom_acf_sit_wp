<?php
    $headline = get_sub_field('headline');
    $content = get_sub_field('content');
	$link = get_sub_field('link');
	$images = get_sub_field('images');
    $classList[] = 'image-slider';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container container--fullwidth">

        <div class="image-slider__intro">
            <?php if($headline): ?><h2><?php echo $headline; ?></h2><?php endif; ?>
            <?php if($content): ?><?php echo $content; ?><?php endif; ?>
            <?php 
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="bordered-cta" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('chevron'); ?></a>
            <?php endif; ?>
        </div>

        <div class="image-slider__carousel-wrap">

            <div class="image-slider__carousel">
                <?php 
                if( $images ): ?>
                
                        <?php foreach( $images as $image_id ): ?>
                            <div class="carousel-cell image-slider__carousel-cell">
                                
                                        <?php echo getIMG($image_id, 'xl'); ?>
                                  
                            </div>
                        <?php endforeach; ?>
                
                <?php endif; ?>
    
                
            </div>
    
            
            <div class="custom-nav">
                <button class="img-slider_prev-button"><?php echo getSVG('carousel-arrow'); ?></button>
                <button class="img-slider_next-button"><?php echo getSVG('carousel-arrow'); ?></button>
            </div>
        </div>

        
    </div>
</section>