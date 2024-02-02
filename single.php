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
		<span class="date-clickable" data-author="<?php echo esc_attr(get_the_author()); ?>" data-date="<?php echo get_the_date('ymd'); ?>">
			<?php echo get_the_date('ymd'); ?>
		</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dateElement = document.querySelector('.date-clickable');
    if (dateElement) {
        dateElement.addEventListener('click', function() {
            // Store both the date and author name for toggling
            var currentDate = this.getAttribute('data-date'); // Assumes the original date is stored in a data attribute
            var authorName = this.getAttribute('data-author');
            // Check what's currently displayed and toggle accordingly
            if (this.textContent === currentDate) {
                this.textContent = authorName; // Show author if the date is currently displayed
            } else {
                this.textContent = currentDate; // Show date if the author is currently displayed
            }
        });
    }
});
</script>
