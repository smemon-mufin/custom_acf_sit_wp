<?php global $global, $site_logo;
    $footer_top = get_field('footer_top', 'option');
    $first_menu = $footer_top['start_menu'];
    $second_menu = $footer_top['second_menu'];
    $third_menu = $footer_top['third_menu'];
    $fourth_menu = $footer_top['fourth_menu'];
    
    $logo = $footer_top['logo'];
    $footer_bottom = get_field('footer_bottom', 'option');
    $first_link = $footer_bottom['first_link'];
    $second_link = $footer_bottom['second_link'];
    $last_link = $footer_bottom['last_link'];

    if(!empty($logo)) $site_logo = getIMG( $logo['ID'], 'md', false, array('alt' => get_bloginfo( 'name' ), 'lazy' => false));
?>

</main>
<style>
.gfooter__logo img {
    max-width: 80px;
    width: 100%;
}
</style>
<footer class="gfooter">
    <div class="gfooter__content">
        <div class="container">
            <div class="row">
                <div class="col col--left">
                    <div class="gfooter-content">
                        <div class="gfooter__logo">
                            <a class="site-logo" href="<?php echo home_url(); ?>"><?php echo $site_logo; ?></a>
                            <?php if($footer_top['content']): ?>
                                <?php echo $footer_top['content']; ?> 
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col col--right">
                    <div class="gfooter-menus">
                        <div class="menu menu--foot">
                            <span class="menu--heading"><?php echo $first_menu['heading']; ?></span>
                            <ul>
                                <?php foreach($first_menu['links'] as $link){ ?>
                                <li>
                                    <?php 
                                    $link = $link['link'];
                                    if( $link ): 
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                    <?php endif; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        
                        <div class="menu menu--foot">
                            <span class="menu--heading"><?php echo $second_menu['heading']; ?></span>
                            <ul>
                                <?php foreach($second_menu['links'] as $link){ ?>
                                <li>
                                    <?php 
                                    $link = $link['link'];
                                    if( $link ): 
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                    <?php endif; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="menu menu--foot">
                            <span class="menu--heading"><?php echo $third_menu['heading']; ?></span>
                            <ul>
                                <?php foreach($third_menu['links'] as $link){ ?>
                                <li>
                                    <?php 
                                    $link = $link['link'];
                                    if( $link ): 
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                    <?php endif; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="menu menu--foot">
                            <span class="menu--heading"><?php echo $fourth_menu['heading']; ?></span>
                            <ul>
                                <?php foreach($fourth_menu['links'] as $link){ ?>
                                <li>
                                    <?php 
                                    $link = $link['link'];
                                    if( $link ): 
                                        $link_url = $link['url'];
                                        $link_title = $link['title'];
                                        $link_target = $link['target'] ? $link['target'] : '_self';
                                        ?>
                                        <a class="button" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                                    <?php endif; ?>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gfooter__bottom">
        <div class="container">
            <div class="gfooter__copy">
                <p class="copy">&copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
                <a href="<?php echo $first_link['url']; ?>"><?php echo $first_link['label']; ?></a>
                <a href="<?php echo $second_link['url']; ?>"><?php echo $second_link['label']; ?></a>
                <!--<a href="<?php //echo $last_link['url']; ?>"><?php //echo $last_link['label']; ?></a>-->
				<!-- OneTrust Cookies Settings button start -->
				<button style="font-size:100%;margin: 0 0 0.9rem 1rem !important;height: fit-content;text-underline-offset: .25em;line-height: 1.5;" id="ot-sdk-btn" class="ot-sdk-show-settings">Cookie Settings</button>
				<!-- OneTrust Cookies Settings button end -->

            </div>
            <div class="gfooter__social">
                <?php echo getSocialLinks(); ?>
            </div>
        </div>
    </div>
</footer>

<div class="pdm-lightbox pdm-lightbox--reset">
    <div class="pdm-lightbox__container">
        <button class="pdm-lightbox__close" type="button">Close Popup</button>
        <div class="pdm-lightbox__content"></div>
    </div>
</div>

<?php wp_footer(); ?>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<?php echo get_field('body_scripts_bottom', 'option'); ?>
</body>



</html>