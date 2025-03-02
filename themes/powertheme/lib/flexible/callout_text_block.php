<?php
    $heading = get_sub_field('heading');
    $content = get_sub_field('content');
    $callout = get_sub_field('callout');
    $classList[] = 'callout_text_block';
	$attr = buildAttr(array('id'=>$id,'class'=>$classList));
?>

<section <?php echo $attr; ?>>
    <div class="container">
        <div class="callout_text_block__wrap">

            <div class="callout_text_block__col">
                <div class="callout_text_block__content">
                    <h2><?php echo $heading; ?></h2>
                    <?php echo $content; ?>
                </div>
            </div>

            <div class="callout_text_block__col">
                <div class="callout_text_block__callout">
                    <?php foreach($callout as $callout){ ?> 
                        <div class="callout_label">
                            <span class="h2"><?php echo $callout['label']; ?></span>
                        </div>
                    <?php } ?> 
                </div>
            </div>

            <div class="circular-svg desk-only">
                <?php echo getSVG('circular'); ?>
            </div>

           
        </div>
    </div>
</section>

<style>
.callout_text_block__col:first-child {
  margin-bottom: 3rem;
}
.callout_text_block__callout .callout_label {
  margin: 0 2% 0;
}
.callout_text_block__callout .callout_label:not(:last-child) {
  margin-bottom: 1.5rem;
}
.callout_text_block__callout .callout_label .h2 {
  color: #0da89e;
}
.callout_text_block__callout .callout_label p {
  margin-top: 0.5rem;
}
@media (min-width: 960px) {
  .callout_text_block {
    padding-top: 9rem;
  }
  .callout_text_block__wrap {
    display: flex;
    position: relative;
  }
  .callout_text_block__col {
    flex: 1;
    margin-bottom: 0 !important;
  }
  .callout_text_block__col:first-child {
    max-width: 44%;
    padding-right: 3rem;
  }
  .callout_text_block__col:not(:last-child) {
    margin-bottom: 3rem;
  }
  .callout_text_block__callout {
    display: flex;
/*     flex-wrap: wrap; */
    padding-top: 3rem;
    justify-content: center;
  }
  .callout_text_block__callout .callout_label {
    width: 60%;
    background: #f8f8f8;
    padding: 2rem;
  }
  .callout_text_block__callout .callout_label:not(:last-child) {
    margin-bottom: 3rem;
  }
  .callout_text_block .circular-svg {
    position: absolute;
    width: 318px;
    height: 318px;
    top: -18%;
    right: -6%;
    z-index: -1;
  }
  .callout_text_block .circular-svg .svg-icon {
    width: 100%;
    height: 100%;
  }
}
</style>