<?php /* Template Name: Flexible Content */ ?>

<?php get_header(); ?>

<?php if( have_posts() ):
	while( have_posts() ): the_post();
		get_template_part('lib/layout/flexible');
	endwhile;
endif; ?>

<?php get_footer(); ?>