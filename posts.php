<?php

/**
 * Retrieves posts belonging to a specific category.
 *
 * This function fetches posts from the database based on the provided
 * category slug and limits the number of returned posts (defaults to 10).
 *
 * @param string $category_slug The slug of the category to retrieve posts from.
 * @param int $posts_per_page (optional) The maximum number of posts to return. Defaults to 10.
 * @return WP_Query An instance of the WP_Query class containing the retrieved posts.
 *
 * @throws Exception If the `Timber` class is not available.
 */
function get_category_posts($category_slug, $posts_per_page = 10, $excluded_category_slug = null) {

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  
    $args = [
      'post_type' => 'post',
      'category_name' => $category_slug,
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
      'orderby' => 'date',
      'order' => 'DESC',
    ];
  
    // Add exclusion logic if an excluded category slug is provided
    if ($excluded_category_slug) {
      $args['tax_query'] = [
        [
          'taxonomy' => 'category',
          'field' => 'slug',
          'terms' => [$excluded_category_slug],
          'operator' => 'NOT IN', // Exclude posts in the specified category
        ],
      ];
    }
  
    $query = Timber::get_posts($args);
  
    if (!$query) {
      throw new Exception('Failed to retrieve posts.');
    }
  
    return $query;
}



/**
 * Retrieves posts from all categories except the provided slugs.
 *
 * This function fetches posts using Timber's `get_posts` function, excluding
 * categories specified by their slugs.
 *
 * @param array $excluded_category_slugs (optional) An array of category slugs to exclude.
 *                                      Defaults to an empty array.
 * @param int $posts_per_page (optional) The number of posts to retrieve per page.
 *                                      Defaults to 6.
 * @return Timber\PostCollection|null A Timber Post Collection containing the retrieved posts,
 *                                    or null if there's an error.
 * @throws Exception If there's an error retrieving posts.
 */
function get_all_categories_except($excluded_category_slugs = [], $posts_per_page = 6) {

    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  
    $args = [
      'post_type' => 'post',
      'posts_per_page' => $posts_per_page,
      'paged' => $paged,
      'orderby' => 'date',
      'order' => 'DESC',
      'tax_query' => [
        [
          'taxonomy' => 'category',
          'field' => 'slug',
          'operator' => 'NOT IN',
        ],
      ],
    ];
  
    // Set the excluded category slugs in the tax_query
    $args['tax_query'][0]['terms'] = $excluded_category_slugs;
  
    $query = Timber::get_posts($args);
  
    if (!$query) {
      throw new Exception('Failed to retrieve posts.');
    }
  
    return $query;
}
  


/**
 * Renders a template using Timber.
 *
 * This function utilizes the Timber library to render a template with the
 * provided context data.
 *
 * @param string $template The path to the template file.
 * @param array $context An associative array containing variables to be used in the template.
 * @throws Exception If the `Timber` class is not available.
 */
function render_template($template, $context) {
    if (!class_exists('Timber')) {
        throw new Exception('Timber is not available. Please install and activate the Timber plugin.');
    }

    Timber::render($template, $context);
}