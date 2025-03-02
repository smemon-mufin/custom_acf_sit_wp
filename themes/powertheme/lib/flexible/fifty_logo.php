<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $logos = get_sub_field('logos');
    $classList[] = 'fifty_fifty fifty_logo';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="fifty_fifty__wrap">


            <div class="fifty_fifty__col">
                <div class="fifty_fifty__content">
                    <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                </div>
            </div>

            <div class="fifty_fifty__col">
                <div class="fifty_logo__logos">
                    <?php 
                    $images = $logos;
                    if( $images ): ?>
                        <?php foreach( $images as $image ): ?>
                            <div class="fifty_logo__logo" data-aos="zoom-out" data-aos-duration="1000">
                                <?php echo getIMG($image); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

           
        </div>
    </div>
</section>