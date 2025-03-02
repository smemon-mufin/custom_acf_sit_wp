<?php
	$heading = get_sub_field('heading');
	$logos = get_sub_field('logos');
    $classList[] = 'logos';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="logos__wrap">
            <div class="logos__col">
                <h4><?php echo $heading; ?></h4>
            </div>

            <?php foreach($logos as $img_id){ ?>
            <div class="logos__col">
                <div class="logos__logo" data-aos="fade-left">
                    <?php echo getIMG($img_id); ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>