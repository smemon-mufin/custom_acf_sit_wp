<?php
    $hero_heading = get_sub_field('hero_heading');
    $heading_highlight_text = get_sub_field('heading_highlight_text');
    $description = get_sub_field('description');
    $hero_image = get_sub_field('hero_image');
?>
<section class="hero-section">
	<div class="container">
		<div class="hero-wrap">
			<div class="hero-content">
				<h1><?php echo $hero_heading; ?> <span><?php echo $heading_highlight_text; ?></span></h1>
				<?php echo $description ?>
			</div>
			<div class="hero-img">
				<?php echo getIMG($hero_image);?>
			</div>
		</div>
	</div>
</section>