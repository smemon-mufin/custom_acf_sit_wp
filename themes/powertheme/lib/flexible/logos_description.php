<?php
    $image = get_sub_field('image');
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $link = get_sub_field('link');
    $items = get_sub_field('items');
    $classList[] = 'logos_description';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container container--medium">

        <div class="logos_description__content">
            <h2><?php echo $heading; ?></h2>
            <?php echo $content; ?>
            <?php 
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="bordered-cta" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('arrow-circle'); ?></a>
            <?php endif; ?>
        </div>

        <div class="logos_description__wrap">
            
            <?php foreach($items as $item){ ?>
                <div class="logos_description__col">
                    <div class="logos_description__logo">
                    <a target="_blank" href="<?php echo esc_attr( $item['link'] ); ?>">
                        <?php echo getIMG($item['image']); ?>
                    </a>
                    </div>

                    <?php echo $item['content']; ?>
                </div>
            <?php } ?>

           
        </div>
    </div>
</section>