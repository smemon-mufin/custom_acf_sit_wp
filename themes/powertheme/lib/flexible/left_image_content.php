<?php
    $image = get_sub_field('image');
    $heading = get_sub_field('heading');
    $description = get_sub_field('description');
    $listing = get_sub_field('listing');
?>
<section class="right-img-content">
	<div class="container">
		<div class="img-content-wrap">
			<div class="img-part">
				<?php echo getIMG($image);?>
			</div>
			<div class="content-part">
				<h2><?php echo $heading; ?></h2>
				<?php echo $description ?>
				<ul>
					<?php foreach($listing as $item): ?>
					<li><span><?php echo $item['highlight_test'] ?></span> <?php echo $item['content'] ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>