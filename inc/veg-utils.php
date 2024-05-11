<?php


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
function atgc_image_upload_check($file) {
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
add_filter('wp_handle_upload_prefilter', 'atgc_image_upload_check', 10, 1);




/**
 * Fetches metadata for a given DOI using the CrossRef Metadata Fetcher service.
 *
 * @param string $doi The Digital Object Identifier (DOI) for which to fetch metadata.
 * @return array|null The fetched metadata as an array, or null if fetching failed.
 */
function fetch_metadata_for_doi_filter($doi) {

    /**
     * Instantiates a CrossRefMetadataFetcher object to interact with the CrossRef service.
     *
     * @var CrossRefMetadataFetcher $fetcher
     */
    $fetcher = new CrossRefMetadataFetcher();

    /**
     * We calls the fetchMetadataForDOI method on the CrossRefMetadataFetcher object to retrieve metadata.
     *
     * @return array|null The fetched metadata or null if retrieval failed.
     */
    return $fetcher->fetchMetadataForDOI($doi);
}

add_filter('timber/twig', function($twig){
    // Register the fetch_metadata_for_doi filter function
    $twig->addFilter(new Twig\TwigFilter('fetch_metadata_for_doi', 'fetch_metadata_for_doi_filter'));
    return $twig;
});




/**
 * Populates the choices for the "Service" field (field_65eef792d3c22) with service names and submission options cooming from Waves API.
 *
 * @param array $field The field configuration array.
 * @return array The modified field configuration array.
 */
function populate_service_field_choices($field) {

    // We check if we're working with the "Service" field: | If not, we return the original field configuration
    if ($field['key'] !== 'field_65eef792d3c22') {
        return $field;
    }

    // We set the Waves API URL
    $api_url = get_option('atgc_options_waves_api_url', 'http://195.220.237.118/api/services');

    // Retrieve data from the API
    $response = wp_remote_get($api_url);

    // We initialize choices with a default option
    $choices = array('' => 'Select a service');

    // Handle API response
    if (is_wp_error($response)) {
        // we log error if API request fails
        error_log('Failed to fetch options: ' . $response->get_error_message());
        $choices['error'] = 'Failed to fetch options';
    } else {
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code === 200) {
            $body = wp_remote_retrieve_body($response);
            $data = json_decode($body, true);

            // We loop through each service
            foreach ($data as $service) {
                $service_name = $service['name'];

                // We add submission options for each service
                if (isset($service['submissions']) && is_array($service['submissions'])) {
                    foreach ($service['submissions'] as $submission) {
                        $submission_app_name = $submission['submission_app_name'];
                        $submission_option_value = $submission['url'];
                        $submission_option_label = $service_name . ' (' . $submission_app_name . ')';
                        // We add the submission option to choices
                        $choices[$submission_option_value] = $submission_option_label;
                    }
                }
            }
        } else {
            // We log error if API response code is not 200
            error_log('Failed to fetch options. API response code: ' . $response_code);
            $choices['error'] = 'Failed to fetch options';
        }
    }

    // Assign choices to the field
    $field['choices'] = $choices;

    return $field;
}

add_filter('acf/load_field/key=field_65eef792d3c22', 'populate_service_field_choices');




/**
 * Adds a custom Twig filter named 'get_api_content' to retrieve content from our Waves API URL.
 *
 * @param Twig_Environment $twig The Twig environment instance.
 * @return Twig_Environment The modified Twig environment with the added filter.
 */
add_filter('timber/twig', function ($twig) {

    $twig->addFilter(new Twig\TwigFilter('get_api_content', function($service_name) {

        // We construct the API URL for fetching the form
        $api_url = $service_name . '/form';

        /**
         * Fetches content from the specified API URL using wp_remote_get.
         *
         * @param string $api_url The API URL to fetch content from.
         * @return string|WP_Error The fetched content or a WP_Error object on failure.
         */
        $response = wp_remote_get($api_url);

        // We check for errors and retrieve content if successful
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            return wp_remote_retrieve_body($response);
        } else {
            // Return an error message if API request fails
            return 'Failed to fetch API content';
        }
    }));

    return $twig;
});




/**
 * Extracts the desired path segment after "/services/" from a given URL.
 *
 * This function parses the provided URL using `parse_url` and attempts to extract
 * the path segment following the "/services/" string.
 *
 * @param string $url The URL to extract the path segment from.
 *
 * @return string|null The desired path segment after "/services/" or an error message
 *                     indicating an invalid URL, missing path component, or the "/services/"
 *                     part not being found. Returns null if the URL is empty.
 */
function extractDesiredPath($url) {

    if (empty($url)) {
        return null;
    }

    $parsed_url = parse_url($url);

    // We return `null` if parsing failed or path is missing
    if (!$parsed_url || !isset($parsed_url['path'])) {
        return null;
    }

    $desired_part = strstr($parsed_url['path'], '/services/');
    return $desired_part === false ? null : substr($desired_part, strlen('/services/'));
}

// We register the filter
add_filter('timber/twig', function ($twig) {
    $twig->addFilter(new Twig\TwigFilter('filterExtractDesiredPath', 'extractDesiredPath'));
    return $twig;
});




/**
 * Removes a specified prefix from the beginning of a string.
 *
 * @param string $string The string to remove the prefix from.
 * @param string $prefix The prefix to remove.
 *
 * @return string The string without the prefix, or the original string if the prefix wasn't found.
 */
function remove_prefix($string, $prefix = "waves-job-id-") {
    
    $prefixLength = strlen($prefix);
  
    if (strncmp($string, $prefix, $prefixLength) === 0) {
      return substr($string, $prefixLength);
    }
  
    // No prefix match, we return the original string as-is
    return $string;
  }
  

// We register the filter
add_filter('timber/twig', function ($twig) {
    $twig->addFilter(new Twig\TwigFilter('remove_prefix', 'remove_prefix'));
    return $twig;
});