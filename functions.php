<?php
// Add theme support for featured images
add_theme_support('post-thumbnails');

// Function to enqueue theme stylesheets
function my_custom_theme_styles() {
    // Enqueue Normalize.css
    wp_enqueue_style('normalize-style', get_template_directory_uri() . '/normalize.css');

    // Enqueue the main Stylesheet (style.css)
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_custom_theme_styles');

function custom_add_google_fonts() {
   wp_enqueue_style( 'custom-source-sans-font', 'https://use.typekit.net/fdg4tfd.css', false );
}

function load_scripts() {
    // Existing script loading
    wp_enqueue_script('jquery'); // Loading the WordPress bundled jQuery version.
}
add_action('wp_enqueue_scripts', 'load_scripts');


function get_post_count_excluding_author($excluded_author_id) {
    $args = array(
        'author__not_in' => array($excluded_author_id), // Exclude author ID 3
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1 // Retrieve all posts
    );

    $query = new WP_Query($args);
    return $query->found_posts; // Return the count of posts
}


function remove_p_tags($content) {
    // Removes all <p> tags
    return strip_tags($content, '<p>');
}

function keep_only_p_tags($content) {
    // Keeps only the text within <p> tags
    return preg_replace('/<[^\/>]*>([\s\S]*?)<\//', '', $content);
}

function get_images_from_content($content) {
    preg_match_all('/<img [^>]*src=["|\']([^"|\']+)/i', $content, $matches);
    return $matches[1];
}


add_action('pre_get_posts', function ($query) {
    // Ensure we are modifying the main query and it's a search query
    if ($query->is_main_query() && $query->is_search()) {
        // Check if our custom gallery search parameter is set
        if (isset($_GET['gallery_search']) && $_GET['gallery_search']) {
            // Modify the query parameters as needed
            // For example, if you have a custom post type for gallery items, set it here
            // $query->set('post_type', 'your_custom_post_type');
            
            // If your gallery posts are just regular posts, you might want to limit the search to a specific category or tag
            // Example: $query->set('cat', 'your_gallery_category_id');

            // Note: You don't need to explicitly set the template file here;
            // WordPress will continue to use the template file from which the search was initiated (i.e., your gallery template)
        }
    }
});
