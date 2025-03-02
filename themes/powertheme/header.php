<?php
    global $global, $isHome, $isBlog, $is404, $isSingle, $post_id, $post_type, $isPTArchive, $isCategory, $site_logo;

    $global = get_field('global', 'option');
    $header = get_field('header', 'option');
    $isHome = is_front_page();
    $is404 = is_404();
    $isBlog = is_home();
    $isSingle = is_single();
    $isPTArchive = is_post_type_archive();
    $isCategory = is_category() || is_tax();
    $isArchive = is_archive();

    $post_id = $isBlog ? get_option('page_for_posts') : (is_search() ? -1 : get_the_ID());
    $post_type = $isPTArchive ? 'cpt_' . get_post_type() : get_post_type();

    $site_logo = getIMG( $global['logo']['ID'], 'sm', false, array('alt' => get_bloginfo( 'name' ), 'lazy' => false));
    $site_favicon = $global['favicon'];
?>

<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!-- OneTrust Cookies Consent Notice start for aboutsib.com -->
    <?php if($isSingle && $post_type == 'post'): ?>
    	<meta property="og:image" content="<?php echo get_the_post_thumbnail_url($post_id,'hero'); ?>" />
	 <?php else: ?>
        <meta property="og:image" content="https://www.aboutsib.com/wp-content/uploads/2024/11/Thumbnail_SIB24.jpg" />
    <?php endif; ?>
    <?php if(!empty($site_favicon)): ?>
    <link rel="shortcut icon" href="<?php echo $site_favicon['url']; ?>" type="<?php echo $site_favicon['mime_type']; ?>" />
    <?php endif; ?>


    <?php wp_head(); ?>

    <script>var ajaxURL = "<?php echo esc_url( home_url( '/' ) ) . 'wp-admin/admin-ajax.php' ?>";</script>
    <?php echo get_field('head_scripts', 'option'); ?>
	<style  type='text/css'>
		.gchoice_16_11_1 {
			margin-top:1rem;
		}
		#label_16_11_1 {
			font-weight: 400;
		}
		@media (min-width: 960px) {
			.menu--main .menu-item {
				margin-right: 1.15rem;
			}
		}
		@media (min-width: 960px) {
			.menu--main>ul {
				justify-content: flex-end;
			}

		}
		@media (max-width: 960px) {
			.logos__col:last-child {
				width: 100%;
				text-align: center;
			}
		}
		@media (min-width: 1024px) {
			.global, .menu, .menu--main {
				padding-right: 0 !important;
			}
		}
		
/* 	New Home page css start	 */
		section.hero-section {
    padding: 51px 20px 75px;
    margin: 0 !important;
}
.hero-section .hero-wrap {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 20px;
}
.hero-section .hero-wrap .hero-content,
.hero-section .hero-wrap .hero-img{
    max-width: calc(50% - 10px);
    width: 100%;
}
.hero-section .hero-content h1{
	font-size: 48px;
	font-weight: 600;
	line-height: 57.6px;
	color: #000;
}
.hero-section .hero-content h1 span{
	color: #1695ae;
}
.hero-section .hero-content p{
	font-size: 16px;
	font-weight: 400;
	line-height: 24px;
	color: rgba(85, 85, 85, 1);
	margin: 17px 0 0 0;
}

.content-section {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center right;
    padding: 90px 20px 90px;
	background-attachment: fixed;
}
.content-section .content-wrap {
    text-align: center;
}
.content-section .content-wrap h2{
	font-size: 36px;
	font-weight: 600;
	line-height: 46px;
	color: rgba(32, 32, 32, 1);
}
.content-section .content-wrap p{
	font-size: 16px;
	font-weight: 400;
	line-height: 24px;
	color: rgba(85, 85, 85, 1);
	max-width: 1080px;
	margin: 22px auto 0;
}

