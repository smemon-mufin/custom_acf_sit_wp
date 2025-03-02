<?php
    $heading = get_sub_field('heading');
    $description = get_sub_field('description');
    $image = get_sub_field('image');
?>
<section class="left-img-content">
	<div class="container">
		<div class="img-content-wrap">
			<div class="content-part">
				<h2><?php echo $heading; ?></h2>
				<?php echo $description; ?>
			</div>
			<div class="img-part">
				<?php echo getIMG($image);?>
			</div>
		</div>
	</div>
</section>