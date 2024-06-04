<?php

require_once get_template_directory() . '/inc/veg-breadcrumbs.php';
require_once get_template_directory() . '/inc/veg-post-views.php';
// Path to post.php file
require_once get_template_directory() . '/posts.php';

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {

	protected $custom_veg_breadcrumbs;   // A property to hold the custom breadcrumb instance
	protected $veg_post_views_counter;  // A property to hold the Post_Views_Counter instance

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );

		// Register menus on init
        add_action('init', array($this, 'register_my_menus'));
		// Initialize the action hook for enqueueing scripts and styles when the theme is constructed
        add_action('wp_enqueue_scripts', array($this, 'enqueue_theme_assets'));

		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', [ $this, 'update_twig_environment_options' ] );

		// Instantiate our VEGNATURE custom breadcrumb class
		$this->custom_veg_breadcrumbs = new VEG_Breadcrumbs();
		// Instantiate ou Post_Views_Counter class
		$this->veg_post_views_counter = new Post_Views_Counter();

		parent::__construct();
	}



	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {

	}


	
	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies() {

	}



	/** Function to register menus */
    public function register_my_menus() {
        register_nav_menus(
            array(
                'main-menu' => __('Main Menu'),
                'social-menu' => __('Social Menu'),
				'footer-menu' => __('Footer Menu')
            )
        );
    }



	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		// Function to generate breadcrumbs
        $breadcrumbs = VEG_Breadcrumbs::veg_generate_breadcrumbs();
		$context['breadcrumbs'] = $breadcrumbs;
		$context['custom_wp_title'] = wp_title('', false);
		$context['logo'] = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
		$context['tagline'] = get_bloginfo('description');
		// Instantiate our view class and add it into the context
    	$context['post_views_counter'] = $this->veg_post_views_counter;
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = Timber::get_menu('main-menu');
		$context['social_menu']  = Timber::get_menu('social-menu');
		$context['footer_menu']  = Timber::get_menu('footer-menu');
		$context['footer_news'] = get_all_categories_except(['evenements', 'stages'], 2);
		$context['site']  = $this;

		return $context;
	}



	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );

		/*
		 * Set the height and width of our logo.
		 *
		 */
		add_theme_support('custom-logo', array(
            'height'      => 83,   // Set the desired height here
            'width'       => 203, // Set the desired width here
            'flex-height' => true,
            'flex-width'  => true,
        ));
	}



	public function enqueue_theme_assets() {
		// Enqueue CSS file
    	wp_enqueue_style('veg-style', get_template_directory_uri() . '/app/dist/app.css', array(), '1.0', 'all');
		wp_enqueue_style('font-awesome', get_template_directory_uri() . '/app/dist/font-awesome.css', array(), '5.13', 'all');
		wp_enqueue_style('veg-responsive', get_template_directory_uri() . '/app/dist/responsive.css', array(), '1.0', 'all');

    	// Enqueue JavaScript file
		wp_enqueue_script('jquery', get_template_directory_uri() . '/app/js/jquery.min.js', '3.6.0', true);
    	wp_enqueue_script('jquery-easing', get_template_directory_uri() . '/app/js/jquery.easing.js', array('jquery'), '1.3', true);
		wp_enqueue_script('waypoints', get_template_directory_uri() . '/app/js/jquery.waypoints.min.js', array('jquery'), '4.0.0', true);
		wp_enqueue_script('countup', get_template_directory_uri() . '/app/js/countup.js', array('jquery'), '1.0.3', true);
		wp_enqueue_script('count-down', get_template_directory_uri() . '/app/js/count-down.js', array('jquery'), '1.0', true);
		wp_enqueue_script('js-popper', get_template_directory_uri() . '/app/js/js-popper.js', array('jquery'), '1.16.1', true);
		wp_enqueue_script('bootstrap', get_template_directory_uri() . '/app/js/bootstrap.min.js', array('jquery'), '4.6.2', true);
		wp_enqueue_script('swiper-bundle-min-js', get_template_directory_uri() . '/app/js/swiper-bundle.min.js', array('jquery'), '6.8.1', true);
		wp_enqueue_script('swiper', get_template_directory_uri() . '/app/js/swiper.js', array('jquery'), '1.0', true);
		wp_enqueue_script('jquery-validate', get_template_directory_uri() . '/app/js/jquery-validate.js', array('jquery'), '1.11.1', true);
		wp_enqueue_script('plugin', get_template_directory_uri() . '/app/js/plugin.js', array('jquery'), '1.3', true);
		wp_enqueue_script('shortcodes', get_template_directory_uri() . '/app/js/shortcodes.js', array('jquery'), '1.3', true);
		wp_enqueue_script('veg-main', get_template_directory_uri() . '/app/js/main.js', array('jquery'), '1.0', true);
		

		// Pass data to our JavaScript file
		wp_localize_script('veg-scripts', 'themeData', array(
			'isHomePage' => is_front_page(), // We check if it's the home page
		));
    	

    	// Enqueue Fonts if need
    	//wp_enqueue_style('veg-fonts', get_template_directory_uri() . '/assets/fonts/fonts.css', array(), '1.0', 'all');

        // Enqueue Images (if needed for inline CSS background images, etc.)
        // Note: We typically don't enqueue images, but this is an example if necessary (You can comment this line if don't need)
        //wp_enqueue_style('veg-images', get_template_directory_uri() . '/assets/img/images.css', array(), '1.0', 'all');
    }



	/**
	 * This would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}



	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

		return $twig;
	}



	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * @param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options( $options ) {
	    // $options['autoescape'] = true;

	    return $options;
	}
}