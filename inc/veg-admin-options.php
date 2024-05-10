<?php

class VegOptionsSettings {

    public $adresse;
    public $email;
    public $telephone;

    public function __construct() {
        $this->adresse = get_option('veg_options_adresse', "138 Av. de Lodeve, 34070 Montpellier");
        $this->email = get_option('veg_options_email', 'vegnature@vegnature.fr');
        $this->telephone = get_option('veg_options_telephone', '0123456789');
        
        // We add actions to WordPress hooks
        add_action('admin_menu', [$this, 'add_menu_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_menu_page() {
        // We add options page to the admin menu
        add_options_page(
            'VEG Options',                 // Page title
            'VEG Options',                // Menu title
            'manage_options',            // Capability required to access
            'veg-options-settings',    // Menu slug
            [$this, 'settings_page']  // Callback function to display settings page
        );
    }

    public function settings_page() {
        // We display the settings page
        ?>
<div class="wrap">
    <h2>Vegnature Options</h2>
    <form method="post" action="options.php">
        <?php settings_fields('veg_options_settings_group'); ?>
        <?php do_settings_sections('veg-options-settings'); ?>
        <?php submit_button(); ?>
    </form>
</div>
<?php
    }

    public function register_settings() {
        // We register settings
        register_setting(
            'veg_options_settings_group',  // Group name
            'veg_options_adresse',        // Option name for transient expiration
        );
        register_setting(
            'veg_options_settings_group', // Group name
            'veg_options_email'          // Option name for Waves API URL
        );
        register_setting(
            'veg_options_settings_group', // Group name
            'veg_options_telephone'      // Option name for Waves Token
        );

        // We add settings section for transient expiration
        add_settings_section(
            'veg_options_adresse_section',         // Section ID
            '',                                   // Section title
            [$this, 'adresse_section_callback'], // Callback function to display section description
            'veg-options-settings'              // Page slug
        );

        // We add settings field for transient expiration
        add_settings_field(
            'veg_options_adresse_field',         // Field ID
            'Adresse',                          // Field label
            [$this, 'adresse_field_callback'], // Callback function to display field
            'veg-options-settings',           // Page slug
            'veg_options_adresse_section'    // Section ID
        );

        // We add settings section for Waves API URL
        add_settings_section(
            'veg_options_email_section',        // Section ID
            '',                                // Section title
            [$this, 'email_section_callback'],// Callback function to display section description
            'veg-options-settings'                   // Page slug
        );

        // We add settings field for Waves API URL
        add_settings_field(
            'veg_options_email_field',         // Field ID
            'Email',                          // Field label
            [$this, 'email_field_callback'], // Callback function to display field
            'veg-options-settings',         // Page slug
            'veg_options_email_section'    // Section ID
        );

        // We add settings section for Waves Token
        add_settings_section(
            'veg_options_telephone_section',         // Section ID
            '',                                     // Section title
            [$this, 'telephone_section_callback'], // Callback function to display section description
            'veg-options-settings'                // Page slug
        );

        // We add settings field for Waves Token
        add_settings_field(
            'veg_options_telephone_field',         // Field ID
            'Téléphone',                          // Field label
            [$this, 'telephone_field_callback'], // Callback function to display field
            'veg-options-settings',             // Page slug
            'veg_options_telephone_section'    // Section ID
        );
    }

    public function adresse_section_callback() {
        // Our callback function to display section description for adresse
        echo '<p>Entrer l\'adresse de l\'association. (Current: ' . $this->adresse . ' .)</p>';
    }

    public function email_section_callback() {
        // Our callback function to display section description for Waves API URL
        echo '<p>Entrer l\'email de l\'association.</p>';
    }

    public function telephone_section_callback() {
        // Our callback function to display section description for Waves Token
        echo '<p>Entrer le téléphone de l\'association.</p>';
    }

    public function adresse_field_callback() {
        // Callback function to display the transient expiration field
        $value = get_option('veg_options_adresse', "138 Av. de Lodeve, 34070 Montpellier"); // Default location
        echo '<input type="text" name="veg_options_adresse" value="' . esc_attr($value) . '" style="width: 20%;"/>';
    }

    public function email_field_callback() {
        // Our callback function to display the Waves API URL field
        $value = get_option('veg_options_email', 'vegnature@vegnature.fr');
        echo '<input type="text" name="veg_options_email" value="' . esc_attr($value) . '" style="width: 20%;"/>';
    }

    public function telephone_field_callback() {
        // Our callback function to display the Waves Token field
        $value = get_option('veg_options_telephone', '0123456789');
        echo '<input type="text" name="veg_options_telephone" value="' . esc_attr($value) . '" style="width: 20%;"/>';
    }
}

// We instantiate our class
new VegOptionsSettings();  