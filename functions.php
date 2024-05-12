<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 */

// Customize login
require_once get_template_directory() . '/inc/veg-custom-login.php';
// Path to our VegOptionsSettings class
require_once get_template_directory() . '/inc/veg-admin-options.php';
// Path to our utils class or functions..
require_once get_template_directory() . '/inc/veg-utils.php';
// Path to our customizer function
require_once get_template_directory() . '/inc/veg-customizer.php';
// Path to our shortcode class
require_once get_template_directory() . '/inc/veg-member-shortcode.php';

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/StarterSite.php';

Timber\Timber::init();

// Sets the directories (inside your theme) to find .twig files.
Timber::$dirname = [ 'templates', 'views' ];

new StarterSite();