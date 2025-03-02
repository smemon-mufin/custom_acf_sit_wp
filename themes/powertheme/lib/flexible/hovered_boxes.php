<?php
    $heading = get_sub_field('heading');
	$link = get_sub_field('link');
	$hovered_boxes = get_sub_field('hovered_boxes');
    $classList[] = 'hovered-boxes';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">

        <div class="hovered-boxes__intro">
            <h2><?php echo $heading; ?></h2>
            <?php 
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="bordered-cta" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('chevron'); ?></a>
            <?php endif; ?>
        </div>

        <div class="hovered-boxes__wrap">

            <?php foreach( $hovered_boxes as $box ) { ?>

                <div class="hovered-box" data-aos="zoom-in">
                    <div class="hovered-box-img">
                        <div class="overlay"></div>
                        <div class="positioner">
                            <?php echo getIMG($box['image']); ?>
                        </div>
                    </div>

                    <div class="hovered-box-content">
                        <h3><?php echo $box['title']; ?></h3>

                        <div class="hovered-box-hidden">
                            <p><?php echo $box['content']; ?></p>
                            <?php 
                            $link = $box['link'];
                            if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('chevron'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <?php } ?>


        </div>
    </div>
</section>