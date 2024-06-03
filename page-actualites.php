<?php

require_once('posts.php');

$context = Timber::context();
  
$context['news'] = get_all_categories_except(['evenements', 'stages'], 6);


render_template('views/pages/actualites.twig', $context);
?>