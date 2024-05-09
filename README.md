# VEGNATURE WORDPRESS THEME USING TIMBER 2.x

[![Build Status](https://travis-ci.com/timber/starter-theme.svg?branch=master)](https://travis-ci.com/github/timber/starter-theme)
[![Packagist Version](https://img.shields.io/packagist/v/upstatement/timber-starter-theme?include_prereleases)](https://packagist.org/packages/upstatement/timber-starter-theme)

## About Timber

Timber is a powerful framework for WordPress that empowers you to craft beautiful and maintainable themes using the Twig template engine. Instead of wrestling with traditional PHP templates, Timber lets you leverage Twig's concise syntax, resulting in cleaner, more readable HTML code.

At the heart of Timber lies the separation of concerns principle. This means your theme's logic (written in PHP) is neatly separated from its presentation (rendered in Twig templates). This separation offers a multitude of benefits:

- Enhanced Maintainability: Code becomes easier to understand, modify, and debug due to its clear organization.
- Improved Testability: Separated logic allows for more efficient unit testing, ensuring the reliability of your theme's functionality.
- Encourages Design Patterns: Timber promotes the adoption of established design patterns like MVC (Model-View-Controller), fostering better code organization and reusability.

## Why we've choose Timber?

Our decision to embrace Timber was driven by several key advantages:

1. **Clean and Readable Templates::** Twig's syntax is designed for clarity and conciseness, making your templates significantly easier to understand and maintain compared to traditional PHP.

2. **Separation of Concerns::** Timber enforces a clear separation of logic and presentation, leading to a more organized and maintainable codebase.

3. **Reusable Components::** Timber empowers you to create reusable template partials (headers, footers, sidebars) and components. This approach minimizes code duplication and fosters consistency throughout your theme.

4. **Streamlined Development Experience::** Timber offers valuable features like template inheritance, template contexts, and automatic escaping. These features streamline the development process and help avoid common pitfalls.

5. **Leveraging the Twig Ecosystem::** As a widely used template engine, Twig boasts a rich ecosystem of extensions, filters, and functions. By using Timber, we gain access to these tools, further enhancing our theme development workflow.

In essence, Timber empowers us to craft beautiful, well-structured, and maintainable WordPress themes with greater efficiency.

## Installation

Follow these steps to install the VEGNATURE WordPress theme:

1. **Download Theme Files:**

   - Obtain the latest version of the Vegnature theme files from [Github](https://github.com/Aziguy/vegnature-theme).

2. **Extract Theme Files:**

   - Unzip the downloaded file to access the theme files.
   - If you're using a local development environment, navigate to the directory where the downloaded ZIP file is located.
   - Right-click on the ZIP file and select "Extract Here" or use your preferred unzip utility to extract the files.
   - Once the files are extracted, you'll find a folder containing the theme files.

   If you're working on a remote server and have SSH access, you can transfer the theme files using the `scp` command. Here's an example of how to do it:

   ```bash
   scp /path/to/your/theme.zip username@your-server-ip:/path/to/wordpress/wp-content/themes/

   ```

Replace /path/to/your/theme.zip with the path to the downloaded ZIP file on your local machine, username with your SSH username, your-server-ip with the IP address of your server, and /path/to/wordpress/wp-content/themes/ with the path to the themes directory on your WordPress server.

After executing the scp command, you'll be prompted to enter your SSH password. Once the transfer is complete, SSH into your server and navigate to the wp-content/themes/ directory to confirm that the theme files have been successfully transferred.

3. **Upload to WordPress:**

   - Log in to your WordPress admin panel.
   - Navigate to `Appearance » Themes`.
   - Click on the `Add New` button at the top of the page.
   - Select the `Upload Theme` option.
   - Choose the ZIP file you downloaded earlier, then click `Install Now`.

4. **Activate Theme:**

   - Once the theme has been successfully uploaded and installed, click the `Activate` button to make it the active theme for your WordPress site.

5. **Install Required Plugins:**

   After activating the theme, you'll need to install and activate the following plugins to ensure full compatibility and functionality:

   - **Breaking News Plugin:** Provides a ticker-style display for important announcements or updates.
   - **Advanced Custom Fields Pro:** Enhances the theme's flexibility by allowing you to add custom fields to posts, pages, and custom post types.
   - **ACF Extended:** Extends the functionality of Advanced Custom Fields with additional features and options.
   - **Map Block Leaflet:** Adds a customizable map block to your site using the Leaflet JavaScript library.

6. **Set Up Theme Options:**

   - Customize the appearance of the theme to suit your preferences using the WordPress Customizer. Access the Customizer by navigating to `Appearance » Customize` in your WordPress admin panel. From there, you'll be able to adjust various settings such as:

     - Image Banner: Upload or select an image to be displayed as the banner on your site.
     - Title: Set the title of your website.
     - Subtitle: Add a subtitle to complement the title.
     - And so on..

   - Additionally, you can configure specific options for the theme via the theme's options panel. Follow these steps to access and fill out the theme's options:

     - Navigate to `{your-domain}/wp-admin/options-general.php?page=vegnature-options-settings` in your WordPress admin panel.
     - Fill in the following fields:
       - **Transient Expiration Time**: This field allows you to specify the expiration time (in seconds) for data retrieved from the DOI API. Adjust this value according to your caching needs.
       - **Waves API URL**: Enter the base URL of the Waves API. In our theme, the default URL should be `{wave-domain}/api/services`. Modify this URL if your API endpoint differs.
       - **Waves Token**: Provide your Waves token in this field. This token is necessary for accessing Yave services within the theme.

These settings allow you to customize various aspects of the theme's functionality and integrate external services seamlessly.

7. **Import Demo Content (Optional):**
   - If you want to replicate the demo content shown in the theme's preview, you can import the provided demo content. From the theme repository, locate the `local.sql` file, which contains the necessary data to populate your site with sample content. Exercise caution when importing this file, as it may overwrite existing content in your WordPress database.

## What's here?

- `vegnature-theme/` contains all of the PHP and other files needed by WordPress. When using the ATGC Theme as a parent theme, you need to include the theme directory in your child theme’s `style.css` docblock like so: `Template: vegnature-theme/theme`. This directory holds essential theme files, including template files, functions.php, and configuration files required by WordPress.

- `assets/` is where we keep our static front-end scripts, styles, or images. In other words, our Sass files, JS files, fonts, and so on live here. As a module bundler, we use Gulp. After editing a CSS file, you should run `gulp style`, and after editing a JavaScript file, you should run `gulp scripts` to compile and bundle these assets for use in the theme.

- `views/` contains all of our Twig templates. These templates correspond one-to-one with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you’ll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. This separation of concerns helps maintain a clean and modular structure for our theme's frontend rendering.

- `inc/` contains classes, functions, Timber custom filters, and files where we write code for our custom post types (CPTs) such as tool, scientist, training, and job, as well as taxonomies, DOI handler API, Waves handler API, and other functionalities. This directory is crucial for organizing theme-specific functionality and ensuring clean separation of concerns within the theme codebase.

- `login/` contains the necessary files to customize the WordPress login page. This includes template files and stylesheets that allow us to create a branded and customized login experience for administrators accessing our WordPress site.

## Other Resources about Timber

- [This branch](https://github.com/laras126/timber-starter-theme/tree/tackle-box) of the starter theme has some more example code with ACF and a slightly different set up.
- [Twig for Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)
- [Timber and Twig Reignited My Love for WordPress](https://css-tricks.com/timber-and-twig-reignited-my-love-for-wordpress/) on CSS-Tricks
- [A real live Timber theme](https://github.com/laras126/yuling-theme).
- [Timber Video Tutorials](http://timber.github.io/timber/#video-tutorials) and [an incomplete set of screencasts](https://www.youtube.com/playlist?list=PLuIlodXmVQ6pkqWyR6mtQ5gQZ6BrnuFx-) for building a Timber theme from scratch.