.our-value-sec{
	padding: 86px 20px 120px;
}
.our-value-sec h2{
	font-size: 36px;
	font-weight: 600;
	line-height: 46px;
	color: rgba(32, 32, 32, 1);
	text-align: center;
	margin-bottom: 40px;
}
.our-value-sec .our-value-wrap {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
}
.our-value-sec .our-value-wrap .value-box{
	max-width: calc(25% - 15px);
	width: 100%;
	border-radius: 10px;
	background-color: rgba(242, 252, 252, 1);
	padding: 35px 20px 40px;
}
.our-value-sec .value-box h3{
	font-size: 24px;
	font-weight: 400;
	line-height: 24px;
	color: rgba(32, 32, 32, 1);
}
.our-value-sec .value-box p{
	font-size: 16px;
	font-weight: 400;
	line-height: 24px;
	color: rgba(85, 85, 85, 1);
}
.our-value-sec .value-box span {
    height: 5px;
    width: 52px;
    display: block;
    background: rgba(47, 207, 211, 1);
    margin-top: 20px;
}

.left-img-content {
	padding: 0 20px 0;
}
.left-img-content .img-content-wrap,
.right-img-content .img-content-wrap{
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
}
.left-img-content .img-content-wrap .content-part,
.left-img-content .img-content-wrap .img-part,
.right-img-content .img-content-wrap .content-part,
.right-img-content .img-content-wrap .img-part{
    max-width: calc(50% - 10px);
    width: 100%;
}
.left-img-content .content-part h2,
.right-img-content .content-part h2{
	font-size: 36px;
	font-weight: 600;
	line-height: 46px;
	color: rgba(32, 32, 32, 1);
}
.left-img-content .content-part p,
.right-img-content .content-part p{
	font-size: 16px;
	font-weight: 400;
	line-height: 24px;
	color: rgba(85, 85, 85, 1);
	margin-top: 12px;
}
.right-img-content .content-part ul{
	margin: 14px 0 0 0;
}
.right-img-content .content-part ul li:before{
	content: unset;
}
.right-img-content .content-part ul li {
    font-size: 16px;
    font-weight: 500;
    line-height: 31px;
    color: #555555;
    padding: 0;
    margin: 0 0 7px;
    background-image: url(https://www.aboutsib.com/wp-content/uploads/2024/12/arrow_back.png);
    background-repeat: no-repeat;
    background-position: 0% 15%;
    padding-left: 30px;
}
.right-img-content .content-part ul li span {
    font-weight: 600;
    color: #1695ae;
}
@media(max-width: 1366px){
	.content-section {
	    background-position: bottom right;
	}
}
@media(max-width: 1024px){
	.hero-section .hero-content h1 {
	    font-size: 40px;
	}
}
@media(max-width: 960px){
	.our-value-sec .our-value-wrap .value-box {
	    max-width: calc(50% - 10px);
	}
	.hero-section .hero-wrap .hero-content, 
	.hero-section .hero-wrap .hero-img,
	.left-img-content .img-content-wrap .content-part, 
	.left-img-content .img-content-wrap .img-part, 
	.right-img-content .img-content-wrap .content-part, 
	.right-img-content .img-content-wrap .img-part{
	    max-width: 100%;
	}
	.right-img-content .img-content-wrap {
	    flex-direction: column-reverse;
	}
	.our-value-sec {
	    padding: 86px 20px 86px;
	}
	section.right-img-content {
	    padding: 50px 20px 50px;
	}
}
@media(max-width: 767px){
	.content-section {
	    background: #8bd0e8 !important;
    	padding: 60px 20px 60px;
	}
}
@media(max-width: 576px){ 
	.our-value-sec .our-value-wrap .value-box {
	    max-width: 100%;
	}
	.left-img-content .content-part h2,
	.right-img-content .content-part h2,
	.content-section .content-wrap h2,
	.hero-section .hero-content h1,
	.our-value-sec h2{
	    font-size: 30px;
	    line-height: 36px;
	}
}
/* 	New Home page css end	 */
	</style>
</head>

<body data-sample="sample" id="top" <?php body_class(); ?>>
    <?php echo get_field('body_scripts_top', 'option'); ?>
    <?php include locate_template( 'lib/layout/header.php' ); ?>
    <?php include locate_template( 'lib/parts/hero.php' ); ?>
    <main>