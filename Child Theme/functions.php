<?php
/**
 * Semplice Child Theme - functions.php
 *
 * Enqueues all custom and third-party scripts for the front-end only.
 */

if (defined('WP_DEBUG') && WP_DEBUG) {
    error_log('=== FUNCTIONS.PHP LOADED ===');
}

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add error logging for debugging
if (!function_exists('write_log')) {
    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}

function brandon_enqueue_custom_scripts() {
    if (is_admin()) {
        return;
    }

    try {
        // --- STYLES ---
        wp_enqueue_style(
            'brandon-custom-styles',
            get_stylesheet_uri(),
            array(),
            '1.0.0'
        );

        // --- THIRD-PARTY LIBRARIES ---

        // P5.js
        wp_enqueue_script(
            'brandon-p5',
            'https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.9.4/p5.min.js',
            array(),
            '1.9.4',
            true
        );

        // GSAP Plugins
        wp_enqueue_script(
            'brandon-gsap-ce',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/CustomEase.min.js',
            array(),
            '3.13.0',
            true
        );



        // --- CUSTOM JS ---
        wp_enqueue_script(
            'brandon-custom-scripts',
            get_stylesheet_directory_uri() . '/brandon-custom-scripts.js',
            array('brandon-p5', 'brandon-gsap-ce'),
            '1.0.3',
            true
        );

    } catch (Exception $e) {
        write_log('Brandon Child Theme Error: ' . $e->getMessage());
    }
}

add_action( 'wp_enqueue_scripts', 'brandon_enqueue_custom_scripts', 20 );
