<?php

/**
 * Function to edit the default WordPress link from the admin login page.
 *
 * @return string The URL of the home page.
 */
function abro_login_logo_url() {
    return home_url();
}

add_filter( 'login_headerurl', 'abro_login_logo_url' );




/**
 * Function to edit the title of the link behind the logo in the admin login form.
 *
 * @return string The blog name retrieved using `get_bloginfo()`.
 */
function abro_login_logo_url_title() {
    return get_bloginfo('name');
}

add_filter( 'login_headertext', 'abro_login_logo_url_title' );




/**
 * Function to load the necessary stylesheet for customizing the admin login page.
 *
 * @return void
 */
function admin_styles() {
    wp_enqueue_style('loginCSS', get_template_directory_uri() . '/login/css/loginStyles.css', array(), NULL);
}
  
add_action('login_enqueue_scripts', 'admin_styles', 10);