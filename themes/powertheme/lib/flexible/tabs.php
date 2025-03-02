<?php
    $heading = get_sub_field('heading');
    $tabs = get_sub_field('tabs');
    $classList[] = 'tabs';
    $link = get_sub_field('link');
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
     
        <div class="tabs__intro">
            <?php if($heading): ?>
            <h2><?php echo $heading; ?></h2>
            <?php endif; ?>
        </div>

        <div class="tabs__wrap desk-only">

            <div class="tabs__col">

                <div class="tabs__tabs">
                    <?php $count = 1; foreach($tabs as $tab): ?>
                    <div class="button-tab hover-trigger <?php echo ($count == 1)? "active" : ""; ?>"><span><?php echo $count; ?></span> <?php echo $tab['title']; ?></div>
                    <?php $count++; endforeach; ?>
                </div>

            </div>

            <div class="tabs__col">

                <?php $count = 1; foreach($tabs as $tab): ?>
                    <div class="tabs__content hover-content <?php echo ($count == 1)? "active" : ""; ?>">
                        <?php echo $tab['content']; ?>
                    </div>
                <?php $count++; endforeach; ?>

            </div>

          
        </div>

        <div class="tabs__carousel mob-only">
            <?php $count = 1; foreach($tabs as $tab): ?>
            <div class="carousel-cell tabs__content">
                <div class="hover-content">
                    <h3><?php echo $tab['title']; ?></h3>
                    <?php echo $tab['content']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="nav-dot mob-only"> 
            <div class="custom-nav">
                <button class="tabsprev-button"><?php echo getSVG('carousel-arrow'); ?></button>
                <button class="tabsnext-button"><?php echo getSVG('carousel-arrow'); ?></button>
            </div>

        </div>

        <div class="tabs__btn">
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
</section>