<?php
    $label = $args['label'];
    $content = $args['content'];
    $attr = $args['attr'];
    $active = (bool) $args['active'];
    $classes = $args['class'];
    $item = $args['item'];

    if(!empty($attr)) $dataset = buildAttr($attr);
    $acc_classes = array('accordion');

    if($active) $acc_classes[] = 'active';
    if(!empty($classes)) $acc_classes[] = implode(' ', $classes);

    $acc_class = buildAttr('class', $acc_classes);

?>
<div <?php echo $acc_class; ?> <?php echo $dataset; ?>>
    <button class="accordion__trigger" type="button" data-trigger="<?php echo $item; ?>">
        <span class="accordion__label"><?php echo $label; ?></span>
        <?php echo getSVG('chevron'); ?>
    </button>
    <div class="accordion__content"><?php echo $content; ?></div> 
</div>