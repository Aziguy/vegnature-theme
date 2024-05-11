<?php

$context = Timber::context();



// Get the Home page
$args = array(
    'post_type' => 'page',
    'pagename' => 'accueil' // Slug of our Home page
);

$home_page = Timber::get_posts($args);

// Pass the Home page data to the context
$context['home_page'] = $home_page[0];



// Render the Twig template
Timber::render('views/pages/contact.twig', $context);