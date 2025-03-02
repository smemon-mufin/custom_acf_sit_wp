<?php
$hero = $isPTArchive ? get_field('hero', $post_type) : get_field('hero', $post_id);
if(empty($hero) || $hero['style'] == 'none') return;

$feat_img_id = $isPTArchive ? get_field('feat_img', $post_type)['ID'] : get_post_thumbnail_id($post_id);
$feat_img = getIMG($feat_img_id, 'xl', true);

$classList = array('hero', 'hero--'.$hero['style']);
if(!empty($feat_img)) $classList[] = 'lazy';

if($isHome){
    $classList[] = 'hero--home';
} elseif ($isBlog){
    $classList[] = 'hero--blog hero--archive';
} elseif ($isCategory){
    $classList[] = 'hero--category hero--archive';
} elseif ($isArchive || $isPTArchive){
    $classList[] = 'hero--archive';
   
} else {
    $classList[] = 'hero--single';
    if($post_type)  $classList[] = 'hero--'.$post_type;
}

if (is_404()) {
    $title = 'Page Not Found';
} elseif($hero['headline']) {
    $title = $hero['headline'];
} elseif ($isPTArchive) {
	$title = post_type_archive_title('', false);
} elseif ($isCategory || $isArchive) {
    $query = get_queried_object(  );
    $title = $query->name;
} else {
    $title = get_the_title($post_id);
}

if(empty($title)) return;

$classes = buildAttr('class', $classList);

include locate_template( 'lib/parts/heros/'.$hero['style'].'.php');
?>