<?php
/**
 * AJAX functions for woo-extend-brix-and-masons plugin.
 *
 * @package hid-wp-woo-extend-brix-and-masons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Example AJAX function for frontend.
 */
function woo_extend_brix_and_masons_example_ajax() {
    check_ajax_referer('hid-wp-woo-extend-brix-and-masons-frontend-nonce', 'nonce');

    $response = array(
        'success' => true,
        'message' => 'AJAX request processed successfully',
        'data'    => $_POST
    );

    wp_send_json($response);
}
add_action('wp_ajax_woo_extend_brix_and_masons_example_ajax', 'woo_extend_brix_and_masons_example_ajax');
add_action('wp_ajax_nopriv_woo_extend_brix_and_masons_example_ajax', 'woo_extend_brix_and_masons_example_ajax');

/**
 * Example AJAX function for admin.
 */
function woo_extend_brix_and_masons_admin_example_ajax() {
    check_ajax_referer('hid-wp-woo-extend-brix-and-masons-admin-nonce', 'nonce');

    $response = array(
        'success' => true,
        'message' => 'Admin AJAX request processed successfully',
        'data'    => $_POST
    );

    wp_send_json($response);
}
add_action('wp_ajax_woo_extend_brix_and_masons_admin_example_ajax', 'woo_extend_brix_and_masons_admin_example_ajax');
