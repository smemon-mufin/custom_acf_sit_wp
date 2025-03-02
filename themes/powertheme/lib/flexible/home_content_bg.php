<?php
    $background_image = get_sub_field('background_image');
    $heading = get_sub_field('heading');
    $description = get_sub_field('description');
?>
<section class="content-section" style="background-image: url(<?php echo $background_image['url'];?>);">
	<div class="container">
		<div class="content-wrap">
			<h2><?php echo $heading; ?></h2>
			<?php echo $description ?>
		</div>
	</div>
</section>