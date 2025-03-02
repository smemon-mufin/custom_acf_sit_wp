<?php
    $heading = get_sub_field('heading');
    $stats = get_sub_field('stats');
    $classList[] = 'stats';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">

        <h2><?php echo $heading; ?></h2>
    
        <div class="stats__wrap">
            <?php foreach($stats as $stat){ ?> 
                <div class="stat">
                    <span class="h3"><?php echo $stat['label']; ?></span>
                    <?php echo $stat['description']; ?>
                </div>
            <?php } ?> 
        </div>
     
    </div>
</section>