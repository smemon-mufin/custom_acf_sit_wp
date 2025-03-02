<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $cards = get_sub_field('cards');
    $classList[] = 'team';
    $attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>


<section <?php echo $attr; ?>>
    <div class="container">
        
        <div class="team__content">
            <h2><?php echo $heading; ?></h2>
            <?php echo $content; ?>
        </div>

        <div class="team__wrap">
            <?php foreach($cards as $card){ ?>
                <div class="team__card">
                    <div class="team__card-image zoom-img">
                        <div class="positioner">
                            <?php echo getIMG($card['image']); ?>
                        </div>
                    </div>

                    <div class="team__card-info">
                        <h4><?php echo $card['name']; ?></h4>
                        <span class="position"><?php echo $card['position']; ?></span>
                    </div>

                </div>
            <?php } ?>
        </div>

    </div>
</section>