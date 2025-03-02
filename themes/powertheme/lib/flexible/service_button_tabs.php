<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $link = get_sub_field('link');
    $items = get_sub_field('items');
    $classList[] = 'service_button_tabs hover-block';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="service_button_tabs__wrap">

            <div class="service_button_tabs__col">
                
                <div class="service_button_tabs__intro">
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


                    
                <div class="service_button_tabs__tabs">
                    <?php $dataID = 1; foreach($items as $item){ ?>
                        <div class="button-tab hover-trigger" data-id="<?php echo $dataID; ?>"><?php echo $item['button']; ?></div>
                    <?php $dataID++; } ?>
                </div>

                

            </div>

            <div class="service_button_tabs__col">

                <?php $dataID = 1; foreach($items as $item){ ?>
                    <div class="img-content hover-content zoom-img" data-id="<?php echo $dataID; ?>">
                        <div class="img-content-img">
                            <div class="overlay"></div>
                            <div class="positioner">
                                <?php echo getIMG( $item['background_image'] ); ?>
                            </div>
                        </div>

                        <div class="img-content-content">
                            <?php echo $item['content']; ?>
                            <?php 
                            $link = $item['link'];
                            if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?> <?php echo getSVG('chevron'); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php $dataID++; } ?>

            </div>

          
        </div>
    </div>
</section>