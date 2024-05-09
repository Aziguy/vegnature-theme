<?php

class Post_Views_Counter {
    public function __construct() {
        // Add a custom column for post views in WordPress admin
        add_filter('manage_posts_columns', array($this, 'add_post_views_column'));
        add_action('manage_posts_custom_column', array($this, 'display_post_views'), 10, 2);

        // Hook to update post views when the post is viewed
        add_action('wp_head', array($this, 'track_post_views'));
        
        // Remove issues with prefetching adding extra views
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    }

    // Function to get post views count
    public function getPostViews($postID){
        $count_key = 'post_views_count';
        $count = get_post_meta($postID, $count_key, true);

        // If no view count exists, set it to 0
        if ($count === '') {
            $count = 0;
            update_post_meta($postID, $count_key, '0');
        }

        return $count;
    }

    // Function to increase post views count
    public function setPostViews($postID) {
        $count_key = 'post_views_count';
        $cookie_name = 'post_view_' . $postID;
        $value_name = 'viewed_' . $postID;
    
        // Check if a cookie exists with the post ID to prevent duplicate views
        if (!isset($_COOKIE[$cookie_name]) || $_COOKIE[$cookie_name] !== $value_name) {
            // Create or update the cookie to prevent multiple views within 60 seconds
            setcookie($cookie_name, $value_name, time() + + 86400, '/');
    
            // Get the current view count
            $count = $this->getPostViews($postID);
    
            // Increment the count only if the cookie was not set before
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
    
    
    
    
    // Add a custom column for post views in WordPress admin
    public function add_post_views_column($columns) {
        $new_columns = array();

        foreach ($columns as $key => $value) {
            $new_columns[$key] = $value;

            // Add the "Views" column after the "Categories" column
            if ($key === 'categories') {
                $new_columns['post_views'] = 'Views';
            }
        }

        return $new_columns;
    }

    // Display post views count in the custom column
    public function display_post_views($column_name, $post_id) {
        if ($column_name === 'post_views') {
            $count = get_post_meta($post_id, 'post_views_count', true);
            echo $count ? $count : '0';
        }
    }

    // Track post views when the post is viewed
    public function track_post_views($post_id) {
        if (!is_single()) return;
        if (empty($post_id)) $post_id = get_the_ID();

        $this->setPostViews($post_id);
    }
}

// Instantiate the class
//new Post_Views_Counter();