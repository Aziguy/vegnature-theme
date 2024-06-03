<?php
/**
 * Enqueue Dashicons for the frontend
 *
 * This function loads the dashicons stylesheet, making them available
 * for use on the frontend of our WordPress website.
 *
 * @since 1.0.0
 */
function ww_load_dashicons() {
    // Enqueue Dashicons stylesheet
    wp_enqueue_style('dashicons');
  }
  
  // Hook the function to 'wp_enqueue_scripts' action at a late priority (999)
  add_action('wp_enqueue_scripts', 'ww_load_dashicons', 999);



/**
 * Converts a string representation of a date to a formatted date string.
 *
 * This function takes a string representing a date, an optional format, and an
 * optional mode to control the output format.
 *
 * Modes:
 *  - 'day': Returns only the day of the month (e.g., 02).
 *  - 'month_year': Returns the month name and year (e.g., June 2024).
 *  - (default) Any other value will format the entire date based on the provided format.
 *
 * @param string $string The string representation of the date to convert.
 * @param string $format (optional) The desired format for the output date string when not using a mode.
 *   Defaults to 'd M Y' (day month year).
 * @param string $mode (optional) Controls the output format. Defaults to the full date.
 * @return string The formatted date string, or an empty string if conversion fails.
 *
 * @throws Exception If the provided string cannot be parsed as a valid date.
 */
function veg_string_to_date($string, $format = 'd M Y', $mode = '') {
    try {
      // Check if the string is in the format YYYYMMDD
      if (preg_match('/^\d{8}$/', $string)) {
        // Create a DateTime object using the specific format 'Ymd'
        $date = DateTime::createFromFormat('Ymd', $string);
      } else {
        // Set the locale to French (or any other appropriate locale)
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); // Adjust locale as needed
  
        // Use IntlDateFormatter for non-YYYYMMDD formats
        $formatter = new IntlDateFormatter(
            'fr_FR', // Locale
            IntlDateFormatter::FULL, // Date type
            IntlDateFormatter::NONE, // Time type
            'UTC', // Time zone
            IntlDateFormatter::GREGORIAN, // Calendar type
            'd MMMM yyyy' // Pattern that matches the input string format (adjust if needed)
        );
  
        $timestamp = $formatter->parse($string);
        if ($timestamp === false) {
            return 'Error: Invalid date format';
        }
  
        // Create a DateTime object from the parsed timestamp
        $date = (new DateTime())->setTimestamp($timestamp);
      }
  
      // Format the DateTime object based on the mode
      switch ($mode) {
        case 'day':
          $format = 'd';
          break;
        case 'month_year':
          $format = 'M Y';
          break;
      }
  
      return $date->format($format);
    } catch (Exception $e) {
      // Handle potential parsing exceptions gracefully (e.g., log the error)
      return '';  // Or return a default value like an empty string
    }
  }
  
  /**
   * Registers the `string_to_date` filter with the Timber Twig environment.
   *
   * This function adds the custom filter to the Twig environment used by Timber.
   *
   * @param Twig_Environment $twig The Twig environment instance used by Timber.
   * @return Twig_Environment The modified Twig environment with the filter registered.
   */
  add_filter('timber/twig', function($twig) {
    $twig->addFilter(new Twig\TwigFilter('string_to_date', 'veg_string_to_date'));
    return $twig;
  });
  
  


/**
 * Formats a given number as a currency with the specified currency symbol.
 * Differentiates formatting based on the currency code provided.
 *
 * @param float $number   The number to be formatted as currency.
 * @param string $currency   The currency symbol or code.
 * @return string   The formatted currency string.
 */
function custom_currency_filter($number, $currency) {
    // Check if the currency is EUR (Euro)
    if ($currency === 'EUR') {
        // Format for EUR currency (French style)
        $formatted_number = number_format($number, 2, ',', ' ') . ' ' . $currency;
    } else {
        // For other currencies, format in English style
        $formatted_number = number_format($number, 2) . ' ' . $currency;
    }
    
    return $formatted_number;
}


/**
 * Registers the custom currency filter with Timber's Twig environment.
 *
 * @param object $twig   The Twig instance to which the filter is being added.
 * @return object   The modified Twig instance.
 */
add_filter('timber/twig', function($twig) {
    // Add the custom currency filter to Twig
    $twig->addFilter(new Twig\TwigFilter('custom_currency', 'custom_currency_filter'));
    return $twig;
});


/**
 * Custom Twig filter to shuffle an array.
 *
 * @param array $array The input array to be shuffled.
 * @return array The shuffled array.
 */
function custom_shuffle_filter($array) {
    // Check if the input is an array
    if (is_array($array)) {
        // Shuffle the array
        shuffle($array);
    }
    return $array;
}

// Register the custom Twig filter
add_filter('timber/twig', function ($twig) {
    // Add the 'shuffle' filter to Twig environment
    $twig->addFilter(new Twig\TwigFilter('shuffle', 'custom_shuffle_filter'));
    return $twig;
});



/**
 * Retrieves intro Customizer values including title, subtitle, text, images.
 * Defaults to predefined values if not set in the Customizer.
 *
 * @return array An associative array containing section Customizer values.
 */
function veg_get_intro_customizer_values() {
    $section_values = array(
        'veg_intro_title'    => get_theme_mod( 'veg_set_intro_title', 'Default Intro. Title' ),
        'veg_intro_subtitle' => get_theme_mod( 'veg_set_intro_subtitle', 'Default Intro. Subtitle' ),
        'veg_intro_text'     => get_theme_mod( 'veg_set_intro_textarea', 'Default Intro. Text' ),
        'veg_intro_image_1'  => wp_get_attachment_url( get_theme_mod( 'veg_set_intro_image_1' ) ),
        'veg_intro_image_2'  => wp_get_attachment_url( get_theme_mod( 'veg_set_intro_image_2' ) ),
    );

    return $section_values;
}



