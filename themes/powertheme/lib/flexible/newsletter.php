<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $use_global = get_sub_field('use_global');

    $newsletter_global = get_field('newsletter', 'option');
    $global_heading = $newsletter_global['heading'];
    $global_content = $newsletter_global['content'];
    $form_shortcode = $newsletter_global['form_shortcode'];
    $classList[] = 'newsletter section-bg';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="newsletter__wrap">
            
            <div class="newsletter__col">

                <div class="newsletter__content">

                    <?php if($use_global){ ?>
                        <h3><?php echo $global_heading; ?></h3>
                        <?php echo $global_content; ?>
                    <?php }else{ ?>
                        <h3><?php echo $heading; ?></h3>
                        <?php echo $content; ?>
                    <?php } ?>
                </div>

            </div>

            <div class="newsletter__col">
                
                <div class="newsletter__form">

                    <?php echo do_shortcode($form_shortcode); ?>
                    <span class="disclaimer">By subscribing you agree to with our <a href="/privacy/">Privacy Policy</a></span>

                </div>

            </div>

        </div>
    </div>

</section>