<?php
	$heading = get_sub_field('heading');
	$content = get_sub_field('content');
	$counter = get_sub_field('counter');
  $classList[] = "counter";
  $classList[] = (get_sub_field('centered')) ? "centered" : null ;

	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container container--medium">
      
    <?php if(!empty($content)): ?>
      <?php if(!empty($heading)): ?>
        <div class="counter__content" data-aos="fade-right">
            <div class="section__header">
                <h2 class="headline"><?php echo $heading; ?></h2>
            </div>
            <?php endif; ?>
            <div class="section__content"><?php echo $content; ?></div>
        </div>
      <?php endif; ?>

      <?php if($counter): ?>
        <div class="counter__wrap">
          <div class="counter__row">
            <?php foreach($counter as $item): ?>
              <div class="counter__col">
                <span class="counter__item">
                  <span class="count-wrap">
                  <?php echo $item['intro']; ?><span class="count"><?php echo $item['number']; ?></span><?php echo $item['sign']; ?> 
                  </span>
                  <span class="counter-text">
                    <?php echo $item['text']; ?></span>
                  </span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
        
    </div>
    
</section>

