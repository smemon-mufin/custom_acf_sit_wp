<?php
$image = $hero["image"];
$headline = $hero["headline"];
$content = $hero["content"];
$intro = $hero["intro"];
?>


<section class="hero-gradient section-bg">
    <div class="container">
        <div class="hero-gradient__wrap">

            <div class="hero-gradient__image desk-only" data-aos="fade-left">
                <div class="positioner">
                    <?php echo getIMG($image,'xxl'); ?>
                </div>
            </div>
            
            <div class="overlay"></div>

            <div class="hero-gradient__content">
                <?php if($intro){ ?>
                <span class="h5 intro"><?php echo $intro ?></span>
                <?php } ?>
                <h1><?php echo $headline;?></h1>
                <?php echo $content; ?>
            </div>
           
        </div>
    </div>
</section>