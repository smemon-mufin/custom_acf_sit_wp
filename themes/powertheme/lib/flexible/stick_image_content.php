<?php
    $heading = get_sub_field('heading');
    $image = get_sub_field('image');
    $description = get_sub_field('description');
    $content_items = get_sub_field('content');
    $classList[] = 'sticky-img-content';
    $attr = buildAttr(array('id'=>$id,'class'=>$classList));
    $count = 0;;
?>


<section <?php echo $attr; ?>>
    <div class="container">
        <div class="si-img">
            <div class="si-img__column">
                <div class="si-img-sticky">

                    <div class="si-item-img">
                        <?php echo getIMG($image['ID']); ?>
                    </div>
                    
                </div>
            </div>
            <div class="si-img__column">
                <span class="h3"><?php echo $heading; ?></span> 
                
                <?php if($description): ?>
                <div class="description">
                    <?php echo $description; ?>           
                </div>
                <?php endif; ?>

               <?php $i = 1;  foreach  ($content_items as $item) { ?>
                    <?php 
                     get_template_part( 'lib/parts/accordion', null, array(
                        
                    'class' => "",
                    'active' => "",
                    'attr' =>  $attr,
                    'label' => $item['title'],
                    'content' => $item['content'],
                    'item' => "item".$i,
                     ) );
                $i++;  }; ?>
            </div>
        </div>

    </div>
</section>