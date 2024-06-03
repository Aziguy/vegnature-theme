<?php

require_once('posts.php');

$context = Timber::context();
$context['events'] = get_category_posts('evenements', 6);


render_template('views/pages/evenements.twig', $context);
?>