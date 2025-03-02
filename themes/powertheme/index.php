<?php get_header(); ?>

<section class="blog-content">
    <div class="container">

        <div class="blog-posts loadmore-container">

            <?php if( have_posts() ):
				while( have_posts() ): the_post();
					get_template_part('lib/parts/post-card');
				endwhile;
				else : ?>
            <h2>No Posts Found</h2>
            <?php endif; ?>
        </div>

        <?php wp_pagenavi();  ?>
    </div>
</section>

<?php get_template_part('lib/layout/flexible'); ?>
<?php get_footer(); ?>