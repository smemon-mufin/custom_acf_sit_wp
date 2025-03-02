<section <?php echo $classes; echo $feat_img;?>>
    <div class="container">
        <h1 class="hero__title"><?php echo $title; ?></h1>
        <?php if(!empty($hero['content'])):?>
        <div class="hero__content"><?php echo $hero['content'];  ?></div>
        <?php endif; ?>
    </div>
</section>