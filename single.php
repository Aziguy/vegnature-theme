<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;


if ( ! post_password_required( $timber_post->ID ) ) {
    $categories = $timber_post->terms('category');
    if ($categories) {
        $recent_posts_args = array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post__not_in'   => array($timber_post->ID),
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => wp_list_pluck($categories, 'term_id'),
                ),
            ),
        );
        $context['recent_posts'] = Timber::get_posts($recent_posts_args);
    } else {
        $context['recent_posts'] = array();
    }

    Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
} else {
    Timber::render( 'single-password.twig', $context );
}