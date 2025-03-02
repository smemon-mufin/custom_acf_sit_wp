<?php
$image = $hero["image"];
$headline = $hero["headline"];
$content = $hero["content"];
$intro = $hero["intro"];
?>


<section class="hero-content_image content_circular_image">
    <div class="container">
        <div class="hero-content_image__wrap">

            <div class="hero-content_image__image" data-aos-duration="1500" data-aos="zoom-in">
                <div class="image">
                    <div class="positioner">
                        <?php echo getIMG($image,'xxl'); ?>
                    </div>
                </div>
            </div>

            <div class="hero-content_image__content">
                <?php if($intro){ ?>
                    <span class="h5 intro"><?php echo $intro ?></span>
                <?php } ?>
                <h1 class="h2"><?php echo $headline; ?></h1>
                <?php echo $content; ?>
            </div>
           
        </div>
    </div>
</section>