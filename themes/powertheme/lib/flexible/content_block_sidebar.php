<?php
	$heading = get_sub_field('heading');
	$content = get_sub_field('content');
	$sidebar = get_sub_field('sidebar');
    $classList[] = 'content_block_sidebar';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        
        <div class="content_block_sidebar__wrap">
    
            <div class="content_block_sidebar__left">
                <div class="content_block_sidebar__top_content">
                    <?php echo $sidebar['top_content']; ?>
                </div>
                <div class="content_block_sidebar__bottom_content">
                    <?php echo $sidebar['bottom_content'];  ?>
                </div>
            </div>

            <div class="content_block_sidebar__right">
                <?php if(!empty($heading)): ?>
                <div class="section__header">
                    <h2><?php echo $heading; ?></h2>
                </div>
                <?php endif; ?>
                <?php if(!empty($content)): ?>
                <div class="section__content"><?php echo $content; ?></div>
                <?php endif; ?>
            </div>

        </div>

            
    </div>
</section>