<?php
/**
 * API file for woo-extend-brix-and-masons plugin.
 *
 * @package hid-wp-woo-extend-brix-and-masons
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register custom REST API endpoints.
 */
function woo_extend_brix_and_masons_register_rest_routes() {
    register_rest_route('hid-wp-woo-extend-brix-and-masons/v1', '/example', array(
        'methods'  => 'GET',
        'callback' => 'woo_extend_brix_and_masons_rest_example_callback',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'woo_extend_brix_and_masons_register_rest_routes');

/**
 * Example REST API callback.
 */
function woo_extend_brix_and_masons_rest_example_callback($request) {
    return new WP_REST_Response(array(
        'success' => true,
        'message' => 'REST API endpoint working',
        'data'    => $request->get_params()
    ), 200);
}
