<?php

ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$context = Timber::context();

$queried_object = get_queried_object();
$category_slug = '';

if ($queried_object && property_exists($queried_object, 'slug')) {
    $category_slug = $queried_object->slug;
}

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$context['category_posts'] = Timber::get_posts([
        'post_type' => 'post',
        'posts_per_page' => 6, 
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC',
        'category_name' => $category_slug
]);

Timber::render('posts/category.twig', $context);