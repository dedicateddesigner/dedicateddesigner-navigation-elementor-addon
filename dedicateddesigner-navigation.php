<?php
/**
 * Plugin Name: Dedicateddesigner-navigation
 * Description: Dedicateddesigner Navigation Widget
 * Version: 1.4.5
 * Author: Sunill Sharma
 */

if (!defined('ABSPATH')) {
    exit;
}

// Step 2: Register Widget

if ( ! function_exists( 'dedicateddesigner_register_widgets' ) ) {
    function dedicateddesigner_register_widgets($widgets_manager){

        if ( ! class_exists( 'Elementor\Widget_Base' ) ) {
            return;
        }

        require_once plugin_dir_path(__FILE__) . 'widget/navigation-widget.php';

        $widgets_manager->register(
            new \DedicatedDesigner_Navigation_Widget()
        );

    }
}

// Step 3: Register Assets

if ( ! function_exists( 'dedicateddesigner_register_assets' ) ) {
    function dedicateddesigner_register_assets(){

        wp_register_style(
            'dedicateddesigner-navigation-css',
            plugin_dir_url(__FILE__) . 'assets/navigation.css',
            [],
            '1.4.5'
        );

        wp_register_script(
            'dedicateddesigner-navigation-js',
            plugin_dir_url(__FILE__) . 'assets/navigation.js',
            [ 'jquery', 'elementor-frontend' ],
            '1.4.5',
            true
        );

    }
}

// Step 4: Check for Elementor dependency and hook actions
add_action( 'plugins_loaded', function() {
    if ( ! did_action( 'elementor/loaded' ) ) {
        return;
    }

    add_action(
        'elementor/widgets/register',
        'dedicateddesigner_register_widgets'
    );

    // Register styles and scripts on Elementor-specific hooks
    add_action(
        'elementor/frontend/after_register_styles',
        'dedicateddesigner_register_assets'
    );
    add_action(
        'elementor/frontend/after_register_scripts',
        'dedicateddesigner_register_assets'
    );

    // Force enqueue styles/scripts in the Elementor preview iframe
    add_action(
        'elementor/preview/enqueue_styles',
        function() {
            wp_enqueue_style( 'dedicateddesigner-navigation-css' );
        }
    );
    add_action(
        'elementor/preview/enqueue_scripts',
        function() {
            wp_enqueue_script( 'dedicateddesigner-navigation-js' );
        }
    );
} );

// Step 5: Enable SVG Uploads and handle checks safely

if ( ! function_exists( 'dedicateddesigner_enable_svg_uploads' ) ) {
    function dedicateddesigner_enable_svg_uploads( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'dedicateddesigner_enable_svg_uploads' );
}

if ( ! function_exists( 'dedicateddesigner_verify_svg_upload' ) ) {
    function dedicateddesigner_verify_svg_upload( $data, $file, $filename, $mimes ) {
        $filetype = wp_check_filetype( $filename, $mimes );
        if ( $filetype['ext'] === 'svg' ) {
            $data['ext']  = 'svg';
            $data['type'] = 'image/svg+xml';
        }
        return $data;
    }
    add_filter( 'wp_check_filetype_and_ext', 'dedicateddesigner_verify_svg_upload', 10, 4 );
}
