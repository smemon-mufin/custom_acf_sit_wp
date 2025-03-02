<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $stats = get_sub_field('stats');
    $classList[] = 'content_stats';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="content_stats__wrap">

            <div class="content_stats__col">
                <div class="content_stats__content">
                    <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                </div>
            </div>

            <div class="content_stats__col">
                <div class="content_stats__stats">
                    <?php foreach($stats as $stat){ ?> 
                        <div class="stat">
                            <span class="h2"><?php echo $stat['label']; ?></span>
                            <?php echo $stat['description']; ?>
                        </div>
                    <?php } ?> 
                </div>
            </div>

           
        </div>
    </div>
</section>