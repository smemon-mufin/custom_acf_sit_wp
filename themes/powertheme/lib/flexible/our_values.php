<?php
    $main_heading = get_sub_field('main_heading');
    $values_box = get_sub_field('values_box');
?>
<section class="our-value-sec">
	<div class="container">
		<h2><?php echo $main_heading ?></h2>
		<div class="our-value-wrap">
			<?php foreach($values_box as $item): ?>
			<div class="value-box">
				<h3><?php echo $item['heading'] ?></h3>
				<?php echo $item['description'] ?>
				<span></span>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>