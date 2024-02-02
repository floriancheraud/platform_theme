<?php
/*
Template Name: Gallery
*/
?>

<?php get_header(); ?>
<title>PLATFORM</title>

<div id="bar_header">
    <div class="title">
        <a href="https://platform-0.com"><b>PLATFORM</b></a><span id="sequence"></span>
    </div>
	<?php
	// Fetch a random post
	$args = array(
		'post_type' => 'post', // Adjust if you have custom post types
		'posts_per_page' => 1,
		'orderby' => 'rand'
	);
	$query_random_post = new WP_Query($args);

	if ($query_random_post->have_posts()) {
		$query_random_post->the_post();
		$random_post_url = get_permalink();
		wp_reset_postdata(); // Always reset post data after a custom query
	} else {
		$random_post_url = ''; // Fallback URL, can be home or any other page
	}
	?>

	<div class="switch" data-random-post-url="<?php echo esc_url($random_post_url); ?>">
		<?php echo date("ymd"); ?>
	</div>
</div>

<div id="gallery">
<div id="images-grid">
    <?php
    // Initialize image count
    $total_images_count = 0;

    // Existing code for retrieving posts
    $search_term = get_query_var('s');
    $query_args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'date',
    );
    if (!empty($search_term)) {
        $query_args['s'] = $search_term;
    }
    $query_all_posts = new WP_Query($query_args);

    // Loop through posts
    if ($query_all_posts->have_posts()) :
        while ($query_all_posts->have_posts()) : $query_all_posts->the_post();
            $post_content = get_the_content();
            $post_images = get_images_from_content($post_content);

            if ($post_images) :
                foreach ($post_images as $image) :
                    // Increment the image count
                    $total_images_count++;
                    ?>
                    <div class="grid-item">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo $image; ?>" alt="" loading="lazy">
                        </a>
                    </div>
                <?php endforeach;
            endif;

        endwhile;
        wp_reset_postdata();
    else :
        echo 'No images found';
    endif;
    ?>
</div>
</div>

<div id="bar_footer">
    <div class="subtitle_footer">
        <a id="search-button"></a> <!-- delete search function in gallery for now 240202-->
        <form id="search-form" action="<?php echo home_url('/gallery/'); ?>" method="get">
    		<input type="hidden" name="gallery_search" value="1">
            <input type="text" name="s" placeholder="Type and press enter to search...">
        </form>
    </div>
    <div class="counter_header">
		<?php echo $total_images_count; ?>
	</div>
</div>

<script>
jQuery(document).ready(function ($) {
    $('#search-button').click(function () {
        toggleSearchForm();
    });

    // Function to toggle the search form visibility
    function toggleSearchForm() {
        $('#search-form').toggle();
        $('#title-text').toggle();
        $('#search-button').toggleClass('active');
        
        $('#bar_footer').toggleClass('active');
        $('#total-posts').toggleClass('active');
        $('#displayed-posts').toggleClass('active');

        // Focus on the search input field when active
        if ($('#search-button').hasClass('active')) {
            $('#search-form input[name="s"]').focus();
        }
    }

    // Check if there is a search query and keep the form visible if there is
    var currentSearchQuery = "<?php echo get_search_query(); ?>";
    if (currentSearchQuery) {
        toggleSearchForm();
        $('#search-form input[name="s"]').val(currentSearchQuery);
    }
});
</script>


<script>
    var txt = [
    ' is edited by <a href="http://www.floriancheraud.com" target="_blank">Florian Cheraud</a> and Rémi Désir.',
    ' ', 
    ' ',
    ' ',
    ' ',
    ' imposes a horizontal dispatching of things.', 
    ' brings togethers elements of different natures.', 
    ' is an island in internet archipelago.', 
    ' is a place of dialogue.', 
    ' is a sedimentation of thoughts.', 
    ' is a place to construct a body of knowledge.', 
    ' is an observatory of our time.', 
    ' reassembles pieces of an endless puzzle.'
    ];
    
    txt.sort(function() { return 0.5 - Math.random() });

    textSequence(0);
    function textSequence(i) {

        if (txt.length > i) {
            setTimeout(function() {
                document.getElementById("sequence").innerHTML = txt[i];
                textSequence(++i);
            }, 4500);

        } else if (txt.length == i) { // Loop
            textSequence(0);
        }

    }
</script>

<script>
	jQuery(document).ready(function ($) {
    // Click event for the date div
    $('.switch').click(function () {
        var randomPostUrl = $(this).data('random-post-url');
        if (randomPostUrl) {
            window.location.href = randomPostUrl; // Redirect to the random post
        }
    });
});
</script>
