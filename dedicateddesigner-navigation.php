<?php
/**
 * Plugin Name: Dedicateddesigner-navigation
 * Description: Dedicateddesigner Navigation Widget
 * Version: 1.4.1
 * Author: Sunill Sharma
 */

if (!defined('ABSPATH')) {
    exit;
}

// Step 2: Register Widget

if ( ! function_exists( 'dedicateddesigner_register_widgets' ) ) {
    function dedicateddesigner_register_widgets($widgets_manager){

        require_once plugin_dir_path(__FILE__) . 'widget/navigation-widget.php';

        if ( class_exists( 'DedicatedDesigner_Navigation_Widget' ) ) {
            $widgets_manager->register(
                new \DedicatedDesigner_Navigation_Widget()
            );
        }

    }

    add_action(
        'elementor/widgets/register',
        'dedicateddesigner_register_widgets'
    );
}

// Step 3: Register Assets

if ( ! function_exists( 'dedicateddesigner_register_assets' ) ) {
    function dedicateddesigner_register_assets(){

        wp_register_style(
            'dedicateddesigner-navigation-css',
            plugin_dir_url(__FILE__) . 'assets/navigation.css',
            [],
            '1.4.1'
        );

        wp_register_script(
            'dedicateddesigner-navigation-js',
            plugin_dir_url(__FILE__) . 'assets/navigation.js',
            [ 'jquery', 'elementor-frontend' ],
            '1.4.1',
            true
        );

    }

    add_action(
        'wp_enqueue_scripts',
        'dedicateddesigner_register_assets'
    );
}
