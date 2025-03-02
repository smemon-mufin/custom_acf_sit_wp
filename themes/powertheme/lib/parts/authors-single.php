

<?php 
    $author = $args['author'];

    if($author): ?>
    <?php if ( ! is_singular( 'resource_videos' ) ) { ?>
        <div class="authors">
            <div class="author">
                <div class="author__bio">
                    <div class="author__thumb">
                        <div class="positioner">
                            <?php echo getIMG(get_field('image',$author->ID)); ?>
                        </div>
                    </div>
                    <div class="autho__info">
                        <span class="name"><strong><?php echo $author->post_title; ?></strong></span>
                        <span class="title"><?php echo get_field('role',$author->ID)  ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php endif; ?>
