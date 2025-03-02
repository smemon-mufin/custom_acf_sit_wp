<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $background_image = get_sub_field('background_image');
    $classList[] = 'cta section-bg';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="cta__wrap">
            <div class="cta__content">
                <h2><?php echo $heading; ?></h2>
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <div class="cta__img bg-img">
        <div class="overlay"></div>
        <div class="positioner">
            <?php echo getIMG($background_image,'xxl'); ?>
        </div>
    </div>
</section>