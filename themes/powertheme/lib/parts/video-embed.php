<?php
	$video = $args['video'];
    $video_cover = getIMG($video['cover']['ID'], 'md', true);
    $video_src = getIFrameSrc($video['embed']);
	$play_text = !empty($video['play_label']) ? $video['play_label'] : 'Watch Video';
?>

<div class="video-embed">
    <div class="video-embed__cover lazy" <?php echo $video_cover; ?> data-lightbox-iframe="<?php echo $video_src; ?>">
        <div class="video-embed__play"><?php echo getSVG('play', false, false); ?>
            <?php if($play_text): ?> <span><?php echo $play_text; ?></span><?php endif; ?>
        </div>
    </div>
</div>