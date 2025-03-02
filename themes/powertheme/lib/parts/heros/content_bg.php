<?php
$image = $hero["image"];
$intro = $hero["intro"];
$headline = $hero["headline"];
$content = $hero["content"];
?>


<section class="hero-content_bg">

    
    <div class="hero-content_bg__img">
        <div class="overlay"></div>
        <div class="positioner">
            <?php echo getIMG($image,'xxl'); ?>
        </div>
    </div>

    <div class="container">
        <div class="hero-content_bg__wrap zxcvzcvzxc">
            <div class="hero-content_bg__content">
                <?php if($intro){ ?>
                    <span class="h5 intro"><?php echo $intro ?></span>
                <?php } ?>
                <h1 class="h2"><?php echo $headline; ?></h1>
                <?php echo $content; ?>
            </div>
           
        </div>
    </div>
</section>