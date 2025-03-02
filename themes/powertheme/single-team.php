<?php 
get_header(); 
$imgid = get_field('image');
$role = get_field('role');
$phone = get_field('phone');
$email = get_field('email');
$linkedin = get_field('linkedin');
?>

<section class="page-content">
    <div class="container container--medium">
       
        <?php if( have_posts() ): ?>
           <?php while( have_posts() ): the_post(); ?>

                <div class="single-team-fifty">
                    <div class="single-team-fifty-col">
                        <h4 class="team-card__title"><?php the_title(); ?></h4>
                        <span class="single-team-role"><?php echo $role; ?></span>
                        <div class="single-team-thumb">
                            <?php echo getIMG($imgid); ?>
                        </div>
                        <?php if($phone): ?>
                            <div class="bioinfo"><?php echo getSVG('phone'); ?> Call: <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                        <?php endif; ?>
                        <?php if($email): ?>
                            <div class="bioinfo"><?php echo getSVG('email'); ?> Message: <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                        <?php endif; ?>
                        <?php if($linkedin): ?>
                            <div class="bioinfo"><?php echo getSVG('linkedin'); ?> Follow on: <a target="_blank" href="<?php echo  $linkedin; ?>">LinkedIn</a></div>
                        <?php endif; ?>
                    </div>

                    <div class="single-team-fifty-col">
                        <?php the_content(); ?>
                    </div>
                </div>

               
               
                
            <?php endwhile; ?>
        <?php endif; ?>
         
    </div>
</section>

<?php get_footer(); ?>