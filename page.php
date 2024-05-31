<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

// Function to fetch related posts based on category matching the page slug
function get_related_posts($slug) {
    $args = array(
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'category_name'  => $slug // Fetch posts from category matching the page slug
    );

    return Timber::get_posts($args);
}

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

// Check if the page is "lecologie", "le-bien-etre", "lien-social", "veganisme" or "le-vegetalisme"
if (in_array($timber_post->slug, ['lecologie', 'le-bien-etre', 'le-lien-social', 'le-veganisme', 'le-vegetalisme'])) {
    $context['related_posts'] = get_related_posts($timber_post->slug);
}

Timber::render( array( 'page-' . $timber_post->post_name . '.twig', 'page.twig' ), $context );