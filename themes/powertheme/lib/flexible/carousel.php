<?php
    $heading = get_sub_field('heading');
    $items = get_sub_field('items');
    $background_pattern = get_sub_field('background_pattern');
    $classList[] = 'carousel-sect';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>

    <div class="carousel-sect__bg-img">
        <div class="positioner">
        </div>
    </div>

    <h2><?php echo $heading; ?></h2>

    <div class="carousel-sect-testimonial">

        <?php foreach($items as $item){ ?> 
            
            <div class="carousel-sect-cell">
                <div class="carousel-sect-cell__inner">
                    <div class="carousel-sect__logo">
                        <?php echo getIMG($item['logo']); ?>
                    </div>
    
                    <div class="carousel-sect__content">
                        <?php echo $item['content']; ?>
                    </div>
    
                    <div class="carousel-sect__info">
                        <div class="name h4"><?php echo $item['name']; ?></div>
                        <div class="role"><?php echo $item['role']; ?></div>
                    </div>
                </div>
            </div>

        <?php } ?>
       
    </div>


    <div class="nav-dot"> 
        <div class="custom-nav">
            <button class="prev-button"><?php echo getSVG('carousel-arrow'); ?></button>
            <div class="custom-dots"></div>
            <button class="next-button"><?php echo getSVG('carousel-arrow'); ?></button>
        </div>

    </div>

</section>