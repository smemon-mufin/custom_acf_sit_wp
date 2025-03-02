<?php
	$classList = array('gheader');

	if($isHome) $classList[] = 'gheader--home';
	elseif ($isBlog) $classList[] ='gheader--blog';
	elseif ($isArchive || $isPTArchive) $classList[] ='gheader--archive';
	elseif (!empty($post_type)) $classList[] = 'gheader--'.$post_type;

    $header = get_field('header', 'option');
    $hd_button = $header['header_dropdown_button'];

    $classList[] = 'sticky';

	$class = buildAttr('class', $classList);

?>

<header <?php echo $class; ?>>
    <div class="gheader-content">
        <div class="container">

            <div class="gheader__logo">
                <a class="site-logo" href="<?php echo home_url(); ?>"><?php echo $site_logo; ?></a>
            </div>

            <nav class="global menu menu--main" aria-label="main navigation">
                <?php
				wp_nav_menu(array(
					'container' => false,
					'items_wrap' => '<ul id="%1$s">%3$s</ul>',
					'walker' => new PDM_Navwalker(),
					'theme_location' => 'main'
				));
			?>

                <div class="gheader__right">
                    <a href="/contact-us/" class="btn btn--blue mob-only">Contact Us</a>
                </div>

                <?php if($hd_button['button_text']): ?>
                <div class="client-dropdown mob-only"> 
                    <button class="btn btn--outline"><span><?php echo $hd_button['button_text']; ?></span></button>
                    <div class="dropdown-content">
                        <?php foreach($hd_button['dropwdown'] as $item): ?>
                        
                        <?php 
                            $link = $item['item'];
                            if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </nav>

            <div class="gheader__right">
                <div class="lightbox-trigger search-icon"><?php echo getSVG('search'); ?></div>
                <div class="lightbox-content">
                    <form role="search" method="get" class="container container--small search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'textdomain' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                        <button type="submit" class="btn btn--blue search-submit"><?php echo _x( 'Search', 'submit button', 'textdomain' ); ?></button>
                    </form>
                </div>
                <a href="/contact-us/" class="btn btn--blue desk-only">Contact Us</a>

                <?php if($hd_button['button_text']): ?>
                <div class="client-dropdown desk-only">
                    <button class="btn btn--outline"><span><?php echo $hd_button['button_text']; ?></span></button>
                    <div class="dropdown-content">
                        <?php foreach($hd_button['dropwdown'] as $item): ?>
                        
                        <?php 
                            $link = $item['item'];
                            if( $link ): 
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <button type="button" class="menu-burger" title="Menu">
                <span class="menu-burger__icon"><span></span></span>
            </button>

        </div>
    </div>
</header>