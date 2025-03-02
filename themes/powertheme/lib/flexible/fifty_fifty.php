<?php
    $image = get_sub_field('image');
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $classList[] = 'fifty_fifty';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="fifty_fifty__wrap">

            <div class="fifty_fifty__col">
                <div class="fifty_fifty__img">
                    <?php if (in_array("small-image", $classList)) { ?>
                        <div data-aos="zoom-in" data-aos-duration="500">
                            <?php echo getIMG($image);?>
                        </div>
                    <?php }else{?>
                        <div class="positioner" data-aos="zoom-in" data-aos-duration="500">
                            <?php echo getIMG($image);?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="fifty_fifty__col">
                <div class="fifty_fifty__content">
                    <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                </div>
            </div>

           
        </div>
    </div>
</section>