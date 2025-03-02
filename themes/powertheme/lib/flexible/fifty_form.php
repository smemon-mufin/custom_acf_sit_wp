<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $form_shortcode = get_sub_field('form_shortcode');
    $classList[] = 'fifty_form small-pt small-pb no-mt';
    $attr = buildAttr(array('id'=>$id,'class'=>$classList));
    $count = 0;;
?>


<section <?php echo $attr; ?>>
    <div class="container">

        <div class="fifty_form__wrap">
            <div class="fifty_form__column">
                <h1><?php echo $heading; ?></h1>
                <?php echo $content; ?>
            </div>
            <div class="fifty_form__column">
                <div class="fifty_form__form">
                    <?php echo do_shortcode($form_shortcode); ?> 
                </div>
            </div>
        </div>

    </div>
</section>