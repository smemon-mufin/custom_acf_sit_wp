<?php
$image = $hero["image"];
$headline = $hero["headline"];
$content = $hero["content"];
$intro = $hero["intro"];
$content_above_img = $hero['content_above_image'];
?>


<section class="hero-content_image <?php echo ($content_above_img) ? "type2" : null ; ?>">
    <div class="container">
        <div class="hero-content_image__wrap">

            <div class="hero-content_image__image" data-aos-duration="1500" data-aos="zoom-in">
				
				<?php echo $content_above_img; ?>
				
                <?php echo getIMG($image); ?>
				
					<?php if(is_page('3529')): ?>

					<div class="hero-content_image__box box1">
						<span class="subtext">Pricing Benchmarks</span>
						<span class="pricing">500,000</span>
					</div>
					<div class="hero-content_image__box box2">
						<span class="pricing">$0</span>
						<span class="subtext">Upfront Costs</span>
					</div>

					<?php endif; ?>
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