/**
 * Retrieves stats Customizer values including title, subtitle, text, image, and stats numbers.
 * Defaults to predefined values if not set in the Customizer.
 *
 * @return array An associative array containing section Customizer values.
 */
function veg_get_stats_customizer_values() {
    $section_values = array(
        'veg_stats_title'        => get_theme_mod( 'veg_set_stats_title', 'Default Stats Title' ),
        'veg_stats_subtitle'     => get_theme_mod( 'veg_set_stats_subtitle', 'Default Stats Subtitle' ),
        'veg_stats_text'         => get_theme_mod( 'veg_set_stats_textarea', 'Default Stats Text' ),
        'veg_stats_image'        => wp_get_attachment_url( get_theme_mod( 'veg_set_stats_image' ) ),
        'veg_stats_sympathizers' => get_theme_mod( 'veg_set_stats_sympathizers', 0 ),
        'veg_stats_maps'         => get_theme_mod( 'veg_set_stats_maps', 0 ),
        'veg_stats_actions'      => get_theme_mod( 'veg_set_stats_actions', 0 ),
    );

    return $section_values;
}



/**
 * Registers the 'veg_get_intro_customizer_values' and 'veg_get_stats_customizer_values' Twig filters
 * to fetch section Customizer settings in Twig templates.
 *
 * @param object $twig The Twig object to which the filters are added.
 * @return object The modified Twig object.
 */
add_filter( 'timber/twig', function ( $twig ) {
    // Add a Twig filter to get intro Customizer values in Twig templates
    $twig->addFilter( new Twig\TwigFilter( 'veg_get_intro_customizer_values', 'veg_get_intro_customizer_values' ) );

    // Add a Twig filter to get stats Customizer values in Twig templates
    $twig->addFilter( new Twig\TwigFilter( 'veg_get_stats_customizer_values', 'veg_get_stats_customizer_values' ) );

    return $twig;
} );



/**
 * Function to calculate the difference in days between two dates.
 *
 * @param string $startDate The start date in "dd/mm/yyyy" format.
 * @param string $endDate The end date in "dd/mm/yyyy" format.
 * @return int|null The difference in days or null if invalid dates.
 */
function calculate_days_between_dates($startDate, $endDate) {
    // Convert the dates from "dd/mm/yyyy" to "yyyy-mm-dd" format for DateTime
    $startDateTime = DateTime::createFromFormat('d/m/Y', $startDate);
    $endDateTime = DateTime::createFromFormat('d/m/Y', $endDate);

    // Check if the dates are valid DateTime objects
    if (!$startDateTime || !$endDateTime) {
        // Return null if dates are invalid
        return null;
    }

    // Adjust the end date by adding 1 day to include the end date
    $endDateTime->modify('+1 day');

    // Calculate the difference between dates
    $interval = $startDateTime->diff($endDateTime);

    // Return the difference in days
    return $interval->days;
}

// Register the custom filter
add_filter('timber/twig', function ($twig) {
    // Add the 'calculate_days' filter to Twig environment
    $twig->addFilter(new Twig\TwigFilter('calculate_days', 'calculate_days_between_dates'));
    return $twig;
});



/**
 * Custom Twig filter to count words in a string.
 *
 * @param string $content The input content to count words from.
 * @return int The number of words in the content.
 */
function word_count_filter($content) {
    // Strip HTML tags and extra whitespaces
    $clean_content = strip_tags($content);
    $clean_content = trim(preg_replace('/\s+/', ' ', $clean_content));

    // Count words
    $word_count = str_word_count($clean_content);
    return $word_count;
}

// Register the custom filter
add_filter('timber/twig', function($twig){
    // Add the word_count_filter to Twig environment
    $twig->addFilter(new Twig\TwigFilter('word_count', 'word_count_filter'));
    return $twig;
});




/**
 * Checks the dimensions of an uploaded image before it is handled.
 * Ensures the image dimensions match the specified requirements for a 'post' type.
 *
 * @param array $file   An array containing information about the uploaded file.
 * @return array   The modified file array or an error if dimensions are incorrect.
 */
function veg_image_upload_check($file) {
    // Get the post ID from the request or set it to 0 if not present
    $post_id = isset($_REQUEST['post_id']) ? $_REQUEST['post_id'] : 0;

    // Get the post type based on the retrieved post ID
    $post_type = get_post_type($post_id);
    
    // Set the desired width and height for the image
    $required_width = 800; // Our desired width
    $required_height = 476; // Our desired height

    // Check if the uploaded file is an image and the post type is 'post'
    if (substr($file['type'], 0, 5) === 'image' && $post_type === 'post') {
        // Get the dimensions of the uploaded image
        $image_data = getimagesize($file['tmp_name']);
        $image_width = $image_data[0];
        $image_height = $image_data[1];

        // Check if the dimensions don't match the required width and height
        if ($image_width !== $required_width || $image_height !== $required_height) {
            // Set an error message for incorrect dimensions
            $file['error'] = 'The uploaded image should have dimensions ' . $required_width . 'x' . $required_height;
            
            // Remove the uploaded file if dimensions are incorrect
            @unlink($file['tmp_name']);
        }
    }

    return $file;
}

// Add the filter to check the dimensions before the upload
//add_filter('wp_handle_upload_prefilter', 'veg_image_upload_check', 10, 1);