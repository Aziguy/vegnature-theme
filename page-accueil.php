<?php

require_once('posts.php');

$context = Timber::context();



// Get the Home page
$args = array(
    'post_type' => 'page',
    'pagename' => 'accueil' // Slug of our Home page
);

$home_page = Timber::get_posts($args);

// Pass the Home page data to the context
$context['home_page'] = $home_page[0];

$context['events'] = get_category_posts('evenements', 3);

$context['news'] = get_all_categories_except(['evenements', 'stages'], 6);

// Render the Twig template
Timber::render('views/pages/home.twig', $context);







//render_template('views/pages/home.twig', $context);