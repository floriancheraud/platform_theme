<?php get_header(); ?>

<title>PLATFORM/<?php echo strip_tags(get_the_title()); ?></title>

<?php
// Start the loop.
if ( have_posts() ) : 
while ( have_posts() ) : the_post();
?>

<div id="bar_header">
    <div class="subtitle">
        <a href="https://platform-0.com"><b>PLATFORM</b></a> <b>/</b> <?php the_title(); ?>
    </div>
    <div class="counter">
        <?php echo get_the_date('ymd'); ?>
    </div>
</div>

<div id="post_container">
    <div class="post_content_left">
        <?php the_content(); ?>
    </div>
    <div class="post_content_right">
        <?php the_content(); ?>
    </div>
</div>

<?php
endwhile;
else :
echo '<p>??? error 404 or something</p>';
endif;
?>
