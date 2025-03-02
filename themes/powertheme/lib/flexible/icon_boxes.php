<?php
    $heading = get_sub_field('heading');
    $boxes = get_sub_field('box');
    $background_image = get_sub_field('background_image');
    $classList[] = 'icon_boxes';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <h2><?php echo $heading; ?></h2>

        <div class="icon_boxes__wrap">
        <?php $i=1; foreach($boxes as $box){ ?>
            <div class="icon_boxes__box" data-aos="flip-left" data-aos-duration="1000">
                <?php echo getSVG('checkcircle'); ?>
                <h4><?php echo $box['title']; ?></h4>
                <p><?php echo $box['content']; ?></p>
            </div>
        <?php $i++; } ?>
        </div>
    </div>

   
</section>