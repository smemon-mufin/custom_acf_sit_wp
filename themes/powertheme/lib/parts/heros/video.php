<?php
$image = $hero["image"];
$video = $hero["video"];
$headline = $hero["headline"];
$content = $hero["content"];
$intro = $hero["intro"];
?>


<section class="hero-content_image content_circular_image hero-video">
    <div class="container">
        <div class="hero-content_image__wrap">

            <div class="hero-content_image__image" data-aos-duration="1500" data-aos="zoom-in">
                <iframe width="560" height="315" src="<?php echo $video; ?>" frameborder="0" allowfullscreen></iframe>
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