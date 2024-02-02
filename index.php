<?php get_header(); ?>
<title>PLATFORM</title>

<div id="bar_header">
    <div class="title">
        <a href="https://platform-0.com/gallery/"><b>PLATFORM</b></a><span id="sequence"></span>
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


<div id="loop">
    <?php
    // Check if there is a search query
    $search_query = get_search_query();
    $args = array();

    if (!empty($search_query)) {
        $args['s'] = $search_query; // Add search query to arguments
    }

    // The Query
    $query = new WP_Query($args);

    // The Loop
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <div class="loop_single_post_title"><a class="loop_single_post_link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
        <?php endwhile;
        // Restore original Post Data
        wp_reset_postdata();
    else :
        // Display all posts if no search query
        $args_all_posts = array(
            'post_type' => 'post', // You can specify the post type you want to display
            'posts_per_page' => -1, // -1 to show all posts
        );

        $query_all_posts = new WP_Query($args_all_posts);

        if ($query_all_posts->have_posts()) :
            while ($query_all_posts->have_posts()) : $query_all_posts->the_post(); ?>
                <div class="loop_single_post_title"><a class="loop_single_post_link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <?php endwhile;
            // Restore original Post Data
            wp_reset_postdata();
        else :
            // Display a message if no posts found
            echo 'No posts found';
        endif;
    endif;
    ?>
</div>

<div id="bar_footer">
    <div class="subtitle_footer">
        <a id="search-button">Search</a>
        <form id="search-form" action="<?php echo home_url('/'); ?>" method="get">
            <input type="text" name="s" placeholder="Type and press enter to search...">
        </form>
    </div>
    <div class="counter_header">
        <?php
        // Check if there is a search query
        $search_query = get_search_query();
        $args = array();

        if (!empty($search_query)) {
            $args['s'] = $search_query; // Add search query to arguments
        }

        // The Query
        $query = new WP_Query($args);

        // Get the total number of posts
        $total_posts = wp_count_posts()->publish;

        if ($query->have_posts()) :
            $displayed_posts = $query->found_posts;
            echo "<span id='displayed-posts' class='displayed-posts'>$displayed_posts/</span><span id='total-posts' class='total-posts'>$total_posts</span>";
        else :
            // If no search query, display all posts
            $displayed_posts = $total_posts;
            echo "<span id='displayed-posts' class='displayed-posts'>$displayed_posts/</span><span id='total-posts' class='total-posts'>$total_posts</span>";
        endif;
        ?>
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
