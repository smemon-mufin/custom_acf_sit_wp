<?php
    $galleries = get_sub_field('galleries');
    $classList[] = 'jumplink_galleries';
    $attr = buildAttr(array('id'=>$id,'class'=>$classList));
    $count = 0;;
?>


<section <?php echo $attr; ?>>
    <div class="container">

        <div class="jumplink_galleries__wrap">
            <div class="jumplink_galleries__links">
                <h3>Our Industries</h3>

                <div class="jumplink_galleries__links-sticky desk-only">
                    
                    <?php $count=1; foreach($galleries as $item){ ?>
                        <a href="#item<?php echo $count; ?>"><?php echo $item['name']; ?></a>
                    <?php  $count++; } ?>
                        
                </div>

                <div class="dropdown mob-only">
                    <div class="dropdown-toggle">Select Industry</div>
                    <div class="dropdown-menu">
                        <?php $count=1; foreach($galleries as $item){ ?>
                            <a href="#item<?php echo $count; ?>" class="dropdown-item button-tab hover-trigger"><?php echo $item['name']; ?></a>
                        <?php  $count++; } ?>


                        <?php $dataID = 1; foreach($galleries as $item){ ?>
                            <a href="#item<?php echo $count; ?>" class="dropdown-item button-tab hover-trigger" data-id="<?php echo $dataID; ?>"><?php echo $item['name']; ?></a>
                        <?php $dataID++; } ?>
                    </div>

                    <?php echo getSVG('chevron'); ?>
                </div>


            </div>
    
            <div class="jumplink_galleries__galleries">

                <?php $count=1; foreach($galleries as $item){ ?>

                    <?php 
                    $images = $item['images'];
                    if( $images ): ?>
                    <div class="jumplink_galleries__galleries-item" id="item<?php echo $count; ?>">
                        <h4><?php echo $item['name']; ?></h4>
                        <ul>
                            <?php foreach( $images as $image_id ): ?>
                                <li data-aos="zoom-out" data-aos-offset="10" data-aos-once="true">
                                    <?php echo getIMG($image_id,'sm'); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                <?php $count++; } ?>
              
    
            </div>
        </div>


    </div>
</section>