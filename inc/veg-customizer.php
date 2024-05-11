<?php

/**
 * Class for registering custom controls and settings for the WordPress Customizer.
 */
class VEG_Customizer {

    /**
     * Register the sections, settings, and controls with the WordPress Customizer.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     */
    public static function register( $wp_customize ) {
        self::register_intro_section( $wp_customize );
        self::register_stats_section( $wp_customize );
    }

    /**
     * Register the intro section and its controls.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     */
    private static function register_intro_section( $wp_customize ) {
        $wp_customize->add_section(
            'veg_sec_intro',
            array(
                'title'       => 'Section d\'introduction',
                'priority'    => 30,
                'capability'  => 'edit_theme_options',
                'description' => 'Personnaliser la section d\'introduction.',
            )
        );

        self::register_setting_and_control( $wp_customize, 'veg_set_intro_title', 'Titre de l\'intro.', 'text', 'Changer ceci par votre titre...', 'veg_sec_intro' );
        self::register_setting_and_control( $wp_customize, 'veg_set_intro_subtitle', 'Sous titre de l\'introduction', 'text', 'Changer ceci par votre sous-titre...', 'veg_sec_intro' );
        self::register_setting_and_control( $wp_customize, 'veg_set_intro_textarea', 'Intro. textarea', 'textarea', 'Changer ceci par votre texte...', 'veg_sec_intro' );

        self::register_image_control( $wp_customize, 'veg_set_intro_image_1', 'Image n°1', 'veg_sec_intro' );
        self::register_image_control( $wp_customize, 'veg_set_intro_image_2', 'Image n°2', 'veg_sec_intro' );
    }

    /**
     * Register the stats section and its controls.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     */
    private static function register_stats_section( $wp_customize ) {
        $wp_customize->add_section(
            'veg_sec_stats',
            array(
                'title'       => 'Section des statistiques',
                'priority'    => 30,
                'capability'  => 'edit_theme_options',
                'description' => 'Personnaliser la section des statistiques.',
            )
        );

        self::register_setting_and_control( $wp_customize, 'veg_set_stats_title', 'Titre des statistiques.', 'text', 'Changer ceci par votre titre...', 'veg_sec_stats' );
        self::register_setting_and_control( $wp_customize, 'veg_set_stats_subtitle', 'Sous titre des statistiques', 'text', 'Changer ceci par votre sous-titre...', 'veg_sec_stats' );
        self::register_setting_and_control( $wp_customize, 'veg_set_stats_textarea', 'Stats. textarea', 'textarea', 'Changer ceci par votre texte...', 'veg_sec_stats' );

        self::register_image_control( $wp_customize, 'veg_set_stats_image', 'Image de fond', 'veg_sec_stats' );

        self::register_number_control( $wp_customize, 'veg_set_stats_sympathizers', 'Nombre de Sympathisants', 'Merci d\'entrer le nombre de Sympathisants..', 'veg_sec_stats' );
        self::register_number_control( $wp_customize, 'veg_set_stats_maps', 'Nombre de cartes', 'Merci d\'entrer le nombre de carte..', 'veg_sec_stats' );
        self::register_number_control( $wp_customize, 'veg_set_stats_actions', 'Nombre d\'actions', 'Merci d\'entrer le nombre d\'actions..', 'veg_sec_stats' );
    }

    /**
     * Register a setting and a control for the given arguments.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     * @param string               $setting_id   Setting ID.
     * @param string               $label        Control label.
     * @param string               $type         Control type (text, textarea).
     * @param string               $default      Default value for the setting.
     * @param string               $section      Section ID.
     */
    private static function register_setting_and_control( $wp_customize, $setting_id, $label, $type, $default, $section ) {
        $wp_customize->add_setting(
            $setting_id,
            array(
                'type'              => 'theme_mod',
                'default'           => $default,
                'sanitize_callback' => $type === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            $setting_id,
            array(
                'label'       => $label,
                'section'     => $section,
                'type'        => $type,
            )
        );
    }

    /**
     * Register an image control for the given arguments.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     * @param string               $setting_id   Setting ID.
     * @param string               $label        Control label.
     * @param string               $section      Section ID.
     */
    private static function register_image_control( $wp_customize, $setting_id, $label, $section ) {
        $wp_customize->add_setting(
            $setting_id,
            array(
                'type'              => 'theme_mod',
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                $setting_id,
                array(
                    'label'     => $label,
                    'section'   => $section,
                    'mime_type' => 'image',
                )
            )
        );
    }

    /**
     * Register a number control for the given arguments.
     *
     * @param WP_Customize_Manager $wp_customize WordPress Customizer instance.
     * @param string               $setting_id   Setting ID.
     * @param string               $label        Control label.
     * @param string               $description  Control description.
     * @param string               $section      Section ID.
     */
    private static function register_number_control( $wp_customize, $setting_id, $label, $description, $section ) {
        $wp_customize->add_setting(
            $setting_id,
            array(
                'type'              => 'theme_mod',
                'default'           => 0,
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            $setting_id,
            array(
                'label'       => $label,
                'description' => $description,
                'section'     => $section,
                'type'        => 'number',
            )
        );
    }
}

add_action( 'customize_register', array( 'VEG_Customizer', 'register' ) );